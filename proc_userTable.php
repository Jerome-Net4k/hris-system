<?php
include 'table_userTable.php';
if(isset($_POST['id'])){
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $id = $_POST['id'];
    switch($id){
        case 'userLogin': loginProcess($uname,$pass);
        break;
    }
}


function loginProcess($uname,$pass){
    include 'connection.php';
    session_start();
        if(!empty($uname) && !empty($pass)){
        $userTable = new userTable('user_table');
        $result = $userTable->get_user($uname,$pass);
        $query = "UPDATE `user_table` SET `onlineStatus`='1' WHERE `user_name` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$uname);
        $stmt->execute();
            if($result->num_rows > 0){
                echo 'Account Found';
                $row = $result->fetch_assoc();
                $user = $row['role'];
                $uname = $row['user_name'];
                $_SESSION['uname'] = $uname;
                $_SESSION['user'] = $user;
            }
            else{
                echo 'No Account Found';
            }
        }
    
}


?>