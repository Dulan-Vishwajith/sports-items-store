<?php

include "includes/header.php";

?>

<div class="success">

    <h1>
        Payment Successful!
    </h1>

    <p>
        Your order has been placed successfully.
    </p>

    <?php if (isset($_GET['id'])): ?>

        <p>
            Order ID:
            #<?php echo intval($_GET['id']); ?>
        </p>

    <?php endif; ?>


    <a href="orders.php" class="button">
        View My Orders
    </a>

</div>

<?php
include "includes/footer.php";
?>