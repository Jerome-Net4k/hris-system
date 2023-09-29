<?php
// Replace the values in the array with your own database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hr_management';

// Create a connection to the database
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get the data values from the AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $subdate = $_POST['subdate'];

  // Check if name and subdate are empty
  if (empty($name) || empty($subdate)) {
    echo "Error: Name and subdate cannot be empty";
    exit;
  }

  // Update the data in your database
  $sql = "UPDATE moa_tbl SET name='$name', subdate='$subdate' WHERE id='$id'";
  if (mysqli_query($conn, $sql)) {
    echo "Data updated successfully";
  } else {
    echo "Error updating data: " . mysqli_error($conn);
  }
}

// Close the database connection
mysqli_close($conn);
?>
