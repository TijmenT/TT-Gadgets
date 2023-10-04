<?php

include('db.php');
include('controllers/cart_controller.php');
include("dependencies/functions.php");
session_start();
$cart = $_SESSION['cart'];
$discount = $_SESSION['discount']


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
<h1 class="cart--header">Winkelwagen</h1>
<div class="cart">

<br>
      <br>
    <section class="cart--container">
    <div class="cart--item--labels">
        <img id="cart--image" src="img/<?php echo $product1['image']?>" alt="">
        <p class="cart--productnaam">Product</p>
        <p id="cart--aantalkiezen--label">Aantal</p>
        <p class="cart--productprijs">Prijs</p>
       
    </div>
    <?php
$cartQuantities = array_count_values($cart);
$totalPrice = 0; 
if($cartQuantities == NULL){
  ?>
  <h1 class="cart--noitems">Uw winkelwagen is leeg.</h1>
<?php
}
foreach ($cartQuantities as $productid => $quantity) {
    $product1 = GetProductByID($productid, $mysqli);
    $productPrice = $product1['price'] * $quantity; 
    $totalPrice += $productPrice; 
    ?>
    <div class="cart--item">
        <img id="cart--image" src="img/<?php echo $product1['image']?>" alt="product image">
        <p class="cart--productnaam"><?php echo $product1['name'] ?></p>
        <input  onchange="(UpdateCart(<?php echo $product1['product_ID']?>, this.value))" maxlength="10" value="<?php echo $quantity; ?>" type="number" id="cart--aantalkiezen" name="points" step="1">
        <p class="cart--productprijs">€<?php echo number_format($productPrice, 2, ',', '.'); ?></p>
    </div>
    <?php
}
?>
</section>
<section class="cart--totalcontainer">
    <h1 class="cart--bezorging">Bezorging</h1>
    <select name="shipping" class="cart--bezorgingkeuze" id="shippingSelect">
        <option value="standaard">Standaard</option>
        <option value="fast">Express (+ €4,95)</option>
    </select>
    <h1 class="cart--korting">Kortingscode</h1>
    <input type="text" name="korting" id="" class="cart--kortinginput">
    <button type="submit" onclick="ApplyCoupon()" class="cart--kortingbutton">Toepassen</button>
    
    <p class="cart--discounttext"><?php if(isset($_SESSION['discount'])){echo "€" . number_format($totalPrice, 2);}?></p>
    <button class="cart--removediscountbutton" onclick="RemoveDiscount()"><?php if(isset($_SESSION['discount'])){echo "Korting verwijderen (" . number_format($_SESSION['discount'], 2) . "%)";}?></button>
    <?php
    $totalPrice = LoadCoupon($totalPrice);
    ?>
    <h1 class="cart--total">Totaal: €<span id="totalPrice"><?php number_format($totalPrice, 2, ',', '.'); ?></span></h1> 
    <button onclick="ProcessOrder()" class="cart--pay">Betalen</button>
</section>
</div>

  <div class="cart--mobile">
    <?php

if($cartQuantities == NULL){
  ?>
  <h1 class="cart--noitems">Uw winkelwagen is leeg.</h1>
    <?php
}
    foreach ($cartQuantities as $productid => $quantity) {
    $product1 = GetProductByID($productid, $mysqli);
    $productPrice = $product1['price'] * $quantity; 
    $totalPricee += $productPrice; 
    ?>
    <div class="cart--item--mobile">
      <h1 class="cart--productname--mobile"><?php echo $product1['name']?></h1>
      <input onchange="(UpdateCart(<?php echo $product1['product_ID']?>, this.value))" placeholder="<?php echo $quantity; ?>" value="<?php echo $quantity; ?>" type="number" id="cart--aantalkiezen--mobile" name="points" step="1">
      <p class="cart--productprijs--mobile">€<?php echo number_format($product1['price'], 2, ',', '.');?></p>
    </div>
    <?php
    }
    ?>
    
  <div class="cart--totalcontainer--mobile">
    <h1 class="cart--bezorging--mobile">Bezorging</h1>
      <select name="" class="cart--bezorgingkeuze--mobile">
        <option value="standaard">Standaard</option>
        <option value="fast">Express (+ €4,95)</option>
      </select>
      <h1 class="cart--korting--mobile">Kortingscode</h1>
      <input type="text" name="korting" id="" class="cart--kortinginput--mobile">
      <br>
      <button type="submit" onclick="ApplyCoupon()" class="cart--kortingbutton--mobile">Toepassen</button>
      <p class="cart--discounttext"><?php if(isset($_SESSION['discount'])){echo "€" . number_format($totalPricee, 2);}?></p>
    <button class="cart--removediscountbutton" onclick="RemoveDiscount()"><?php if(isset($_SESSION['discount'])){echo "Korting verwijderen (" . number_format($_SESSION['discount'], 2) . "%)";}?></button>
    <?php
    $totalPricee = LoadCoupon($totalPricee);
    ?>  
      <h1 class="cart--total--mobile">Totaal: €<span id="totalPriceee"><?php echo number_format($totalPricee, 2, ',', '.'); ?></span></h1> 
      <button onclick="ProcessOrder()" class="cart--pay--mobile">Betalen</button>
  </div>
  </div>
  
    <footer class="footer--container">
        <p class="footer--text">Contact</p>
        <p class="footer--text">FAQ</p>
        <p class="footer--text">TOS</p>
    </footer>
</body>
<script>
 const shippingSelect = document.getElementById('shippingSelect');
    const totalPriceSpan = document.getElementById('totalPrice');
    function updateTotalPrice() {
        const selectedOption = shippingSelect.value;
        let total = <?php echo $totalPrice; ?>; 
        if (selectedOption === 'fast') {
            total += 4.95; 
        }
        totalPriceSpan.textContent = total.toFixed(2);
    }
    shippingSelect.addEventListener('change', updateTotalPrice);
    updateTotalPrice();

</script>
</html>