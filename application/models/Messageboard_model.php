<?php
    class Messageboard_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function addMessage($incidentId, $content, $userType, $userId, $name, $organization) {
            $data = array(
                'inc_id' => (int) $incidentId,
                'content' => $content,
                'user_type' => $userType,
                'user_id' => (int) $userId,
                'organization' => $organization,
                'name' => $name
            );

            $this->db->insert('messages', $data);
            return $this->db->insert_id(); 
        }

        public function getMessages($incidentId, $from, $count, $direction) {
            $query = $this->db->select('*')
                     ->from('messages')
                     ->where('inc_id', $incidentId)
                     ->where('id ' . $direction . ' ', $from)
                     ->order_by('id', 'DESC')
                     ->limit($count)
                     ->get();

            return $query->result();
        }

        public function getLatestMsgId($incidentId) {
            $query = $this->db->select('id')
                     ->from('messages')
                     ->where('inc_id', $incidentId)
                     ->order_by('id', 'DESC')
                     ->limit(1)
                     ->get();

            return $query->result();
        }

        public function getFirstMsgId($incidentId) {
            $query = $this->db->select('id')
                     ->from('messages')
                     ->where('inc_id', $incidentId)
                     ->order_by('id', 'ASC')
                     ->limit(1)
                     ->get();

            return $query->result();
        }
    }