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


$payment_method = $_POST['payment_method'] ?? "Card";


$grand_total = 0;

foreach ($_SESSION['cart'] as $product_id => $quantity) {

    $product_id = intval($product_id);

    $result = mysqli_query(
        $conn,
        "SELECT price FROM products WHERE id=$product_id"
    );

    $product = mysqli_fetch_assoc($result);

    if ($product) {

        $grand_total +=
            $product['price'] * $quantity;
    }
}


include "includes/header.php";

?>

<h1>Mock Payment</h1>

<h2>
    Total:
    Rs. <?php echo number_format($grand_total, 2); ?>
</h2>

<p>
    Payment Method:
    <?php echo htmlspecialchars($payment_method); ?>
</p>


<form
    action="payment.php"
    method="POST"
    id="payment-form"
>

    <input
        type="hidden"
        name="payment_method"
        value="<?php echo htmlspecialchars($payment_method); ?>"
    >

    <input
        type="hidden"
        name="confirm_payment"
        value="1"
    >


    <?php if ($payment_method == "Card"): ?>

        <label>
            Card Number
        </label>

        <input
            type="text"
            id="card-number"
            name="card_number"
            placeholder="1234 5678 9012 3456"
            maxlength="19"
            required
        >

        <small id="card-error"></small>


        <label>
            Expiry Date
        </label>

        <input
            type="text"
            id="expiry-date"
            name="expiry_date"
            placeholder="12/30"
            maxlength="5"
            required
        >

        <small id="expiry-error"></small>


        <label>
            CVV
        </label>

        <input
            type="password"
            id="cvv"
            name="cvv"
            placeholder="123"
            maxlength="3"
            required
        >

        <small id="cvv-error"></small>

    <?php endif; ?>


    <br>

    <button type="submit">
        Pay Now
    </button>

</form>

<?php

if (isset($_POST['confirm_payment'])) {

    $customer_id = $_SESSION['customer_id'];

    $payment_method =
        mysqli_real_escape_string(
            $conn,
            $_POST['payment_method']
        );


    /* CREATE ORDER */

    $sql = "
        INSERT INTO orders
        (customer_id, total, payment_method, status)
        VALUES
        (
            $customer_id,
            $grand_total,
            '$payment_method',
            'Paid'
        )
    ";

    mysqli_query($conn, $sql);

    $order_id = mysqli_insert_id($conn);


    /* CREATE ORDER ITEMS */

    foreach ($_SESSION['cart'] as $product_id => $quantity) {

        $product_id = intval($product_id);

        $result = mysqli_query(
            $conn,
            "SELECT price FROM products WHERE id=$product_id"
        );

        $product = mysqli_fetch_assoc($result);

        if (!$product) {
            continue;
        }

        $price = $product['price'];

        $sql = "
            INSERT INTO order_items
            (order_id, product_id, quantity, price)
            VALUES
            (
                $order_id,
                $product_id,
                $quantity,
                $price
            )
        ";

        mysqli_query($conn, $sql);
    }


    /* EMPTY CART */

    $_SESSION['cart'] = [];


    header(
        "Location: order-success.php?id=$order_id"
    );

    exit();
}

include "includes/footer.php";

?>