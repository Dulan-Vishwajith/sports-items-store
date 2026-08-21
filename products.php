<?php

include "includes/db.php";
include "includes/header.php";

$search = "";
$category = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

$sql = "SELECT * FROM products WHERE 1=1";

if ($search != "") {

    $search = mysqli_real_escape_string($conn, $search);

    $sql .= " AND name LIKE '%$search%'";
}

if ($category != "") {

    $category = mysqli_real_escape_string($conn, $category);

    $sql .= " AND category = '$category'";
}

$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<h1>Product Catalog</h1>


<form method="GET" class="search-form">

    <input
        type="text"
        name="search"
        placeholder="Search products..."
        value="<?php echo htmlspecialchars($search); ?>"
    >

    <select name="category">

        <option value="">
            All Categories
        </option>

        <option value="Football"
            <?php if ($category == "Football") echo "selected"; ?>>
            Football
        </option>

        <option value="Cricket"
            <?php if ($category == "Cricket") echo "selected"; ?>>
            Cricket
        </option>

        <option value="Shoes"
            <?php if ($category == "Shoes") echo "selected"; ?>>
            Shoes
        </option>

        <option value="Basketball"
            <?php if ($category == "Basketball") echo "selected"; ?>>
            Basketball
        </option>

    </select>

    <button type="submit">
        Search
    </button>

</form>


<div class="product-grid">

<?php while ($product = mysqli_fetch_assoc($result)): ?>

    <div class="product-card">

        <?php if ($product['image']): ?>

            <img
                src="uploads/products/<?php echo $product['image']; ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>"
            >

        <?php endif; ?>

        <h3>
            <?php echo htmlspecialchars($product['name']); ?>
        </h3>

        <p>
            <?php echo htmlspecialchars($product['category']); ?>
        </p>

        <strong>
            Rs. <?php echo number_format($product['price'], 2); ?>
        </strong>

        <br><br>

        <a
            href="product.php?id=<?php echo $product['id']; ?>"
            class="button"
        >
            View
        </a>

    </div>

<?php endwhile; ?>

</div>

<?php
include "includes/footer.php";
?>