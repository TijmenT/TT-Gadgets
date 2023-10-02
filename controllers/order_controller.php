<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../dependencies/functions.php");
include("../db.php");
include("cart_controller.php");
session_start();

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type == "Checkout") {
        $fastshipping = $_GET['fastshipping'];
        ProcessOrder($mysqli, $fastshipping);
    }
}
function ProcessOrder($mysqli, $fastshipping){
    if(!isset($_SESSION['cart'])){
        return header("Location: ../cart.php");
    }
    if(count($_SESSION['cart']) == 0){
        return header("Location: ../cart.php");
    }
    $cart = $_SESSION['cart'];
    $cartQuantities = array_count_values($cart);
    $totalPrice = 0; 
    foreach ($cartQuantities as $productid => $quantity) {
        $product1 = GetProductByID($productid, $mysqli);
        $productPrice = $product1['price'] * $quantity; 
        $totalPrice += $productPrice; 
    }

    if($fastshipping == "true"){
        $totalPriceDiscounted = LoadCoupon($totalPrice) + 4.95;
    }
    else
    {
        $totalPriceDiscounted = LoadCoupon($totalPrice);
    }
    

    $customer_ID = GetUserIDByEmail($_SESSION['email'], $mysqli);
    $unique_id = generateUUID();
    $datee = date("Y-m-d");
    $query = "INSERT INTO `orders`(`order_ID`, `customer_ID`, `amount`, `date`, `fastshipping`) VALUES (?, ?,?, ?, ?)";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sidss", $unique_id, $customer_ID, $totalPriceDiscounted, $datee, $fastshipping);

        if ($stmt->execute()) {
            $stmt->close();

            $ordereditems = $_SESSION['cart'];
            unset($_SESSION['cart']);
            unset($_SESSION['discount']);
            foreach($ordereditems as $item){
                $query = "INSERT INTO `ordered_items`(`order_ID`, `product_ID`) VALUES (?, ?)";
                if ($stmt = $mysqli->prepare($query)) {
                    $stmt->bind_param("si", $unique_id, $item);

                    if ($stmt->execute()) {
                        echo "Imported item";
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    echo "Error: " . $mysqli->error;
                }
            }
            header("Location: ../order.php");
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $mysqli->error;
    }
}
