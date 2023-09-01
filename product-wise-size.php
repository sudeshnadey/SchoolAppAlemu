<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/products.class.php';

$Product  = new Product();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
  $product_id     = htmlspecialchars(trim($_GET['product_id']));
  $SizeData       = $Product->displaySizePrice($product_id);
  $COUNTSizeData  = count($SizeData);
  if ($COUNTSizeData == 0) {
    echo json_encode(array('status' => 'No Data Avilable.'));

    } else{
        http_response_code(200); // method allowed
echo json_encode(array('status' => 'success', 'data' => $SizeData));
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