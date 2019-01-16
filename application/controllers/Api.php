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
        }
        
        if (count($data) > 0) {
            $data['status'] = 'OK';
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

        if (count($data) > 0) {
            $data['status'] = 'OK';
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }
    }

    public function alert_get() {
        $this->respondErrorIfNotAuthorized('Employee');

        $incidentId = $this->get('incidentId', true);

        $result = $this->incident_model->getAlerts($incidentId);

        foreach ($result as $row) {
            $data[$row->id] = array(
                'content' => $row->content
            );
        }

        if (count($data) > 0) {
            $data['status'] = 'OK';
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }

    }

    public function alert_post() {
        $this->respondErrorIfNotAuthorized('Employee');

        $incidentId = $this->post('incidentId', true);
        $content = $this->post('content', true);
        $isPublic = $this->post('isPublic', true);

        if ($this->incident_model->addAlert($incidentId, $content, $isPublic)) {
            $data = array(
                'status' => 'OK'
            );
        } else {
            $data = array(
                'status' => 'DB_ERROR'
            );
        }
        
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function alert_delete() {
        $this->respondErrorIfNotAuthorized('Employee');
        $alertId = $this->delete('alertId', true);

        if ($this->incident_model->deleteAlert($alertId)) {
            $data = array(
                'status' => 'OK'
            );
        } else {
            $data = array(
                'status' => 'DB_ERROR'
            );
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function warning_post() {
        $this->respondErrorIfNotAuthorized('Employee');

        $incidentId = $this->post('incidentId', true);
        $warning = $this->post('warning', true);

        if ($this->incident_model->updateWarning($incidentId, $warning)) {
            $data = array(
                'status' => 'OK'
            );
        } else {
            $data = array(
                'status' => 'DB_ERROR'
            );
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function task_post() {
        $this->respondErrorIfNotAuthorized('Employee');
        $incidentId = $this->post('incidentId', true);
        $taskContent = $this->post('taskContent', true);
        $respondingOrgId = $this->post('respongingOrg', true);

        if ($this->incident_model->addTask($incidentId, $respondingOrgId, $taskContent)) {
            $data = array(
                'status' => 'OK'
            );
        } else {
            $data = array(
                'status' => 'DB_ERROR'
            );
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function task_get() {
        $this->respondErrorIfNotAuthorized('Employee');
        $incidentId = $this->get('incidentId');

        $tasks = $this->incident_model->getTasks($incidentId);
        
        if (count($tasks) > 0) {
            $tasks['status'] = 'OK';
            $this->response($tasks, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }
    }

    public function article_save_post() {
        $this->respondErrorIfNotAuthorized('Employee');
        $incidentId = $this->post('incidentId', true);
        $articleId = (int) $this->post('articleId', true);
        $title = $this->post('title', true);
        $content = $this->post('content');
        $articleId = $this->article_model->save($incidentId, $title, $content, $articleId);

        if ($articleId > 0) {
            $data = array(
                'status' => 'OK',
                'articleId' => $articleId
            );
        } else {
            $data = array(
                'status' => 'DB_ERROR',
                'articleId' => $articleId
            );
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function article_publish_post() {
        $this->respondErrorIfNotAuthorized('Employee');
        $articleId = $this->post('articleId', true);

        if ($this->article_model->publish($articleId)) {
            $data = array(
                'status' => 'OK'
            );
        } else {
            $data = array(
                'status' => 'DB_ERROR'
            );
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function article_unpublish_post() {
        $this->respondErrorIfNotAuthorized('Employee');
        $articleId = $this->post('articleId', true);

        if ($this->article_model->unPublish($articleId)) {
            $data = array(
                'status' => 'OK'
            );
        } else {
            $data = array(
                'status' => 'DB_ERROR'
            );
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function article_delete() {
        $this->respondErrorIfNotAuthorized('Employee');
        $articleId = $this->delete('articleId', true);

        if ($this->article_model->delete($articleId)) {
            $data = array(
                'status' => 'OK'
            );
        } else {
            $data = array(
                'status' => 'DB_ERROR'
            );
        }

        $this->response($data, REST_Controller::HTTP_OK);
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