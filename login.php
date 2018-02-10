<?php

include("connect.php");

if (isset($_POST)){
    if (isset($_POST['username'])){
        $_SESSION['username'] = $_POST['username'];
    }
    if (isset($_POST['password'])){
        $_SESSION['password'] = $_POST['password'];
    }
    if (isset($_POST["loginBtn"])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $result = $connection->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
        if ($result->num_rows == 0){
            $_SESSION['password'] = "";
            echo "Invalid username or password";
        } else {
            $_SESSION['username'] = "";
            $_SESSION['password'] = "";
            $_SESSION['active'] = true;
            header("Location: profile.php");
            exit;
        }
    }
}

?>

<html>
    <head>
    </head>
    <body>
        <h2>Log In</h2>
        <form method="post" action="index.php">
            <h1></h1>
            <p>
                <input placeholder="User Name" type="text" name="username">
            </p>
            <p>
                <input placeholder="Password" type="password" name="password">
            </p>
            <p>
                <input value="Log In" type="submit" name="loginBtn">
            </p>
            <p>
                <a href="registration.php" type="submit" name="goToRegisterView">Don't have an account?</a>
            </p>
        </form>
    </body>
</html>
