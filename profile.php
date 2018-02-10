<?php

if(isset($_POST['logoutBtn'])){
    $_SESSION['username'] = "";
    $_SESSION['email'] = "";
    $_SESSION['password'] = "";
    $_SESSION['active'] = false;
    header("Location: login.php");
    exit;
}

?>

<html>
    <head>
    </head>
    <body>
        <form method="post" action="profile.php">
            <p>
                <input placeholder="Log Out" type="submit" name="logoutBtn" value="Log Out">
            </p>
        </form>
    </body>
</html>
