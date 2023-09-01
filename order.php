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
        $userId  = json_encode($decoded);

    $data = json_decode(file_get_contents('php://input'), true);

    $code                     = rand(1, 99999);
    $order_id                 = "ORDER".$code;
    $payment_method           = $data['payment_method'];
    $cart_id                  = $data['cart_id'];
    $total_amount             = $data['total_amount'];
    $school_id                = $data['school_id'];
    $address_id               = $data['address_id'];
    
  $resultscart    = $Order->productBycartID($cart_id);
  $resulttype = $Order->AddToCartStatus($cart_id);
  $result = $Order->orderAdd($userId, $order_id, $payment_method, $cart_id, $total_amount, $school_id, $address_id);

  foreach ($resultscart as $productdata) {
    $price_id             = $productdata['price_id'];
    $product_id           = $productdata['product_id'];
    $Qty                  = $productdata['Qty'];
    
    $results    = $Order->orderstackUpdateprice($Qty, $price_id);
    $resultdata = $Order->orderstackUpdateproduct($Qty, $price_id);

  }

date_default_timezone_set("Asia/Kolkata");
 $curr_timestamp = date("Y-m-d");

  if($result){
  http_response_code(200); // method allowed
  echo json_encode(array('status' => 'success', 'order_id' => $order_id, 'amount' => $total_amount, 'payment_method' => $payment_method, 'Date' => $curr_timestamp));

  exit;

  }

  else {
  http_response_code(405); // method not allowed
  echo json_encode(array('status' => 'error', 'message' => 'no data insert'));
  }

} catch (\Exception $e) {
    http_response_code(405); 
    echo json_encode(array('status' => 'error', 'message' => ' Token does not match'));
    exit;
  }

}else {
    http_response_code(405); // method not allowed
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>