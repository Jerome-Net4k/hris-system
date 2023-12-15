<?php
include 'connection.php';

$query = "SELECT * FROM emp_table";
$stmt = $conn->prepare($query);
$stmt->execute();

$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($employees);
?>