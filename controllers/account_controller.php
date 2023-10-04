<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../dependencies/filter.php");
include("../db.php");
session_start();

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type == "register") {
        Registation($mysqli);
    }
    else if($type == "login"){
        Login($mysqli);
    }
    else if($type =="logout"){
        Logout();
    }
}

function Registation($mysqli){
    $firstname = customFilter($_POST['firstname'], 3, 20, "str", true, false, false);
    $lastname = customFilter($_POST['lastname'], 3, 20, "str", true, false, false);
    $email = customFilter($_POST['email'], 4, 40, "str", false, false, true);
    $temppassword = customFilter($_POST['password'], 4, 40, "str", false, false, true);
    $temppassword2 = customFilter($_POST['password2'], 4, 40, "str", false, false, true);
    $street = customFilter($_POST['streetandnumber'], 3, 40, "str", true, false, false);
    $zipcode = customFilter($_POST['zipcode'], 3, 40, "str", false, false, false);
    $city = customFilter($_POST['city'], 2, 40, "str", false, false, false);
    if($temppassword == $temppassword2)
    {
        $password = password_hash($temppassword, PASSWORD_DEFAULT);
    }
    else
    {
        echo " Password does not match";
    }

    $query = "INSERT INTO `customers`(`email`, `password`, `firstname`, `lastname`, `street`, `zipcode`, `city`, `active`) VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sssssss", $email, $password, $firstname, $lastname, $street, $zipcode, $city);

        if ($stmt->execute()) {
            header("Location: ../login.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
}   

function Login($mysqli){
    $email = customFilter($_POST['email'], 4, 40, "str", false, false, true);
    $password = customFilter($_POST['password'], 4, 40, "str", false, false, true);
    $query = "SELECT * FROM `customers` WHERE `email` = ?";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            if(password_verify($password, $data['password'])){
                $_SESSION['id'] = $data['customer_ID'];
                header("Location: ../index.php");
            }
            else{
                header("Location: ../login.php?error=Email and/or password incorrect.");
            }
        } else {
            echo "Error: " . $stmt->error;
            header("Location: ../login.php?error=unknown");
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
        header("Location: ../login.php?error=unknown");
    }
}

function Logout(){
    session_destroy();
    header("Location: ../index.php");
}