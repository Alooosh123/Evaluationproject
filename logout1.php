<?php

session_start();
$conn = mysqli_connect('localhost','root','','eva');
if(!$conn)
{
    die('error'.mysqli_connect_error());
}
$_SESSION = [];
session_unset();
session_destroy();
header('location:loginUser.php');
?>
