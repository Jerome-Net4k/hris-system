<?php

class lnd{

    function getAll(){
        include 'connection.php';
        $query = "SELECT * FROM `seminars_table`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function getData($title,$dateFrom,$dateTo){
        include 'connection.php';
        /*$query = "SELECT seminars_table.title AS Title, seminars_table.dateFrom, seminars_table.dateTo, seminars_table.smt, seminars_table.noHours, seminars_table.typeLnd, seminars_table.venue, seminars_table.expenses, seminars_table.amount, seminars_table.total, seminars_table.officeOrder, seminars_table.obj, seminars_table.ref, seminars_table.rem, lnd_table.empNo, lnd_table.title, lnd_table.lndFrom, lnd_table.lndTo, lnd_table.noh, lnd_table.type, lnd_table.sponsor  FROM 
        `seminars_table` INNER JOIN `lnd_table` ON seminars_table.title = lnd_table.title WHERE seminars_table.title = ? AND seminars_table.dateFrom = ? AND seminars_table.dateTo = ?";*/
        $query = "SELECT * FROM `seminars_table` WHERE `title` = ? AND `dateFrom` = ? AND `dateTo` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('sss',$title,$dateFrom,$dateTo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    function insert($title,$dateFrom,$dateTo,$smt,$nh,$type,$venue,$exp,$am,$total,$oo_file_name,$obj,$ref_name,$rem){
        include 'connection.php';
        $query = "INSERT INTO `seminars_table`(`title`, `dateFrom`, `dateTo`, `smt`, `noHours`, `typeLnd`, `venue`, `expenses`, `amount`, `total`, `officeOrder`, `obj`, `ref`, `rem`) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ssssssssssssss',$title,$dateFrom,$dateTo,$smt,$nh,$type,$venue,$exp,$am,$total,$oo_file_name,$obj,$ref_name,$rem);
        $stmt->execute();
    }

    function getSpecificData($id){
        include 'connection.php';
        $query = "SELECT * FROM `seminars_table` WHERE `title` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}

?>