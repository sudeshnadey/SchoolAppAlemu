<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/order.class.php';
$Order  = new Order();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $headers = apache_request_headers();
    $token   = $headers['token']; 
    $secretKey = 'S35001_A4M1n'; 
  
    try {
    $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));
    $userId = json_encode($decoded);

  $OrderData       = $Order->displayOrderreturn();

  $COUNTOrderData  = count($OrderData);
  if ($COUNTOrderData == 0) {
    echo json_encode(array('status' => 'No Data Avilable.'));

    } else{
        http_response_code(200); // method allowed
echo json_encode(array('status' => 'success', 'data' => $OrderData));
}
} catch (\Exception $e) {
    http_response_code(405); 
    echo json_encode(array('status' => 'error', 'message' => ' Token does not match'));
    exit;
  }
}else{
  $data = [
    'status' => 405,
    'message' => $_SERVER['REQUEST_METHOD']. 'Method Not Allowed',
  ];
  header("HTTP/1.0 Method Not Allowed");
  echo json_encode($data);
}

?>