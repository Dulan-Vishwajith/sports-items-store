<?php

include "includes/db.php";

session_start();

$message = "";

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $password = $_POST['password'];

    $sql = "
        SELECT *
        FROM customers
        WHERE email='$email'
    ";

    $result = mysqli_query($conn, $sql);

    $customer = mysqli_fetch_assoc($result);


    if (
        $customer &&
        password_verify(
            $password,
            $customer['password']
        )
    ) {

        $_SESSION['customer_id'] = $customer['id'];

        $_SESSION['customer_name'] =
            $customer['name'];

        header("Location: index.php");

        exit();

    } else {

        $message = "Invalid email or password.";

    }
}

include "includes/header.php";

?>

<h1>Customer Login</h1>

<p><?php echo $message; ?></p>


<form method="POST">

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
        name="login"
    >
        Login
    </button>

</form>


<p>
    Don't have an account?
    <a href="signup.php">
        Create Account
    </a>
</p>

<?php
include "includes/footer.php";
?>