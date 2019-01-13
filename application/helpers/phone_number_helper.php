<?php 
    if (!defined('BASEPATH')) exit('No direct script access allowed');

    function convertToInternational($input) {
        if (preg_match('/^(07)([0-9]{8})$/', $input)) {
            return '+94'.ltrim($input, '0');
        } else if (preg_match('/^(00947)([0-9]{8})$/', $input)) {
            return '+'.ltrim($input, '00');
        } else if (preg_match('/^(\+947)([0-9]{8})$/', $input)) {
            return $input;
        } else {
            return 'INVALID OR NOT SUPPORTED';
        }  
    }

?>