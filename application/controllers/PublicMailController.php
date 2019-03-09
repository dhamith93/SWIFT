<?php 

class PublicMailController extends CI_Controller{
    public function mail(){
        $this->form_validation->set_rules('name','Name','trim|required|max_length[20]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('subject','Subject','trim|required|max_length[20]');
        $this->form_validation->set_rules('message','Message','trim|required|max_length[200]');
        if($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            
            $data = array(
                'name' => htmlspecialchars($this->input->post('name')),
                'email' => htmlspecialchars($this->input->post('email')),
                'subject' => htmlspecialchars($this->input->post('subject')),
                'message' => htmlspecialchars($this->input->post('message'))
            );
         
            if($this->sendMail($data)){
                redirect('contacts/#message-success');
            } else {
                redirect('contacts/#message-error');
                // echo "Mail sas not sent. Please try again";
            }
        }
    }

    public function sendMail($data) {
        $this->load->helper('email_helper');
        
        $emailAddress = 'dakshitha.m.a@gmail.com';
        $name = 'Prabuddha';
        $subject = 'SWIFT Emails';
        $content  = '<h3>Mail from website Visiter</h3><br>';
        $content .= '<p>Name - '.$data['name'] . '</p>';
        $content .= '<p>Email - '.$data['email'] . '</p>';
        $content .= '<p>Mail subject - '.$data['subject'] . '</p>';
        $content .= '<p>Content - '.$data['message'] . '</p>';
        return sendEmail($emailAddress,$name,$subject,$content);
        
    }
}
?>