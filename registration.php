<?php

include("connect.php");
session_start();

if ($_SESSION['active']){
    header("Location: profile.php");
} else {
    if (isset($_POST)){
        if (isset($_POST['registerBtn'])){
            // validation
            $errors = [];
            if (empty($_POST['usernameRegister']) || $_POST['usernameRegister'][0]=='@' || is_numeric(substr($_POST['usernameRegister'], 0, 1)) || strlen($_POST['usernameRegister']) < 3)
                $errors['usernameErr'] = "Username shouldn't start with `@`, first character must not be a number and username must have minimum 3 characters.<br>";
            if (!filter_var($_POST['emailRegister'], FILTER_VALIDATE_EMAIL))
                $errors['emailErr'] = "Enter valid email.<br>";
            if (strlen($_POST['passwordRegister']) < 4)
                $errors['passwordErr'] = "Password must have at least 4 characters.<br>";
            if ($_POST['passwordRegister'] != $_POST['confirmPasswordRegister'])
                $errors['passwordError'] = "Passwords don't match.<br>";
            $result = $connection->prepare("SELECT * FROM users WHERE username = ?");
            $result->bind_param("s", $_POST['usernameRegister']);
            $result->execute();
            if ($result->fetch() != 0)
                $errors['existErr'] = "Account with that username already exists.<br>";
            $result->close();
            $result = $connection->prepare("SELECT * FROM users WHERE password = ?");
            $result->bind_param("s", $_POST['passwordRegister']);
            $result->execute();
            if ($result->fetch() != 0)
                $errors['existError'] = "Account with that email already exists.<br>";
            $result->close();

            //register if all is OK
            if(empty($errors)){
                $stmt = $connection->prepare("INSERT INTO users(username, email, password, picture) VALUES (?, ?, ?, 'https://goo.gl/Wdsvs7')");
                $stmt->bind_param("sss", $_POST['usernameRegister'], $_POST['emailRegister'], password_hash($_POST['passwordRegister'], PASSWORD_DEFAULT));
                $stmt->execute();
                $stmt->close();
                $_SESSION['username'] = $_POST['usernameRegister'];
                $_SESSION['active'] = true;
                header("Location: profile.php");
                exit;
            } else {
                foreach ($errors as $error)
                    echo $error;
                $errors = [];
            }
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
