<?php
    include("connection.php");


    $personnel_id = $_POST['moveid'];
    $personnel_name = $_POST['movename'];
    $personnel_position = $_POST['moveposition'];
    $personnel_under = $_POST['moveunder'];

    $sql = "UPDATE orgchart SET name=?, position=?, under=? WHERE id=?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sssi', $personnel_name, $personnel_position, $personnel_under, $personnel_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "move personnel successfully";
    } else {
        echo "Error updating data: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($con);

?>