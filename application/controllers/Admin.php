<?php
    class Admin extends CI_Controller {
        public function view($page = 'employees') {
            if (!file_exists(APPPATH.'views/dashboard/admin/'.$page.'.php'))
                show_404();
            

            $data['title'] = ucfirst($page);

            $this->load->view('templates/header');
            $this->load->view('dashboard/admin/dashboard', $data);
        }

        public function addEmployee() {
            
        }
    }

?>