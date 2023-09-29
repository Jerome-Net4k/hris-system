<?php

include 'connection.php';
$query = "SELECT * FROM `psipop_table` ORDER BY `salary_grade` DESC";
$stmt = $con->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()){
    echo '<tr>
        <td>'.$row['item_num'].'</td>
        <td>'.$row['pos_title'].'</td>
        <td>'.$row['salary_grade'].'</td>
        <td>'.$row['year'].'</td>
        <td>'.$row['division'].'</td>
    </tr>';
}
?>