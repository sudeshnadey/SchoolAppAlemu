<?php


class School extends DatabaseConnection{

  
    function schoolAdd($school_name, $school_image, $added_by){


    date_default_timezone_set("Asia/Kolkata");

    $curr_timestamp = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `school` ( `name`, `image`, `added_by`, `added_on`) VALUES ('$school_name', '$school_image', $added_by, '$curr_timestamp')";

        $insertAboutQuery = $this->conn->query($sql);

        return $insertAboutQuery;

    }

    function displaySchool(){

        $proData = array();
        $sql = "SELECT * FROM `school`";
        $proQuery   = $this->conn->query($sql);
        while($row  = $proQuery->fetch_assoc()){ 
            $proData[]	= $row;
        }
    
        return $proData;
    
    }
    
    
      function schoolDelete($id){

        $sql = "DELETE FROM `school` WHERE  `school`.`id` = '$id'";
        $res = $this->conn->query($sql);
        return $res;
    
    }
    
    
    
    function schoolUpdate($name, $added_by, $id, $c_image, $password,$user_id){
        
    date_default_timezone_set("Asia/Kolkata");

    $curr_timestamp = date("Y-m-d H:i:s");
    
    $sql = "UPDATE  `school` 
            SET `id`          = COALESCE(NULLIF('$id', ''),`id`),
            `name`            = COALESCE(NULLIF('$name', ''),`name`),
            `user_id`            = COALESCE(NULLIF('$user_id', ''),`user_id`),
            `added_by`        =COALESCE(NULLIF($added_by, ''),`added_by`),
            `image`           = COALESCE(NULLIF('$c_image', ''),`image`),
            `added_on`        = '$curr_timestamp',
            `password`        = COALESCE(NULLIF('$password', ''),`password`)
            WHERE
            `school`.`id` = '$id'";

    $result = $this->conn->query($sql);

    return $result;

   }

 
 
 
 
    
   function schoolByID($id){

    $proData = array();
    $sql = "SELECT * FROM `school` WHERE `school`.`id` = '$id'";
    $proQuery   = $this->conn->query($sql);
    while($row  = $proQuery->fetch_array()){ 
        $proData[]	= $row;
    }

    return $proData;

}

function productgalleryDelete($School_id){

    $sql = "DELETE FROM `productgallery` WHERE  `productgallery`.`school_id` = '$School_id'";
    $res = $this->conn->query($sql);
    return $res;

}



function productPriceDelete($School_id){

    $sql = "DELETE FROM `product_price` WHERE  `product_price`.`school_id` = '$School_id'";
    $res = $this->conn->query($sql);
    return $res;

}


function productsDelete($School_id){

    $sql = "DELETE FROM `products` WHERE  `products`.`school_id` = '$School_id'";
    $res = $this->conn->query($sql);
    return $res;

}





function displaySchoolSearch($search){

    $proData = array();
    $sql = "SELECT * FROM `school` WHERE `school`.`name` LIKE '%$search%'";
    $proQuery   = $this->conn->query($sql);
    while($row  = $proQuery->fetch_array()){ 
        $proData[]	= $row;
    }

    return $proData;

}

 
function logIn($user_id){

    $data = array();
    $sql  = "SELECT * FROM `school` WHERE `user_id` = '$user_id' ";
    $res  = $this->conn->query($sql);
    $rows =  $res->num_rows;
    if ($rows > 0) {
        while ($result = $res->fetch_array()) {
            $data[] = $result;
        }
    }
    return $data;
}



function products($user_id){
    $sql_user = "SELECT * FROM `school` WHERE `school`.`user_id` = '$user_id'";
    $res_user = $this->conn->query($sql_user);
    if ($res_user && $res_user->num_rows > 0) {
        // School ID, UserID, and Password match, proceed to fetch product information
        $row_user = $res_user->fetch_assoc();
        $School_id = $row_user['user_id'];
    
        $sql_sold = "SELECT SUM(total_amount) AS total_sold FROM `order` WHERE `order`.`school_id` = '$School_id'";
        $res_sold = $this->conn->query($sql_sold);
    
        if ($res_sold && $res_sold->num_rows > 0) {
            $row_sold = $res_sold->fetch_assoc();
            $total_sold = $row_sold['total_sold'];
    
            $sql_products = "SELECT SUM(Quantity) AS total_quantity FROM `products` WHERE `products`.`school_id` = '$School_id'";
            $res_products = $this->conn->query($sql_products);
    
            if ($res_products && $res_products->num_rows > 0) {
                $row_products = $res_products->fetch_assoc();
                $total_quantity = $row_products['total_quantity'];
                $total_left = $total_quantity - $total_sold;
    
                $base_url = "https://localhost.com"; // Replace with actual base URL

                // Get the full URL of the filename saved in the database
                $filename_url = $base_url . "/SchoolApp/api/" . $row_user['image'];
                unset($row_user['password']);
                $row_user['image']=$filename_url;
                return array(
                    'school'=>$row_user,
                    'total_products' => $total_quantity,
                    'total_sold' => $total_sold,
                    'total_left' => $total_left
                );
            }
        }
    }}
}

?>