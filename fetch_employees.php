<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connection.php';

$bpNo = $_POST['empNo'];

$lnd_query = "SELECT * FROM emp_table WHERE bpNo = :bpNo";
$stmt = $conn->prepare($lnd_query);
$stmt->execute([':bpNo' => $bpNo]);

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['bpNo'] . "</td>";
    echo "<td>" . $row['fname'] . "</td>";
    echo "<td>" . $row['lname'] . "</td>";
    // Output other data
    echo "</tr>";
}
?>