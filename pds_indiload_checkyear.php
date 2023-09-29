<?php
if(isset($_POST['gsis'])){
    $gsis = $_POST['gsis'];
    $dtryear = $_POST['dtryear'];
    loadlistchecker($dtryear,$gsis);
}

function loadlistchecker($dtryear,$gsis){
//     $gsis = '2000132435';
// $dtryear = '2023';
include "connection.php";
for ($i = 1; $i < 13; $i++) {
    $stmt = $con->prepare("SELECT * FROM pds_monitoring_table WHERE month = ? AND pdsempNo = ? AND year = ?");
    $stmt->bind_param("sss", $i, $gsis, $dtryear);
    $stmt->execute();
    $result2 = $stmt->get_result();
    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
            $monthselect = $row2['month'];
            echo '<tr>
                <td>January</td>';
            if ($monthselect == "1") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }

            echo '<tr>
                <td>February</td>';
            if ($monthselect == "2") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>March</td>';
            if ($monthselect == "3") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>April</td>';
            if ($monthselect == "4") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>May</td>';
            if ($monthselect == "5") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>June</td>';
            if ($monthselect == "6") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>July</td>';
            if ($monthselect == "7") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>August</td>';
            if ($monthselect == "8") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>September</td>';
            if ($monthselect == "9") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>October</td>';
            if ($monthselect == "10") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>November</td>';
            if ($monthselect == "11") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
            
            echo '<tr>
                <td>Decemnber</td>';
            if ($monthselect == "12") {
                echo '<td class="text-center"><input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'"></td>';
            } else {
                echo '<td class="text-center"><input type="checkbox" disabled></td>';
            }
        }
    }
}


}
?>