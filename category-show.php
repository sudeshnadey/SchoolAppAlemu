<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/category.class.php';

$Category  = new Category();

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  $CategorytData      = $Category->displayCategory();
  $COUNTCategorytData = count($CategorytData);
  if ($COUNTCategorytData == 0) {
    echo json_encode(array('status' => 'No Data Avilable.'));

    } else{
        http_response_code(200); // method allowed
echo json_encode(array('status' => 'success', 'data' => $CategorytData));
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