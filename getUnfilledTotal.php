<?php

include 'connection.php';

$query = "SELECT COUNT(`id`) AS totalPos, SUM(`authorize`) AS totalAuth, SUM(`actual`) AS totalAct FROM `office_assistant_sec` WHERE `name` = ''";
$stmt = $con->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$pos = $row['totalPos'];
$totAuth = number_format($row['totalAuth']);
$totAct = number_format($row['totalAct']);
$gTotal = array("position"=>$pos, "auth"=>$totAuth, "act"=>$totAct);
echo json_encode($gTotal);

?>