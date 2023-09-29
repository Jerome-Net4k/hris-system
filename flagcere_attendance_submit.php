<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the attendance array is set and not empty
    if (isset($_POST['attendance']) && !empty($_POST['attendance'])) {
        $attendances = $_POST['attendance'];
        $monthselected = $_POST['monthselected'];
        $dayattendance = $_POST['dayattendance'];
        $yearselected = $_POST['yearselected'];
        $att = $_POST['attend'];

        // Prepare the SQL statement with ON DUPLICATE KEY UPDATE
        $insert_stmt = mysqli_prepare($con, "INSERT INTO attendance_monitoring (empNo, name, month, day, year, attend) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE attend = ?");

        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($insert_stmt, "sssssss", $empNo, $name, $monthselected, $dayattendance, $yearselected, $att, $att);

        // Loop through each selected attendance
        foreach ($attendances as $attendance) {
            // Get the employee details from the database based on the empNo
            $select_stmt = mysqli_prepare($con, "SELECT name as fullname FROM attendance_table_person WHERE empNo = ?");
            mysqli_stmt_bind_param($select_stmt, "s", $attendance);
            mysqli_stmt_execute($select_stmt);
            mysqli_stmt_bind_result($select_stmt, $fullname);
            mysqli_stmt_fetch($select_stmt);
            mysqli_stmt_close($select_stmt);

            // Insert or update the attendance in the attendance_table_person
            $empNo = $attendance;
            $name = $fullname;
            mysqli_stmt_execute($insert_stmt);
        }

        // Close the prepared statement
        mysqli_stmt_close($insert_stmt);

        echo "Attendance submitted successfully";
    } else {
        echo "No attendance selected.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($con);
?>
