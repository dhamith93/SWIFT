<?php
    class Responder_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function add($userData) {
            $this->db->insert('responders', $userData);
        }
    }