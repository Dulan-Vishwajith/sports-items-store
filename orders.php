<?php

include "includes/auth.php";

requireCustomer();

include "includes/db.php";

include "includes/header.php";


$customer_id = $_SESSION['customer_id'];

$sql = "
    SELECT *
    FROM orders
    WHERE customer_id = $customer_id
    ORDER BY id DESC
";

$result = mysqli_query($conn, $sql);

?>

<h1>My Previous Orders</h1>


<table>

    <tr>

        <th>Order ID</th>

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
        Rs. <?php echo number_format($order['total'], 2); ?>
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


<?php
include "includes/footer.php";
?>