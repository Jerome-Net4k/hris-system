<?php

include 'connection.php';


$ServFrom = $_POST['convServFrom'];
$ServTo = $_POST['convServTo'];
$ServDesig = $_POST['convServDesig'];
$ServStatus = $_POST['convServStatus'];
$ServSalary = $_POST['convServSalary'];
$ServStation = $_POST['convServStation'];
$ServBranch = $_POST['convServBranch'];
$ServLv = $_POST['convServLv'];
$ServCause = $_POST['convServCause'];
$id = $_POST['id'];
$name = getName($id);

$convServFrom = explode(',',$ServFrom);
$convServTo = explode(',',$ServTo);
$convServDesig = explode(',',$ServDesig);
$convServStatus = explode(',',$ServStatus);
$convServSalary = explode(',',$ServSalary);
$convServStation = explode(',',$ServStation);
$convServBranch = explode(',',$ServBranch);
$convServLv = explode(',',$ServLv);
$convServCause = explode(',',$ServCause);

for($a = 0; $a < count($convServFrom); $a++){
    if(!empty($convServFrom)){
    $query = "INSERT INTO `servicerecord_table`(`empNo`, `name`, `serveRecFrom`, `serveRecTo`, `designation`, `status`, `salary`, `station`, `branch`, `abs/lv`, `cause`) VALUES 
    (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('sssssssssss',$id,$name,$convServFrom[$a],$convServTo[$a],$convServDesig[$a],
    $convServStatus[$a],$convServSalary[$a],$convServStation[$a],$convServBranch[$a],$convServLv[$a],$convServCause[$a]);
    $stmt->execute();
}
}


function getName($id){
    include 'connection.php';
    $query = "SELECT * FROM `personalInfo_table` WHERE `empNo` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $name = "";
    if(!empty($row['mname'])){
        $name = $row['sname'].", ".$row['fname']." ".$row['mname'].".";
    }
    else{
        $name = $row['sname'].", ".$row['fname'];
    }
    return $name;
}




?>