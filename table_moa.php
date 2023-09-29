<?php
class moadata{   

    function get_allmoa(){
        include 'connection.php';
        $query = "SELECT * FROM `moa_tbl`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

}
?>