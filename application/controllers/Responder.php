<?php
    class Responder extends CI_Controller {
        public function view($page = null) {
            $this->redirectIfNotAuthorized('Responder');

            if ($page === null)
                redirect('responder/incidents/');

            $orgId = $this->session->userdata('org_id');
            $resId = $this->session->userdata('res_id');

            $data['title'] = ucfirst($page);
            $data['section'] = 'responder';
            $data['orgId'] = $orgId;
            $data['resId'] = $resId;

            if ($page === 'incidents') 
                $data['incidents'] = $this->incident_model->getOngoingIncidentsFor($resId);

            if ($page === 'tasks') 
                $data['tasks'] = $this->responder_model->getTasks($resId);

            $this->load->view('templates/header');
            $this->load->view('dashboard/dashboard', $data);
            $this->load->view('templates/footer');
        }

        public function incidentView($id, $page = null) {
            $this->redirectIfNotAuthorized('Responder');
    
            if ($page === null)
                redirect('responder/incident/'.$id.'/information');

            $resId = $this->session->userdata('res_id');
    
            $this->load->helper('directory');
    
            $orgId = $this->session->userdata('org_id');
            $data['id'] = $id;
            $data['orgId'] = $orgId;
            $data['title'] = $page;
            $data['incident'] = $this->incident_model->getSingleIncident($id);
            $data['resId'] = $resId;
            
            if ($page === 'information') {
                $data['casualties'] = $this->incident_model->getCasualties($id);
                $data['hospitalizations'] = $this->incident_model->getHospitalizations($id);
                $data['evacuations'] = $this->incident_model->getEvacuations($id);
            }
    
            if ($page === 'alerts-warnings')
                $data['alerts'] = $this->incident_model->getAlerts($id);
        
            if ($page === 'tasks') {
                // $data['tasks'] = $this->incident_model->getTasksFor($orgId, $id);
                $data['tasks'] = $this->responder_model->getTasks($resId, $id);
            }

            if ($page === 'requests') {
                $data['requests'] = $this->incident_model->getRequests($id);
            }
    
            if ($page === 'media') {
                if (is_dir('assets/media/' . $id . '/images/'))
                    $data['images'] = directory_map('./assets/media/' . $id . '/images/', 1);
    
                if (is_dir('assets/media/' . $id . '/videos/'))
                    $data['videos'] = directory_map('./assets/media/' . $id . '/videos/', 1);
            }
            
    
            $this->load->view('templates/header');
            $this->load->view('dashboard/responder/incident/incident', $data);
            $this->load->view('templates/footer'); 
        }  

        public function markTaskCompleted($taskId, $incidentId = null) {
            $this->redirectIfNotAuthorized('Responder');

            $orgId = $this->session->userdata('org_id');

            if ($this->incident_model->markTaskCompleted($taskId)) {
                if ($incidentId !== null) {
                    redirect('responder/incident/'.$incidentId.'/tasks');
                } else {
                    redirect('responder/tasks');
                }
            }

            if ($incidentId !== null) {
                redirect('responder/incident/'.$incidentId.'/tasks#update-error');
            }

            redirect('responder/tasks#update-error');
        }

        public function markRequestCompleted($requestId, $incidentId) {
            $this->redirectIfNotAuthorized('Responder');

            if ($this->incident_model->markRequestCompleted($requestId)) {
                if ($incidentId !== null) {
                    redirect('responder/incident/'.$incidentId.'/tasks');
                }
            }

            redirect('responder/');
        }

        public function addRequest() {
            $this->redirectIfNotAuthorized('Responder');

            $this->form_validation->set_rules('inc-id', 'Incident Id', 'required');
            $this->form_validation->set_rules('res-id', 'Responder ID', 'required');
            $this->form_validation->set_rules('request-content', 'Request Content', 'required'); 
            $this->form_validation->set_rules('priority', 'Request Priority', 'required'); 

            if ($this->form_validation->run()) {
                $incidentId = $this->input->post('inc-id', true);
                $resId = $this->input->post('res-id', true);
                $content = $this->input->post('request-content', true);
                $priority = $this->input->post('priority', true);
    
                $this->incident_model->addRequest($incidentId, $resId, $content, $priority);
                redirect('responder/incident/'.$incidentId.'/requests');
            }

            redirect('responder/');
        }

        public function redirectIfNotAuthorized($userType) {
            if (!$this->session->userdata('logged_in') 
                        || $this->session->userdata('user_type') !== $userType) 
                redirect('login');
        }
    } 
