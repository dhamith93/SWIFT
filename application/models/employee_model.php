<?php
    class Employee_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function addEmployee() {
            $formData = array(
                'emp_id' => $this->input->post('emp-id'),
                'first_name' => $this->input->post('first-name'),
                'last_name' => $this->input->post('last-name'),
                'password' => $this->input->post('password'),
                'contact' => $this->input->post('contact'),
                'email' => $this->input->post('email')
            );

            return $this->db->insert('employees', $formData);
        }

        public function getEmployee($empId) {
            $query = $this->db->get_where('employees', array('emp_id' => $empId));
            return $query->row_array();
        }

        public function deleteEmployee($empId) {
            $this->db->where('emp_id', $empId);
            $this->db->delete('employees');
            return TRUE;
        }
    }
?>