<?php
    if (isset($_GET['id'])) {
    $myidd = $_GET['id'];
    selectojtinfo($myidd);
}

function selectojtinfo($myidd)
{
    include "connection.php";

    // Prepare the SQL statement with a placeholder for the id
    $sql = "SELECT empno, CONCAT(sname,', ', fname,' ', mname) as fullname FROM ipcr_encoding_table WHERE empno = ?";
    
    $stmt = mysqli_prepare($con, $sql);

    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "i", $myidd);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Create array to store data
    $data = array();

    // Loop through the result set and add each row to the data array
    while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
    }

    if (count($data) > 0) {
    // Return data as JSON object
    echo json_encode($data);
    } else {
    // No results found
    echo json_encode("No data found");
    }
}
?>