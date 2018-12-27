<?php
    class Incident_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function addIncident() {
            $locationString = $this->input->post('location-list', true);
            $locationArray = $this->extractLocations($locationString);
            $alertReceivers = $this->input->post('alerts-receivers');

            $incidentData = array(
                'name' => htmlspecialchars($this->input->post('name', true)),
                'type' => htmlspecialchars($this->input->post('type', true)),
                'lat' => htmlspecialchars($this->input->post('lat', true)),
                'lng' => htmlspecialchars($this->input->post('long', true)),
                'hazard_warning' => htmlspecialchars($this->input->post('warning', true))
            );

            $this->db->insert('incidents', $incidentData);
            $incidentId = $this->db->insert_id();

            foreach ($locationArray as $location) {
                $locationData = array(
                    'inc_id' => $incidentId,
                    'province' => $location[0],
                    'district' => $location[1],
                    'town' => $location[2],
                );

                $this->db->insert('affected_areas', $locationData);
                
                if (!empty($alertReceivers)) {
                    foreach ($alertReceivers as $receiver) {
                        if ($receiver !== 'public')
                            $this->notifyResponders($location[2], $receiver, $incidentId);
                    }
                }
            }

            if (!empty($alertReceivers)) {
                $alert = array(
                    'inc_id' => $incidentId,
                    'content' => htmlspecialchars($this->input->post('alert', true)),
                    'is_public' => (in_array('public', $alertReceivers)) ? '1' : '0'
                );

                $this->db->insert('alerts', $alert);
            }
        }

        public function getIncidents($searchValue, $searchType, $onlyOngoing) {

            if ($searchType === 'name' || $searchType === 'type') {
                if ($onlyOngoing === '-1') {
                    $query = $this->db->get_where('incidents', array($searchType => $searchValue));
                } else {
                    $ongoing = ($onlyOngoing ) ? 1 : 0;
                    $query = $this->db->get_where('incidents', array($searchType => $searchValue, 'on_going' => $ongoing));
                }
    
                return $this->buildReturnArray($query->result());
            } 

            $query = $this->db->get_where('affected_areas', array($searchType => $searchValue));
            $locationResult = $query->result();
            $resultArray = array();

            foreach ($locationResult as $location) {
                $query = $this->db->get_where('incidents', array('id' => $location->inc_id));
                $result = $query->row();
                $locationString = $location->province.' > '.$location->district.' > '.$location->town;

                if (!isset($resultArray[$result->id])) {
                    $resultArray[$result->id] = array(
                        'id' => $result->id,
                        'name' => $result->name,
                        'type' => $result->name,
                        'lng' => $result->lng,
                        'lat' => $result->lat,
                        'locations' => array($locationString),
                        'on_going' => $result->on_going,
                        'warning' => $result->hazard_warning
                    );
                    $count += 1;
                } else {
                    $resultArray[$result->id]['locations'][] = $locationString;
                }
            }

            return $resultArray;
        }

        public function getSingleIncident($id) {
            $query = $this->db->get_where('incidents', array('id' => $id));
            return $this->buildReturnArray($query->result());
        }

        public function getOngoingIncidents() {
            $query = $this->db->get_where('incidents', array('on_going' => 1));
            $incidentResult = $query->result();
            return $this->buildReturnArray($incidentResult);
        }

        public function addAlert($incidentId, $content, $isPublic) {
            $data = array(
                'inc_id' => $incidentId,
                'content' => $content,
                'is_public' => $isPublic
            );

            return $this->db->insert('alerts', $data);
        }

        public function getAlerts($incidentId) {
            $query = $this->db->get_where('alerts', array('inc_id' => $incidentId));
            return $query->result();
        }

        public function getAlertsForPublic($incidentId) {
            $query = $this->db->get_where('alerts', array('inc_id' => $incidentId, 'is_public' => '1'));
            return $query->result();
        }

        public function deleteAlert($alertId) {
            $this->db->where('id', $alertId);
            return $this->db->delete('alerts'); 
        }

        public function getResponders($incidentId) {
            $query = $this->db->select('t1.org_id, t2.id, t2.name, t2.address, t2.contact, t2.email, t3.type')
                        ->from('responding_organizations as t1')
                        ->where('t1.inc_id', $incidentId)
                        ->join('organizations as t2', 't1.org_id = t2.id', 'LEFT')
                        ->join('organization_types as t3', 't2.type_id = t3.id', 'LEFT')
                        ->get();
            return $query->result();
        }

        public function notifyResponder($orgId, $incidentId) {
            $data = array(
                'inc_id' => $incidentId,
                'org_id' => $orgId
            );
            
            return $this->db->insert('responding_organizations', $data);
        }

        function notifyResponders($town, $responderType, $incidentId) {
            $query = $this->db->get_where('responding_areas', array('town' => $town, 'type_id' => $responderType));
            $result = $query->result();

            foreach ($result as $row) {
                if (!$this->responderExists($row->org_id, $incidentId))
                    $this->notifyResponder($row->org_id, $incidentId);
            }
        }

        public function responderExists($orgId, $incidentId) {
            $checkQuery = $this->db->get_where('responding_organizations', array('inc_id' => $incidentId, 'org_id' => $orgId));
            return (count($checkQuery->result()) > 0);
        }

        function buildReturnArray($queryResult) {
            $resultArray = array();

            foreach ($queryResult as $incident) {
                $query = $this->db->get_where('affected_areas', array('inc_id' => $incident->id));
                $locationArray = array();

                foreach ($query->result() as $location) 
                    $locationArray[] = $location->province.' > '.$location->district.' > '.$location->town;

                $resultArray[$incident->id] = array(
                    'id' => $incident->id,
                    'name' => $incident->name,
                    'type' => $incident->type,
                    'lng' => $incident->lng,
                    'lat' => $incident->lat,
                    'locations' => $locationArray,
                    'on_going' => $incident->on_going,
                    'warning' => $incident->hazard_warning
                );
            }

            return $resultArray;
        }

        function extractLocations($str) {
            $arr = array_unique(explode('|', $str));
            $returnArr = array();

            foreach ($arr as $itm)
                $returnArr[] = explode('>', $itm);

            return $returnArr;
        }
    }
?>