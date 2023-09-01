<?php

date_default_timezone_set("Asia/Kolkata");
    
class Admin extends DatabaseConnection{


    function adminInsert($name, $email, $pwd_hashed, $ph_no, $user_id){

        $sql = "SELECT * FROM `admins` WHERE `admins`.`email` = '$email' and `admins`.`ph_no` = '$ph_no'";

        $selectdata   = $this->conn->query($sql);

        $rows = $selectdata->num_rows;

        if ($rows == 0) {

            $sql = "INSERT INTO `admins` (`name`, `email`, `password`, `ph_no`, `user_id`) VALUES ('$name', '$email', '$pwd_hashed', '$ph_no', '$user_id')";
    
            $insertEmpQuery = $this->conn->query($sql);
            
            return $insertEmpQuery;
            
        }
        else
       {
        $data = [
        'message' => 'USERNAME ALREADY EXITSTS',
        ];
        echo json_encode($data);
        exit;
        }
    }




    function logIn($username){

        $data = array();
        $sql  = "SELECT * FROM `admins` WHERE `email` = '$username' OR `ph_no` = '$username'";
        // echo $sql.$this->conn->error;
        $res  = $this->conn->query($sql);
        $rows =  $res->num_rows;
        if ($rows > 0) {
            while ($result = $res->fetch_array()) {
                $data[] = $result;
            }
        }
        return $data;
    }
    
    
    
    
    ############################################# USER #########################################################


    function userInsert($user_id, $name, $ph_no, $email, $pwd_hashed, $address, $landmark, $pincode){

            $curr_timestamp = date("Y-m-d H:i:s");

        $sql = "SELECT * FROM `user` WHERE `user`.`email` = '$email' and `user`.`ph_no` = '$ph_no'";

        $selectdata   = $this->conn->query($sql);

        $rows = $selectdata->num_rows;

        if ($rows == 0) {

            $sql = "INSERT INTO `user` (`user_id`, `name`, `ph_no`, `email`, `password`, `address`, `landmark`, `pincode`, `added_on`)
             VALUES ('$user_id', '$name', '$ph_no', '$email', '$pwd_hashed', '$address', '$landmark', '$pincode', '$curr_timestamp')";
    
            $insertEmpQuery = $this->conn->query($sql);
            
            return $insertEmpQuery;
            
        }
        else
       {
        $data = [
        'message' => 'USERNAME ALREADY EXITSTS',
        ];
        echo json_encode($data);
        exit;
        }
    }



    
    function userlogIn($username){

        $data = array();
        // $sql  = "SELECT * FROM `user` WHERE `email` = '$username' OR `ph_no` = '$username'";
        $sql  = "SELECT * FROM `user` WHERE `ph_no` = '$username'";
        $res  = $this->conn->query($sql);
        $rows =  $res->num_rows;
        if ($rows > 0) {
            while ($result = $res->fetch_array()) {
                $data[] = $result;
            }
        }
        return $data;
    }
    
    
        function displayuser($userId){

        $data = array();
        $sql  = "SELECT * FROM `user` WHERE `user_id` = $userId";
        $res  = $this->conn->query($sql);
        $rows =  $res->num_rows;
        if ($rows > 0) {
            while ($result = $res->fetch_array()) {
                $data[] = $result;
            }
        }
        return $data;
    }
    
    
    
    
    
       function displayAlluser(){

        $data = array();
        $sql  = "SELECT * FROM `user`";
        $res  = $this->conn->query($sql);
        $rows =  $res->num_rows;
        if ($rows > 0) {
            while ($result = $res->fetch_array()) {
                $data[] = $result;
            }
        }
        return $data;
    }

    
    
    
    
    
        function userProfileupdate($id, $name, $email, $ph_no, $address, $state, $city, $pincode, $landmark){
    
        $sqledit = "UPDATE `user`
                    SET `name`           = COALESCE(NULLIF('$name', ''),`name`),
                    `email`              = COALESCE(NULLIF('$email', ''),`email`),
                    `ph_no`              = COALESCE(NULLIF('$ph_no', ''),`ph_no`),
                    `address`            = COALESCE(NULLIF('$address', ''),`address`),
                    `state`              = COALESCE(NULLIF('$state', ''),`state`),
                    `city`               = COALESCE(NULLIF('$city', ''),`city`),
                    `pincode`            = COALESCE(NULLIF('$pincode', ''),`pincode`),
                    `landmark`      = COALESCE(NULLIF('$landmark', ''),`landmark`)
                    WHERE
                    `user`.`id` = '$id'";
    
        $result = $this->conn->query($sqledit);
    
        return $result;
    
    }
    
    
    
    
    
    
    
    
    
########################################################### ADD TO CART #######################################################
#                                                                                                                             #
#                                                                                                                             #
#                                                                                                                             #
###############################################################################################################################


