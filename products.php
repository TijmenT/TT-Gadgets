<?php

include("db.php");
include("controllers/product_controller.php");
$categories = GetCatergories($mysqli);
session_start();
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
    <script src="js/cart.js"></script>
    <script src="js/main.js"></script>
    <script src="js/slideshow.js"></script>


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

<div class="slideshow">
  <div id="image1" class="fade">
    <img src="img/background.jpg" class="background2--container" width="100%" alt="background">
  </div>
  <div id="image2" class="fade">
    <img src="img/rD1eOT.jpeg" class="background2--container" width="100%" alt="background">
  </div>
  <div id="image3" class="fade">
    <img src="img/turtle-beach-stealth-pro-preorder-blogroll-1679582803054_vcah.jpeg" class="background2--container" width="100%" alt="background">
  </div>
</div>



  <?php
foreach($categories as $categorie){
    $products = GetProductsByCat($categorie['catergorie_ID'], $mysqli)
  ?>
    <center><h1 class="product--cats" ><?php echo $categorie['name']?></h1><center>
    
    <section class="product--products1">
      <?php
foreach ($products as $product) {
      ?>
      <div class="product--card1">
        <img class="product--img" src="img/<?php echo $product['image']?>" />
        <h1 class="product--header"><?php echo $product['name']?></h1>
        <p1 class="product--price">€<?php echo number_format($product['price'], 2, ',', '.'); ?></p1>
        <button onclick="AddToCart(<?php echo $product['product_ID']?>)"class="product--buy">In Winkelwagen</button>
      </div>
<?php
}
?>
</section>
<?php
}
?>
  
  
    <footer class="footer--container">
        <p class="footer--text">Contact</p>
        <p class="footer--text">FAQ</p>
        <p class="footer--text">TOS</p>
    </footer>
</body>
</html>