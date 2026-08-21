<?php

include "includes/db.php";
include "includes/header.php";

if (!isset($_GET['id'])) {
    die("Product not found.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM products WHERE id = $id";

$result = mysqli_query($conn, $sql);

$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}

?>

<div class="product-details">

    <?php if ($product['image']): ?>

        <img
            src="uploads/products/<?php echo $product['image']; ?>"
            alt="<?php echo htmlspecialchars($product['name']); ?>"
        >

    <?php endif; ?>


    <div>

        <h1>
            <?php echo htmlspecialchars($product['name']); ?>
        </h1>

        <p>
            <?php echo htmlspecialchars($product['description']); ?>
        </p>

        <h2>
            Rs. <?php echo number_format($product['price'], 2); ?>
        </h2>

        <p>
            Category:
            <?php echo htmlspecialchars($product['category']); ?>
        </p>


        <form action="cart.php" method="POST">

            <input
                type="hidden"
                name="product_id"
                value="<?php echo $product['id']; ?>"
            >

            <label>
                Quantity
            </label>

            <input
                type="number"
                name="quantity"
                value="1"
                min="1"
            >

            <button
                type="submit"
                name="add_to_cart"
            >
                Add to Cart
            </button>

        </form>

    </div>

</div>

<?php
include "includes/footer.php";
?>