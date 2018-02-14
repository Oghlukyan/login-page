<?php

include("connect.php");
session_start();

//echo phpinfo();
//openssl support disabled?
//mail("oghlukyan@gmail.com", "about account", "your account was deleted", "From: aoghlukyan@mail.ru");
//echo "sent";

if ($_SESSION['active']){
    header("Location: profile.php");
} else {
    if ($_SESSION['accountCreated']) {
        echo "<script>alert('account created successfully');</script>";
        session_unset();
        $_SESSION['active'] = false;
        $_SESSION['accountCreated'] = false;
    }
    if (isset($_POST)){
        if (isset($_POST["loginBtn"])){
            $result = mysqli_prepare($connection, "SELECT password, isAdmin FROM users WHERE username = ?");
            mysqli_stmt_bind_param($result, "s", $_POST['usernameLogin']);
            mysqli_stmt_execute($result);
            mysqli_stmt_bind_result($result, $pass, $isAdmin);
            mysqli_stmt_fetch($result);

            if (password_verify($_POST['passwordLogin'], $pass)){
                $_SESSION['username'] = $_POST['usernameLogin'];
                $_SESSION['active'] = true;
                $result->close();
                $_SESSION['isAdmin'] = $isAdmin;
                $location = $isAdmin ? "profileAdmin.php" : "profile.php";
                header("Location: $location");
                exit;
            } else {
                $result->close();
                echo "<h5 class='container-fluid text-danger'>Invalid username or password</h5>";
            }
        }
    }
}

?>

<html>
    <head>
    </head>
    <body>
        <div class="container-fluid">
            <h2>Log In</h2>
            <form method="POST" action="login.php" class="contaier-fluid">
                <p> <input placeholder="User Name" type="text" name="usernameLogin"> </p>
                <p> <input placeholder="Password" type="password" name="passwordLogin"> </p>
                <p> <input class="btn-success" value="Log In" type="submit" name="loginBtn"> </p>
                <p> <a class="btn-info" href="registration.php" type="submit" name="goToRegisterView">Don't have an account?</a> </p>
            </form>
        </div>
    </body>
</html>
