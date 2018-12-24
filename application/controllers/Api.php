<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

    // http://localhost:8888/SWIFT/api/test/
    public function test_get() {
        $testVar = $this->get('var');
        $data = array('response' => $testVar);

        if(count($data ) > 0) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response($error, REST_Controller::HTTP_OK);
        }
    }

    public function organizations_get() {
        $this->respondErrorIfNotAuthorized();

        $orgType = $this->get('orgType', true);
        $searchValue = $this->get('searchValue', true);
        $locationType = $this->get('searchType', true);

        $data = array();

        if (!empty($searchValue)) {
            $result = $this->organization_model->getOrganizations($orgType, $searchValue, $locationType);

            foreach ($result as $row) {
                $data[$row['id']] = array(
                    'name' => $row['name'],
                    'type' => $row['type'],
                    'address' => $row['address'],
                    'contact' => $row['contact'],
                    'email' => $row['email']
                );
            }

            if (count($data ) > 0)
                $data['status'] = 'OK';
        }

        if (count($data ) > 0) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }
    }
    
    public function employee_get() {
        $employeeId = $this->get('emp-id');
        $employee = $this->employee_model->getEmployee($employeeId);
        if(!empty($employee)) {
            $this->response($employee, REST_Controller::HTTP_OK);
        } else {
            $error = array('status' => 'NO_RECORDS');
            $this->response($error, REST_Controller::HTTP_OK);
        }
    }

    public function respondErrorIfNotAuthorized() {
        if (!$this->session->userdata('logged_in') 
                    || $this->session->userdata('user_type') !== 'Employee')
            $this->response(array('status' => 'UNAUTHORIZED_ACCESS'), REST_Controller::HTTP_UNAUTHORIZED);
    }
} 
?>