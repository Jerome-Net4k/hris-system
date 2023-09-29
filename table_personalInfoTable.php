<?php

class personalInfo{

    function get_all(){
        include 'connection.php';
        $query = "SELECT * FROM `personalInfo_table` ";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    function get_sglTbl($table,$id){
        include 'connection.php';
        $query = "SELECT * FROM `personalinfo_table` INNER JOIN `emp_table` ON personalinfo_table.gsis = emp_table.bpNo WHERE personalinfo_table.".$table." = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_wldcrdTbl($table,$value){
        include 'connection.php';
        $query = "SELECT * FROM `emp_table` WHERE `".$table."` LIKE ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$value);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
    function get_wldcrdTbl2($table,$name){
        include 'connection.php';
        $query = "SELECT * FROM `emp_table` WHERE CONCAT(bpNo, lname, fname, mname) LIKE '%$name'";
        $stmt = $con->prepare($query);
        // $stmt->bind_param('s',$name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_allIpcr(){
        include 'connection.php';
        // $query = "SELECT * FROM `personalInfo_table`";
        $query = "SELECT * FROM `ipcr_encoding_table` ORDER BY `sname`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_inactiveTblank(){
        include 'connection.php';
        $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `surname` = '' ORDER BY `idno`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_inactiveTbl(){
        include 'connection.php';
        // $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `surname` != '' ORDER BY `idno` DESC";
        $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `surname` != '' AND `idno` >= 3000  AND `idno` <= 5000 ORDER BY `idno`"; // DESC limit 50
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_pendingTbl(){
        include 'connection.php';
        $query = "SELECT * FROM `pending_inactive_table` WHERE status = 'pending'";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_existNo(){
        include 'connection.php';
        $query = "SELECT idNo FROM `personalInfo_inactive_table`";
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

    function get_existIpcrNo(){
        include 'connection.php';
        $query = "SELECT empno FROM `ipcr_encoding_table`";
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

    function get_wldcrdInactiveTbl($filSelect,$regionFil,$infoFil){
        include 'connection.php';
        if($regionFil=='all'){
            $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `".$filSelect."` LIKE '$infoFil'";
        } else{
            $query = "SELECT * FROM personalinfo_inactive_table WHERE region LIKE '$regionFil' AND `".$filSelect."` LIKE '$infoFil'";
        }
            
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_wldcrdInactiveTblTest($filSelect,$regionFil,$infoFil){
        include 'connection.php';
        if($regionFil=='all'){
            $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `".$filSelect."` LIKE '$infoFil' AND `surname` != '' ORDER BY `$filSelect`";
        } else{
            $query = "SELECT * FROM personalinfo_inactive_table WHERE region LIKE '$regionFil' AND `".$filSelect."` LIKE '$infoFil' AND `surname` != '' ORDER BY `$filSelect`";
        }
            
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_regionInactiveTbl($value){
        include 'connection.php';
        $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `region` LIKE '$value'";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_monitoringTbl($year){
        include 'connection.php';
        $query = "SELECT mst.emp_id, pit.sname, pit.fname, pit.mname, pit.ext, mst.pds, mst.saln, mst.pmcr, mst.idp, mst.opcr, mst.dpcr, mst.ipcr FROM monitoring_submission_table AS mst INNER JOIN personalinfo_table AS pit ON pit.emp_id = mst.emp_id WHERE mst.year = $year";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_wldcrdMonitoringTbl($filSelect,$regionFil,$infoFil){
        include 'connection.php';
        if($regionFil=='all'){
            // $query = "SELECT * FROM `personalInfo_table` WHERE `".$filSelect."` LIKE '$infoFil' AND `sname` != '' ORDER BY `$filSelect`";
            $query = "SELECT * FROM `ipcr_encoding_table` WHERE `".$filSelect."` LIKE '$infoFil' AND `sname` != '' ORDER BY `$filSelect`";
        } else{
            // $query = "SELECT * FROM personalInfo_table WHERE region LIKE '$regionFil' AND `".$filSelect."` LIKE '$infoFil' AND `sname` != '' ORDER BY `$filSelect`";
        }
            
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_existYear(){
        include 'connection.php';
        $query = "SELECT year FROM `performance_rating_year`";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmtPendingResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($stmtPendingResult);
    }
}


?>