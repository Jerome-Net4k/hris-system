<?php

class personalInfo{

    function get_all() {
        include 'connection.php';
        $sortval = $_POST['sortval'];
        $sortwhat = $_POST['sortwhat'];
        $query = "SELECT * FROM `ipcr_encoding_table` ORDER BY $sortval $sortwhat";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
    function get_PROCMonitoringTbl($name){
        include 'connection.php';
        $sortval = $_POST['sortval'];
        $sortwhat = $_POST['sortwhat'];
        // if($regionFil=='all'){
            $query = "SELECT * FROM `ipcr_encoding_table` WHERE CONCAT(empno, sname, fname, mname) LIKE '%$name' ORDER BY $sortval $sortwhat";
        // } else{
            // $query = "SELECT * FROM personalInfo_table WHERE region LIKE '$regionFil' AND `".$filSelect."` LIKE '$infoFil' AND `sname` != '' ORDER BY `$filSelect`";
        // }
            
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
    function get_all2() {
        include 'connection.php';
        $sortval = $_POST['sortval'];
        $sortwhat = $_POST['sortwhat'];
        $query = "SELECT * FROM `emp_table` ORDER BY $sortval $sortwhat";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
    // function get_PROCMonitoringTbl2($filSelect,$regionFil,$infoFil){
    function get_PROCMonitoringTbl2($name){
        include 'connection.php';
        $sortval = $_POST['sortval'];
        $sortwhat = $_POST['sortwhat'];
        // if($regionFil=='all'){
            $query = "SELECT * FROM `emp_table` WHERE CONCAT(bpNo, lname, fname, mname) LIKE '%$name' ORDER BY $sortval $sortwhat";
        // } else{
        //     // $query = "SELECT * FROM personalInfo_table WHERE region LIKE '$regionFil' AND `".$filSelect."` LIKE '$infoFil' AND `sname` != '' ORDER BY `$filSelect`";
        // }
            
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_existYear(){
        include 'connection.php';
        $query = "SELECT year FROM `performance_rating_year`";
        // $stmt = $con->prepare($query);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $row = $result->fetch_assoc();
        // return json_encode($row);

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmtPendingResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($stmtPendingResult);
    }

}


?>