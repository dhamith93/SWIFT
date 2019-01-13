<?php
    $url = 'http://localhost:5050';
    // $key = 'somekey';
    $key = 'emulate'; // for testing

    function sendSms($receiver, $msg) {
        $postFields = [
            'rec' => $receiver,
            'msg' => $msg,
            'key' => $key
        ];

        $postString = http_build_query($postFields);
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, count($postFields));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $response = json_decode(curl_exec($curl));
    
        return ($response->status === 'REQUEST_PROCESSED');
    }
?>