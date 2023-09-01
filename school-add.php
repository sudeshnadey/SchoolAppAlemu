<?php
// insert data
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/school.class.php';

$School  = new School();

// process the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $headers = apache_request_headers();
  $token = $headers['token'];
  $secretKey = 'S35001_A4M1n'; // Secret key used for signing the token
  try {
  $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));
  $added_by = json_encode($decoded);

  // do something with the data, for example:
  $school_name       = htmlspecialchars(trim(($_POST['school_name'])));

  // $code              = rand(1, 99999);
  // $user_id           = "SCHOOL".$code;

  $school_image      = $_FILES[ 'image' ][ 'name' ];

  $image_size       = $_FILES[ 'image' ][ 'size' ];

  $image_tmp_name   = $_FILES[ 'image' ][ 'tmp_name' ];

  $image_folter     = 'image/'.$school_image;

  move_uploaded_file( $image_tmp_name, $image_folter );
 
  $result = $School->schoolAdd($school_name, $school_image, $added_by);

  if($result){
  http_response_code(200); // method allowed
  echo json_encode(array('status' => 'success'));
  exit;
  }
  else {
  http_response_code(405); 
  echo json_encode(array('status' => 'error', 'message' => 'no data insert'));
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