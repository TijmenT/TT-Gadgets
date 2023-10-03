<?php

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
    else if($type == "Paid"){
        $order_ID = $_GET['orderid'];
        PaidOrder($order_ID, $mysqli);
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
    
    $customer_ID = $_SESSION['id'];
    $datee = date("Y-m-d");
    $query = "INSERT INTO `orders`(`customer_ID`, `amount`, `date`, `fastshipping`) VALUES (?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("idss", $customer_ID, $totalPriceDiscounted, $datee, $fastshipping);

        if ($stmt->execute()) {
            $stmt->close();

            $order_ID = $mysqli->insert_id;
            $ordereditems = $_SESSION['cart'];
            unset($_SESSION['cart']);
            unset($_SESSION['discount']);
            foreach($ordereditems as $item){
                $query = "INSERT INTO `ordered_items`(`order_ID`, `product_ID`) VALUES (?, ?)";
                if ($stmt = $mysqli->prepare($query)) {
                    $stmt->bind_param("ii", $order_ID, $item);

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
            header("Location: ../payment.php?amount=$totalPriceDiscounted&orderID=$order_ID");
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $mysqli->error;
    }
}


function GetMyOrders($mysqli){
    $customer_id = $_SESSION['id'];
    $orders = array();
    $query = "SELECT * FROM orders WHERE customer_ID = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $customer_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            $result->free();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
    return $orders;
}

function PaidOrder($order_ID, $mysqli){
    $query = "UPDATE `orders` SET `paid` = 1 WHERE order_ID = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $order_ID);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
}

function GetProductsFromOrderID($order_ID, $mysqli){
    $query = "SELECT * FROM products LEFT JOIN ordered_items ON products.product_ID=ordered_items.product_ID WHERE ordered_items.order_ID = ?";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param("i", $order_ID);
        if($stmt->execute()){
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $products[] = $row;
            }
            $result->free();
        } else
        {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else
    {
        echo "Error: " . $mysqli->error;
    }
    return $products;
}

function findProductByID($productid, $orderproducts) {
    foreach ($orderproducts as $product) {
        if ($product['product_ID'] == $productid) {
            return $product;
        }
    }
    return false;
}

function IsThisMyOrder($order_ID, $mysqli){
    $order = array();
    $query = "SELECT `customer_ID` FROM orders WHERE order_ID = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $order_ID);
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $order[] = $row;
            }
            $result->free();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
        return $order;
    
}