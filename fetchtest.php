<?php
require_once 'connection.php'; // Include your database connection script

// Fetch all participants from the database
$stmt = $conn->prepare("SELECT * FROM emp_table");
$stmt->execute();

$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Make sure to call json_encode on the data you want to return
echo json_encode($participants);
?>