<?php
    class Employee_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function addEmployee() {
            $password = $this->input->post('password');
            $hashedPw = password_hash($password, PASSWORD_BCRYPT);

            $formData = array(
                'emp_id' => htmlspecialchars($this->input->post('emp-id', true)),
                'first_name' => htmlspecialchars($this->input->post('first-name', true)),
                'last_name' => htmlspecialchars($this->input->post('last-name', true)),
                'password' => $hashedPw,
                'contact' => htmlspecialchars($this->input->post('contact', true)),
                'email' => htmlspecialchars($this->input->post('email', true))
            );

            return $this->db->insert('employees', $formData);
        }

        public function getEmployees($searchValue, $searchType) {
            $query = $this->db->get_where('employees', array($searchType => $searchValue));
            return $query->result();
        }

        public function getEmployee($empId) {
            $query = $this->db->get_where('employees', array('emp_id' => $empId));
            return $query->result();
        }

        public function deleteEmployee($empId) {
            $this->db->where('emp_id', $empId);
            $this->db->delete('employees');
            return true;
        }

        public function verifyUser($username, $password) {
            $query = $this->db->get_where('employees', array('emp_id' => $username));
            $hash = $query->row_array()['password'];
            
            if (empty($hash)) 
                return false;
            
            return password_verify($password, $hash);
        }

        public function changePassword($username, $password) {
            $hashedPw = password_hash($password, PASSWORD_BCRYPT);

            $this->db->where('emp_id', $username);
            return $this->db->update('employees', array('password' => $hashedPw));
        }

        public function setLoginDateTime($empId, $dateTime) {
            $this->db->where('emp_id', $empId);
            return $this->db->update('employees', array('last_logged_in' => $dateTime));
        }
    }
?>