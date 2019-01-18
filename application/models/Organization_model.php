<?php
    class Organization_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function add() {
            $orgTypeId = $this->input->post('type', true);

            if ($orgTypeId === -1)
                return false;

            $orgData = array(
                'name' => htmlspecialchars($this->input->post('org-name', true)),
                'type_id' => $orgTypeId,
                'address' => htmlspecialchars($this->input->post('address', true)),
                'contact' => htmlspecialchars($this->input->post('org-contact', true)),
                'email' => htmlspecialchars($this->input->post('org-email', true))
            );

            $this->db->insert('organizations', $orgData);
            $orgId = $this->db->insert_id();

            $locationString = $this->input->post('location-list', true);
            $locationArray = $this->extractLocations($locationString);

            foreach ($locationArray as $location) {
                $locationData = array(
                    'org_id' => $orgId,
                    'type_id' => $orgTypeId,
                    'province' => $location[0],
                    'district' => isset($location[1]) ? $location[1] : '',
                    'town' => isset($location[2]) ? $location[2] : '',
                );

                $this->db->insert('responding_areas', $locationData);
            }

            return $this->responder_model->add($orgId, 1);
        }

        public function getOrganizations($orgType, $searchValue, $locationType) {
            $query = $this->db->get_where('responding_areas', array($locationType => $searchValue, 'type_id' => $orgType));
            $result = $query->result();

            $returnArr = array();
            $prevId = '';

            foreach ($result as $row) {
                if ($prevId !== $row->org_id) {
                    $query = $this->db->select('t1.id, t1.name, t1.address, t1.contact, t1.email, t2.type')
                        ->from('organizations as t1')
                        ->where('t1.id', $row->org_id)
                        ->join('organization_types as t2', 't1.type_id = t2.id', 'LEFT')
                        ->get();

                    $r1 = $query->row_array();

                    $returnArr[] = array(
                        'id' => $r1['id'],
                        'name' => $r1['name'],
                        'address' => $r1['address'],
                        'contact' => $r1['contact'],
                        'email' => $r1['email'],
                        'type' => $r1['type']
                    );
                }
                $prevId = $row->org_id;
            }

            return $returnArr;
        }

        public function getOrganization($orgId) {
            $query = $this->db->select('t1.id, t1.name, t1.address, t1.contact, t1.email, t2.type')
                        ->from('organizations as t1')
                        ->where('t1.id', $orgId)
                        ->join('organization_types as t2', 't1.type_id = t2.id', 'LEFT')
                        ->get();
            return $query->result();
        }

        public function getRespondingAreas($orgId) {
            $query = $this->db
                    ->select('*')
                    ->from('responding_areas')
                    ->where('org_id', $orgId)
                    ->order_by('province', 'asc')
                    ->order_by('district', 'asc')
                    ->order_by('town', 'asc')
                    ->get();

            return $query->result();
        }

        public function getResponders($orgId) {
            $query = $this->db
                    ->select('first_name, last_name, contact, email, is_admin')
                    ->from('responders')
                    ->where('org_id', $orgId)
                    ->get();
            return $query->result();
        }

        public function verifyUser($email, $password) {
            $query = $this->db->get_where('responders', array('email' => $email));
            $hash = $query->row_array()['password'];
            
            if (empty($hash)) 
                return false;
            
            return password_verify($password, $hash);
        }

        public function getOrgId($email) {
            $query = $this->db->get_where('responders', array('email' => $email));
            return $query->row_array()['org_id'];
        }

        function extractLocations($str) {
            $arr = array_unique(explode('|', $str));
            $returnArr = array();

            foreach ($arr as $itm)
                $returnArr[] = explode('>', $itm);

            return $returnArr;
        }
    }