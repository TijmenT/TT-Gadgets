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
        <a href="dashboard.php" class="nav--item">Account</a>
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
  <a href="dashboard.php" class="nav--mobile--item">Account</a>
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
    <section class="contact--container">
      <h1 class="contact--header">Contact</h1>
      <p class="contact--phonenumber--mobile">Tel: 123456789</p>
      <p class="contact--email--mobile">Email: voorbeeld@ttgadgets.com</p>
      <div class="contact--object">
      <section class="contact--formcontainer">
        <h1 class="contact--formheader">Contact Formulier</h1>
        <form action="" class="contact--form">
          <placeholder for="naam" class="contact--formname">Naam:</placeholder>
          <input type="text" class="contact--formname" name="naam" id="">
          <br>
          <placeholder for="email" class="contact--formemail">Email:</placeholder>
          <input type="email" class="contact--formemail"name="emal" id="">
          <br>
          <placeholder for="description" id="contact--formholderdescription">Beschrijving:</placeholder>
          <br>
          <textarea name="description" class="contact--formdescription" cols="30" rows="6"></textarea>
          <br>
          <button class="contact--formsubmit" type="submit">Verstuur</button>
        </form>
      </section>
      <section class="contact--infocontainer">
        <p class="contact--infotext">
         Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus consectetur eaque impedit vel laboriosam ea corporis quibusdam
        </p>
        <p class="contact--phonenumber">Tel: 123456789</p>
        <p class="contact--email">Email: voorbeeld@ttgadgets.com</p>
      </section>
    </div>
    </section>
  </section>
    <footer class="footer--container">
        <p class="footer--text">Contact</p>
        <p class="footer--text">FAQ</p>
        <p class="footer--text">TOS</p>
    </footer>
</body>
</html>