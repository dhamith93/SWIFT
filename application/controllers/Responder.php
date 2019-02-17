<?php
    class Responder extends CI_Controller {
        public function view($page = null) {
            $this->redirectIfNotAuthorized('Responder');

            if ($page === null)
                redirect('responder/incidents');

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

        public function redirectIfNotAuthorized($userType) {
            if (!$this->session->userdata('logged_in') 
                        || $this->session->userdata('user_type') !== $userType) 
                redirect('login');
        }
    } 
