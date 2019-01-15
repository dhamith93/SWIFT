<?php
    class Company_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function updateInfo($data) {
            $this->db->where('id', '0');
            return $this->db->update('company_info', $data);
        }

        public function getInfo() {
            $query = $this->db->get_where('company_info', array('id' => '0'));
            return $query->row();
        }
    }

?>