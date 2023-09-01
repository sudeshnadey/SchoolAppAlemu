<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/school.class.php';

$School  = new School();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $headers = apache_request_headers();
    $token = $headers['token'];
    $secretKey = 'S35001_A4M1n'; // Secret key used for signing the token
    try {
    $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));
    $added_by = json_encode($decoded);

    $id                = htmlspecialchars(trim($_POST['id']));
    $name              = htmlspecialchars(trim($_POST['name']));
    $password              = htmlspecialchars(trim($_POST['password']));
    $user_id       = htmlspecialchars(trim(($_POST['user_id'])));
    $pwd_hashed = password_hash($password, PASSWORD_DEFAULT);

        $new_image        = $_FILES[ 'image' ][ 'name' ];
    
        $image_size       = $_FILES[ 'image' ][ 'size' ];
    
        $image_tmp_name   = $_FILES[ 'image' ][ 'tmp_name' ];
    
        $image_folter     = 'image/'.$new_image;
    
    
        $c_image    = $new_image;
    
        move_uploaded_file( $image_tmp_name, $image_folter );
    
    $result = $School->schoolUpdate($name, $added_by, $id, $c_image, $pwd_hashed,$user_id);

    if($result){
    http_response_code(200); // method allowed
    echo json_encode(array('status' => 'Update Successfull'));
    exit;
    }else {
    http_response_code(405);
    echo json_encode(array('status' => 'Update Failed'));
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