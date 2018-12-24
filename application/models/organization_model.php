<?php
    class Organization_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function add() {
            $orgData = array(
                'name' => htmlspecialchars($this->input->post('org-name', true)),
                'type' => htmlspecialchars($this->input->post('type', true)),
                'address' => htmlspecialchars($this->input->post('address', true)),
                'contact' => htmlspecialchars($this->input->post('org-contact', true)),
                'email' => htmlspecialchars($this->input->post('org-email', true))
            );

            $this->db->insert('organizations', $orgData);
            $orgId = $this->db->insert_id();

            $locationString = htmlspecialchars($this->input->post('location-list', true));
            $locationArray = $this->extractLocations($locationString);

            foreach ($locationArray as $location) {
                $locationData = array(
                    'org_id' => $orgId,
                    'province' => $location[0],
                    'district' => isset($location[1]) ? $location[1] : '',
                    'town' => isset($location[2]) ? $location[2] : '',
                );

                $this->db->insert('responding_areas', $locationData);
            }
            

            $password = $this->input->post('password');
            $hashedPw = password_hash($password, PASSWORD_BCRYPT);

            $adminData = array(
                'org_id' => $orgId,
                'first_name' => htmlspecialchars($this->input->post('first-name')),
                'last_name' => htmlspecialchars($this->input->post('last-name')),
                'password' => htmlspecialchars($hashedPw),
                'contact' => htmlspecialchars($this->input->post('contact')),
                'email' => htmlspecialchars($this->input->post('email')),
                'is_admin' => 1
            );

            $this->responder_model->add($adminData);
        }

        function extractLocations($str) {
            $arr = explode("|",$str);
            $returnArr = array();
            $count = 0;

            foreach ($arr as $itm) {
                $returnArr[$count] = explode(">",$itm);
                $count += 1;
            }

            return $returnArr;
        }
    }