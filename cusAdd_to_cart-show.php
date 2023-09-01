<?php
require_once '_config/dbconnect.php';
require_once 'classes/admin.class.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/products.class.php';

$Product  = new Product();
$Admin     = new Admin();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $headers = apache_request_headers();
    $token = $headers['token'];
  
    $secretKey = 'S35001_Us37'; // Secret key used for signing the token
  
    try {
    $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));

    $userId = json_encode($decoded);

  $addTocartData   = $Admin->cusaddToAartdataShow($userId);

  $COUNTProduct = count($addTocartData);
  

  if ($COUNTProduct == 0) {
    echo json_encode(array('status' => 'No Data Avilable.'));

    } else{
      echo json_encode(array('status' => 'success', 'CartCount' => $COUNTProduct, 'data' => $addTocartData));   
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