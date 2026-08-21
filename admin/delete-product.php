<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");

    exit();
}

include "../includes/db.php";


$id = intval($_GET['id']);


mysqli_query(
    $conn,
    "DELETE FROM products WHERE id=$id"
);


header("Location: products.php");

exit();

?>