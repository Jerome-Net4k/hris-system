<?php

class expenses{

    function getAll(){
        include 'connection.php';
        $query = "SELECT * FROM `seminars_expenses_table`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function insert($title,$dateFrom,$dateTo,$exp,$am){
        include 'connection.php';
        $query = "INSERT INTO `seminars_expenses_table`(`title`, `dateFrom`, `dateTo`, `type`, `amount`) VALUES (?,?,?,?,?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('sssss',$title,$dateFrom,$dateTo,$exp,$am);
        $stmt->execute();
    }
}

?>