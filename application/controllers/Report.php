<?php
    class Report extends CI_Controller {
        public function view() {
            $this->load->view('templates/header');

            if (!empty($_POST)) {
                $data['report'] = $this->generateReport();
                $this->load->view('report/main', $data);
            } else {
                $this->load->view('report/main');
            }

            $this->load->view('templates/footer');
        }

        private function generateReport() {
            $startDate = $this->input->post('start-date');
            $endDate = $this->input->post('end-date');
            $location = $this->input->post('location');
            $locationType = $this->input->post('location-type');

            if (!empty($startDate) && !empty($endDate) && !empty($location) && !empty($locationType)) {
                if ($locationType === 'all')
                    return $this->incident_model->getBetween($startDate, $endDate);

                return $this->incident_model->getBetween($startDate, $endDate, $location, $locationType);
                    
            } else {
                echo 'EMPTY';
            }
        }
    }    