<?php
include "connection.php";

if (isset($_POST['myidsurname'])) {
    $myidsurname = $_POST['myidsurname'];
    $myidonly = $_POST['myidonly'];
    $year = $_POST['year'];

    $delete_stmt = mysqli_prepare($con, "DELETE FROM pds_monitoring_table WHERE pdsempNo=? AND year=?");
    mysqli_stmt_bind_param($delete_stmt, "ss", $myidonly, $year);
    
    if (mysqli_stmt_execute($delete_stmt)) {
        $folderpath = 'pmupload/' . $year . '/PDS/' . $myidsurname . '.pdf';
        if (file_exists($folderpath)) {
            if (unlink($folderpath)) {
                echo 'Deleted successfully';
            }
        }
    }
}
?>
