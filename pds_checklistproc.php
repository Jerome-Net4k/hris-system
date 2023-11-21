<?php
include "connection.php";
if (isset($_POST['searchinput'])) {
    $pdsinputsearch = $_POST['searchinput'];
    $startyear = $_POST['yearload'];
    $endyear = $_POST['endload'];
    nosiloadsearch($pdsinputsearch, $startyear, $endyear);
} else {
    loadlist();
}

function nosiloadsearch($pdsinputsearch, $startyear, $endyear) {
    include "connection.php";
    $sortval = $_POST['sortval'];
    $sortwhat = $_POST['sortwhat'];
    if (!empty($pdsinputsearch)) {
        $stmt = $con->prepare("SELECT bpNo, CONCAT(lname, ' ', fname, ' ', mname) as fullname FROM emp_table WHERE CONCAT(bpNo,lname,fname,mname) LIKE ? ORDER BY $sortval $sortwhat");
        $search_param = "%" . $pdsinputsearch . "%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();
        nosiloaddata($result, $startyear, $endyear);
    } else {
        loadlist();
    }
}

function loadlist() {
    $startyear = $_POST['yearload'];
    $endyear = $_POST['endload'];
    nosiselectall($startyear, $endyear);
}

function nosiselectall($startyear, $endyear) {
    include "connection.php";
    $sortval = $_POST['sortval'];
    $sortwhat = $_POST['sortwhat'];
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $sql = "SELECT bpNo, CONCAT(lname,' ',fname, ' ',mname) as fullname FROM emp_table WHERE lname != '' ORDER BY $sortval $sortwhat";
    $result = $con->query($sql);
    nosiloaddata($result, $startyear, $endyear);
}

function nosiloaddata($result, $startyear, $endyear) {
    include "connection.php";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $selectid = $row['bpNo'];
            echo '<tr>
                <td class="text-center" style="padding: 10px 0 10px 10px; margin: 0;">' . $row['bpNo'] . '</td>
                <td>' . $row['fullname'] . '</td>';
                
            
            for ($i = $startyear; $i > $endyear; $i--) {
                $stmt = $con->prepare("SELECT * FROM pds_monitoring_table WHERE year = ? and pdsempNo = ?");
                $stmt->bind_param("ss", $i, $selectid);
                $stmt->execute();
                $result2 = $stmt->get_result();
                
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        echo '<td class="text-center">
                            <input type="checkbox" style="padding: 0; margin: 0;" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'">
                        </td>';
                    }
                } else {
                    echo '<td class="text-center">
                        <input type="checkbox" disabled style="padding: 0; margin: 0;">
                    </td>';
                }
            }
            
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="22" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}

// $conn->close();
?>
                        <style>
                           .bi-check2-circle {
                                width: 55px;
                                height: 55px;
                                cursor: pointer;
                            }
                        </style>