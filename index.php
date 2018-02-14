<?php

include ("connect.php");

//mail("oghlukyan@gmail.com", "about account", "your account was deleted", "From: oghlukyan@gmail.com");

session_start();
session_unset();
$_SESSION['active'] = false;
$_SESSION['accountCreated'] = false;
$_SESSION['isAdmin'] = false;

header ("Location: login.php");

?>

