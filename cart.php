<?php

session_start();

include "includes/db.php";


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


/* ADD TO CART */

if (isset($_POST['add_to_cart'])) {

    $product_id = intval($_POST['product_id']);

    $quantity = intval($_POST['quantity']);

    if ($quantity < 1) {
        $quantity = 1;
    }

    if (isset($_SESSION['cart'][$product_id])) {

        $_SESSION['cart'][$product_id] += $quantity;

    } else {

        $_SESSION['cart'][$product_id] = $quantity;

    }

    header("Location: cart.php");

    exit();
}


/* REMOVE FROM CART */

if (isset($_GET['remove'])) {

    $product_id = intval($_GET['remove']);

    unset($_SESSION['cart'][$product_id]);

    header("Location: cart.php");

    exit();
}


include "includes/header.php";

?>

<h1>Your Cart</h1>

<?php if (empty($_SESSION['cart'])): ?>

    <p>Your cart is empty.</p>

    <a href="products.php" class="button">
        Browse Products
    </a>

<?php else: ?>

<table>

    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
    </tr>


<?php

$grand_total = 0;

foreach ($_SESSION['cart'] as $product_id => $quantity):

    $product_id = intval($product_id);

    $sql = "SELECT * FROM products WHERE id = $product_id";

    $result = mysqli_query($conn, $sql);

    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        continue;
    }

    $total = $product['price'] * $quantity;

    $grand_total += $total;

?>

<tr>

    <td>
        <?php echo htmlspecialchars($product['name']); ?>
    </td>

    <td>
        Rs. <?php echo number_format($product['price'], 2); ?>
    </td>

    <td>
        <?php echo $quantity; ?>
    </td>

    <td>
        Rs. <?php echo number_format($total, 2); ?>
    </td>

    <td>

        <a
            href="cart.php?remove=<?php echo $product_id; ?>"
        >
            Remove
        </a>

    </td>

</tr>

<?php endforeach; ?>

<tr>

    <td colspan="3">
        <strong>
            Grand Total
        </strong>
    </td>

    <td>

        <strong>
            Rs. <?php echo number_format($grand_total, 2); ?>
        </strong>

    </td>

    <td></td>

</tr>

</table>


<br>

<a href="checkout.php" class="button">
    Checkout
</a>

<?php endif; ?>

<?php
include "includes/footer.php";
?>