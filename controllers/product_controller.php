<?php
include("db.php");
include("../dependencies/functions.php");
function GetProducts($mysqli)
{
    $products = array();

    $query = "SELECT * FROM products";
    $result = $mysqli->query($query);


    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $result->free();
    } else {
        echo "Error: " . $mysqli->error;
    }
    return $products;
}


function GetProductsByCat($categorie_id, $mysqli)
{
    $products = array();
    $query = "SELECT * FROM products WHERE categorie_ID = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $categorie_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            $result->free();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
    return $products;
}

function GetCatergories($mysqli)
{

    $categories = array();

    $query = "SELECT * FROM categories";
    $result = $mysqli->query($query);


    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        $result->free();
    } else {
        echo "Error: " . $mysqli->error;
    }

    return $categories;
}