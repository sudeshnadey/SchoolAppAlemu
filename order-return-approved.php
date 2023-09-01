<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/order.class.php';
$Order  = new Order();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $headers = apache_request_headers();
    $token = $headers['token'];
    $secretKey = 'S35001_A4M1n';  // Secret key used for signing the token
    try {
    $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));
    $data = json_decode(file_get_contents('php://input'), true);

    $price_id                 = $data['price_id'];
    $Qty                      = $data['Qty'];
    $order_id                 = $data['order_id'];
    $status                   = 'Return';

    $results    = $Order->stackUpdatepriceAdd($Qty, $price_id);
    $resultdata = $Order->stackUpdateproductAdd($Qty, $price_id);
    $result     = $Order->orderstatus($order_id, $status);      


    if($result){
    http_response_code(200); // method allowed
    echo json_encode(array('status' => 'Update Successfull'));
    exit;
    }else {
    http_response_code(405);
    echo json_encode(array('status' => 'Update Failed'));
    }
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