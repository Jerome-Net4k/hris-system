<?php
include "connection.php";
if (isset($_POST['searchinput'])) {
    $salninputsearch = $_POST['searchinput'];
    $year = $_POST['yearload'];
    $month = $_POST['month'];
    nosiloadsearch($salninputsearch, $year, $month);
}
else if (isset($_POST['sortsortval'])) {
    $year = $_POST['yearload'];
    $month = $_POST['month'];
    $sortval = $_POST['sortsortval'];
    $sortwhat = $_POST['sortwhat'];
    nosiselectall($year, $month, $sortval, $sortwhat);
} 
else {
    loadlist();
}

function nosiloadsearch($salninputsearch, $year, $month) {
    include "connection.php";
    $dept = $_POST['deptname'];
    
    if (!empty($salninputsearch)) {
        $stmt = $con->prepare("SELECT empNo, job_status, name as fullname FROM attendance_table_person WHERE dept = ? AND CONCAT(empNo, name) LIKE ? ORDER BY name");
        $search_param = "%" . $salninputsearch . "%";
        $stmt->bind_param("ss", $dept, $search_param);
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
    $sortval = "name";
    $sortwhat = "ASC";
    nosiselectall($year, $month, $sortval, $sortwhat);
}

function nosiselectall($year, $month, $sortval, $sortwhat) {
    include "connection.php";
    $dept = $_POST['deptname'];
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $sql = "SELECT empNo, job_status, name as fullname FROM attendance_table_person WHERE dept = '$dept' ORDER BY $sortval $sortwhat";
    $result = $con->query($sql);
    nosiloaddata($result, $year, $month);
}

function nosiloaddata($result, $year, $month) {
    include "connection.php";
    if ($result->num_rows > 0) {
        $rowno = 1;
        while ($row = $result->fetch_assoc()) {
            $selectid = $row['empNo'];
            
            // <td class="text-center" style="padding: 10px 0 10px 10px; margin: 0;">' . $row["empNo"] . '</td>
            echo '<tr>
                <td class="edit-record" style="text-align: center;" data-value="'. $row["empNo"] . '" data-bs-toggle="modal" data-bs-target="#addnewpersonnel">
                    <button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                </td>
                <td class="text-center" style="padding: 10px 0 10px 10px; margin: 0;">' .  $rowno++ . '</td>
                <td>' . $row["fullname"] . '</td>
                <td class="text-center" style="width: 120px;">' . $row["job_status"] . '</td>
                <td>
                    <div class="border-right in-out d-flex justify-content-center" id="headerdate">';
            
                $a=0;
                
                for ($i = 1; $i <= 31; $i++) { //make this code an array
                    $sql = "SELECT * FROM attendance_date WHERE dmonth = '$month' AND dday = '$i' AND dyear = '$year' GROUP BY dmonth, dday, dyear";
                    $results = $con->query($sql);
                    if ($results->num_rows > 0) {
                        while ($rowa = $results->fetch_assoc()) {

                        $sql = "SELECT * FROM attendance_monitoring WHERE empNo ='$selectid' AND month = '$month' AND day = '$i' AND year = '$year' AND attend = '1' GROUP BY month, day, year";
                        $results = $con->query($sql);
                        if ($results->num_rows > 0) {
                            while ($rowa = $results->fetch_assoc()) {
                                $a++;
                                echo '<div class="col">
                                    <div class="text-center">Attended</div>
                                </div>';
                            }
                        }else{
                            echo '<div class="col">
                                <div class="text-center">NOT</div>
                            </div>';
                        }
                        }
                    }
                }
            echo '</div>
                </td>
                <td class="text-center"><b>'.$a.'</b></td>';
                $stmt = $con->prepare("SELECT * FROM attendance_monitoring WHERE empNo = ? AND year = ? AND attend = '1'");
                $stmt->bind_param("ss", $selectid, $year);
                $stmt->execute();
                $resultb = $stmt->get_result();

                $countyear = 0;
                if ($resultb->num_rows > 0) {
                    while ($rowb = $resultb->fetch_assoc()) {
                        $countyear++;
                    }
                }
                echo '<td class="text-center"><b>' . $countyear. '</b></td>';
                $stmt = $con->prepare("SELECT * FROM attendance_monitoring WHERE empNo = ? AND attend = '1'");
                $stmt->bind_param("s", $selectid);
                $stmt->execute();
                $resultb = $stmt->get_result();

                $countyear = 0;
                if ($resultb->num_rows > 0) {
                    while ($rowb = $resultb->fetch_assoc()) {
                        $countyear++;
                    }
                }
                echo '<td class="text-center"><b>' . $countyear. '</b></td>';
            echo '</tr>';
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
            // alert(myid);
             $.ajax({
             url: 'flagcere_crud.php?id=' + myid,
             type: 'GET',
             dataType: 'json',
             success: function(data) {
                 $('#attempno').val(data[0].empNo);
                 $('#attempname').val(data[0].name);
                 $('#attdept').val(data[0].dept);
                 $('#jobstatus').val(data[0].job_status);
                $('#delenablebtn').prop('disabled', false);
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