<?php
include "connection.php";
if (isset($_POST['searchinput'])) {
    $salninputsearch = $_POST['searchinput'];
    $year = $_POST['yearload'];
    $month = $_POST['month'];
    nosiloadsearch($salninputsearch, $year, $month);
} else {
    loadlist();
}

function nosiloadsearch($salninputsearch, $year, $month) {
    include "connection.php";
    $dept = $_POST['deptname'];
    if (!empty($salninputsearch)) {
        $stmt = $con->prepare("SELECT empNo, name as fullname FROM attendance_table_person WHERE  dept = ' $dept' and CONCAT(empNo,name) LIKE ?");
        $search_param = "%" . $salninputsearch . "%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();
        nosiloaddata($result, $year, $month);
    } else {
        loadlist();
    }
}

function loadlist() {
    $year = $_POST['yearload'];
    $month = $_POST['month'];
    nosiselectall($year, $month);
}

function nosiselectall($year, $month) {
    include "connection.php";
    $dept = $_POST['deptname'];
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $sql = "SELECT empNo, name as fullname FROM attendance_table_person WHERE dept = '$dept' limit 10";
    $result = $con->query($sql);
    nosiloaddata($result, $year, $month);
}

function nosiloaddata($result, $year, $month) {
    include "connection.php";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $selectid = $row['empNo'];
            echo '<tr>
                <td class="edit-record" style="text-align: center;" data-value="'. $row["empNo"] . '" data-bs-toggle="modal" data-bs-target="#addnewpersonnel">
                    <button class="btn btn-warning"><i class="fas fa-file-code"></i></button>
                </td>
                <td class="text-center" style="padding: 10px 0 10px 10px; margin: 0;">' . $row["empNo"] . '</td>
                <td>' . $row["fullname"] . '</td>
                <td>
                    <div class="border-right in-out d-flex justify-content-center" id="headerdate">';
            
                $a=0;
                
                for ($i = 1; $i <= 31; $i++) {
                    $sql = "SELECT * FROM attendance_date WHERE dmonth = '$month' AND dday = '$i' AND dyear = '$year' GROUP BY dmonth, dday, dyear";
                    $results = $con->query($sql);
                
                    if ($results->num_rows > 0) {
                        while ($rowa = $results->fetch_assoc()) {
                            $sql = "SELECT * FROM attendance_monitoring WHERE empNo ='$selectid' AND month = '$month' AND day = '$i' AND year = '$year' AND attend = '1' GROUP BY month, day, year";
                            $results = $con->query($sql);
                
                            if ($results->num_rows > 0) {
                                while ($rowa = $results->fetch_assoc()) {
                                    $a++;
                                    $attendanceData[$i] = '<div class="col">
                                        <div class="text-center">Attended</div>
                                    </div>';
                                }
                            } else {
                                $attendanceData[$i] = '<div class="col">
                                    <div class="text-center">NOT</div>
                                </div>';
                            }
                        }
                    }
                }
                
                foreach ($attendanceData as $day => $data) {
                    echo $data;
                }
            echo '</div>
                </td>
                <td>'.$a.'</td>
            </tr>';
        }
    } else {
        echo '<tr><td colspan="22" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}


// $con->close();
?>
<script>
    $(document).ready(function() {
        $('.edit-record').click(function() {
            var myid = $(this).data('value');
            alert(myid);
             $.ajax({
             url: 'flagcere_crud.php?id=' + myid,
             type: 'GET',
             dataType: 'json',
             success: function(data) {
                 $('#attempno').val(data[0].empNo);
                 $('#attempname').val(data[0].name);
                 $('#attdept').val(data[0].dept);
             },
             error: function(xhr, status, error) {
                 alert('Error: ' + error.message);
             }
             });
         });
     });

  </script>
                        <style>
                           .bi-check2-circle {
                                width: 55px;
                                height: 55px;
                                cursor: pointer;
                            }
                        </style>