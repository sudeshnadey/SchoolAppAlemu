<?php
require_once '_config/dbconnect.php';
require_once 'classes/school.class.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';

$school     = new  School();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

 
 $data = json_decode(file_get_contents('php://input'), true);
  // retrieve username and password from POST request
  $username = $data['username'];
  $password = $data['password'];

  
  $login   = $school->logIn($username);
  $COUNTlogindata = count($login);

if ($COUNTlogindata == 1) {

foreach ($login as $user) {
$database_password        = $user['password'];
$user_id                  = $user['user_id'];

if (password_verify($password, $database_password)) {

session_start();

$_SESSION['username'] = $username; 

$_SESSION['loggedin']  = true;


   $secretKey = 'S35001_A4M1n';  // Secret key for signing the token
  $token = \Firebase\JWT\JWT::encode($user_id, $secretKey);
  $all_products=$school->products($username); 
echo json_encode(array('status' => 'success', 'Token' => $token,...$all_products));
exit;
}else{  echo json_encode(array('status' => 'Password Incorrect'));
}
}
}elseif ($COUNTlogindata > 1) {

  echo json_encode(array('status' => 'More Than One User'));

}else {
  echo json_encode(array('status' => 'Username Incorrect'));
  
}
}else {
  http_response_code(405); // method not allowed
  echo json_encode(array('status' => 'error', 'message' => 'Invalid Request Method'));

}
