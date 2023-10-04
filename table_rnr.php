<?php
class Rnrrec{

/**
 * Retrieves all records from the `rnr_reference_files` table.
 *
 * @return mysqli_result|bool Returns the result of the query or false on failure.
 */
    function get_rnrrefrec(){
        include 'connection.php';
        $query = "SELECT * FROM `rnr_reference_files`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /**
     * Retrieves a service record from the database based on the given ID.
     *
     * @param string $id The ID of the service record to retrieve.
     * @throws Exception If there is an error while retrieving the service record.
     * @return mysqli_result|bool The result of the database query, or false if no record is found.
     */
    function get_servicerec($id){
        include 'connection.php';
        $query = "SELECT * FROM `servicerecord_table` WHERE `empNo` = ? LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /**
     * Retrieves the latest record from the 'rnr_table' for a given employee ID.
     *
     * @param string $id The employee ID.
     * @return mysqli_result|bool The result of the SQL query, or false on failure.
     */
    function get_rnrleaveTbl($id){
        include 'connection.php';
        $query = "SELECT * FROM `rnr_table` WHERE `empNo` = ? AND id = (SELECT MAX(id) FROM rnr_table)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    /**
     * Retrieves the record from the `rnr_table` table based on the provided employee ID.
     *
     * @param string $id The employee ID used to retrieve the record.
     * @return mysqli_result|bool The result of the query, or false on failure.
     */
    function get_rnrrecordTbl($id){
        include 'connection.php';
        $query = "SELECT * FROM `rnr_table` WHERE `empNo` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

/**
 * Updates the record in the `rnr_table` table with the given ID.
 *
 * @param int $id The ID of the record to be updated.
 * @param string $day The day of the record.
 * @param string $hrs The hours of the record.
 * @param string $min The minutes of the record.
 * @param string $leavetype The leave type of the record.
 * @param string $auwp The auwp of the record.
 * @param string $auwop The auwop of the record.
 * @param string $credits The credits of the record.
 * @param string $leavemonth The leave month of the record.
 * @param string $leavedate_from The start date of the leave.
 * @param string $leavedate_to The end date of the leave.
 * @param string $vl_bal The vacation leave balance.
 * @param string $sl_bal The sick leave balance.
 * @throws Exception If an error occurs during the update.
 * @return void
 */
function edit_rnrrecord($id, $day, $hrs, $min, $leavetype, $auwp, $auwop, $credits, $leavemonth, $leavedate_from, $leavedate_to, $vl_bal, $sl_bal){
    include 'connection.php';
    $query = "UPDATE `rnr_table` SET `day`=?, `hrs`=?, `min`=?, `leavetype`=?, `auwp`=?, `auwop`=?, `credits`=?, `leavemonth`=?, `leavedate_from`=?, `leavedate_to`=?, `vl_bal`=?, `sl_bal`=? WHERE `empNo`=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('sssssssssssss', $day, $hrs, $min, $leavetype, $auwp, $auwop, $credits, $leavemonth, $leavedate_from, $leavedate_to, $vl_bal, $sl_bal, $id);
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
