<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");

    exit();
}

include "../includes/db.php";


$sql = "
    SELECT
        orders.*,
        customers.name,
        customers.email
    FROM orders

    INNER JOIN customers
        ON orders.customer_id = customers.id

    ORDER BY orders.id DESC
";


$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Orders</title>

    <link
        rel="stylesheet"
        href="../css/admin.css"
    >

</head>

<body>

<div class="admin-container">

<h1>
    Customer Orders
</h1>


<table>

<tr>

    <th>Order ID</th>

    <th>Customer</th>

    <th>Email</th>

    <th>Total</th>

    <th>Payment</th>

    <th>Status</th>

    <th>Date</th>

</tr>


<?php while ($order = mysqli_fetch_assoc($result)): ?>

<tr>

    <td>
        #<?php echo $order['id']; ?>
    </td>

    <td>
        <?php echo htmlspecialchars($order['name']); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($order['email']); ?>
    </td>

    <td>
        Rs.
        <?php echo number_format($order['total'], 2); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($order['payment_method']); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($order['status']); ?>
    </td>

    <td>
        <?php echo $order['created_at']; ?>
    </td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>

</html>