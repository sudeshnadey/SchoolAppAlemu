<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/school.class.php';

$School  = new School();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $search= htmlspecialchars(trim($_POST['search']));

  if ($_POST['search']==null) {
    $SchoolData      = $School->displaySchool();
    $COUNTSchoolData = count($SchoolData);
    if ($COUNTSchoolData == 0) {
      echo json_encode(array('status' => 'No Data Avilable.'));
  
      } else{
          http_response_code(200); // method allowed
  echo json_encode(array('status' => 'success', 'data' => $SchoolData));
  }
    exit;
    }


  $SchoolData      = $School->displaySchoolSearch($search);
  $COUNTSchoolData = count($SchoolData);
  if ($COUNTSchoolData == 0) {
    echo json_encode(array('status' => 'No Data Avilable.'));

    } else{
        http_response_code(200); // method allowed
echo json_encode(array('status' => 'success', 'data' => $SchoolData));
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