<?php

class OJTinfo{

    function get_all(){
        include 'connection.php';
        $query = "SELECT * FROM `ojtinfo_table`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    function get_sglTbl($table,$id){
        include 'connection.php';
        $query = "SELECT * FROM `ojtinfo_table` WHERE `".$table."` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_wldcrdTbl($table,$value){
        include 'connection.php';
        $query = "SELECT * FROM `ojtinfo_table` WHERE `".$table."` LIKE ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$value);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}


?>