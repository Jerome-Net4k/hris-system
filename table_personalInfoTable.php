<?php

class personalInfo{

    /**
     * Retrieves all records from the personalInfo_table.
     *
     * @throws Some_Exception_Class description of exception
     * @return mysqli_result|false Returns a result object or false if the query fails.
     */
    function get_all(){
        include 'connection.php';
        $query = "SELECT * FROM `personalInfo_table` ";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    /**
     * Retrieves data from the specified table based on the given ID.
     *
     * @param string $table The name of the table to retrieve data from.
     * @param string $id The ID used to filter the data.
     * @throws Exception If there is an error executing the query.
     * @return mysqli_result The result set containing the retrieved data.
     */
    function get_sglTbl($table,$id){
        include 'connection.php';
        $query = "SELECT * FROM `personalinfo_table` INNER JOIN `emp_table` ON personalinfo_table.gsis = emp_table.bpNo WHERE personalinfo_table.".$table." = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /**
     * Retrieve data from a specific table in the database based on a given value.
     *
     * @param string $table The name of the table to retrieve data from.
     * @param mixed $value The value to search for in the specified table.
     * @throws Some_Exception_Class A description of the exception that could be thrown.
     * @return mysqli_result|bool The result set from the executed query, or false on failure.
     */
    function get_wldcrdTbl($table,$value){
        include 'connection.php';
        $query = "SELECT * FROM `emp_table` WHERE `".$table."` LIKE ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$value);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
    /**
     * Retrieves records from the specified table based on the given name.
     *
     * @param string $table The name of the table to retrieve records from.
     * @param string $name The name to search for in the records.
     * @throws Exception If an error occurs during the retrieval process.
     * @return mysqli_result|bool The result set of the retrieved records, or false if an error occurs.
     */
    function get_wldcrdTbl2($table,$name){
        include 'connection.php';
        $query = "SELECT * FROM `emp_table` WHERE CONCAT(bpNo, lname, fname, mname) LIKE '%$name'";
        $stmt = $con->prepare($query);
        // $stmt->bind_param('s',$name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /**
     * Retrieves all IPCR records from the database.
     *
     * @throws Some_Exception_Class description of exception
     * @return mysqli_result Returns the result of the database query.
     */
    function get_allIpcr(){
        include 'connection.php';
        // $query = "SELECT * FROM `personalInfo_table`";
        $query = "SELECT * FROM `ipcr_encoding_table` ORDER BY `sname`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /**
     * Retrieves all inactive Tblank records from the personalInfo_inactive_table.
     *
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value the result set containing the inactive Tblank records
     */
    function get_inactiveTblank(){
        include 'connection.php';
        $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `surname` = '' ORDER BY `idno`";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /**
     * Retrieves all records from the `personalInfo_inactive_table` table where the `surname` is not empty and the `idno` is between 3000 and 5000 (inclusive), ordered by `idno`.
     *
     * @return mysqli_result|bool Returns the result set of the query or false if the query fails.
     */
    function get_inactiveTbl(){
        include 'connection.php';
        // $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `surname` != '' ORDER BY `idno` DESC";
        $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `surname` != '' AND `idno` >= 3000  AND `idno` <= 5000 ORDER BY `idno`"; // DESC limit 50
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /**
     * Retrieves all pending records from the pending_inactive_table.
     *
     * @return mysqli_result The result set containing the pending records.
     */
    function get_pendingTbl(){
        include 'connection.php';
        $query = "SELECT * FROM `pending_inactive_table` WHERE status = 'pending'";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /**
     * Retrieves the existing ID numbers from the personalInfo_inactive_table.
     *
     * @return string Returns a JSON-encoded string containing the ID numbers.
     */
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

    /**
     * Retrieves the existing IPCR numbers from the IPCR encoding table.
     *
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Some_Return_Value The JSON-encoded result of the query.
     */
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

    /**
     * Retrieves data from the `personalInfo_inactive_table` table based on the provided filter criteria.
     *
     * @param string $filSelect The name of the column to filter on.
     * @param string $regionFil The region filter criteria. If set to 'all', no region filtering is applied.
     * @param string $infoFil The filter value to match against the specified column.
     * @return mixed The result set obtained from the query execution.
     */
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

    /**
     * Retrieves the inactive table test with wildcard filters.
     *
     * @param string $filSelect The column to filter on.
     * @param string $regionFil The region to filter on. Use 'all' for all regions.
     * @param string $infoFil The filter value.
     * @return mixed The result of the query.
     */
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

    /**
     * Retrieves the records from the `personalInfo_inactive_table` table that match the given region.
     *
     * @param string $value The region to match against.
     * @return mysqli_result The result set containing the matching records.
     */
    function get_regionInactiveTbl($value){
        include 'connection.php';
        $query = "SELECT * FROM `personalInfo_inactive_table` WHERE `region` LIKE '$value'";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    /**
     * Retrieves the monitoring table for a given year.
     *
     * @param int $year The year for which to retrieve the monitoring table.
     * @return mysqli_result|bool The result of the query, or false on failure.
     */
function get_monitoringTbl($year){
        include 'connection.php';
        $query = "SELECT mst.emp_id, pit.sname, pit.fname, pit.mname, pit.ext, mst.pds, mst.saln, mst.pmcr, mst.idp, mst.opcr, mst.dpcr, mst.ipcr FROM monitoring_submission_table AS mst INNER JOIN personalinfo_table AS pit ON pit.emp_id = mst.emp_id WHERE mst.year = $year";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
        }

    /**
     * Retrieves data from the wldcrdMonitoringTbl table based on the provided filters.
     *
     * @param string $filSelect The column name to filter on.
     * @param string $regionFil The region to filter on. Use 'all' to include all regions.
     * @param string $infoFil The value to match in the filtered column.
     * @throws Some_Exception_Class [optional] A description of the exception that can be thrown.
     * @return mysqli_result The result set from the executed query.
     */
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

    /**
     * Retrieve the existing years from the performance_rating_year table.
     *
     * This function fetches the year column from the performance_rating_year table
     * and returns the result as a JSON-encoded string.
     *
     * @return string The JSON-encoded existing years.
     */
    function get_existYear(){
        include 'connection.php';
        $query = "SELECT year FROM `performance_rating_year`";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmtPendingResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($stmtPendingResult);
    }
};


?>