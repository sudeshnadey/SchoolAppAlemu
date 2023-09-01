<?php
require_once '_config/dbconnect.php';
require_once 'classes/admin.class.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';

$Admin     = new  Admin();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

 
 $data = json_decode(file_get_contents('php://input'), true);
  // retrieve username and password from POST request
  $username = $data['username'];
  $password = $data['password'];
//   echo json_encode(array('status' => $username));
//  return;
  $login   = $Admin->logIn($username);
  $COUNTlogindata = count($login);

if ($COUNTlogindata == 1) {

foreach ($login as $user) {
$database_password        = $user['password'];
$user_id                  = $user['user_id'];

if (password_verify($password, $database_password)) {

session_start();

$_SESSION['username'] = $username; 

$_SESSION['loggedin']  = true;

 //jwt
//  $payload = array(
//   'userId' => $user_id,
//   // Add any other relevant user information to the payload
//   );
   $secretKey = 'S35001_A4M1n';  // Secret key for signing the token
  $token = \Firebase\JWT\JWT::encode($user_id, $secretKey);
 
echo json_encode(array('status' => 'success', 'Token' => $token));
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
