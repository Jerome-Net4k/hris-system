<?php
include 'connection.php';

$query = "SELECT COUNT(id) as filledPos FROM `office_assistant_sec` WHERE `name` != '' AND `year` = '2023'";
$stmt = $con->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    echo $row['filledPos'];
}
else{
    echo 0;
}

?>