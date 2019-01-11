<?php
    class Article extends CI_Controller {
        public function add($incidentId) {
            $this->load->helper('directory');
            
            if (is_dir('assets/media/' . $incidentId . '/images/'))
                $data['images'] = directory_map('./assets/media/' . $incidentId . '/images/', 1);
            
            $data['id'] = $incidentId;

            $this->load->view('templates/header');
            $this->load->view('incident/article', $data);
        }

        public function redirectIfNotAuthorized() {
            if (!$this->session->userdata('logged_in') 
                        || $this->session->userdata('user_type') !== 'Employee') 
                redirect('login');
        }
    }
?>