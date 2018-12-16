<?php
    class Employee extends CI_Controller {
        public function view($page = 'incidents') {
            $this->redirectIfNotAuthorized();

            if (!file_exists(APPPATH.'views/dashboard/employee/'.$page.'.php'))
                show_404();

            $data['title'] = ucfirst($page);
            $data['section'] = 'employee';

            if (!empty($this->session->flashdata('errors')))
                $data['errors'] = $this->session->flashdata('errors');

            if (!empty($this->session->flashdata('formData')))
                $data['formData'] = $this->session->flashdata('formData');

            if (!empty($this->session->flashdata('incidentResult')))
                $data['incidentResult'] = $this->session->flashdata('incidentResult');

            if (!empty($this->session->flashdata('searchValue')))
                $data['searchValue'] = $this->session->flashdata('searchValue');
            
            if (!empty($this->session->flashdata('searchType')))
                $data['searchType'] = $this->session->flashdata('searchType');

            if (!empty($this->session->flashdata('ongoing')))
                $data['ongoing'] = $this->session->flashdata('ongoing');

            $this->load->view('templates/header');
            $this->load->view('dashboard/dashboard', $data);
            $this->load->view('templates/footer');
        }

        public function redirectIfNotAuthorized() {
            if (!$this->session->userdata('logged_in') 
                        || $this->session->userdata('user_type') !== 'Employee') 
                redirect('login');
        }
    }
?>