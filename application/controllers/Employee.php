<?php
    class Employee extends CI_Controller {
        public function view($page = 'default') {
            $this->redirectIfNotAuthorized();

            if ($page === 'default')
                redirect('employee/incidents/');

            if (!file_exists(APPPATH.'views/dashboard/employee/'.$page.'.php'))
                show_404();

            $data['title'] = ucfirst($page);
            $data['section'] = 'employee';

            if (!empty($this->session->flashdata('errors')))
                $data['errors'] = $this->session->flashdata('errors');

            if (!empty($this->session->flashdata('formData')))
                $data['formData'] = $this->session->flashdata('formData');

            if (!empty($this->session->flashdata('incidentResult')))
                $data['incidentResults'] = $this->session->flashdata('incidentResult');

            if (!empty($this->session->flashdata('organizationResult')))
                $data['organizationResult'] = $this->session->flashdata('organizationResult');

            if (!empty($this->session->flashdata('orgSearchValue')))
                $data['orgSearchValue'] = $this->session->flashdata('orgSearchValue');

            if (!empty($this->session->flashdata('orgType')))
                $data['orgType'] = $this->session->flashdata('orgType');

            if (!empty($this->session->flashdata('locationType')))
                $data['locationType'] = $this->session->flashdata('locationType');

            if (!empty($this->session->flashdata('searchValue')))
                $data['searchValue'] = $this->session->flashdata('searchValue');
            
            if (!empty($this->session->flashdata('searchType')))
                $data['searchType'] = $this->session->flashdata('searchType');

            if (!empty($this->session->flashdata('ongoing')))
                $data['ongoing'] = $this->session->flashdata('ongoing');

            $data['incidents'] = $this->incident_model->getOngoingIncidents();

            $this->load->view('templates/header');
            $this->load->view('dashboard/dashboard', $data);
            $this->load->view('templates/footer');
        }

        public function changePassword() {
            $this->form_validation->set_rules('current', 'Current password', 'trim|required');
            $this->form_validation->set_rules('new', 'New password', 'trim|required');
            $this->form_validation->set_rules('new-confirm', 'New password confirm', 'trim|required|matches[new]'); 

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('errors', $this->form_validation->error_array());
                $this->session->set_flashdata('formData', $formData);
                redirect('employee/settings/');
            } 

            $username = $this->session->userdata('username');
            $password = $this->input->post('current');
            $newPassword = $this->input->post('new');
            
            if (!$this->employee_model->verifyUser($username, $password)) {
                $this->session->set_flashdata('errors', array('current' => 'invalid'));
                redirect('employee/settings/');
            }

            if ($this->employee_model->changePassword($username, $newPassword))
                redirect('employee/settings/#password-changed');

            redirect('employee/settings/#password-change-error');
            
        }

        public function redirectIfNotAuthorized() {
            if (!$this->session->userdata('logged_in') 
                        || $this->session->userdata('user_type') !== 'Employee') 
                redirect('login');
        }
    }
?>