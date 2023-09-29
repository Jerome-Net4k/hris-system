<?php

include 'connection.php';

$query = "SELECT * FROM `salarygrade`";
$stmt = $con->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()){
    echo '<tr>
        <td class="text-center">'.$row['level'].'</td>
        <td>'.$row['sgstep1'].'</td>
        <td>'.$row['sgstep2'].'</td>
        <td>'.$row['sgstep3'].'</td>
        <td>'.$row['sgstep4'].'</td>
        <td>'.$row['sgstep5'].'</td>
        <td>'.$row['sgstep6'].'</td>
        <td>'.$row['sgstep7'].'</td>
        <td>'.$row['sgstep8'].'</td>
    </tr>';
}

?>