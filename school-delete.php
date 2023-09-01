<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/school.class.php';

$School  = new School();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

  $headers = apache_request_headers();
  $token = $headers['token'];
  $secretKey = 'S35001_A4M1n';  // Secret key used for signing the token
  try {
  $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));

  $id            = htmlspecialchars(trim($_GET['id']));
  $schoolData    = $School->schoolByID($id);

  foreach($schoolData as $data){
    $School_id = $data['user_id'];
  }


  $deleteD       = $School->productgalleryDelete($School_id);
  $deleteDs      = $School->productPriceDelete($School_id);
  $deleteDatas   = $School->productsDelete($School_id);
  $deleteData    = $School->schoolDelete($id);

  if($deleteData){
    http_response_code(200); // method allowed
    echo json_encode(array('status' => 'Delete Successfull'));
    exit;
    }else {
    http_response_code(405);
    echo json_encode(array('status' => 'Delete Failed'));
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