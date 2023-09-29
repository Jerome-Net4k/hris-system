<?php
session_start();

if(isset($_POST['newIpcr'])){
    uploadPersonalInfo();
} else if(isset($_POST['editIpcr'])){
    updatePersonalInfo();
} else if(isset($_POST['delIpcr'])){
    deletePersonalInfo();
}

function uploadPersonalInfo(){
    include "connection.php";

    $empNo = $_POST['ipcrEmpNo'];
    $sname = $_POST['sname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $ext = $_POST['ext'];

    $query = "INSERT INTO `ipcr_encoding_table`(`empno`, `sname`, `fname`, `mname`, `ext`) VALUES ('$empNo', UPPER('$sname'), UPPER('$fname'), UPPER('$mname'), UPPER('$ext'))";
    $stmt = $con->prepare($query);

    if($stmt->execute()){
        echo 'success';
    }

}

function updatePersonalInfo(){
    include 'connection.php';

    $empNo = $_POST['editIpcrNo'];
    $sname = $_POST['editsname'];
    $fname = $_POST['editfname'];
    $mname = $_POST['editmname'];
    $ext = $_POST['editext'];

    $query = "UPDATE `ipcr_encoding_table` SET `sname` = UPPER('$sname'), `fname` = UPPER('$fname'), `mname` = UPPER('$mname'), `ext` = UPPER('$ext') WHERE `empno` = '$empNo'";
    $stmt = $con->prepare($query);

    if($stmt->execute()){
        echo 'success';
    }

}

function deletePersonalInfo(){
    include 'connection.php';

    $empNo = $_POST['delIpcrNo'];

    $query = "DELETE FROM ipcr_encoding_table WHERE empno = $empNo";
    $stmt = $con->prepare($query);

    if($stmt->execute()){
        echo 'success';
    }
}

?>