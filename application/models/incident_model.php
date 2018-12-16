<?php
    class Incident_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function addIncident() {
            $formData = array(
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'province' => $this->input->post('province'),
                'district' => $this->input->post('district'),
                'location' => $this->input->post('location'),
                'lat' => $this->input->post('lat'),
                'lng' => $this->input->post('long'),
                'hazard_warning' => $this->input->post('warning')
            );

            return $this->db->insert('incidents', $formData);
        }

        public function getIncidents($searchValue, $searchType, $onlyOngoing) {
            $ongoing = ($onlyOngoing) ? 1 : 0;
            $query = $this->db->get_where('incidents', array($searchType => $searchValue, 'on_going' => $ongoing));
            return $query->result();
        }

        // public function getEmployee($empId) {
        //     $query = $this->db->get_where('employees', array('emp_id' => $empId));
        //     return $query->row_array();
        // }

        // public function deleteEmployee($empId) {
        //     $this->db->where('emp_id', $empId);
        //     $this->db->delete('employees');
        //     return true;
        // }

        // public function verifyUser($username, $password) {
        //     $query = $this->db->get_where('employees', array('emp_id' => $username));
        //     $hash = $query->row_array()['password'];
            
        //     if (empty($hash)) 
        //         return false;
            
        //     return password_verify($password, $hash);
        // }
    }
?>