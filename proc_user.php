<?php

if(isset($_GET['action'])){
    $action = $_GET['action'];

    if($action == 'load'){
        load();
    }
    if($action == 'save'){
       if(!empty($_POST['username']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['convRole'])){
        if(!checkDuplicateUser($_POST['username'])){
            $username = $_POST['username'];
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $lname = $_POST['lname'];
            $role = $_POST['convRole'];
            insertUser($username,$fname,$mname,$lname,$role);
        }
        else{
            echo 'duplicate';
        }   
       }
       else{
            echo 'check';
       }
    }
}

function checkDuplicateUser($username){
    include 'connection.php';
    $query = "SELECT * FROM `user_table` WHERE `user_name` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        return true;
    }
    else{
        return false;
    }
}


function insertUser($username,$fname,$mname,$lname,$role){
    include 'connection.php';
    $defaultPass = "pass123";
    $query = "INSERT INTO `user_table`(`user_name`,`fname`,`mname`,`lname`, `role`, `password`) VALUES (?,?,?,?,?,?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssssss',$username,$fname,$mname,$lname,$role,$defaultPass);
    $stmt->execute();
}

function load(){
    include 'connection.php';
    $query = "SELECT * FROM `user_table`";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        if($row['Status'] == '1'){
            $status =  '<td class="bg-success text-center"><strong>Active</strong></td>';
        }
        else{
            $status =  '<td class="bg-danger text-center"><strong>Inactive</strong></td>';
        }

        if($row['onlineStatus'] == '1'){
            $os = '<td class="bg-success text-center"><strong>Online</strong></td>';
        }
        else{
            $os = '<td class="bg-danger text-center"><strong>Offline</strong></td>';
        }
        echo '<tr>
        <td>'.$row['id'].'</td>
        <td>'.$row['user_name'].'</td>
        <td>'.$row['fname'].'</td>
        <td>'.$row['mname'].'</td>
        <td>'.$row['lname'].'</td>
        <td>'.$row['role'].'</td>';
        echo $status;
        echo $os;
        echo '</tr>';
    }
}

?>