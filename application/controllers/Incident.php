<?php
    class Incident extends CI_Controller {
        public function view($id, $page = null) {
            if ($page === null)
                redirect('incident/'.$id.'/information');

            $this->redirectIfNotAuthorized();

            $this->load->helper('directory');

            $data['id'] = $id;
            $data['title'] = $page;
            $data['incident'] = $this->incident_model->getSingleIncident($id); 
            $data['responders'] = $this->incident_model->getResponders($id);
            $data['alerts'] = $this->incident_model->getAlerts($id);
            $data['tasks'] = $this->incident_model->getTasks($id);
            $data['casualties'] = $this->incident_model->getCasualties($id);
            $data['hospitalizations'] = $this->incident_model->getHospitalizations($id);
            $data['evacuations'] = $this->incident_model->getEvacuations($id);
            $data['pressReleases'] = $this->incident_model->getPressReleases($id);
            
            if (is_dir('assets/media/' . $id . '/images/'))
                $data['images'] = directory_map('./assets/media/' . $id . '/images/', 1);

            if (is_dir('assets/media/' . $id . '/videos/'))
                $data['videos'] = directory_map('./assets/media/' . $id . '/videos/', 1);

            $this->load->view('templates/header');
            $this->load->view('incident/incident', $data);
            $this->load->view('templates/footer');         
        }

        public function add() {
            $this->redirectIfNotAuthorized();

            $alertReceivers = $this->input->post('alerts-receivers');

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('location-list', 'Location List', 'required');

            if (!empty($alertReceivers))
                $this->form_validation->set_rules('alert', 'Alert', 'required');
            
            if ($this->form_validation->run() === FALSE) {                
                $formData = array(
                    'name' => $this->input->post('name'),
                    'type' => $this->input->post('type'),
                    'lat' => $this->input->post('lat'),
                    'long' => $this->input->post('long'),
                    'hazard_warning' => $this->input->post('warning')
                );
                $this->session->set_flashdata('errors', $this->form_validation->error_array());
                $this->session->set_flashdata('formData', $formData);
                redirect('employee/incidents/#add');
            } else {
                $this->incident_model->addIncident();
                redirect('employee/incidents/#add-success');
            }
        }

        public function getIncidentInfo() {
            $this->redirectIfNotAuthorized();

            $searchValue = $this->input->post('search-value');
            $searchType = $this->input->post('search-type');
            $onlyOngoing = $this->input->post('is-ongoing');

            $this->session->set_flashdata('searchValue', $searchValue);
            $this->session->set_flashdata('searchType', $searchType);

            if (empty($searchValue))
                redirect('employee/incidents/#search');

            $searchType = str_replace('-', '_', $searchType);

            if ($onlyOngoing === '1') {
                $this->session->set_flashdata('ongoing', 'checked');
            } else if ($onlyOngoing === '0') {
                $this->session->set_flashdata('ongoing', 'unchecked');
            } else if ($onlyOngoing === '-1') {
                $this->session->set_flashdata('ongoing', 'indeterminate');
            }

            $incidents = $this->incident_model->getIncidents($searchValue, $searchType, $onlyOngoing);

            if (empty($incidents))
                redirect('employee/incidents/#no-record');

            $this->session->set_flashdata('incidentResult', $incidents);
            redirect('employee/incidents/#search');
        }

        public function markComplete($id) {
            $this->redirectIfNotAuthorized();

            if ($this->incident_model->markComplete($id))
                redirect('incident/' . $id .'/information/');

            redirect('incident/' . $id .'/information/#update-error');
        }

        public function updateCasualties($id) {
            $this->redirectIfNotAuthorized();

            $this->form_validation->set_rules('deaths', 'Deaths', 'required');
            $this->form_validation->set_rules('wounded', 'Wounded', 'required');
            $this->form_validation->set_rules('missing', 'Missing', 'required');

            if ($this->form_validation->run() === FALSE) 
                redirect('incident/' . $id .'#update-error');

            if ($this->incident_model->updateCasualties($id))
                redirect('incident/' . $id);

            redirect('incident/' . $id .'/information/#update-error');
        }

        public function addEvacuations($id) {
            $this->redirectIfNotAuthorized();

            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('evacuees', 'Evacuees', 'required');
            $this->form_validation->set_rules('contact', 'Conact', 'required');

            if ($this->form_validation->run() === FALSE) 
                redirect('incident/' . $id .'#update-error');

            if ($this->incident_model->addEvacuations($id))
                redirect('incident/' . $id);

            redirect('incident/' . $id .'/information/#update-error');
        }

        public function updateEvacuations($id) {
            $this->redirectIfNotAuthorized();

            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('evacuees', 'Evacuees', 'required');
            $this->form_validation->set_rules('contact', 'Conact', 'required');

            if ($this->form_validation->run() === FALSE) 
                redirect('incident/' . $id .'#update-error');

            if ($this->incident_model->updateEvacuations($id))
                redirect('incident/' . $id);

            redirect('incident/' . $id .'/information/#update-error');
        }

        public function addLocation($id) {
            $this->redirectIfNotAuthorized();

            $locationString = $this->input->post('location-string');
            $alertOrgs = ($this->input->post('alert-orgs') === 'TRUE');

            if ($this->incident_model->addLocation($id, $locationString, $alertOrgs)) {
                redirect('incident/' . $id);
            } else {
                redirect('incident/' . $id . '/information/#location-error');
            }
        }

        public function uploadImage($id) {
            $this->redirectIfNotAuthorized();
            
            if (!is_dir('assets/media/' . $id .'/images/')) 
                mkdir('./assets/media/' . $id .'/images/', 0777, TRUE);

            $config['upload_path'] = './assets/media/' . $id .'/images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 256000;
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('user-image')) {
                // $error = array('error' => $this->upload->display_errors());
                redirect('incident/' . $id .'/media/#gallery-error');
            } else {
                $image_data = $this->upload->data();

                if ($image_data['image_height'] > 2000 || $image_data['image_width'] > 2000) {
                    $this->load->library('image_lib');

                    $config =  array(
                        'image_library'   => 'gd2',
                        'source_image'    =>  $image_data['full_path'],
                        'maintain_ratio'  =>  TRUE,
                        'width'           =>  2000,
                        'height'          =>  2000,
                    );
    
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }

                redirect('incident/' . $id .'/media');
            }
        }

        public function uploadVideo($id) {
            $this->redirectIfNotAuthorized();
            
            if (!is_dir('assets/media/' . $id . '/videos/')) 
                mkdir('./assets/media/' . $id. '/videos/', 0777, TRUE);

            $config['upload_path'] = './assets/media/' . $id . '/videos/';
            $config['allowed_types'] = 'mp4';
            $config['max_size'] = 524288000;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('user-video')) {
                // $error = array('error' => $this->upload->display_errors());
                redirect('incident/' . $id .'/media/#gallery-error');
            } else {
                $image_data = $this->upload->data();
                redirect('incident/' . $id .'/media');
            }
        }

        public function redirectIfNotAuthorized() {
            if (!$this->session->userdata('logged_in') 
                        || $this->session->userdata('user_type') !== 'Employee') 
                redirect('login');
        }

    }

?>