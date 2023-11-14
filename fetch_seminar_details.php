<?php
include 'connection.php';

$bpNo = $_POST['bpNo'];

$bpNo_query = "SELECT * FROM emp_table WHERE bpNo = ?";
$stmt = $conn->prepare($bpNo_query);
$stmt->execute([$bpNo]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    echo json_encode($row);
} else {
    echo json_encode([]);
}
?>