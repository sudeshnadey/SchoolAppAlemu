<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/products.class.php';

$Product  = new Product();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'GET') {


    $school_id                  = htmlspecialchars(trim($_GET['school_id']));

    if ($_GET['school_id']==null) {
      $userData       = $Product->displayproducts();
      $COUNTuserData  = count($userData);
      if ($COUNTuserData == 0) {
        echo json_encode(array('status' => 'No Data Avilable.'));
    
        } else{
            http_response_code(200); // method allowed
    echo json_encode(array('status' => 'success', 'data' => $userData));
    }
      exit;
      }

  $userData       = $Product->displayproduct($school_id);
  $COUNTuserData  = count($userData);
  if ($COUNTuserData == 0) {
    echo json_encode(array('status' => 'No Data Avilable.'));

    } else{
        http_response_code(200); // method allowed
echo json_encode(array('status' => 'success', 'data' => $userData));
}
}else{
  $data = [
    'status' => 405,
    'message' => $_SERVER['REQUEST_METHOD']. 'Method Not Allowed',
  ];
  header("HTTP/1.0 Method Not Allowed");
  echo json_encode($data);
}

?>