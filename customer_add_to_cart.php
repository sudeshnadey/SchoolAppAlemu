<?php
require_once '_config/dbconnect.php';
require_once 'classes/admin.class.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';

$Admin     = new Admin();

// process the request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $headers = apache_request_headers();
  $token = $headers['token'];

  $secretKey = 'S35001_Us37';  // Secret key used for signing the token

  try {
      $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));

  // do something with the data, for example:
  $user_id               = json_encode($decoded);
  $product_id            = htmlspecialchars(trim(($_GET['product_id'])));
  $price_id              = htmlspecialchars(trim(($_GET['price_id'])));
  $Qty                   = htmlspecialchars(trim(($_GET['Qty'])));
  
    $code             = rand(1, 99999);
  $cart_id            = "CART".$code;
  
    $resultscart    = $Admin->productimage($product_id);

  foreach ($resultscart as $productdata) {
    $product_gallery             = $productdata['product_gallery'];
  }
  
    $code             = rand(1, 99999);
  $cart_id            = "CART".$code;
  
  $result = $Admin->addToAartDtlsInsert($user_id, $product_id, $price_id, $Qty, $cart_id, $product_gallery);

  if($result){
  http_response_code(200); // method allowed
  echo json_encode(array('status' => 'success', 'data' => $decoded));

  exit;
  }
  else {
  http_response_code(405); 
  echo json_encode(array('status' => 'error', 'message' => 'no data insert'));
  }

} catch (\Exception $e) {
  // Token verification failed
  http_response_code(405); 
  echo json_encode(array('status' => 'error', 'message' => ' Token does not match'));
  exit;
}

}else{
    http_response_code(405); // method not allowed
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}

?>