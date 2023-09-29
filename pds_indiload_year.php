<?php
if (isset($_GET['id'])) {
    $myidd = $_GET['id'];
    selectojtinfo($myidd);
}

function selectojtinfo($myidd)
{
    include "connection.php";
    $sql = "SELECT * FROM pds_monitoring_table WHERE pdsempNo = '$myidd' ORDER BY year DESC";

    // Execute the query
    $result = mysqli_query($con, $sql);

    // Check if the query was successful
    if ($result) {
        // Create an array to store the options
        $options = array();

        // Fetch and process the result set
        while ($row = mysqli_fetch_assoc($result)) {
            $options[] = array('year' => $row['year']);
        }

        // Return options as JSON
        echo json_encode($options);
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>