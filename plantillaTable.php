<?php

include 'connection.php';
/*$query = "SELECT `item_num`,`pos_title`,office_assistant_sec.salary_grade,salarygrade.level,(salarygrade.sgstep1 * 12)AS annual
FROM office_assistant_sec
INNER JOIN salarygrade ON office_assistant_sec.salary_grade =salarygrade.level
ORDER BY `annual` DESC";*/
$query = "SELECT * FROM `psipop_table` WHERE `division` = 'OASEC' ORDER BY `salary_grade` DESC";
$stmt = $con->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo '<tr class="data"> 
        <td class="text-start textdata data">'.$row['item_num'].'</td>
        <td class="text-start textdata data">'.$row['pos_title']." - ".$row['salary_grade'].'</td>
        <td class="text-start textdata data">'.number_format($row['authorize']).'</td>
        <td class="text-start textdata data">'.number_format($row['actual']).'</td>
        <td class="text-start textdata data">'.$row['step'].'</td>
        <td class="text-start textdata data">'.$row['code'].'</td>
        <td class="text-start textdata data">'.$row['type'].'</td>
        <td class="text-start textdata data">'.$row['level'].'</td>
        <td class="text-start textdata data">'.$row['attr'].'</td>
        <td class="text-start textdata data">'.$row['name'].'</td>
        <td class="text-start textdata data">'.substr($row['sex'],0,1).'</td>
        <td class="text-start textdata data">'.substr($row['dob'],5,2)."/".substr($row['dob'],strlen($row['dob'])-2,2).'/'.substr($row['dob'],2,2).'</td>
        <td class="text-start textdata data">'.$row['tin'].'</td>
        <td class="text-center textdata data">'.$row['dooa'].'</td>
        <td class="text-center textdata data">'.$row['doop'].'</td>
        <td class="text-center textdata data">'.$row['status'].'</td>
        <td class="text-center textdata data">'.$row['cse'].'</td>
</tr>';
    }
}


?>