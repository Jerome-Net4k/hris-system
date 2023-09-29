<?php

session_start();
session_destroy();
include 'connection.php';
$query = "UPDATE `user_table` SET `onlineStatus`='0' WHERE `user_name` = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('s',$_SESSION['uname']);
$stmt->execute();
header("Location:index.php");


?>