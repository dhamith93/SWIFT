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
            if ($onlyOngoing === '-1') {
                $query = $this->db->get_where('incidents', array($searchType => $searchValue));
            } else {
                $ongoing = ($onlyOngoing ) ? 1 : 0;
                $query = $this->db->get_where('incidents', array($searchType => $searchValue, 'on_going' => $ongoing));
            }
            return $query->result();
        }

        public function getOngoingIncidents() {
            $query = $this->db->get_where('incidents', array('on_going' => 1));
            return $query->result();
        }
    }
?>