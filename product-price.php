<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/products.class.php';

$Product  = new Product();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $headers = apache_request_headers();
  $token   = $headers['token'];

  $secretKey = 'S35001_A4M1n'; // Secret key used for signing the token

  try {
  $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));
  $userId = json_encode($decoded);
  // do something with the data, for example:
  $product_id               = htmlspecialchars(trim(($_POST['product_id'])));
  $school_id                = htmlspecialchars(trim(($_POST['school_id'])));
  $size                     = htmlspecialchars(trim(($_POST['size'])));
  $original_price           = htmlspecialchars(trim(($_POST['original_price'])));
  $discount_price           = htmlspecialchars(trim(($_POST['discount_price'])));
  $gender                   = htmlspecialchars(trim(($_POST['gender'])));
  $Quantity                 = htmlspecialchars(trim(($_POST['Quantity'])));

  $code                         = rand(1, 99999);
  $price_id                     = "PRICE".$code;
 
  $result = $Product->productPriceAdd($school_id, $product_id, $size, $original_price, $discount_price, $gender, $Quantity, $userId, $price_id);
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