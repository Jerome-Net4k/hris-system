<?php

include 'connection.php';
session_start();
$checked = $_POST['checked'];
$user = $_SESSION['user'];
$query = "UPDATE `user_table` SET `edit`= ? WHERE `id` = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('si',$checked,$user);
$stmt->execute();
?>