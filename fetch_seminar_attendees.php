<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connection.php';

$empNo = $_POST['empNo'];

// Fetch seminar attendees from the database
$query = "SELECT bpNo, fname, lname FROM emp_table WHERE empNo = :empNo";
$stmt = $conn->prepare($query);
$stmt->execute([':empNo' => $empNo]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate the table rows
foreach ($result as $row) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['fname']) . '</td>';
    echo '<td>' . htmlspecialchars($row['lname']) . '</td>';
    echo '</tr>';
}
?>