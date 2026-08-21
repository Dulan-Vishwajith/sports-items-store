<?php

session_start();

function customerLoggedIn()
{
    return isset($_SESSION['customer_id']);
}

function requireCustomer()
{
    if (!customerLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

?>