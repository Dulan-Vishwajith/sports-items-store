<?php

include "includes/db.php";

session_start();

$message = "";

if (isset($_POST['signup'])) {

    $name = mysqli_real_escape_string(
        $conn,
        $_POST['name']
    );

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $password = $_POST['password'];

    $check = mysqli_query(
        $conn,
        "SELECT id FROM customers WHERE email='$email'"
    );

    if (mysqli_num_rows($check) > 0) {

        $message = "Email already exists.";

    } else {

        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "
            INSERT INTO customers
            (name, email, password)
            VALUES
            ('$name', '$email', '$hashed_password')
        ";

        mysqli_query($conn, $sql);

        header("Location: login.php");

        exit();
    }
}

include "includes/header.php";

?>

<h1>Create Account</h1>

<p><?php echo $message; ?></p>


<form method="POST">

    <label>Name</label>

    <input
        type="text"
        name="name"
        required
    >


    <label>Email</label>

    <input
        type="email"
        name="email"
        required
    >


    <label>Password</label>

    <input
        type="password"
        name="password"
        required
    >


    <button
        type="submit"
        name="signup"
    >
        Sign Up
    </button>

</form>

<?php
include "includes/footer.php";
?>