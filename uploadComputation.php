<?php

include 'connection.php';


$rowCount = $_POST['rowCount'];
$empId = $_POST['empId'];
$yearSelected = $_POST['yearSelected'];
$half = $_POST['half'];

for ($i = 1; $i < $rowCount; $i++) {
    $outputNo = $i;
    $outputq = $_POST['outputq' . $i];
    $outpute = $_POST['outpute' . $i];
    $outputt = $_POST['outputt' . $i];
    $outputa = $_POST['outputaVal' . $i];

    // $outputq = $_POST['outputq1'];
    // $outpute = $_POST['outpute1'];
    // $outputt = $_POST['outputt1'];
    // $outputa = $_POST['outputaVal1'];

    $stmtPending = $con->prepare("INSERT INTO `ipcr_output_table`(`emp_id`, `year`, `half`, `output`, `q`, `e`, `t`, `a`) VALUES ($empId, $yearSelected, $half, $outputNo, $outputq, $outpute, $outputt, $outputa) ON DUPLICATE KEY UPDATE `q` = $outputq, `e` = $outpute, `t` = $outputt, `a` = $outputa");

    if($stmtPending->execute()){
        echo "orayt ";
    }
} 

?>