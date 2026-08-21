<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");

    exit();
}

include "../includes/db.php";


$message = "";


if (isset($_POST['add_product'])) {

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


    /* IMAGE */

    $image_name = "";

    if (isset($_FILES['image']) &&
        $_FILES['image']['error'] == 0) {


        $image_name =
            basename($_FILES['image']['name']);


        $extension =
            strtolower(
                pathinfo(
                    $image_name,
                    PATHINFO_EXTENSION
                )
            );


        $allowed = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];


        if (!in_array($extension, $allowed)) {

            $message =
                "Only JPG, JPEG, PNG and WEBP allowed.";

        } else {

            /*
             * Create unique filename
             */

            $new_name =
                time() . "_" . $image_name;


            $upload_path =
                "../uploads/products/" . $new_name;


            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $upload_path
            );


            $image_name = $new_name;


            $sql = "
                INSERT INTO products
                (
                    name,
                    description,
                    category,
                    price,
                    image
                )
                VALUES
                (
                    '$name',
                    '$description',
                    '$category',
                    $price,
                    '$image_name'
                )
            ";


            mysqli_query($conn, $sql);


            header("Location: products.php");

            exit();
        }

    } else {

        $sql = "
            INSERT INTO products
            (
                name,
                description,
                category,
                price
            )
            VALUES
            (
                '$name',
                '$description',
                '$category',
                $price
            )
        ";


        mysqli_query($conn, $sql);


        header("Location: products.php");

        exit();
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Add Product</title>

    <link
        rel="stylesheet"
        href="../css/admin.css"
    >

</head>

<body>

<div class="admin-container">

<h1>
    Add Product
</h1>

<p>
    <?php echo $message; ?>
</p>


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
        required
    >


    <label>
        Description
    </label>

    <textarea
        name="description"
    ></textarea>


    <label>
        Category
    </label>

    <select name="category">

        <option value="Football">
            Football
        </option>

        <option value="Cricket">
            Cricket
        </option>

        <option value="Basketball">
            Basketball
        </option>

        <option value="Shoes">
            Shoes
        </option>

    </select>


    <label>
        Price
    </label>

    <input
        type="number"
        name="price"
        step="0.01"
        required
    >


    <label>
        Product Image
    </label>

    <input
        type="file"
        name="image"
        accept=".jpg,.jpeg,.png,.webp"
    >


    <button
        type="submit"
        name="add_product"
    >
        Add Product
    </button>

</form>


<br>

<a href="products.php">
    Back to Products
</a>

</div>

</body>

</html>