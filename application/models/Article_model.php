<?php
    class Article_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        public function get($articleId) {
            $query = $this->db->get_where('press_releases', array('id' => $articleId));
            return $query->row();
        }

        public function save($incidentId, $title, $content, $articleId) {
            if ($articleId > -1) {
                $data = array(
                    'title' => htmlspecialchars($title),
                    'content' => htmlspecialchars($content)
                );
                $this->db->where('id', $articleId);
                $this->db->update('press_releases', $data);
                return $articleId;
            } else {
                $data = array(
                    'inc_id' => $incidentId,
                    'title' => htmlspecialchars($title),
                    'content' => htmlspecialchars($content),
                    'written_by' => $this->employee_model->getEmployee(
                                        $this->session->userdata('username')
                                    )[0]->id
                );
                $this->db->insert('press_releases', $data);
                return $this->db->insert_id(); 
            }
        }

        public function publish($articleId) {
            $this->db->where('id', $articleId);
            return $this->db->update('press_releases', array('is_published' => '1'));
        }

        public function unPublish($articleId) {
            $this->db->where('id', $articleId);
            return $this->db->update('press_releases', array('is_published' => '0'));
        }

        public function delete($articleId) {
            $this->db->where('id', $articleId);
            return $this->db->delete('press_releases');
        }
    }


?>