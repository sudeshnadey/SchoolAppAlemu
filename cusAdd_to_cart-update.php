<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/admin.class.php';

$Admin     = new Admin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $headers = apache_request_headers();
    $token = $headers['token'];
    $secretKey = 'S35001_Us37';   // Secret key used for signing the token
    try {
    $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));
    $userId = json_encode($decoded);

    $product_id         = htmlspecialchars(trim(($_POST['product_id'])));
    $price_id           = htmlspecialchars(trim(($_POST['price_id'])));
    $cart_id            = htmlspecialchars(trim(($_POST['cart_id'])));
    $Qty                = htmlspecialchars(trim(($_POST['Qty'])));

    $result = $Admin->addCartUpdate($product_id, $price_id, $cart_id, $Qty);

    if($result){
    http_response_code(200); // method allowed
    echo json_encode(array('status' => 'Update Successfull'));
    exit;
    }else {
    http_response_code(405);
    echo json_encode(array('status' => 'Update Failed' ));
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