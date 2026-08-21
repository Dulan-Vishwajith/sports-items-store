<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");

    exit();
}

include "../includes/db.php";


$id = intval($_GET['id']);


$result = mysqli_query(
    $conn,
    "SELECT * FROM products WHERE id=$id"
);

$product = mysqli_fetch_assoc($result);


if (!$product) {
    die("Product not found.");
}


if (isset($_POST['update'])) {

    $name = mysqli_real_escape_string(
        $conn,
        $_POST['name']
    );

    $description = mysqli_real_escape_string(
        $conn,
        $_POST['description']
    );

    $category = mysqli_real_escape_string(
        $conn,
        $_POST['category']
    );

    $price = floatval($_POST['price']);


    $image = $product['image'];


    if (
        isset($_FILES['image']) &&
        $_FILES['image']['error'] == 0
    ) {

        $filename =
            time() . "_" .
            basename($_FILES['image']['name']);


        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../uploads/products/" . $filename
        );


        $image = $filename;
    }


    $sql = "
        UPDATE products
        SET
            name='$name',
            description='$description',
            category='$category',
            price=$price,
            image='$image'
        WHERE id=$id
    ";


    mysqli_query($conn, $sql);


    header("Location: products.php");

    exit();
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Edit Product</title>

    <link
        rel="stylesheet"
        href="../css/admin.css"
    >

</head>

<body>

<div class="admin-container">

<h1>
    Edit Product
</h1>


<form
    method="POST"
    enctype="multipart/form-data"
>

    <label>
        Product Name
    </label>

    <input
        type="text"
        name="name"
        value="<?php echo htmlspecialchars($product['name']); ?>"
        required
    >


    <label>
        Description
    </label>

    <textarea name="description"><?php
        echo htmlspecialchars($product['description']);
    ?></textarea>


    <label>
        Category
    </label>

    <input
        type="text"
        name="category"
        value="<?php echo htmlspecialchars($product['category']); ?>"
        required
    >


    <label>
        Price
    </label>

    <input
        type="number"
        name="price"
        step="0.01"
        value="<?php echo $product['price']; ?>"
        required
    >


    <p>
        Current Image:
    </p>

    <?php if ($product['image']): ?>

        <img
            src="../uploads/products/<?php echo $product['image']; ?>"
            width="150"
        >

    <?php endif; ?>


    <label>
        New Image
    </label>

    <input
        type="file"
        name="image"
    >


    <button
        type="submit"
        name="update"
    >
        Update Product
    </button>

</form>

</div>

</body>

</html>