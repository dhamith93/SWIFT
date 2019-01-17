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
                'date' => htmlspecialchars($this->input->post('date', true)),
                'time' => htmlspecialchars($this->input->post('time', true)),
                'hazard_warning' => htmlspecialchars($this->input->post('warning', true))
            );

            $this->db->insert('incidents', $incidentData);
            $incidentId = $this->db->insert_id();

            $this->addLocation($incidentId, $locationString, !empty($alertReceivers), $alertReceivers);

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
            $ongoing = ($onlyOngoing ) ? 1 : 0;

            if ($searchType === 'name' || $searchType === 'type') {
                if ($onlyOngoing === '-1') {
                    $query = $this->db
                            ->select('*')
                            ->from('incidents')
                            ->where($searchType, $searchValue)
                            ->order_by('id', 'desc')
                            ->get();
                } else {
                    $query = $this->db
                            ->select('*')
                            ->from('incidents')
                            ->where($searchType, $searchValue)
                            ->where('on_going', $ongoing)
                            ->order_by('id', 'desc')
                            ->get();
                }
    
                return $this->buildReturnArray($query->result());
            } 
            
            $query = $this->db
                            ->select('*')
                            ->from('affected_areas')
                            ->where($searchType, $searchValue)
                            ->order_by('id', 'desc')
                            ->get();
            $locationResult = $query->result();
            $resultArray = array();

            foreach ($locationResult as $location) {
                $query = $this->db->get_where('incidents', array('id' => $location->inc_id, 'on_going' => $ongoing));
                $results = $query->result();

                foreach ($results as $result) {
                    $locations = $this->getLocationStrings($result->id);
                    if (!isset($resultArray[$result->id])) {
                        $resultArray[$result->id] = array(
                            'id' => $result->id,
                            'name' => $result->name,
                            'type' => $result->name,
                            'lng' => $result->lng,
                            'lat' => $result->lat,
                            'locations' => $locations,
                            'on_going' => $result->on_going,
                            'warning' => $result->hazard_warning
                        );
                    }
                }
            }

            return $resultArray;
        }

        public function getSingleIncident($id) {
            $query = $this->db->get_where('incidents', array('id' => $id));
            return $this->buildReturnArray($query->result());
        }

        public function getCasualties($id) {
            $query = $this->db->get_where('casualties', array('inc_id' => $id));
            return $query->result();
        }

        public function getHospitalizations($id) {
            $query = $this->db->get_where('hospitalizations', array('inc_id' => $id));
            return $query->result();
        }

        public function getEvacuations($id) {
            $query = $this->db->get_where('evacuations', array('inc_id' => $id));
            return $query->result();
        }

        public function getOngoingIncidents() {
            $query = $this->db
                    ->select('*')
                    ->from('incidents')
                    ->where('on_going', 1)
                    ->order_by('id', 'desc')
                    ->get();
            $incidentResult = $query->result();
            return $this->buildReturnArray($incidentResult);
        }

        public function getOngoingIncidentsOf($orgId) {            
            $query = $this->db->select('*')
                        ->from('responding_organizations as t1')
                        ->where('t1.org_id', $orgId)
                        ->join('incidents as t2', 't1.inc_id = t2.id', 'LEFT')
                        ->where('t2.on_going', '1')
                        ->order_by('t2.id', 'desc')
                        ->get();

            $incidentResult = $query->result();
            return $this->buildReturnArray($incidentResult);
        }

        public function getPressReleases($id) {
            $query = $this->db
                    ->select('id, title, published_date, is_published')
                    ->from('press_releases')
                    ->where('inc_id', $id)
                    ->order_by('published_date', 'desc')
                    ->get();
            return $query->result();
        }

        public function getLocationStrings($id) {
            $query = $this->db->get_where('affected_areas', array('inc_id' => $id));
            $locationArray = array();

            foreach ($query->result() as $row)
                $locationArray[] = $row->province . ' > ' . $row->district . ' > ' . $row->town;

            return $locationArray;            
        }

        public function markComplete($id) {
            $this->db->where('id', $id);
            return $this->db->update('incidents', array('on_going' => '0'));
        }

        public function updateCasualties($id) {
            $checkQuery = $this->db->get_where('casualties', array('inc_id' => $id));
            
            $data = array(
                'inc_id' => $id,
                'deaths' => htmlspecialchars($this->input->post('deaths', true)),
                'wounded' => htmlspecialchars($this->input->post('wounded', true)),
                'missing' => htmlspecialchars($this->input->post('missing', true))
            );

            if (count($checkQuery->result()) > 0) {
                $this->db->where('inc_id', $id);
                return $this->db->update('casualties', $data);
            }

            return $this->db->insert('casualties', $data);
        }

        public function addEvacuations($id) {
            $data = array(
                'inc_id' => $id,
                'address' => htmlspecialchars($this->input->post('address', true)),
                'count' => htmlspecialchars($this->input->post('evacuees', true)),
                'contact' => htmlspecialchars($this->input->post('contact', true))
            );

            return $this->db->insert('evacuations', $data);
        }

        public function updateEvacuations($id) {
            $data = array(
                'id' => htmlspecialchars($this->input->post('id', true)),
                'address' => htmlspecialchars($this->input->post('address', true)),
                'count' => htmlspecialchars($this->input->post('evacuees', true)),
                'contact' => htmlspecialchars($this->input->post('contact', true))
            );

            $this->db->where('id', $data['id']);
            return $this->db->update('evacuations', $data);
        }

        public function addLocation($incidentId, $locationString, $alertOrgs, $responders = NULL) {
            $locations = $this->extractLocations($locationString);
            
            foreach ($locations as $location) {
                if (count($location) !== 3)
                    return false;
                    
                if ($this->locationExists($incidentId, $location))
                    return false;

                $this->load->helper('map_helper');

                $geocode = getGeoCode($location);

                $locationData = array(
                    'inc_id' => $incidentId,
                    'province' => $location[0],
                    'district' => $location[1],
                    'town' => $location[2],
                    'lat' => $geocode->lat,
                    'lng' => $geocode->lng
                );

                $this->db->insert('affected_areas', $locationData);

                if ($alertOrgs) {
                    if ($responders === NULL) {
                        $responders = $this->getResponders($incidentId);
                        foreach ($responders as $responder)
                               $this->notifyResponders($location[2], $responder->type_id, $incidentId);
                    } else {
                        foreach ($responders as $responder) {
                            if ($responder !== 'public')
                                $this->notifyResponders($location[2], $responder, $incidentId);
                        }
                    }
                }
            }
            
            return true;
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
            $query = $this->db
                    ->select('*')
                    ->from('alerts')
                    ->where('inc_id', $incidentId)
                    ->order_by('id', 'desc')
                    ->get();
            return $query->result();
        }

        public function getAlertsForPublic($incidentId) {
            $query = $this->db->get_where('alerts', array('inc_id' => $incidentId, 'is_public' => '1'));
            return $query->result();
        }

        public function getAlertsFor($orgId) {
            $query = $this->db->select('t3.name, t2.id, t2.inc_id, t2.content, t2.published_date')
                        ->from('responding_organizations as t1')
                        ->where('t1.org_id', $orgId)
                        ->join('alerts as t2', 't1.inc_id = t2.inc_id', 'LEFT')
                        ->join('incidents as t3', 't2.inc_id = t3.id', 'LEFT')
                        ->where('t3.on_going', '1')
                        ->order_by('t3.id', 'desc')
                        ->get();

            return $query->result();
        }

        public function deleteAlert($alertId) {
            $this->db->where('id', $alertId);
            return $this->db->delete('alerts'); 
        }

        public function updateWarning($incidentId, $warning) {
            $this->db->where('id', $incidentId);
            return $this->db->update('incidents', array('hazard_warning' => $warning));
        }

        public function getResponders($incidentId) {
            $query = $this->db->select('t1.org_id, t2.id, t3.id AS type_id, t2.name, t2.address, t2.contact, t2.email, t3.type')
                        ->from('responding_organizations as t1')
                        ->where('t1.inc_id', $incidentId)
                        ->join('organizations as t2', 't1.org_id = t2.id', 'LEFT')
                        ->join('organization_types as t3', 't2.type_id = t3.id', 'LEFT')
                        ->get();
            return $query->result();
        }

        public function notifyResponder($orgId, $incidentId) {
            $this->load->helper('phone_number_helper');
            $this->load->helper('sms_helper');
            $this->load->helper('email_helper');

            $query = $this->db->get_where('responders', array('org_id' => $orgId, 'is_admin' => 1));
            $result = $query->row();
            $orgAdminContact = convertToInternational($result->contact);
            $orgAdminEmail = $result->email;
            $orgAdminName = $result->first_name . ' ' . $result->last_name;

            $data = array(
                'inc_id' => $incidentId,
                'org_id' => $orgId
            );
            
            $success = $this->db->insert('responding_organizations', $data);

            if ($success) {
                if ($orgAdminContact !== 'INVALID OR NOT SUPPORTED')
                    sendSms($orgAdminContact, 'ALERT: New incident assigned. Login to your dashboard and continue.');

                sendEmail($orgAdminEmail, $orgAdminName, 'New Incident Alert From SWIFT', 'ALERT: New incident assigned. Login to your dashboard and continue.');
            }

            return $success;
        }

        function notifyResponders($town, $responderType, $incidentId) {
            $query = $this->db->get_where('responding_areas', array('town' => $town, 'type_id' => $responderType));
            $result = $query->result();

            foreach ($result as $row) {
                if (!$this->responderExists($row->org_id, $incidentId))
                    $this->notifyResponder($row->org_id, $incidentId);
            }
        }

        public function addTask($incidentId, $respondingOrgId, $taskContent) {
            $data = array(
                'inc_id' => $incidentId,
                'org_id' => $respondingOrgId,
                'content' => $taskContent
            );

            return $this->db->insert('tasks', $data);
        }

        public function getTasks($incidentId) {
            $query = $this->db
                    ->select('*')
                    ->from('tasks')
                    ->where('inc_id', $incidentId)
                    ->order_by('assigned_at', 'desc')
                    ->get();

            $tasks = $query->result();

            $data = array();

            foreach ($tasks as $task) {
                $organization = $this->organization_model->getOrganization($task->org_id);
                $data[$task->id] = array(
                    'content' => $task->content,
                    'org' => $organization[0]->name,
                    'is_completed' => ($task->is_completed === '0') ? 'NO' : 'YES',
                    'assigned_at' => $task->assigned_at,
                    'completed_at' => $task->completed_at
                );
            }

            return $data;
        }

        public function getTasksFor($orgId, $incidentId = null) {
            if ($incidentId === null) {
                $query = $this->db->select('t3.name, t2.id, t2.inc_id, t2.content, t2.is_completed, t2.completed_at, t2.assigned_at')
                            ->from('responding_organizations as t1')
                            ->where('t1.org_id', $orgId)
                            ->join('tasks as t2', 't1.inc_id = t2.inc_id', 'LEFT')
                            ->join('incidents as t3', 't2.inc_id = t3.id', 'LEFT')
                            ->where('t3.on_going', '1')
                            ->where('t2.is_completed', '0')
                            ->order_by('t2.id', 'desc')
                            ->get();
            } else {
                $query = $this->db->select('t3.name, t2.id, t2.inc_id, t2.content, t2.is_completed, t2.completed_at, t2.assigned_at')
                            ->from('responding_organizations as t1')
                            ->where('t1.org_id', $orgId)
                            ->where('t1.inc_id', $incidentId)
                            ->join('tasks as t2', 't1.inc_id = t2.inc_id', 'LEFT')
                            ->join('incidents as t3', 't2.inc_id = t3.id', 'LEFT')
                            ->where('t3.on_going', '1')
                            ->where('t2.is_completed', '0')
                            ->order_by('t2.id', 'desc')
                            ->get();
            }

            return $query->result();
        }

        public function markTaskCompleted($taskId, $orgId) {
            $this->db->where('id', $taskId);
            $this->db->where('org_id', $orgId);
            return $this->db->update('tasks', array('is_completed'=> '1'));
        }

        public function responderExists($orgId, $incidentId) {
            $checkQuery = $this->db->get_where('responding_organizations', array('inc_id' => $incidentId, 'org_id' => $orgId));
            return (count($checkQuery->result()) > 0);
        }

        function locationExists($incidentId, $location) {
            $checkQuery = $this->db->get_where(
                'affected_areas', 
                array(
                    'inc_id' => $incidentId, 
                    'province' => $location[0],
                    'district' => $location[1],
                    'town' => $location[2]
                )
            );
            return (count($checkQuery->result()) > 0);
        }


        function buildReturnArray($queryResult) {
            $resultArray = array();

            foreach ($queryResult as $incident) {
                $query = $this->db->get_where('affected_areas', array('inc_id' => $incident->id));
                $locationArray = array();
                $geocodes = array();

                foreach ($query->result() as $location) {
                    $locationArray[] = ucfirst($location->province).' > '.ucfirst($location->district).' > '.ucfirst($location->town);
                    $geocodes[] = array(
                        'name' => $location->town,
                        'lat' => $location->lat,
                        'lng' => $location->lng
                    );
                }

                $resultArray[$incident->id] = array(
                    'id' => $incident->id,
                    'name' => $incident->name,
                    'type' => $incident->type,
                    'date' => $incident->date,
                    'time' => $incident->time,
                    'lng' => $incident->lng,
                    'lat' => $incident->lat,
                    'locations' => $locationArray,
                    'geocodes' => $geocodes,
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