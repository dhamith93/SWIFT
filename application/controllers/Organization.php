<?php
    class Organization extends CI_Controller {
        public function singleOrganizationView($id) {
            $this->redirectIfNotAuthorized();

            $data['id'] = $id;
            $data['organization'] = $this->organization_model->getOrganization($id);
            $data['respondingAreas'] = $this->organization_model->getRespondingAreas($id);
            $data['responders'] = $this->organization_model->getResponders($id);
            // $data['isOrgAdmin'] = $this->organization_model->isOrgAdmin($id);

            // $data['isOrgAdmin'] = true; // for test

            $this->load->view('templates/header');
            $this->load->view('organization/single-organization-view', $data);
        }

        public function add() {
            $this->redirectIfNotAuthorized();

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
                if ($this->organization_model->add()) {
                    redirect('employee/organizations/#add-success');
                } else {
                    redirect('employee/organizations/#add-error');
                }
            }
        }

        public function getOrganizationInfo() {
            $this->redirectIfNotAuthorized();
            
            $orgType = $this->input->post('org-type', true);
            $searchValue = $this->input->post('search-value', true);
            $locationType = $this->input->post('location-type', true);

            if (!empty($searchValue)) {
                $result = $this->organization_model->getOrganizations($orgType, $searchValue, $locationType);
    
                if (count($result) > 0)
                    $this->session->set_flashdata('organizationResult', $result);
            }

            $this->session->set_flashdata('orgType', $orgType);
            $this->session->set_flashdata('orgSearchValue', $searchValue);
            $this->session->set_flashdata('locationType', $locationType);

            redirect('employee/organizations/');
        }

        public function redirectIfNotAuthorized() {
            if (!$this->session->userdata('logged_in') 
                        || $this->session->userdata('user_type') !== 'Employee') 
                redirect('login');
        }
    }