<?php

include 'connection.php';

$item = $_POST['convItem'];
$pos = $_POST['convPos'];
$sg = $_POST['convSg'];
$level = $_POST['convLevel'];
$div = $_POST['convDiv'];
$attr = $_POST['convAttr'];

$convItem = explode(',',$item);
$convPos = explode(',',$pos);
$convSg = explode(',',$sg);
$convLevel = explode(',',$level);
$convDiv = explode(',',$div);
$convAttr = explode(',',$attr);

for($a = 0; $a < count($convItem); $a++){
    if(!empty($convItem[$a]) && !empty($convPos[$a]) && !empty($convSg[$a]) && !empty($convLevel[$a]) && !empty($convDiv[$a])){
        if(!empty($convItem[$a]) && !empty($convPos[$a]) && !empty($convSg[$a]) && !empty($convLevel[$a]) && !empty($convDiv[$a]) && !empty($convAttr[$a])){
            $query = "SELECT * FROM `psipop_table` WHERE `item_num` = ? && `pos_title` = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ss',$convItem[$a],$convPos[$a]);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows < 1){
                $insert = "INSERT INTO `psipop_table` (`item_num`, `pos_title`, `salary_grade`, `authorize`, `actual`, `step`, `code`, `type`, `level`, `attr`, `year`, `division`) VALUES 
                ( ?, ?, ?, '0', '0', '1', '000', 'R', ?, ?, '2023', ?)";
                $inStmt = $con->prepare($insert);
                $inStmt->bind_param('ssssss',$convItem[$a],$convPos[$a],$convSg[$a],$convLevel[$a],$convAttr[$a],$convDiv[$a]);
                $inStmt->execute();
            }
             
         }      
    }
}

?>