<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connection.php';

$seminarId = $_POST['seminarId'];

$lnd_query = "SELECT emp_table.* FROM emp_table INNER JOIN lnd_table ON emp_table.bpNo = lnd_table.empNo WHERE lnd_table.seminarId = ?";
$stmt = $conn->prepare($lnd_query);
$stmt->execute([$seminarId]);

$employees = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $employees[] = $row;
}

echo json_encode($employees);
?>