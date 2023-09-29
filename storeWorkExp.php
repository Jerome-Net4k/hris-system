<?php

session_start();

$_SESSION['promotion'] = $_POST['promotion'];
$_SESSION['workDOA'] = $_POST['doa'];
$_SESSION['convWorkSg'] = $_POST['convWorkSg'];
$_SESSION['convWorkFrom'] = $_POST['convWorkFrom'];
$_SESSION['convWorkItemNum'] = $_POST['convWorkItemNum'];
$_SESSION['convWorkTo'] = $_POST['convWorkTo'];
$_SESSION['convWorkPos'] = $_POST['convWorkPos'];
$_SESSION['convWorkDept'] = $_POST['convWorkDept'];
$_SESSION['convWorkSalary'] = $_POST['convWorkSalary'];
$_SESSION['convWorkSoa'] = $_POST['convWorkSoa'];
$_SESSION['convWorkGovt'] = $_POST['convWorkGovt'];

$convWorkItem = explode(',',$_POST['convWorkItemNum']);
$convWorkDept = explode(',',$_POST['convWorkDept']);

if(!checkIfPositionIsOccupied($convWorkItem[0])){
    if(!checkIfItemNumExist($convWorkItem[0])){
        echo 'nice';
    }
    else{
        if(checkIfPosExistInDiv($convWorkItem[0],$convWorkDept[0])){
            echo 'nice';
        }
        else{
            echo 'error';
        }
    }
}
else{
    echo 'occupied';
}



function checkIfPositionIsOccupied($convWorkItem){
    include 'connection.php';
    $query = "SELECT * FROM `psipop_table` WHERE `item_num` = ? AND `name` != '' AND `empNo` != ''";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$convWorkItem);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        return true;
    }
    else{
        return false;
    }
}

function checkIfPosExistInDiv($convWorkItem,$convWorkDept){
    include 'connection.php';
    $query = "SELECT * FROM `psipop_table` WHERE `item_num` = ? AND `division` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ss',$convWorkItem,$convWorkDept);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        return true;
    }
    else{
        return false;
    }
}

function checkIfItemNumExist($convWorkItem){
    include 'connection.php';
    $query = "SELECT * FROM `psipop_table` WHERE `item_num` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$convWorkItem);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        return true;
    }
    else{
        return false;
    }
}





?>