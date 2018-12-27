<?php
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

    // http://localhost:8888/SWIFT/api/test/
    public function test_get() {
        $testVar = $this->get('inc_id');
        $data = $this->incident_model->getAlerts($testVar);
        // $data = array('response' => $testVar);

        if(count($data ) > 0) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response($error, REST_Controller::HTTP_OK);
        }
    }

    public function organizations_get() {
        $this->respondErrorIfNotAuthorized('Employee');

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

    public function responding_orgs_post() {
        $this->respondErrorIfNotAuthorized('Employee');

        $orgId = $this->post('orgId', true);
        $incidentId = $this->post('incidentId', true);

        if ($this->incident_model->responderExists($orgId, $incidentId)) {
            $data = array('status' => 'ERROR', 'msg' => 'RECORD_EXISTS');
        } else {
            if ($this->incident_model->notifyResponder($orgId, $incidentId)) {
                $data = array('status' => 'OK');
            } else {
                $data = array('status' => 'ERROR', 'msg' => 'DB_FAILURE');
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function responding_orgs_get() {
        $this->respondErrorIfNotAuthorized('Employee');

        $incidentId = $this->get('incidentId', true);

        $result = $this->incident_model->getResponders($incidentId);

        foreach ($result as $row) {
            $data[$row->id] = array(
                'name' => $row->name,
                'type' => $row->type,
                'address' => $row->address,
                'contact' => $row->contact,
                'email' => $row->email
            );
        }

        if (count($data ) > 0) {
            $data['status'] = 'OK';
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }
    }
    
    public function employee_get() {
        $this->respondErrorIfNotAuthorized('Admin');

        $employeeId = $this->get('emp-id');
        $employee = $this->employee_model->getEmployee($employeeId);
        if(!empty($employee)) {
            $this->response($employee, REST_Controller::HTTP_OK);
        } else {
            $error = array('status' => 'NO_RECORDS');
            $this->response($error, REST_Controller::HTTP_OK);
        }
    }

    public function respondErrorIfNotAuthorized($userType) {
        if (!$this->session->userdata('logged_in') 
                    || $this->session->userdata('user_type') !== $userType)
            $this->response(array('status' => 'UNAUTHORIZED_ACCESS'), REST_Controller::HTTP_UNAUTHORIZED);
    }
} 
?>