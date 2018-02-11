<?php

include("connect.php");
session_start();

if ($_SESSION['active']){
    header("Location: profile.php");
} else {
    if (isset($_POST)){
        if (isset($_POST["loginBtn"])){
            $result = mysqli_prepare($connection, "SELECT password FROM users WHERE username = ?");
            mysqli_stmt_bind_param($result, "s", $_POST['usernameLogin']);
            mysqli_stmt_execute($result);
            mysqli_stmt_bind_result($result, $pass);
            mysqli_stmt_fetch($result);

            if (password_verify($_POST['passwordLogin'], $pass)){
                $_SESSION['username'] = $_POST['usernameLogin'];
                $_SESSION['active'] = true;
                $result->close();
                header("Location: profile.php");
                exit;
            } else {
                $result->close();
                echo "Invalid username or password";
            }
        }
    }
}

?>

<html>
    <head>
    </head>
    <body>
        <h2>Log In</h2>
        <form method="POST" action="login.php">
            <h1></h1>
            <p>
                <input placeholder="User Name" type="text" name="usernameLogin">
            </p>
            <p>
                <input placeholder="Password" type="password" name="passwordLogin">
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
