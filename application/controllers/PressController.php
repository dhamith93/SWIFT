<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PressController extends CI_Controller{

    public function press(){
        $data['site_title'] = 'Press Release';
        $data['site_view'] = 'Press';
        $data['site_header'] = '__press';
        $data['company'] = $this->company_model->getInfo();
        $this->load->view('public/main/swift', $data);
    }

    public function singlePress($pageid){
        $data['site_title'] = 'Press Release';
        $data['site_view'] = 'Single-press';
        $data['site_header'] = '__press';
        $data['result'] = $this->article_model->getPress($pageid);
        $data['company'] = $this->company_model->getInfo();
        $this->load->view('public/main/swift', $data);
    }


}



?>