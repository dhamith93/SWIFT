<?php
    class Company_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function updateInfo() {
            $data = array(
                'name' => $this->input->post('name'),
                'slogan' => $this->input->post('slogan'),
                'address' => $this->input->post('address'),
                'email' => $this->input->post('email'),
                'contact_1' => $this->input->post('contact_1'),
                'contact_2' => $this->input->post('contact_2'),
                'contact_3' => $this->input->post('contact_3'),
                'contact_4' => $this->input->post('contact_4'),
                'contact_5' => $this->input->post('contact_5') 
            );

            $this->db->where('id', '0');
            return $this->db->update('company_info', $data);
        }

        public function getInfo() {
            $query = $this->db->get_where('company_info', array('id' => '0'));
            return $query->row();
        }
    }

?>