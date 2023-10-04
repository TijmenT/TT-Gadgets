<?php
include("../db.php");

function GetUserIDByEmail($email, $mysqli){
    $query = "SELECT `customer_ID` FROM customers WHERE email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); 
        $customer_ID = $row['customer_ID']; 
        $stmt->close();
        return $customer_ID;
    } else {
        $stmt->close();
        return null; 
    }
}
function GetProductByID($product_ID, $mysqli){
    $query = "SELECT * FROM products WHERE product_ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $product_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $stmt->close();
        return $product;
    } else {
        $stmt->close();
        return null; 
    }
}
