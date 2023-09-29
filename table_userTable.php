<?php
class userTable{

    function get_user($uname,$pass){
        include 'connection.php';
        $query = "SELECT * FROM `user_table` WHERE `user_name` = ? AND `password` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ss',$uname,$pass);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>