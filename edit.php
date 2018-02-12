<?php

include("connect.php");
session_start();

if (!$_SESSION['active']){
    header("Location: login.php");
} else if (!$_SESSION['isAdmin']){
    header("Location: profile.php");
} else {
    if(isset($_POST['backEdit'])){
        $_SESSION['editableId'] = null;
        header("Location: profileAdmin.php");
        exit;
    }
    if(isset($_POST['saveEdit'])){
        $id = $_SESSION['editableId'];
        $username = $_POST['usernameEdit'];
        $email = $_POST['emailEdit'];
        $password = $_POST['passwordEdit'];

        // validation
        $errors = [];
        if (empty($_POST['usernameEdit']) || $_POST['usernameEdit'][0]=='@' || is_numeric(substr($_POST['usernameEdit'], 0, 1)) || strlen($_POST['usernameEdit']) < 3)
            $errors['usernameErr'] = "Username shouldn't start with `@`, first character must not be a number and username must have minimum 3 characters.<br>";
        if (!filter_var($_POST['emailEdit'], FILTER_VALIDATE_EMAIL))
            $errors['emailErr'] = "Enter valid email.<br>";
        if (strlen($_POST['passwordEdit']) < 4)
            $errors['passwordErr'] = "Password must have at least 4 characters.<br>";
        $result = $connection->prepare("SELECT * FROM users WHERE username = ?");
        $result->bind_param("s", $_POST['usernameEdit']);
        $result->execute();
        if ($result->fetch() != 0)
            $errors['existErr'] = "Account with that username already exists.<br>";
        $result->close();
        $result = $connection->prepare("SELECT * FROM users WHERE password = ?");
        $result->bind_param("s", $_POST['passwordEdit']);
        $result->execute();
        if ($result->fetch() != 0)
            $errors['existError'] = "Account with that email already exists.<br>";
        $result->close();

        //Edit if all is OK
        if(empty($errors)){
            $password = password_hash($password, PASSWORD_DEFAULT);
            $isAdmin = $_POST['isAdminEdit'];
            mysqli_query($connection, "UPDATE users SET username='$username', email='$email', password='$password', isAdmin='$isAdmin' WHERE id='$id'");
            $_SESSION['editableId'] = null;
            header("Location: profileAdmin.php");
            exit;
        } else {
            foreach ($errors as $error)
                echo $error;
            $errors = [];
        }
    }
}

?>

<html>
    <head>
    </head>
    <body>
        <form method="post" action="edit.php">
            <p> <input placeholder="Username" type="text" name="usernameEdit"> </p>
            <p> <input placeholder="Email" type="text" name="emailEdit"> </p>
            <p> <input placeholder="Password" type="password" name="passwordEdit"> </p>
            <p> <input placeholder="Picture URL" type="text" name="pictureEdit"> </p>
            <p> <input placeholder="1 if admin, 0 if no" type="text" name="isAdminEdit"> </p>
            <p> <input value="Save" type="submit" name="saveEdit">
                <input value="Back" type="submit" name="backEdit"> </p>
        </form>
    </body>
</html>
