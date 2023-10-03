<?php
include 'connection.php';
$id = $_POST['id'];
$day = $_POST['day'];
$hrs = $_POST['hrs'];
$min = $_POST['min'];
$auwp = $_POST['auwp'];
$leavetype = $_POST['leavetype'];
$leavedate = $_POST['leavedate'];
$auwop = $_POST['auwop'];

// Sanitize the input variables
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
$day = filter_var($day, FILTER_SANITIZE_STRING);
$hrs = filter_var($hrs, FILTER_SANITIZE_NUMBER_INT);
$min = filter_var($min, FILTER_SANITIZE_NUMBER_INT);
$auwp = filter_var($auwp, FILTER_SANITIZE_STRING);
$leavetype = filter_var($leavetype, FILTER_SANITIZE_STRING);
$leavedate = filter_var($leavedate, FILTER_SANITIZE_STRING);
$auwop = filter_var($auwop, FILTER_SANITIZE_STRING);

// Insert the values into your database
// Example using PDO
$db = new PDO("mysql:host=localhost;dbname=hr_management2", "root", "");
$stmt = $db->prepare("INSERT INTO rnr_table (empNo, day, hrs, min, auwp, leavetype, leavedate, auwop) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$empNo, $day, $hrs, $min, $auwp, $leavetype, $leavedate, $auwop]);

// Send a response back to the AJAX request
echo "Data saved successfully!";
?>
