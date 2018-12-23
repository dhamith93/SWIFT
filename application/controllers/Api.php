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

        $orgType = $this->get('orgType');
        $searchValue = $this->get('searchValue');
        $searchType = $this->get('searchType');

        $data = array(
            'id_1' => array(
                'name' => '_name',
                'type' => '_type',
                'contact' => '_contact',
                'address' => '_address',
            ),
            'id_2' => array(
                'name' => '_name1',
                'type' => '_type1',
                'contact' => '_contact1',
                'address' => '_address1',
            ),
            'id_3' => array(
                'name' => '_name2',
                'type' => '_type2',
                'contact' => '_contact2',
                'address' => '_address2',
            )
        );

        if(count($data ) > 0) {
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
            $error = array('message' => 'No record found');
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