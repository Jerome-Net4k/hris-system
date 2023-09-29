<?php
if (isset($_POST['searchinput'])) {
    $nosiinputsearch = $_POST['searchinput'];
    $nosiyear = $_POST['nosiyear'];
    nosiloadsearch($nosiinputsearch, $nosiyear);
} else {
    loadlist();
}

function nosiloadsearch($nosiinputsearch, $nosiyear) {
    include "connection.php";
    $sortval = $_POST['sortval'];
    $sortwhat = $_POST['sortwhat'];
    if (!empty($nosiinputsearch)) {
        $stmt = $con->prepare("SELECT empno, CONCAT(sname, ' ', fname, ' ', mname) as fullname FROM ipcr_encoding_table WHERE CONCAT(empno,sname,fname,mname) LIKE ? ORDER BY $sortval $sortwhat");
        $search_param = "%" . $nosiinputsearch . "%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        nosiloaddata($result, $nosiyear);
    } else {
        loadlist();
    }
}

function loadlist() {
    $nosiyear = $_POST['nosiyear'];
    nosiselectall($nosiyear);
}

function nosiselectall($nosiyear) {
    include "connection.php";
    $sortval = $_POST['sortval'];
    $sortwhat = $_POST['sortwhat'];
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $sql = "SELECT empno, CONCAT(sname,' ',fname, ' ',mname) as fullname FROM ipcr_encoding_table WHERE sname != '' ORDER BY $sortval $sortwhat";
    $result = $con->query($sql);
    nosiloaddata($result, $nosiyear);
}

function nosiloaddata($result, $nosiyear) {
    include "connection.php";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $selectid = $row['empno'];
            echo '<tr>
                <td class="text-center" style="padding: 10px 0 10px 10px; margin: 0;">' . $row['empno'] . '</td>
                <td>' . $row['fullname'] . '</td>';

            for ($i = 1; $i < 13; $i++) {
                $stmt = $con->prepare("SELECT * FROM nosi_monitoring_table WHERE month = ? and empNo = ? and year = ?");
                $stmt->bind_param("sss", $i, $selectid, $nosiyear);
                $stmt->execute();
                $result2 = $stmt->get_result();

                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        echo '<td class="text-center">
                            <input type="checkbox" checked title="DE: '. $row2['datetoday'] .'DU: ' . $row2['dateupload'] .'">
                        </td>';
                    }
                } else {
                    echo '<td class="text-center">
                        <input type="checkbox" disabled>
                    </td>';
                }
            }
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="22" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}
?>
                        <style>
                           .bi-check2-circle {
                                width: 55px;
                                height: 55px;
                                cursor: pointer;
                            }
                        </style>