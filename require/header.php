<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
// header('Content-Type: application/Json');
// header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, 
// Accept, x-client-key, x-client-token, x-client-secret, Authorization");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {  
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        header('Access-Control-Max-Age: 1728000');
        header('Content-Length: 0');
         header('Content-Type: application/json');
        die();
    }

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $ret = [
        'result' => 'OK',
    ];
//     print json_encode($ret);
?>