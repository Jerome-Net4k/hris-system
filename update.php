<?php

include 'connection.php';

$query = "SELECT * FROM `psipop_table`";
$stmt = $con->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()){
    $id = $row['id'];
    $sg = $row['salary_grade'];
    $select = "SELECT `sgstep1` FROM `salarygrade` WHERE `level` = ?";
    $sadaq = $con->prepare($select);
    $sadaq->bind_param('s',$sg);
    $sadaq->execute();
    $sadaqRes = $sadaq->get_result();
    $sadaqrow = $sadaqRes->fetch_assoc();
    $auth = $sadaqrow['sgstep1'] * 12;
    $sdq = "UPDATE `psipop_table` SET `authorize`= ? WHERE `id` = ?";
    $sad = $con->prepare($sdq);
    $sad->bind_param('ss',$auth,$id);
    $sad->execute();
}

?>