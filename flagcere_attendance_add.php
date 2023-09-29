<?php
include "connection.php";
if (isset($_POST['attempno'])) {
    $attempno = $_POST['attempno'];
    $attempname = $_POST['attempname'];
    $attdept = $_POST['attdept'];
    $jobstatus = $_POST['jobstatus'];

    $insert_stmt = mysqli_prepare($con, "INSERT INTO attendance_table_person (empNo, name, dept, job_status) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = ?, dept = ?, job_status = ?");

    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($insert_stmt, "sssssss", $attempno, $attempname, $attdept, $jobstatus, $attempname, $attdept, $jobstatus);

    // Execute the INSERT statement
    if (mysqli_stmt_execute($insert_stmt)) {
        echo "Data added successfully";
    } else {
        echo "Error executing statement: " . mysqli_stmt_error($insert_stmt);
    }
}
if (isset($_POST['delattempno'])) {
    $delattempno = $_POST['delattempno'];

    // Delete from attendance_date table
    $delete_stmt = mysqli_prepare($con, "DELETE FROM attendance_table_person WHERE empNo=?");
    mysqli_stmt_bind_param($delete_stmt, "s", $delattempno);
    if (mysqli_stmt_execute($delete_stmt)) {
        echo 'Employee deleted';
    }

    // Delete from attendance_date table
    $delete2_stmt = mysqli_prepare($con, "DELETE FROM attendance_monitoring WHERE empNo=?");
    mysqli_stmt_bind_param($delete2_stmt, "s", $delattempno);
    mysqli_stmt_execute($delete2_stmt);
}
// $con->close();
?>