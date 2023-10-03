<?php

session_start();

include("../db.php");

if ($_SESSION['cart'] == NULL) {
    $_SESSION['cart'] = array();
    $cart = array();
} else {
    $cart = $_SESSION['cart'];
}

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type == "AddToCart") {
        $product_ID = isset($_GET['product_ID']) ? $_GET['product_ID'] : '';
        AddToCart($product_ID);
    }
    elseif($type == "UpdateCart"){
        $product_ID = isset($_GET['product_ID']) ? $_GET['product_ID'] : '';
        $newAmount = isset($_GET['newAmount']) ? $_GET['newAmount'] : '';
        UpdateCart($product_ID, $newAmount);
    }
    elseif($type == "ApplyCoupon")
    {
        $coupon = isset($_GET['coupon']) ? $_GET['coupon'] : '';
        $mysqli;
        ApplyCoupon($coupon, $mysqli);
    }
    elseif($type == "RemoveDiscount")
    {
        RemoveDiscount();
    }
    elseif($type == "LoggedIn")
    {
        LoggedIn();
    }
}

function AddToCart($product_ID)
{
    global $cart;
    array_push($cart, $product_ID);
    $_SESSION['cart'] = $cart;
    echo "Toegevoegd aan winkelwagen!";
}


function UpdateCart($product_ID, $newAmount){
    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
        $updatedCart = array();
        foreach ($cart as $item) {
            if ($item == $product_ID && $newAmount > 0) {
                $updatedCart[] = $product_ID;
                $newAmount--;
            } elseif ($item != $product_ID) {
                $updatedCart[] = $item;
            }
        }
        while ($newAmount > 0) {
            $updatedCart[] = $product_ID;
            $newAmount--;
        }
        $_SESSION['cart'] = $updatedCart;
    }
    echo " Aangepast!";
}

function ApplyCoupon($coupon, $mysqli){
     $query = "SELECT * FROM coupons WHERE code = ?";
     $stmt = $mysqli->prepare($query);
     $stmt->bind_param("s", $coupon);
     $stmt->execute();
     $result = $stmt->get_result();
     if ($result->num_rows > 0) {
         $data = $result->fetch_assoc();
         if($data['active'] == 0 or $data['active'] == ""){
            echo " Coupon expired or inactive.";
         }
         else{
            $_SESSION['discount'] = $data['discount'];
            echo $data['discount'];
         }
     } else {
         echo " Invalid coupon";
     }
     $stmt->close();
}

function LoadCoupon($price){
    
    if(!isset($_SESSION['discount'])){
        return $price;
    }
    else
    {
        return $price / 100 * (100 - $_SESSION['discount']);
    }
      
}

function RemoveDiscount(){
    unset($_SESSION['discount']);
    echo "removed";
}

function LoggedIn(){
    if(isset($_SESSION['id'])){
        echo "active";
    }
}
?>
