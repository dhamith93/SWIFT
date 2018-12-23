<?php
    class Organization extends CI_Controller {
        public function singleOrganizationView($id) {
            echo $id;
        }

        public function add() {
            $this->form_validation->set_rules('org-name', 'Organization name', 'required');
            $this->form_validation->set_rules('org-contact', 'Contact number', 'required'); 
            $this->form_validation->set_rules('address', 'Address', 'required'); 
            $this->form_validation->set_rules('location-list', 'Responding areas', 'required'); 
            $this->form_validation->set_rules('org-email', 'Organization email', 'trim|required|valid_email');
            $this->form_validation->set_rules('first-name', 'First name', 'required');
            $this->form_validation->set_rules('last-name', 'Last name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('password2', 'Password confirm', 'trim|required|matches[password]');
            $this->form_validation->set_rules('contact', 'Admin contact number', 'required'); 
            $this->form_validation->set_rules('email', 'Admin email', 'trim|required|valid_email'); 

            if ($this->form_validation->run() === FALSE) {                
                $formData = array(
                    'org_name' => $this->input->post('org-name'),
                    'org_contact' => $this->input->post('org-contact'),
                    'address' => $this->input->post('address'),
                    'org_email' => $this->input->post('org-email'),
                    'first_name' => $this->input->post('first-name'),
                    'last_name' => $this->input->post('last-name'),
                    'password' => $this->input->post('password'),
                    'password2' => $this->input->post('password2'),
                    'contact' => $this->input->post('contact'),
                    'email' => $this->input->post('email')
                );
                $this->session->set_flashdata('errors', $this->form_validation->error_array());
                $this->session->set_flashdata('formData', $formData);
                redirect('employee/organizations/#add');
            } else {
                $this->organization_model->add();
                redirect('employee/organizations/#add-success');
            }
        }

        public function getOrganizationInfo() {
            echo $this->input->post('name');
        }
    }