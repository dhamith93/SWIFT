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

    public function org_responders_get() {
        $this->respondErrorIfNotAuthorized('Organization');
        $orgId = $this->get('orgId', true);
        $searchType = $this->get('searchType', true);
        $searchValue = $this->get('searchValue', true);

        $searchType = str_replace('-', '_', $searchType);

        $result = $this->responder_model->getAvailableRespondersOf($orgId, $searchType, $searchValue);

        foreach ($result as $row) {
            $data[$row->id] = array(
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'position' => $row->position,
                'contact' => $row->contact,
                'email' => $row->email
            );
        }

        if (!empty($data) && count($data) > 0) {
            $data['status'] = 'OK';
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }
    }

    public function org_responder_get() {
        $this->respondErrorIfNotAuthorized('Organization');
        $orgId = $this->get('orgId', true);
        $searchType = $this->get('searchType', true);
        $searchValue = $this->get('searchValue', true);

        $searchType = str_replace('-', '_', $searchType);

        $result = $this->responder_model->getResponders($orgId, $searchValue, $searchType);

        foreach ($result as $row) {
            $data[$row->id] = array(
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'position' => $row->position,
                'contact' => $row->contact,
                'email' => $row->email
            );
        }

        if (!empty($data) && count($data) > 0) {
            $data['status'] = 'OK';
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }
    }

    public function add_responder_post() {
        $this->respondErrorIfNotAuthorized('Organization');
        $incidentId = $this->post('incidentId', true);
        $responderId = $this->post('responderId', true);

        if ($this->responder_model->assignToIncident($incidentId, $responderId)) {
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

    public function unseen_request_count_get() {
        $this->respondErrorIfNotAuthorized('Employee');
        $incidentId = $this->get('incidentId', true);

        $unseenRequestCount = $this->incident_model->getUnseenRequestCount($incidentId);

        if ($unseenRequestCount >= 0) {
            $data = array(
                'count' => $unseenRequestCount,
                'status' => 'OK'
            );
        } else {
            $data = array(
                'status' => 'DB_ERROR'
            );
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function add_message_post() {
        $incidentId = $this->post('incidentId', true);
        $content = $this->post('content', true);
        $userType = $this->session->userdata('user_type');
        $username = $this->session->userdata('username');

        if ($userType === 'Employee') {
            $userId = $this->employee_model->getEmpId($username);
            $name = $this->employee_model->getEmployeeFullName($userId);
            $organization = 'INTERNAL';
        } else {
            $userId = $this->responder_model->getResId($username);
            $name = $this->responder_model->getResponderFullName($userId);
            $orgId = $this->session->userdata('org_id');
            $organization = $this->organization_model->getOrganizationName($orgId);
        }

        if ($this->messageboard_model->addMessage($incidentId, $content, $userType, $userId, $name, $organization)) {
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

    public function retrieve_messages_get() {
        $incidentId = $this->get('incidentId', true);
        $from = $this->get('from', true);
        $count = $this->get('count', true);
        $direction = $this->get('direction', true);

        $direction = ($direction === 'up') ? '<' : '>';

        $messages = $this->messageboard_model->getMessages($incidentId, $from, $count, $direction);

        $messages['status'] = 'OK';
        echo json_encode($messages);
    }

    public function latest_msg_id_get() {
        $incidentId = $this->get('incidentId', true);
        $id = $this->messageboard_model->getLatestMsgId($incidentId);
        $id['status'] = 'OK';
        echo json_encode($id);
    }

    public function first_msg_id_get() {
        $incidentId = $this->get('incidentId', true);
        $id = $this->messageboard_model->getFirstMsgId($incidentId);
        $id['status'] = 'OK';
        echo json_encode($id);
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

    //Public REST
    public function public_alert_get() {

        $public = 1;
        $result = $this->incident_model->getPublicAlerts($public);

        foreach ($result as $row) {
            $data[$row->id] = array(
                'content' => $row->content,
                'date' => $row->published_date
            );
        }

        if (count($data) > 0) {
            $data['status'] = 'OK';
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }

    }

    public function public_posts_get() {

        $isPublished = 1;
        $result = $this->incident_model->getPublicPosts($isPublished);

        foreach ($result as $row) {
            $data[$row->id] = array(
                'id' => $row->id,
                'title' => htmlspecialchars_decode($row->title),
                'content' => substr(htmlspecialchars_decode($row->content),0,20),
                'publish_date' =>$row->published_date,
                'author' => $row->written_by
            );
        }

        if (count($data) > 0) {
            $data['status'] = 'OK';
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }

    }
    public function public_posts_all_get() {

        $isPublished = 1;
        $result = $this->incident_model->getPublicPostsAll($isPublished);

        foreach ($result as $row) {
            $data[$row->id] = array(
                'id' => $row->id,
                'title' => htmlspecialchars_decode($row->title),
                'content' => substr(htmlspecialchars_decode($row->content),0,20),
                'publish_date' =>$row->published_date,
                'author' => $row->written_by
            );
        }

        if (count($data) > 0) {
            $data['status'] = 'OK';
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'NO_RECORDS'), REST_Controller::HTTP_OK);
        }

    }
} 
?>