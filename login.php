<?php

include('db.php');
include('controllers/cart_controller.php');
session_start();
$cart = $_SESSION['cart'];
$discount = $_SESSION['discount'];

$error = $_GET['error'];

if(isset($_GET['error'])){
  ?>
  <script>
    var popup = document.getElementById("cart-popup");
                popup.textContent = " Failed to delete discount.";
                popup.style.display = "block";
                setTimeout(function () {
                    popup.style.display = "none";
                }, 2000);
  </script>
<?php
}


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
        <a href="login.php" class="nav--item">Login</a>
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
  <a href="dashboard.php" class="nav--mobile--item">Login</a>
</div>
<div id="cart-popup" class="popup">
  Item added to cart!
</div>
  </div>
<div class="register--outer">
<section class="register--container">
<form class="register--form" action="controllers/account_controller.php?type=login" method="post">
  <h2 class="register--header">Login</h2>
    <p class="register--email">Email:</p>
    <input class="register--email--input" required type="email" name="email" id="">
    <p class="register--password">Wachtwoord:</p>
    <input class="register--password--input" required type="password" name="password" id="">
    <br>
    <br>
    <a href="register.php" class="register--noaccount">Nog geen account? Klik hier.</a>
    <br>
    <button type="submit" class="register--confirm">Login</button>
</form>
</section>
</div>
    <footer class="footer--container">
        <p class="footer--text">Contact</p>
        <p class="footer--text">FAQ</p>
        <p class="footer--text">TOS</p>
    </footer>
</body>
<?php
$error = $_GET['error'];

if(isset($_GET['error'])){
  ?>
  <script>
    var popup = document.getElementById("cart-popup");
                popup.textContent = "<?php echo $_GET['error']?>";
                popup.style.display = "block";
                setTimeout(function () {
                    popup.style.display = "none";
                }, 5000);
  </script>
<?php
}


?>

<script>


</script>
</html>

