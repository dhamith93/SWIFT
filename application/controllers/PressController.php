<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PressController extends CI_Controller{

    public function press(){
        $data['site_title'] = 'Press Release';
        $data['site_view'] = 'Press';
        $data['site_header'] = '__press';
        $this->load->view('public/main/swift', $data);
    }


}



?>