<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/order.class.php';

$Order  = new Order();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $headers = apache_request_headers();
    $token = $headers['token'];
    $secretKey = 'S35001_Us37'; // Secret key used for signing the token
    try {
        $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));
        $user_id  = json_encode($decoded);

    $code                     = rand(1, 99999);
    $address_id               = "ADDRESS".$code;
    $house_no         = htmlspecialchars(trim(($_POST['house_no'])));
    $floor_no         = htmlspecialchars(trim(($_POST['floor_no'])));
    $society_name     = htmlspecialchars(trim(($_POST['society_name'])));
    $locality         = htmlspecialchars(trim(($_POST['locality'])));
    $landmark         = htmlspecialchars(trim(($_POST['landmark'])));

    $pincode         = htmlspecialchars(trim(($_POST['pincode'])));
    $area            = htmlspecialchars(trim(($_POST['area'])));
    $city            = htmlspecialchars(trim(($_POST['city'])));
    $state           = htmlspecialchars(trim(($_POST['state'])));
    
  $result = $Order->addressAdd($user_id, $house_no, $floor_no, $society_name, $locality, $landmark, $pincode, $area, $city, $address_id, $state);

  if($result){
  http_response_code(200); // method allowed
  echo json_encode(array('status' => 'success'));

  exit;

  }

  else {
  http_response_code(405); // method not allowed
  echo json_encode(array('status' => 'error', 'message' => 'no data insert'));
  }

} catch (\Exception $e) {
    http_response_code(405); 
    echo json_encode(array('status' => 'error', 'message' => 'Token does not match'));
    exit;
  }

}else {
    http_response_code(405); // method not allowed
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>