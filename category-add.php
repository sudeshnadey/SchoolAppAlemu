<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/category.class.php';

$Category  = new Category();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $headers = apache_request_headers();
  $token = $headers['token'];
  $secretKey = 'S35001_A4M1n'; // Secret key used for signing the token
  try {
  $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));

  $category_name          = htmlspecialchars(trim(($_POST['category_name'])));

  $code                   = rand(1, 99999);
  $category_id            = "CATE".$code;

  $image            = $_FILES[ 'image' ][ 'name' ];

  $image_size       = $_FILES[ 'image' ][ 'size' ];

  $image_tmp_name   = $_FILES[ 'image' ][ 'tmp_name' ];

  $image_folter     = 'image/'.$image;

  move_uploaded_file( $image_tmp_name, $image_folter );

 
  $result = $Category->categoryAdd($category_name, $image, $category_id);

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
  echo json_encode(array('status' => 'error', 'message' => ' Token does not match'));
  exit;
}

}else {
    http_response_code(405); // method not allowed
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>