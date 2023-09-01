<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/order.class.php';
$Order  = new Order();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $school_id                  = htmlspecialchars(trim($_GET['school_id']));
    if ($_GET['school_id']==null) {
        $OrderData       = $Order->showOrderschools();
        $COUNTOrderData  = count($OrderData);
        if ($COUNTOrderData == 0) {
          echo json_encode(array('status' => 'No Data Avilable.'));
      
          } else{
              http_response_code(200); // method allowed
      echo json_encode(array('status' => 'success', 'data' => $OrderData));
      }
        exit;
        }
  

  $OrderData       = $Order->showOrderschool($school_id);
  $COUNTOrderData  = count($OrderData);
  if ($COUNTOrderData == 0) {
    echo json_encode(array('status' => 'No Data Avilable.'));

    } else{
        http_response_code(200); // method allowed
echo json_encode(array('status' => 'success', 'data' => $OrderData));
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