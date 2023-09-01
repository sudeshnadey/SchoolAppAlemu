<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/admin.class.php';

$Admin     = new Admin();

// process the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $data = json_decode(file_get_contents('php://input'), true);

  // do something with the data, for example:
  $ph_no      = $data['ph_no'];
  $password   = $data['password'];
  $name       = $data["name"];
  $email      = $data["email"];

  $address             = $data['address'];
  $landmark            = $data['landmark'];
  $pincode             = $data['pincode'];


  // $code                = rand(1, 9999);
  // $address_id          = "ADD".$code;

  $code       = rand(1, 99999);
  $user_id    = "USER".$code;
  
  $pwd_hashed = password_hash($password, PASSWORD_DEFAULT);

  $result = $Admin->userInsert($user_id, $name, $ph_no, $email, $pwd_hashed, $address, $landmark, $pincode);

  if($result){
  http_response_code(200); // method allowed
  echo json_encode(array('status' => 'success'));

  exit;

  }
  // return a response
  else {
  echo json_encode(array('status' => 'Data Inserted Not Successfully'));
  }

}else {
  http_response_code(405); // method not allowed
  echo json_encode(array('status' => 'error', 'message' => 'Invalid Request Method'));
  }

?>