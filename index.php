<?php

include ("connect.php");

session_start();
session_unset();
$_SESSION['active'] = false;
$_SESSION['accountCreated'] = false;
$_SESSION['isAdmin'] = false;

header ("Location: login.php");

?>