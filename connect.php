<?php

session_start();

$localhost = "localhost";
$username = "root";
$password = "";
$dbName = "user";

$connection = new mysqli($localhost, $username, $password, $dbName);

//TODO add object of User
?>