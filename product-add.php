<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';
require_once 'classes/products.class.php';

$Product  = new Product();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $headers = apache_request_headers();
  $token   = $headers['token'];
  $secretKey = 'S35001_A4M1n';
  try {
  $decoded = \Firebase\JWT\JWT::decode($token, $secretKey, array('HS256'));
  $userId = json_encode($decoded);

    $school_id                  = htmlspecialchars(trim($_POST['school_id']));
    $product_name               = htmlspecialchars(trim($_POST['product_name']));
    $description                = htmlspecialchars(trim($_POST['description']));
    $size                       = htmlspecialchars(trim($_POST['size']));
    $original_price             = htmlspecialchars(trim($_POST['original_price']));
    $discount_price             = htmlspecialchars(trim($_POST['discount_price']));
    $gender                     = htmlspecialchars(trim($_POST['gender']));
    $Quantity                   = htmlspecialchars(trim($_POST['Quantity']));

    $code                         = rand(1, 99999);
    $product_id                   = "PROD".$code;

    $code                         = rand(1, 99999);
    $price_id                     = "PRICE".$code;
   

    //   $image            = $_FILES[ 'image' ][ 'name' ];

    //   $image_size       = $_FILES[ 'image' ][ 'size' ];
  
    //   $image_tmp_name   = $_FILES[ 'image' ][ 'tmp_name' ];
  
    //   $image_folter     = 'image/'.$image;
  
    //   move_uploaded_file( $image_tmp_name, $image_folter );

    if (!empty($_FILES['images']['name'])) {

        $files = $_FILES['images'];

        if (is_array($_FILES['images'])) {

          $totalFiles = count(array_filter($_FILES['images']['name']));
          
          for ($i = 0; $i < $totalFiles; $i++) {

            $file_name = $files['name'][$i];
            $file_tmp = $files['tmp_name'][$i];
            $file_size = $files['size'][$i];
            $file_type = $files['type'][$i];

            $destination = 'image/' . $file_name;
            move_uploaded_file($file_tmp, $destination);
      
            $galleryresult = $Product->productGalleryInsert($product_id, $file_name, $userId, $school_id);         
          
          }
        // }
        } else {
          $file_name = $files['name'];
          $file_tmp  = $files['tmp_name'];
          $file_size = $files['size'];
          $file_type = $files['type'];
      

          $destination = 'image/' . $file_name;
          move_uploaded_file($file_tmp, $destination);
          $galleryresult = $Product->productGalleryInsert($product_id, $file_name, $userId, $school_id);

        }
      }
   
    $resultPrice = $Product->productPriceAdd($school_id, $product_id, $size, $original_price, $discount_price, $gender, $Quantity, $userId, $price_id);
    
    $result = $Product->productInsert($school_id, $product_name, $description, $size, $original_price,
     $discount_price, $gender, $Quantity, $product_id, $userId, $price_id);

    if($result){
    http_response_code(200); // method allowed
    echo json_encode(array('status' => 'Insertion Successfull'));
    exit;
    }else {
    http_response_code(405);
    echo json_encode(array('status' => 'Products Data Insertion Failed'));
    }
// }

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