<?php
    class Organization_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function add() {
            $orgData = array(
                'name' => $this->input->post('org-name'),
                'type' => $this->input->post('type'),
                'address' => $this->input->post('address'),
                'contact' => $this->input->post('org-contact'),
                'email' => $this->input->post('org-email')
            );

            $this->db->insert('organizations', $orgData);
            $orgId = $this->db->insert_id();

            $locationString = $this->input->post('location-list');
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
                'first_name' => $this->input->post('first-name'),
                'last_name' => $this->input->post('last-name'),
                'password' => $hashedPw,
                'contact' => $this->input->post('contact'),
                'email' => $this->input->post('email'),
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