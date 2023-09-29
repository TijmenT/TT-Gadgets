<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type == "checkout") {
        ProcessOrder();
    }
}
// Filter data
// Check of klant al bestaat, zo niet opslaan.
// Check vanuit daar of adres al bestaat, zo niet opslaan en verbinden met klant_id
// Order opslaan, ook hier adres_id aan verbinden.
// Ordered items opslaan en verbinden aan order_id
function ProcessOrder(){
    $name = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $streetandnumber = $_POST['streetandnumber'];
    $zipcode = $_POST['zipcode'];
    $city = $_POST['city'];
    echo $name . $lastname . $email . $streetandnumber . $zipcode . $city;
}