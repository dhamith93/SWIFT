<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicController extends CI_Controller{

    public function home(){
        $data['site_title'] = 'Home';
        $data['site_view'] = 'Home';
        $data['company'] = $this->company_model->getInfo();
        $this->load->view('public/main/swift', $data);
    }

    public function contacts(){
        $data['site_title'] = 'Contacts';
        $data['site_view'] = 'Contacts';
        $data['site_header'] = '__contacts';
        $data['company'] = $this->company_model->getInfo();
        $this->load->view('public/main/swift', $data);
    }


}



?>