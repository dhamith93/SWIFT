<?php
    class Responder extends CI_Controller {
        public function view($page = null) {
            // check auth

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
    }    