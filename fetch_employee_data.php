<?php
// Include the database connection file
include 'connection.php';

try {
  // Check if the employee name is set in the request
  if (isset($_GET['employee_name'])) {
    // Get the employee name from the request
    $employeeName = $_GET['employee_name'];

    // SQL statement to fetch the data for the specified employee
    $sql = "SELECT * FROM emp_table WHERE CONCAT(fname, ' ', lname) = :employeeName";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':employeeName', $employeeName);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      // Fetch the data for the specified employee
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      // Access the desired columns from the row
      $fname = $row["fname"];
      $lname = $row["lname"];

      // Output the dynamic data (employee name) as the response
      echo $fname . " " . $lname;  
    } else {
      echo "No data found for " . $employeeName;
    }
  } else {
    echo "No employee name specified.";
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>