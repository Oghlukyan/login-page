<?php

include ("connect.php");
session_start();

if (!$_SESSION['active']){
    header("Location: login.php");
} else {
    $username = $_SESSION['username'];

    if(isset($_POST['logoutBtn'])){
        session_unset();
        $_SESSION['active'] = false;
        header("Location: login.php");
        exit;
    }
}

?>

<html>
    <head>
    </head>
    <body>
        <p>Hi <?php echo $username ?></p>
        <form method="post" action="profile.php">
            <p>
                <input placeholder="Log Out" type="submit" name="logoutBtn" value="Log Out">
            </p>
        </form>
    </body>
</html>
