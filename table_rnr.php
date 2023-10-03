<?php
class Rnrrec{

    function get_rnrrefrec(){
        include 'connection.php';
        $query = "SELECT * FROM `rnr_reference_files`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_servicerec($id){
        include 'connection.php';
        $query = "SELECT * FROM `servicerecord_table` WHERE `empNo` = ? LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_rnrleaveTbl($id){
        include 'connection.php';
        $query = "SELECT * FROM `rnr_table` WHERE `empNo` = ? AND id = (SELECT MAX(id) FROM rnr_table)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    function get_rnrrecordTbl($id){
        include 'connection.php';
        $query = "SELECT * FROM `rnr_table` WHERE `empNo` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

//updating data to leavecredits
    function edit_rnrrecord($id, $day, $hrs, $min, $leavetype, $auwp, $auwop, $credits, $leavemonth, $leavedate_from, $leavedate_to, $vl_bal, $sl_bal){
        include'connection.php';
        $query ="UPDATE  FROM `rnr_table` WHERE (`empNo`, `day`, `hrs`, `min`, `leavetype`, `auwp`, `auwop`, `credits`, `leavemonth`, `leavedate_from`, `leavedate_to`, `vl_bal`, `sl_bal`) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt =$con->prepare($query);
        $stmt->execute();

    }

//uploading data to leavecredits
    function upload_rnrrec($id, $day, $hrs, $min, $leavetype, $auwp, $auwop, $credits, $leavemonth, $leavedate_from, $leavedate_to, $vl_bal, $sl_bal) {
        include 'connection.php';
        
        $query = "INSERT INTO `rnr_table`(`empNo`, `day`, `hrs`, `min`, `leavetype`, `auwp`, `auwop`, `credits`, `leavemonth`, `leavedate_from`, `leavedate_to`, `vl_bal`, `sl_bal`) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('sssssssssssss', $id, $day, $hrs, $min, $leavetype, $auwp, $auwop, $credits, $leavemonth, $leavedate_from, $leavedate_to, $vl_bal, $sl_bal);
        $stmt->execute();

        }
    }



?>
