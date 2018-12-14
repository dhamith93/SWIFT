<?php
    class Admin extends CI_Controller {
        public function view($page = 'employees') {
            if (!file_exists(APPPATH.'views/dashboard/admin/'.$page.'.php'))
                show_404();
            

            $data['title'] = ucfirst($page);

            if (!empty($this->session->flashdata('errors')))
                $data['errors'] = $this->session->flashdata('errors');

            if (!empty($this->session->flashdata('formData')))
                $data['formData'] = $this->session->flashdata('formData');

            if (!empty($this->session->flashdata('employeeResult')))
                $data['employeeResult'] = $this->session->flashdata('employeeResult');
            
            $this->load->view('templates/header');
            $this->load->view('dashboard/admin/dashboard', $data);
            $this->load->view('templates/footer');
        }

        public function addEmployee() {
            $this->form_validation->set_rules('emp-id', 'Employee ID', 'required');
            $this->form_validation->set_rules('first-name', 'First Name', 'required');
            $this->form_validation->set_rules('last-name', 'Last Name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('password2', 'Password confirm', 'trim|required|matches[password]');
            $this->form_validation->set_rules('contact', 'Contact Number', 'required'); 
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email'); 

            
            if ($this->form_validation->run() === FALSE) {                
                $formData = array(
                    'emp_id' => $this->input->post('emp-id'),
                    'first_name' => $this->input->post('first-name'),
                    'last_name' => $this->input->post('last-name'),
                    'password' => $this->input->post('password'),
                    'password2' => $this->input->post('password2'),
                    'contact' => $this->input->post('contact'),
                    'email' => $this->input->post('email')
                );
                $this->session->set_flashdata('errors', $this->form_validation->error_array());
                $this->session->set_flashdata('formData', $formData);
                redirect('admin/employees/#add');
            } else {
                $this->employee_model->addEmployee();
                redirect('admin/employees/#add-success');
            }
        }

        public function getEmployeeInfo() {
            $empId = $this->input->post('emp-id');

            if (empty($empId))
                redirect('admin/employees/');

            $employee = $this->employee_model->getEmployee($empId);

            if (empty($employee))
                redirect('admin/employees/#no-record');

            $this->session->set_flashdata('employeeResult', $employee);
            redirect('admin/employees/');
        }

        public function deleteEmployee() {
            $empId = $this->input->post('emp-id');

            if (empty($empId))
                redirect('admin/employees/');

            if ($this->employee_model->deleteEmployee($empId) === TRUE);
                redirect('admin/employees/#delete-success');

            redirect('admin/employees/#delete-error');
        }
    }

?>