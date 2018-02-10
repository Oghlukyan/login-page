<?php

include("connect.php");

if (isset($_POST)){
    if (isset($_POST['usernameRegister'])){
        $_SESSION['usernameRegister'] = $_POST['usernameRegister'];
    }
    if (isset($_POST['emailRegister'])) {
        $_SESSION['emailRegister'] = $_POST['emailRegister'];
    }
    if (isset($_POST['passwordRegister'])){
        $_SESSION['passwordRegister'] = $_POST['passwordRegister'];
    }
    if (isset($_POST['confirmPasswordRegister'])){
        $_SESSION['confirmPasswordRegister'] = $_POST['confirmPasswordRegister'];
    }
    if (isset($_POST['registerBtn'])){
        $errors = [];

        $username = $_SESSION['usernameRegister'];
        if (empty($username) || $username[0]=='@' || is_numeric(substr($username, 0, 1)) || strlen($username) < 3) {
            $errors['usernameErr'] = "Username shouldn't with @, first character must not be a number and username must have minimum 3 characters. ";
        }
        $email = $_SESSION['emailRegister'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['emailErr'] = "Enter valid email. ";
        }
        if (strlen($_SESSION['passwordRegister']) < 4){
            $errors['passwordErr'] = "Password must have at least 4 characters. ";
        }
        if ($_SESSION['passwordRegister'] != $_SESSION['confirmPasswordRegister']) {
            $errors['passwordError'] = "Passwords don't match. ";
        }
        $result = $connection->query("SELECT * FROM users WHERE username='$username'");
        if ($result->num_rows != 0){
            $errors['existErr'] = "Account with that username already exists. ";
        }
        $result = $connection->query("SELECT * FROM users WHERE email='$email'");
        if ($result->num_rows != 0){
            $errors['existError'] = "Account with that email already exists. ";
        }

        if(empty($errors)){
            $password = $_SESSION['passwordRegister'];
            $connection->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
            echo "Account created successfully";
            header("Location: profile.php");
            exit;
        } else {
            foreach ($errors as $error)
                echo $error;
            $_POST['passwordRegister'] = "";
            $_POST['confirmPasswordRegister'] = "";
            $_SESSION['passwordRegister'] = "";
            $_SESSION['confirmPasswordRegister'] = "";
            $errors = [];
        }
    }
}

?>

<html>
    <head>
    </head>
    <body>
        <h2>Registration</h2>
        <form method="post" action="registration.php">
            <p> <input placeholder="User Name" type="text" name="usernameRegister"> </p>
            <p> <input placeholder="Email" type="text" name="emailRegister"> </p>
            <p> <input placeholder="Password" type="password" name="passwordRegister"> </p>
            <p> <input placeholder="Confirm Password" type="password" name="confirmPasswordRegister"> </p>
            <p> <input value="Register" type="submit" name="registerBtn"> </p>
            <p> <a href="index.php" type="submit" name="goToLoginView">Already have an account?</a> </p>
        </form>
    </body>
</html>
