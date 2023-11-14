<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connection.php';

$bpNo = $_POST['bpNo'];

$lnd_query = "SELECT * FROM lnd_table WHERE empNo = ?";
$stmt = $conn->prepare($lnd_query);
$stmt->execute([$bpNo]);

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['type'] . "</td>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['lndFrom'] . "</td>";
    echo "<td>" . $row['lndTo'] . "</td>";

    // Output other data
    echo "</tr>";
}
?>