<?php


include('db.php');
include('controllers/order_controller.php');

session_start();
$cart = $_SESSION['cart'];
$discount = $_SESSION['discount'];
$order_ID = $_GET['order_ID'];

if(IsThisMyOrder($order_ID, $mysqli)[0]['customer_ID'] != $_SESSION['id']){
    session_destroy();
    header("Location: login.php");
}

$orderproducts = GetProductsFromOrderID($order_ID, $mysqli);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TT Gadgets</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="js/main.js"></script>
    <script src="js/cart.js"></script>

</head>
<body>
<nav class="nav--container">
    <h1 class="nav--bigtext">TT Gadgets</h1>
    <div class="nav--list">
        <a href="index.php" class="nav--item">Home</a>
        <a href="products.php" class="nav--item">Assortiment</a>
        <a href="about.php" class="nav--item">Over ons</a>
        <a href="contact.php" class="nav--item">Contact</a>
    </div>
    <div class="nav--list2">
        <a href="cart.php" class="nav--item">Winkelwagen</a>
        <?php 
        if(isset($_SESSION['id'])){ ?>
          <a href="ordered.php" class="nav--item">Bestellingen</a>
          <a href="controllers/account_controller.php?type=logout" class="nav--item">Uitloggen</a>
        <?php
        }
        else
        { ?>
          <a href="login.php" class="nav--item">Login</a>
        <?php }?>
    </div>

    <div class="nav--mobile">
      <a href="#home" class="active"></a>
      <a href="javascript:void(0);" id="nav--mobile--icon--open" onclick="OpenBurger()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
</nav>
<div id="nav--mobile--links">
  <a href="javascript:void(0);" id="nav--mobile--icon--close" onclick="CloseBurger()">
    <span>&#10005;</span>

  </a>
  <a href="index.php" class="nav--mobile--item">Home</a>
  <a href="products.php" class="nav--mobile--item">Assortiment</a>
  <a href="about.php" class="nav--mobile--item">Over ons</a>
  <a href="contact.php" class="nav--mobile--item">Contact</a>
  <a href="cart.php" class="nav--mobile--item">Winkelwagen</a>

  <?php 
        if(isset($_SESSION['id'])){ ?>
          <a href="ordered.php" class="nav--mobile--item">Bestellingen</a>
          <a href="controllers/account_controller.php?type=logout" class="nav--mobile--item">Uitloggen</a>
        <?php
        }
        else
        { ?>
      <a href="login.php" class="nav--mobile--item">Login</a>
        <?php }?>
</div>
<div id="cart-popup" class="popup">
  Item added to cart!
</div>
        <p class="cart--noitems">OrderID: <?php echo $order_ID?></p>
<section class="product--products2">
    <?php
    $orderQuantities = array_count_values(array_column($orderproducts, 'product_ID')); 
    if(empty($orderQuantities)){
        echo '<h1 class="cart--noitems">Empty.</h1>';
    } else {
        foreach ($orderQuantities as $productid => $quantity) {
            $product = findProductByID($productid, $orderproducts);
    ?>
            <div class="product--card1">
                <img class="product--img" src="img/<?php echo $product['image']?>" />
                <h1 class="product--header"><?php echo $product['name']?></h1>
                <p1 class="product--price">Amount: <?php echo $quantity?></p1>
                <br>
                <br>
                <center><p1 style="font-size: 1.3rem;"><?php echo $product['description']?></p1></center>
            </div>
    <?php
        }
    }
    ?>
</section>

 
    <footer class="footer--container">
        <p class="footer--text">Contact</p>
        <p class="footer--text">FAQ</p>
        <p class="footer--text">TOS</p>
    </footer>
</body>
<script>


</script>
</html>