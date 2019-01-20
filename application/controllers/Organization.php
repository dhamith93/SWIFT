<?php
    class Organization extends CI_Controller {
        public function view($page = null) {
            $this->redirectIfNotAuthorized('Organization');

            if ($page === null)
                redirect('organization/incidents');

            
            $orgId = $this->session->userdata('org_id');

            $data['title'] = ucfirst($page);
            $data['section'] = 'organization';
            $data['orgId'] = $orgId;
            $data['incidents'] = $this->incident_model->getOngoingIncidentsOf($orgId);
            $data['alerts'] = $this->incident_model->getAlertsFor($orgId);
            $data['tasks'] = $this->incident_model->getTasksFor($orgId);

            if (!empty($this->session->flashdata('errors')))
                $data['errors'] = $this->session->flashdata('errors');

            if (!empty($this->session->flashdata('formData')))
                $data['formData'] = $this->session->flashdata('formData');

            if (!empty($this->session->flashdata('responderResult')))
                $data['responderResult'] = $this->session->flashdata('responderResult');

            if (!empty($this->session->flashdata('searchValue')))
                $data['searchValue'] = $this->session->flashdata('searchValue');
            
            if (!empty($this->session->flashdata('searchType')))
                $data['searchType'] = $this->session->flashdata('searchType');

            $this->load->view('templates/header');
            $this->load->view('dashboard/dashboard', $data);
            $this->load->view('templates/footer');
        }

        public function incidentView($id, $page = null) {
            if ($page === null)
                redirect('organization/incident/'.$id.'/information');

            $this->load->helper('directory');

            $orgId = $this->session->userdata('org_id');
            $data['id'] = $id;
            $data['orgId'] = $orgId;
            $data['title'] = $page;
            $data['incident'] = $this->incident_model->getSingleIncident($id);
            $data['alerts'] = $this->incident_model->getAlerts($id);
            $data['responders'] = $this->responder_model->getRespondersOf($id, $orgId);
            $data['tasks'] = $this->incident_model->getTasksFor($orgId, $id);
            $data['casualties'] = $this->incident_model->getCasualties($id);
            $data['hospitalizations'] = $this->incident_model->getHospitalizations($id);
            $data['evacuations'] = $this->incident_model->getEvacuations($id);
            
            if (is_dir('assets/media/' . $id . '/images/'))
                $data['images'] = directory_map('./assets/media/' . $id . '/images/', 1);

            if (is_dir('assets/media/' . $id . '/videos/'))
                $data['videos'] = directory_map('./assets/media/' . $id . '/videos/', 1);

            $this->load->view('templates/header');
            $this->load->view('dashboard/organization/incident/incident', $data);
            $this->load->view('templates/footer'); 
        }

        public function singleOrganizationView($id) {
            $this->redirectIfNotAuthorized('Employee');

            $data['id'] = $id;
            $data['organization'] = $this->organization_model->getOrganization($id);
            $data['respondingAreas'] = $this->organization_model->getRespondingAreas($id);
            $data['responders'] = $this->organization_model->getResponders($id);

            $this->load->view('templates/header');
            $this->load->view('organization/single-organization-view', $data);
        }

        public function add() {
            $this->redirectIfNotAuthorized('Employee');

            $this->form_validation->set_rules('org-name', 'Organization name', 'required');
            $this->form_validation->set_rules('org-contact', 'Contact number', 'required'); 
            $this->form_validation->set_rules('address', 'Address', 'required'); 
            $this->form_validation->set_rules('location-list', 'Responding areas', 'required'); 
            $this->form_validation->set_rules('org-email', 'Organization email', 'trim|required|valid_email');
            $this->form_validation->set_rules('first-name', 'First name', 'required');
            $this->form_validation->set_rules('last-name', 'Last name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('password2', 'Password confirm', 'trim|required|matches[password]');
            $this->form_validation->set_rules('position', 'Position', 'required');
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
                    'position' => $this->input->post('position'),
                    'password' => $this->input->post('password'),
                    'password2' => $this->input->post('password2'),
                    'contact' => $this->input->post('contact'),
                    'email' => $this->input->post('email')
                );
                $this->session->set_flashdata('errors', $this->form_validation->error_array());
                $this->session->set_flashdata('formData', $formData);
                redirect('employee/organizations/#add');
            } else {
                if ($this->organization_model->add())
                    redirect('employee/organizations/#add-success');
                    
                redirect('employee/organizations/#add-error');
            }
        }

        public function addResponder() {
            $this->redirectIfNotAuthorized('Organization');

            $this->form_validation->set_rules('org-id', 'Organization ID', 'required');
            $this->form_validation->set_rules('first-name', 'First name', 'required');
            $this->form_validation->set_rules('last-name', 'Last name', 'required');
            $this->form_validation->set_rules('position', 'Position', 'required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('password2', 'Password confirm', 'trim|required|matches[password]');
            $this->form_validation->set_rules('contact', 'Admin contact number', 'required'); 
            $this->form_validation->set_rules('email', 'Admin email', 'trim|required|valid_email');

            if ($this->form_validation->run() === FALSE) {                
                $formData = array(
                    'org_name' => $this->input->post('org-id'),
                    'first_name' => $this->input->post('first-name'),
                    'last_name' => $this->input->post('last-name'),
                    'password' => $this->input->post('password'),
                    'password2' => $this->input->post('password2'),
                    'position' => $this->input->post('position'),
                    'contact' => $this->input->post('contact'),
                    'email' => $this->input->post('email')
                );
                $this->session->set_flashdata('errors', $this->form_validation->error_array());
                $this->session->set_flashdata('formData', $formData);
                redirect('organization/responders/#add');
            } else {
                $orgId = $this->input->post('org-id');
                if ($this->responder_model->add($orgId))
                    redirect('organization/responders/#add-success');

                redirect('organization/responders/#add-error');
            }
        }

        public function getResponderInfo() {
            $this->redirectIfNotAuthorized('Organization');

            $searchValue = $this->input->post('search-value');
            $searchType = $this->input->post('search-type');
            $orgId = $this->input->post('org-id');

            $this->session->set_flashdata('searchValue', $searchValue);
            $this->session->set_flashdata('searchType', $searchType);

            if (empty($searchValue) || empty($orgId))
                redirect('organization/responders/');

            $searchType = str_replace('-', '_', $searchType);

            $responders = $this->responder_model->getResponders($orgId, $searchValue, $searchType);

            if (empty($responders))
                redirect('organization/responders/#no-record');

            $this->session->set_flashdata('responderResult', $responders);
            redirect('organization/responders/');
        }

        public function makeAdmin() {
            $this->redirectIfNotAuthorized('Organization');

            $responderId = $this->input->post('responder-id');
            $orgId = $this->input->post('org-id');

            if ($this->responder_model->makeAdmin($orgId, $responderId))
                redirect('logout');

            redirect('organization/responders/#delete-error');
        }

        public function deleteResponder() {
            $this->redirectIfNotAuthorized('Organization');

            $responderId = $this->input->post('responder-id');

            if ($this->responder_model->delete($responderId))
                redirect('organization/responders/#delete-success');

            redirect('organization/responders/#delete-error');

        }

        public function getOrganizationInfo() {
            $this->redirectIfNotAuthorized('Employee');
            
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

        public function markTaskCompleted($taskId) {
            $this->redirectIfNotAuthorized('Organization');
            $orgId = $this->session->userdata('org_id');

            if ($this->incident_model->markTaskCompleted($taskId, $orgId))
                redirect('organization/tasks');

            redirect('organization/tasks#update-error');
        }

        public function redirectIfNotAuthorized($userType) {
            if (!$this->session->userdata('logged_in') 
                        || $this->session->userdata('user_type') !== $userType) 
                redirect('login');
        }
    }