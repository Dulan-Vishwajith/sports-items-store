<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");

    exit();
}

include "../includes/db.php";

$result = mysqli_query(
    $conn,
    "SELECT * FROM products ORDER BY id DESC"
);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Manage Products</title>

    <link
        rel="stylesheet"
        href="../css/admin.css"
    >

</head>

<body>

<div class="admin-container">

<h1>
    Manage Products
</h1>

<a href="dashboard.php">
    Dashboard
</a>

<a href="add-product.php">
    Add Product
</a>


<table>

<tr>

    <th>Image</th>

    <th>Name</th>

    <th>Category</th>

    <th>Price</th>

    <th>Actions</th>

</tr>


<?php while ($product = mysqli_fetch_assoc($result)): ?>

<tr>

    <td>

        <?php if ($product['image']): ?>

            <img
                src="../uploads/products/<?php echo $product['image']; ?>"
                width="80"
            >

        <?php endif; ?>

    </td>

    <td>
        <?php echo htmlspecialchars($product['name']); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($product['category']); ?>
    </td>

    <td>
        Rs. <?php echo number_format($product['price'], 2); ?>
    </td>

    <td>

        <a
            href="edit-product.php?id=<?php echo $product['id']; ?>"
        >
            Edit
        </a>

        |

        <a
            href="delete-product.php?id=<?php echo $product['id']; ?>"
            onclick="return confirm('Delete this product?')"
        >
            Delete
        </a>

    </td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>

</html>