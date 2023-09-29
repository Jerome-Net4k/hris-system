<?php

include 'connection.php';

$query = "SELECT * FROM `psipop_table` WHERE `item_num` = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('s',$_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo json_encode($row);


?>