<?php

session_start();

include "includes/db.php";

if (!isset($_SESSION['customer_id'])) {

    header("Location: login.php");

    exit();
}

if (empty($_SESSION['cart'])) {

    header("Location: cart.php");

    exit();
}

include "includes/header.php";

?>

<h1>Checkout</h1>


<h2>
    Customer Information
</h2>

<p>
    Name:
    <?php echo htmlspecialchars($_SESSION['customer_name']); ?>
</p>


<h2>
    Payment
</h2>

<p>
    This is a mock payment system.
</p>


<form action="payment.php" method="POST">

    <label>
        Payment Method
    </label>

    <select name="payment_method">

        <option value="Card">
            Credit / Debit Card
        </option>

        <option value="Cash">
            Cash on Delivery
        </option>

    </select>


    <br><br>


    <button type="submit">
        Continue to Payment
    </button>

</form>

<?php
include "includes/footer.php";
?>