    // function addToAartDtlsInsert($user_id, $product_id, $price_id, $Qty, $cart_id){
        
    //     $curr_timestamp = date("Y-m-d H:i:s");
    
    //     $sql = "INSERT INTO `customer_add_to_cart` (`customer_id`, `product_id`, `price_id`, `Qty`, `cart_id`, `added_on`) VALUES ($user_id, '$product_id', '$price_id', '$Qty', '$cart_id', '$curr_timestamp')";

    //     $insertAboutQuery = $this->conn->query($sql);

    //     return $insertAboutQuery;

    // }
    
       function addToAartDtlsInsert($user_id, $product_id, $price_id, $Qty, $cart_id, $product_gallery){

        $sql = "SELECT * FROM `product_price` WHERE `product_price`.`product_id` = '$product_id' and 
        `product_price`.`price_id` = '$price_id' and `product_price`.`Quantity` >= $Qty";
    
        $selectdata   = $this->conn->query($sql);
    
        $rows = $selectdata->num_rows;
    
        if ($rows > 0) {
    
        $curr_timestamp = date("Y-m-d H:i:s");
    
        $sql = "INSERT INTO `customer_add_to_cart` (`customer_id`, `product_id`, `price_id`, `Qty`, `cart_id`, `added_on`, `image`) 
        VALUES ($user_id, '$product_id', '$price_id', '$Qty', '$cart_id', '$curr_timestamp', '$product_gallery')";

        $insertAboutQuery = $this->conn->query($sql);

        return $insertAboutQuery;
            
        }
        else
       {
        $data = [
        'message' => 'no quantity available for goods movement',
        ];
        echo json_encode($data);
        exit;
        }
        
    }





    
        function productimage($product_id){

        $data = array();
        $sql = "SELECT * FROM `productgallery` WHERE `productgallery`.`product_id` = '$product_id' LIMIT 1";
        $res = $this->conn->query($sql);
        if ($res->num_rows > 0 ) {
            while ($result = $res->fetch_array()) {
                $data[] = $result;
            }
        }
        return $data;
    }
    
    




    function addCartUpdate($product_id, $price_id, $cart_id, $Qty){

        $sql = "SELECT * FROM `product_price` WHERE `product_price`.`product_id` = '$product_id' and 
        `product_price`.`price_id` = '$price_id' and `product_price`.`Quantity` >= $Qty";
    
        $selectdata   = $this->conn->query($sql);
    
        $rows = $selectdata->num_rows;
    
        if ($rows > 0) {
    
            $sql = "UPDATE  `customer_add_to_cart` 
            SET `Qty`             = '$Qty'
            WHERE
            `customer_add_to_cart`.`cart_id` = '$cart_id'";
    
            $insertEmpQuery = $this->conn->query($sql);
            
            return $insertEmpQuery;
            
        }
        else
       {
        $data = [
        'message' => 'no quantity available for goods movement',
        ];
        echo json_encode($data);
        exit;
        }
        
    }


    function cusaddToAartdataShow($userId){

        $data = array();
        $sql  = " SELECT products.*, product_price.*, customer_add_to_cart.ids, customer_add_to_cart.Qty, customer_add_to_cart.cart_id, customer_add_to_cart.image FROM product_price JOIN products ON product_price.product_id = products.product_id JOIN customer_add_to_cart ON customer_add_to_cart.price_id = product_price.price_id WHERE 
        customer_add_to_cart. customer_id = $userId and customer_add_to_cart.status != '0'";
        $res  = $this->conn->query($sql);
        $rows =  $res->num_rows;
        if ($rows > 0) {
            while ($result = $res->fetch_array()) {
                $data[] = $result;
            }
        }
        return $data;
    }
    
       function addtocartDelete($id){

        $sql = "DELETE FROM `customer_add_to_cart` WHERE  `customer_add_to_cart`.`ids` = '$id'";
        $res = $this->conn->query($sql);
        return $res;
    
    }
    



}

?>