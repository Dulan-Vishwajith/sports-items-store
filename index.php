<?php
include "includes/db.php";
include "includes/header.php";
?>

<section class="hero">

    <h1>
        Welcome to Sports Store
    </h1>

    <p>
        Find sports equipment for your game.
    </p>

    <a href="products.php" class="button">
        Browse Products
    </a>

</section>


<section>

    <h2>
        Popular Products
    </h2>

    <div class="product-grid">

        <?php

        $sql = "SELECT * FROM products LIMIT 4";

        $result = mysqli_query($conn, $sql);

        while ($product = mysqli_fetch_assoc($result)):

        ?>

        <div class="product-card">

            <?php if ($product['image']): ?>

                <img
                    src="uploads/products/<?php echo $product['image']; ?>"
                    alt="<?php echo $product['name']; ?>"
                >

            <?php endif; ?>

            <h3>
                <?php echo $product['name']; ?>
            </h3>

            <p>
                Rs. <?php echo number_format($product['price'], 2); ?>
            </p>

            <a
                href="product.php?id=<?php echo $product['id']; ?>"
                class="button"
            >
                View Product
            </a>

        </div>

        <?php endwhile; ?>

    </div>

</section>

<?php
include "includes/footer.php";
?>