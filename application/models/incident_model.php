<?php
    class Incident_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function addIncident() {
            $locationString = $this->input->post('location-list', true);
            $locationArray = $this->extractLocations($locationString);

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
            $arr = explode('|', $str);
            $returnArr = array();

            foreach ($arr as $itm)
                $returnArr[] = explode('>', $itm);

            return $returnArr;
        }
    }
?>