<?php
class ojtrec{   

    function get_allojt(){
        include 'connection.php';
        $query = "SELECT * FROM `ojt_tbl`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    function get_ojtTbl($table,$id){
        include 'connection.php';
        $query = "SELECT * FROM `ojt_tbl` WHERE `".$table."` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
}
?>