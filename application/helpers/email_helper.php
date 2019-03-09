<?php 
    if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    function sendEmail($emailAddress, $name, $subject, $content) {
        require 'vendor/autoload.php'; 

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("admin@swift.dev", "SWIFT ADMIN");
        $email->setSubject($subject);
        $email->addTo($emailAddress, $name);
        $email->addContent("text/html", $content);
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            return ($response->statusCode() === 202);
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
            return false;
        }
    }

?>