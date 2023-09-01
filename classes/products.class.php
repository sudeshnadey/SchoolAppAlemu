<?php

date_default_timezone_set("Asia/Kolkata");

class Product extends DatabaseConnection{

    function productInsert($school_id, $product_name, $description, $size, $original_price,
    $discount_price, $gender, $Quantity, $product_id, $userId, $price_id){

        $descriptions = addslashes($description);

        $curr_timestamp = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `products` 
        (`product_id`, `school_id`, `product_name`, `description`, `size`, `original_price`, `discount_price`,
        `gender`, `Quantity`, `added_by`, `price_id`, `added_on`)
         VALUES 
         ('$product_id',  '$school_id', '$product_name', '$descriptions', '$size',
          '$original_price', '$discount_price', '$gender', '$Quantity', $userId, '$price_id', '$curr_timestamp')";

        $insertproductQuery = $this->conn->query($sql);

        return $insertproductQuery;

    }

    function productGalleryInsert($product_id, $file_name, $userId, $school_id){

        $curr_timestamp = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `productgallery` (`product_id`, `product_gallery`, `added_by`, `added_on`, `school_id`) VALUES ('$product_id', '$file_name', $userId, '$curr_timestamp', '$school_id')";
    
        $insertproductQuery = $this->conn->query($sql);
    
        return $insertproductQuery;
    
    }


    function productPriceAdd($school_id, $product_id, $size, $original_price, $discount_price, $gender, $Quantity, $userId, $price_id){

        $curr_timestamp = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `product_price` (`product_id`, `school_id`, `size`, `original_price`, `discount_price`, `gender`, `Quantity`, `added_by`, `price_id`, `added_on`)
         VALUES ('$product_id', '$school_id', '$size', '$original_price', '$discount_price', '$gender', '$Quantity', $userId, '$price_id', '$curr_timestamp')";
    
        $insertproductQuery = $this->conn->query($sql);
    
        return $insertproductQuery;
    
    }
    
    
    
       
    function stackUpdatepriceAdd($Qty, $price_id){
    
        $sqledit = "UPDATE `product_price`
        SET `Quantity`= (`Quantity` + '$Qty')
        WHERE
        `product_price`.`price_id` = '$price_id'";
    
        $result = $this->conn->query($sqledit);
    
        return $result;
    
    }


    function stackUpdateproductAdd($Qty, $price_id){
    
        $sqledit = "UPDATE `products`
        SET `Quantity`= (`Quantity` + '$Qty')
        WHERE
        `products`.`price_id` = '$price_id'";

        $result = $this->conn->query($sqledit);
    
        return $result;
    
    }
    
    
     function displayproduct($school_id){

        $data = array();
        $sql = "SELECT `products`.*, productgallery.product_gallery FROM `products` 
         JOIN productgallery ON `products`.product_id = productgallery.product_id 
         WHERE `products`.`school_id` = '$school_id'";
        $res = $this->conn->query($sql);
        if ($res->num_rows > 0 ) {
            while ($result = $res->fetch_array()) {
                $data[] = $result;
            }
        }
        return $data;
    }
    
    
      function productpriceDtls($price_id){
    
        $proData = array();
        $sql = "SELECT * FROM `product_price` WHERE `product_price`.`price_id` = '$price_id'";
        $proQuery   = $this->conn->query($sql);
        while($row  = $proQuery->fetch_array()){ 
            $proData[]	= $row;
        }
    
        return $proData;
    
    }
 
 
 
 
     function displayproducts(){

        $data = array();
        $sql = "SELECT `products`.*, productgallery.product_gallery FROM `products` 
         JOIN productgallery ON `products`.product_id = productgallery.product_id";
        $res = $this->conn->query($sql);
        if ($res->num_rows > 0 ) {
            while ($result = $res->fetch_array()) {
                $data[] = $result;
            }
        }
        return $data;
    }
 
 
 
 
     function displaySizePrice($product_id){
    
        $proData = array();
        $sql = "SELECT * FROM `product_price` WHERE `product_price`.`product_id` = '$product_id'";
        $proQuery   = $this->conn->query($sql);
        while($row  = $proQuery->fetch_array()){ 
            $proData[]	= $row;
        }
    
        return $proData;
    
    }
 


}

?>