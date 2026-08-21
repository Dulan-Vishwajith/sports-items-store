<?php

session_start();

include "../includes/db.php";

$message = "";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $password = $_POST['password'];


    $sql = "
        SELECT *
        FROM admins
        WHERE username='$username'
    ";

    $result = mysqli_query($conn, $sql);

    $admin = mysqli_fetch_assoc($result);


    if (
        $admin &&
        password_verify(
            $password,
            $admin['password']
        )
    ) {

        $_SESSION['admin_id'] = $admin['id'];

        $_SESSION['admin_username'] =
            $admin['username'];

        header("Location: dashboard.php");

        exit();

    } else {

        $message = "Invalid admin login.";

    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Admin Login</title>

    <link
        rel="stylesheet"
        href="../css/admin.css"
    >

</head>

<body>

<div class="admin-login">

    <h1>
        Admin Login
    </h1>

    <p>
        <?php echo $message; ?>
    </p>


    <form method="POST">

        <input
            type="text"
            name="username"
            placeholder="Username"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <button
            type="submit"
            name="login"
        >
            Login
        </button>

    </form>

</div>

</body>

</html>