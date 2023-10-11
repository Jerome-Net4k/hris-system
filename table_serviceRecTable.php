<?php
class serviceRec{
    
    function load_allRec(){
    include 'connection.php';
    $query = "SELECT * FROM `servicerecord_table` WHERE `serveRecTo` = 'present' GROUP BY `empNo`";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
    }
    function load_allRecforloyalty(){
        include 'connection.php';
        $query = "SELECT `empNo`, `name`, MIN(`serveRecFrom`) AS oldestServeRecFrom FROM `servicerecord_table` GROUP BY `empNo`, `name`;";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function get_history($id){
        include 'connection.php';
        $query = "SELECT * FROM `servicerecord_table` WHERE `empNo` = ? ORDER BY `serveRecFrom` ASC";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function upload_serveRec($id,$name,$convServFrom,$convServTo,$convServDesig,$convServStatus,$convServSalary,$convServStation,$convServBranch,$convServLv,$convServCause){
        include 'connection.php';
        for($a = 0; $a < count($convServFrom); $a++){
            if(!empty($convServFrom)){
            $query = "INSERT INTO `servicerecord_table`(`empNo`, `name`, `serveRecFrom`, `serveRecTo`, `designation`, `status`, `salary`, `station`, `branch`, `abs/lv`, `cause`) VALUES 
            (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('sssssssssss',$id,$name,$convServFrom[$a],$convServTo[$a],$convServDesig[$a],
            $convServStatus[$a],$convServSalary[$a],$convServStation[$a],$convServBranch[$a],$convServLv[$a],$convServCause[$a]);
            $stmt->execute();
        }
        }
    }
}
?>