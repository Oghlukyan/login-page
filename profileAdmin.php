<?php

include("connect.php");
session_start();

if (!$_SESSION['active']){
    header("Location: login.php");
} else if (!$_SESSION['isAdmin']){
    header("Location: profile.php");
} else {
    $username = $_SESSION['username'];

    $result = (mysqli_query($connection, "SELECT * FROM users"));

    echo "<div class='table-responsive'><table class='table table-bordered table-hover'>";
    if (mysqli_num_rows($result) > 0){
        echo "<thead><tr><th>id</th><th>username</th><th>email</th><th>password</th><th>profile picture URL</th><th>is admin?</th></tr></thead>";
        while($row = mysqli_fetch_assoc($result)){
            $i = $row['id'];
            $edit = "<a class='btn-warning' href='profileAdmin.php?edit=true&id=" . $i . "'>Edit</a>";
            $delete = "<a class='btn-danger' href='profileAdmin.php?delete=true&id=" . $i . "'>Delete</a>";
            echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td>" . $row['email'] . "</td><td>" . $row['password'] . "</td><td>" . $row['picture'] . "</td><td>" . $row['isAdmin'] . "</td><td>" . $edit . "</td><td>" . $delete . "</td></tr>";
        }
    }
    echo "</table></div>";

    if(isset($_GET['edit'])){
        $_SESSION['editableId'] = $_GET['id'];
        header("Location: edit.php");
        exit;
    }
    if(isset($_GET['delete'])){
        $id = $_GET['id'];
        $result = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE username='$username'"));
        if ($result['id'] != $id){
            mysqli_query($connection, "DELETE FROM users WHERE id='$id'");
//            $result = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id='$id'"));
//            mail($result['email'], "about account", "your account was deleted", "From: oghlukyan@gmail.com");
        }
        header("Location: profileAdmin.php");
    }
    if(isset($_POST['logoutBtn'])){
        session_unset();
        $_SESSION['active'] = false;
        $_SESSION['accountCreated'] = false;
        $_SESSION['isAdmin'] = false;
        header("Location: login.php");
        exit;
    }
}

?>

<html>
    <head>
    </head>
    <body>
        <div class="container-fluid">
            <h1>Admin <?php echo $username;?></h1>
            <form method="post" action="profileAdmin.php">
                <p> <input class="btn-info" value="Log Out" type="submit" name="logoutBtn"> </p>
            </form>
        </div>
    </body>
</html>
