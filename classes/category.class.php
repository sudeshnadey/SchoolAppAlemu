<?php

class Category extends DatabaseConnection{



    function categoryAdd($category_name, $image, $category_id){
            date_default_timezone_set("Asia/Kolkata");

    $curr_timestamp = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `category` (`category_name`, `image`, `category_id`, `added_on`) VALUES ('$category_name', '$image', '$category_id', '$curr_timestamp')";

        $insertAboutQuery = $this->conn->query($sql);

        return $insertAboutQuery;

    }// eof aboutInsert


    function displayCategory(){

        $proData = array();
        $sql = "SELECT * FROM `category`";
        $proQuery   = $this->conn->query($sql);
        while($row  = $proQuery->fetch_array()){ 
            $proData[]	= $row;
        }
    
        return $proData;
    
    }
    
    
     function categoryDelete($id){

        $sql = "DELETE FROM `category` WHERE `category`.`id` = '$id'";
        $res = $this->conn->query($sql);
        return $res;
    
    }
    
    
    
     function categoryUpdate($category_name, $c_image, $id){
         
             date_default_timezone_set("Asia/Kolkata");

    $curr_timestamp = date("Y-m-d H:i:s");

        $sql = "UPDATE  `category` 
                SET `id`             = '$id',
                `category_name`      = '$category_name',
                `image`              = '$c_image',
                `added_on`           = '$curr_timestamp'
                WHERE
                `category`.`id` = '$id'";

        $result = $this->conn->query($sql);

        return $result;

    }
    
    
    
}




?>