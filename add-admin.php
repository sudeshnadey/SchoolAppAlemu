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
  $code       = rand(1, 99999);
  $user_id    = "ADMIN".$code;
  $pwd_hashed = password_hash($password, PASSWORD_DEFAULT);

  $result = $Admin->adminInsert($name, $email, $pwd_hashed, $ph_no, $user_id);

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