<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/admin.class.php';

$Admin     = new  Admin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $headers = apache_request_headers();
    $token   = $headers['token'];
  
    $secretKey = 'S35001_Us37';// Secret key used for signing the token
  
    try {
    $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));

    $id                       = htmlspecialchars(trim($_POST['id']));
    $name                     = htmlspecialchars(trim($_POST['name']));
    //   if ($_POST['name']==null) {
    //     http_response_code(405);
    //     echo json_encode(array('status' => 'name not send'));
    //     exit;
    //     }
    $email                    = htmlspecialchars(trim($_POST['email']));
    //  if ($_POST['email']==null) {
    //     http_response_code(405);
    //     echo json_encode(array('status' => 'email not send'));
    //     exit;
    //     }
    $ph_no                    = htmlspecialchars(trim($_POST['ph_no']));
    // if ($_POST['ph_no']==null) {
    //     http_response_code(405);
    //     echo json_encode(array('status' => 'ph no not send'));
    //     exit;
    //     }
    $address                  = htmlspecialchars(trim($_POST['address']));
    //  if ($_POST['address']==null) {
    //     http_response_code(405);
    //     echo json_encode(array('status' => 'address not send'));
    //     exit;
    //     }
    $state                    = htmlspecialchars(trim($_POST['state']));
    // if ($_POST['state']==null) {
    //     http_response_code(405);
    //     echo json_encode(array('status' => 'state not send'));
    //     exit;
    //     }
    $city                     = htmlspecialchars(trim($_POST['city']));
    //  if ($_POST['city']==null) {
    //     http_response_code(405);
    //     echo json_encode(array('status' => 'city not send'));
    //     exit;
    //     }
    $pincode                  = htmlspecialchars(trim($_POST['pincode']));
    // if ($_POST['pincode']==null) {
    //     http_response_code(405);
    //     echo json_encode(array('status' => 'pincode not send'));
    //     exit;
    //     }
        $landmark                  = htmlspecialchars(trim($_POST['landmark']));
    // if ($_POST['landmark']==null) {
    //     http_response_code(405);
    //     echo json_encode(array('status' => 'landmark not send'));
    //     exit;
    //     }


    $result = $Admin->userProfileupdate($id, $name, $email, $ph_no, $address, $state, $city, $pincode, $landmark);

    if($result){
    http_response_code(200); // method allowed
    echo json_encode(array('status' => 'Update Successfull'));
    exit;
    }else {
    http_response_code(405);
    echo json_encode(array('status' => 'Update Failed'));
    }
// }

} catch (\Exception $e) {
    // Token verification failed
    http_response_code(405); 
    echo json_encode(array('status' => 'error', 'message' => 'Token does not match'));
    exit;
  }

}else {
    http_response_code(405); // method not allowed
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}

?>