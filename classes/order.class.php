<?php


date_default_timezone_set("Asia/Kolkata");

class Order extends DatabaseConnection{

    function AddToCartStatus($cart_id){

        $sql = "SELECT * FROM `customer_add_to_cart` WHERE `customer_add_to_cart`.`cart_id` = '$cart_id'";

        $selectdata   = $this->conn->query($sql);

        $rows = $selectdata->num_rows;

        if ($rows > 0) {
        $sqledit = "UPDATE `customer_add_to_cart`
                    SET `status`= '0'
                    WHERE
                    `customer_add_to_cart`.`cart_id` = '$cart_id'";
    
        $result = $this->conn->query($sqledit);
    
        return $result;
    
        
        }
    }



    
    function productBycartID($cart_id){

        $data = array();
        $sql = "SELECT * FROM `customer_add_to_cart` WHERE `customer_add_to_cart`.`cart_id` = '$cart_id'";
        $res = $this->conn->query($sql);
        if ($res->num_rows > 0 ) {
            while ($result = $res->fetch_array()) {
                $data[] = $result;
            }
        }
        return $data;
    }
    
    
    

    

    function  orderAdd($userId, $order_id, $payment_method, $cart_id, $total_amount, $school_id, $address_id){

        $curr_timestamp = date("Y-m-d H:i:s");
    
        $sql = "INSERT INTO `order` (`added_by`, `order_id`, `payment_method`, `cart_id`, `total_amount`, `status`, `added_on`, `school_id`, `address_id`)
            VALUES 
            ($userId, '$order_id', '$payment_method', '$cart_id', '$total_amount', 'Not Delivered', '$curr_timestamp', '$school_id', '$address_id')";

        $insertQuery = $this->conn->query($sql);

        return $insertQuery;
    }


function orderstackUpdateprice($Qty, $price_id){
    
    $sqledit = "UPDATE `product_price`
    SET `Quantity`= (`Quantity` - '$Qty')
    WHERE
    `product_price`.`price_id` = '$price_id'";

    $result = $this->conn->query($sqledit);

    return $result;

}


function orderstackUpdateproduct($Qty, $price_id){
    
    $sqledit = "UPDATE `products`
    SET `Quantity`= (`Quantity` - '$Qty')
    WHERE
    `products`.`price_id` = '$price_id'";
    
    $result = $this->conn->query($sqledit);

    return $result;

}




function displayOrderProduct($userId){

    $data = array();
    $sql = "SELECT `order`.*, customer_add_to_cart.product_id, customer_add_to_cart.image, customer_add_to_cart.Qty,
     customer_add_to_cart.price_id, user.name, user.email, user.ph_no, user_order_address.*, product_price.size, product_price.gender, products.product_name FROM `order` 
    JOIN customer_add_to_cart ON `order`.cart_id = customer_add_to_cart.cart_id 
    JOIN user ON `order`.added_by = user.user_id 
    JOIN user_order_address ON `order`.address_id = user_order_address.address_id 
    JOIN product_price ON customer_add_to_cart.price_id = product_price.price_id 
    JOIN products ON product_price.product_id = products.product_id 
     WHERE `order`.`added_by` = $userId and `order`.`status` != 'Cancel'";
    $res = $this->conn->query($sql);
    if ($res->num_rows > 0 ) {
        while ($result = $res->fetch_array()) {
            $data[] = $result;
        }
    }
    return $data;
}






function displaybill($order_id){

    $data = array();
    $sql = "SELECT `order`.*, customer_add_to_cart.product_id, customer_add_to_cart.Qty, customer_add_to_cart.price_id, user.*, product_price.size, product_price.gender, product_price.original_price, products.product_name, school.name as 'school_name' FROM `order` 
    JOIN customer_add_to_cart ON `order`.cart_id = customer_add_to_cart.cart_id 
    JOIN user ON `order`.added_by = user.user_id 
     JOIN school ON `order`.`school_id` = school.user_id 
    JOIN product_price ON customer_add_to_cart.price_id = product_price.price_id 
    JOIN products ON product_price.product_id = products.product_id
     WHERE `order`.`order_id` = '$order_id'";
    $res = $this->conn->query($sql);
    if ($res->num_rows > 0 ) {
        while ($result = $res->fetch_array()) {
            $data[] = $result;
        }
    }
    return $data;
}




function displayOrderschool($school_id){

    $data = array();
    $sql = "SELECT `order`.*, customer_add_to_cart.product_id, customer_add_to_cart.Qty, customer_add_to_cart.price_id, user.*, product_price.size, product_price.gender, products.product_name FROM `order` 
    JOIN customer_add_to_cart ON `order`.cart_id = customer_add_to_cart.cart_id 
    JOIN user ON `order`.added_by = user.user_id 
    JOIN product_price ON customer_add_to_cart.price_id = product_price.price_id 
    JOIN products ON product_price.product_id = products.product_id 
     WHERE `order`.`school_id` = '$school_id'";
    $res = $this->conn->query($sql);
    if ($res->num_rows > 0 ) {
        while ($result = $res->fetch_array()) {
            $data[] = $result;
        }
    }
    return $data;
}


function displayOrderschools(){

    $data = array();
    $sql = "SELECT `order`.*, customer_add_to_cart.product_id, customer_add_to_cart.Qty, customer_add_to_cart.price_id, user.*, product_price.size, product_price.gender, products.product_name FROM `order` 
    JOIN customer_add_to_cart ON `order`.cart_id = customer_add_to_cart.cart_id 
    JOIN user ON `order`.added_by = user.user_id 
    JOIN product_price ON customer_add_to_cart.price_id = product_price.price_id 
    JOIN products ON product_price.product_id = products.product_id";
    $res = $this->conn->query($sql);
    if ($res->num_rows > 0 ) {
        while ($result = $res->fetch_array()) {
            $data[] = $result;
        }
    }
    return $data;
}





##################################################### sales  #######################################################

function showOrderschool($school_id){

    $data = array();
    $sql = "SELECT `order`.*, customer_add_to_cart.product_id, customer_add_to_cart.Qty, customer_add_to_cart.price_id, user.*, product_price.size, product_price.gender, products.product_name FROM `order` 
    JOIN customer_add_to_cart ON `order`.cart_id = customer_add_to_cart.cart_id 
    JOIN user ON `order`.added_by = user.user_id 
    JOIN product_price ON customer_add_to_cart.price_id = product_price.price_id 
    JOIN products ON product_price.product_id = products.product_id 
     WHERE `order`.`school_id` = '$school_id' and `order`.`status` = 'Delivered'";
    $res = $this->conn->query($sql);
    if ($res->num_rows > 0 ) {
        while ($result = $res->fetch_array()) {
            $data[] = $result;
        }
    }
    return $data;
}


function showOrderschools(){

    $data = array();
    $sql = "SELECT `order`.*, customer_add_to_cart.product_id, customer_add_to_cart.Qty, customer_add_to_cart.price_id, user.*, product_price.size, product_price.gender, products.product_name FROM `order` 
    JOIN customer_add_to_cart ON `order`.cart_id = customer_add_to_cart.cart_id 
    JOIN user ON `order`.added_by = user.user_id 
    JOIN product_price ON customer_add_to_cart.price_id = product_price.price_id 
    JOIN products ON product_price.product_id = products.product_id
    WHERE `order`.`status` = 'Delivered'";
    $res = $this->conn->query($sql);
    if ($res->num_rows > 0 ) {
        while ($result = $res->fetch_array()) {
            $data[] = $result;
        }
    }
    return $data;
}





##################################################### order status #############################################


function orderstatus($order_id, $status){
    
    $sqledit = "UPDATE `order`
                SET `status`      = '$status'
                WHERE
                `order`.`order_id` = '$order_id'";

    $result = $this->conn->query($sqledit);

    return $result;

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



##################################################### Return #############################################


function orderReturn($order_id, $status){
    
    $sqledit = "UPDATE `order`
                SET `return`      = '$status'
                WHERE
                `order`.`order_id` = '$order_id'";

    $result = $this->conn->query($sqledit);

    return $result;

}



function displayOrderreturn(){

    $data = array();
    $sql = "     SELECT `order`.*, customer_add_to_cart.product_id, customer_add_to_cart.image, customer_add_to_cart.Qty, customer_add_to_cart.price_id, user.*, product_price.size, product_price.gender, products.product_name FROM `order` 
    JOIN customer_add_to_cart ON `order`.cart_id = customer_add_to_cart.cart_id 
    JOIN user ON `order`.added_by = user.user_id 
    JOIN product_price ON customer_add_to_cart.price_id = product_price.price_id 
    JOIN products ON product_price.product_id = products.product_id 
     WHERE `order`.`return` = 'Return'";
    $res = $this->conn->query($sql);
    if ($res->num_rows > 0 ) {
        while ($result = $res->fetch_array()) {
            $data[] = $result;
        }
    }
    return $data;
}





function addressAdd($user_id, $house_no, $floor_no, $society_name, $locality, $landmark, $pincode, $area, $city, $address_id, $state){
    
    $sql = "INSERT INTO `user_order_address` (`user_id`, `house_no`, `floor_no`, `society_name`, `locality`, `landmark`, `pincode`, `area`, `city`, `address_id`, `state`)
        VALUES 
        ($user_id, '$house_no', '$floor_no', '$society_name', '$locality', '$landmark', '$pincode', '$area', '$city', '$address_id', '$state')";

    $insertQuery = $this->conn->query($sql);

    return $insertQuery;

}




function displayOrderAddress($userId){

    $data = array();
    $sql = "SELECT * FROM `user_order_address` WHERE `user_order_address`.`user_id` = $userId";
    $res = $this->conn->query($sql);
    if ($res->num_rows > 0 ) {
        while ($result = $res->fetch_array()) {
            $data[] = $result;
        }
    }
    return $data;
}


function orderAddressDelete($id){

    $sql = "DELETE FROM `user_order_address` WHERE  `user_order_address`.`id` = '$id'";
    $res = $this->conn->query($sql);
    return $res;

}



}
?>