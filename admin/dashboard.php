<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");

    exit();
}

include "../includes/db.php";

?>

<!DOCTYPE html>

<html>

<head>

    <title>Admin Dashboard</title>

    <link
        rel="stylesheet"
        href="../css/admin.css"
    >

</head>

<body>

<div class="admin-container">

    <h1>
        Admin Dashboard
    </h1>

    <p>
        Welcome,
        <?php echo $_SESSION['admin_username']; ?>
    </p>


    <div class="admin-menu">

        <a href="products.php">
            Manage Products
        </a>

        <a href="add-product.php">
            Add Product
        </a>

        <a href="orders.php">
            View Orders
        </a>

        <a href="logout.php">
            Logout
        </a>

    </div>

</div>

</body>

</html>