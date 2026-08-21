<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Sports Store</title>

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body>

<header>

    <div class="logo">
        Sports Store
    </div>

    <nav>

        <a href="index.php">
            Home
        </a>

        <a href="products.php">
            Catalog
        </a>

        <a href="cart.php">
            Cart
        </a>

        <?php if (isset($_SESSION['customer_id'])): ?>

            <a href="orders.php">
                My Orders
            </a>

            <a href="logout.php">
                Logout
            </a>

        <?php else: ?>

            <a href="login.php">
                Login
            </a>

            <a href="signup.php">
                Sign Up
            </a>

        <?php endif; ?>

    </nav>

</header>

<main>