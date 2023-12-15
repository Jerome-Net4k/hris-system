<?php
include 'connection.php';

$id = $_GET['id'];

$query = "SELECT emp_table.bpNo FROM emp_table 
          JOIN seminar_table ON emp_table.bpNo = seminar_table.id 
          WHERE seminar_table.id = :id";
$stmt = $conn->prepare($query);
$stmt->execute([':id' => $id]);

$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($participants as $participant) {
    echo '<p>' . $participant['fname'] . $participant['lname'] . '</p>';
}
?>