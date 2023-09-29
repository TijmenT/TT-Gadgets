<?php
include("../dependencies/filter.php");
function Registation(){
    $firstname = customFilter($_POST['firstname'], 3, 20, "str", true, false, false);
    $lastname = customFilter($_POST['lastname'], 3, 20, "str", true, false, false);
    $email = customFilter($_POST['email'], 4, 40, "str", false, false, true);
    $email = customFilter($_POST['email'], 4, 40, "str", false, false, false);

}