<?php

include ("connect.php");

session_start();
session_unset();
$_SESSION['active'] = false;

header ("Location: login.php");

?>