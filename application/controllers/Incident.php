<?php
    class Incident extends CI_Controller {
        public function add() {
            $this->redirectIfNotAuthorized();

            $alertReceivers = $this->input->post('alerts-receivers');

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('province', 'Province', 'required');
            $this->form_validation->set_rules('district', 'District', 'required');
            $this->form_validation->set_rules('location', 'Location', 'required');

            if (!empty($alertReceivers))
                $this->form_validation->set_rules('alert', 'Alert', 'required');
            
            if ($this->form_validation->run() === FALSE) {                
                $formData = array(
                    'name' => $this->input->post('name'),
                    'type' => $this->input->post('type'),
                    'province' => $this->input->post('province'),
                    'district' => $this->input->post('district'),
                    'location' => $this->input->post('location'),
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

            $this->session->set_flashdata('searchValue', $searchValue);
            $this->session->set_flashdata('searchType', $searchType);

            if (empty($searchValue))
                redirect('employee/incidents/');

            $searchType = str_replace('-', '_', $searchType);

            $onlyOngoing = (null !== $this->input->post('is-ongoing')) ? true : false;

            if ($onlyOngoing) {
                $this->session->set_flashdata('ongoing', 'checked');
            } else {
                $this->session->set_flashdata('ongoing', 'unchecked');
            }


            $incidents = $this->incident_model->getIncidents($searchValue, $searchType, $onlyOngoing);

            if (empty($incidents))
                redirect('employee/incidents/#no-record');

            $this->session->set_flashdata('incidentResult', $incidents);
            redirect('employee/incidents/#search');
        }

        public function redirectIfNotAuthorized() {
            if (!$this->session->userdata('logged_in') 
                        || $this->session->userdata('user_type') !== 'Employee') 
                redirect('login');
        }

    }

?>