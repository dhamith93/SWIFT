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
            $error = array('message' => 'No record found');
            $this->response($error, REST_Controller::HTTP_OK);
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
} 
?>