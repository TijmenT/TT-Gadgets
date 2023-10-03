<?php


include('db.php');
include('controllers/order_controller.php');
session_start();
$cart = $_SESSION['cart'];
$discount = $_SESSION['discount'];
$orderhistory = GetMyOrders($mysqli);

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
  </div>

  <div class="ordered--history">
  <div class="ordered--item" style="background: transparent; height: 2rem;" >
        <p class="ordered--naam">Order ID</p>
        <p class="ordered--prijs">Status</p>
        <p class="ordered--prijs">Totaal prijs</p>
        <p class="ordered--meerinfo">Meer info</p>
    </div>

    <?php
    $orderscount = 0;
foreach($orderhistory as $order){
    $orderscount += 1;
?>
  <div class="ordered--item">
        <p class="ordered--naam"><?php echo $order['order_ID']?></p>
        <?php
        if($order['paid'] == 1){
        ?>
        <p class="ordered--prijs" style="color: #4aba25" >Betaald</p>
        <?php
        }
        else{
        ?>
       <p class="ordered--prijs" style="color: #eb4034">Onbetaald</p>

        <?php }?>
        <p class="ordered--prijs">€<?php echo number_format($order['amount'], 2, ',', '.'); ?></p>
        
        <?php
        if($order['paid'] == 1){
        ?>
        <a href="orderinfo.php?order_ID=<?php echo $order['order_ID'] ?>" class="ordered--meerinfo">Meer Info</a>
        <?php
        }
        else{
        ?>
        <a href="payment.php?amount=<?php echo $order['amount']?>&orderID=<?php echo $order['order_ID']?>" class="ordered--meerinfo">Afrekenen</a>

        <?php }
        ?>
    </div>
<?php
}
        if($orderscount == 0){
        ?>
          <h1 class="cart--noitems">U heeft geen bestellingen.</h1>

        <?php }?>
  </div>
    <footer class="footer--container">
        <p class="footer--text">Contact</p>
        <p class="footer--text">FAQ</p>
        <p class="footer--text">TOS</p>
    </footer>
</body>
<script>


</script>
</html>