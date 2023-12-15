<?php
include 'connection.php';

$bpNo = $_POST['bpNo'];

$query = "DELETE FROM emp_table WHERE bpNo = :bpNo";
$stmt = $conn->prepare($query);
$stmt->execute([':bpNo' => $bpNo]);
?>