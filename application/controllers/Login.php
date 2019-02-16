<?php
    class Login extends CI_Controller {
        public function view() {
            $data = null;
            if (!empty($this->session->flashdata('errors')))
                $data['errors'] = $this->session->flashdata('errors');

            if (!empty($this->session->flashdata('formData')))
                $data['formData'] = $this->session->flashdata('formData');

            $this->load->view('templates/header');
            $this->load->view('login', $data);
            $this->load->view('templates/footer');
        }

        public function userLogin() {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === FALSE) {                
                $formData = array(
                    'username' => $this->input->post('username')
                );
                $this->session->set_flashdata('errors', $this->form_validation->error_array());
                $this->session->set_flashdata('formData', $formData);
                redirect('login');
            }
            
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $accountType = $this->input->post('acct-type');

            $verified = false;

            switch ($accountType) {
                case 'Employee':
                    $verified = $this->employee_model->verifyUser($username, $password);
                    break;
                case 'Organization':
                case 'Responder':
                    $verified = $this->organization_model->verifyUser($username, $password);
                    break;
                default:
                    break;
            }

            if ($verified) {
                $userData = array(
                    'username' => $username,
                    'logged_in' => true,
                    'user_type' => $accountType,
                    'org_id' => ($accountType === 'Organization') ? $this->organization_model->getOrgId($username) : 'null',
                    'res_id' => ($accountType === 'Responder') ? $this->responder_model->getResId($username) : 'null',
                    'is_admin' => $this->employee_model->isAdmin($username) ? true : false
                );
                
                $this->session->set_userdata($userData);
                $this->employee_model->setLoginDateTime($username, $this->input->post('date-time'));

                switch ($accountType) {
                    case 'Employee':
                        redirect('employee');
                        break;
                    case 'Organization':
                        redirect('organization');
                        break;
                    case 'Responder':
                        redirect('responder');
                        break;
                    default:
                        redirect('login');
                        break;
                }
            } else {
                $this->session->set_flashdata('errors', array('loginError' => true));
                redirect('login');
            }
        }

        public function userLogout() {
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('logged_in');
            redirect('login');
        }
    }

?>