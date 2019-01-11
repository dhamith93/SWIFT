<?php 
    function getGeoCode($address) {
        $addressStr = rawurlencode($address[2] . ',' . $address[1]);
        $apiKey = getenv('geocode_api');
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$addressStr.'&key='.$apiKey;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($curl);

        if ($content) {
            $response = json_decode($content);
            if ($response->status === 'OK') {
                return $response->results[0]->geometry->location;
            } else {
                return array('is_error' => true);
            }
        } else {
            return array('is_error' => true);
        }
    }    
?>