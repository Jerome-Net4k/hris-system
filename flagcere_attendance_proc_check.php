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
    $dayattendance = $_POST['dayattendance'];
    if (!empty($salninputsearch)) {
        $stmt = $con->prepare("SELECT empNo, name as fullname FROM attendance_table_person WHERE  dept = '$dept' and CONCAT(empno,name LIKE ? ORDER BY name");
        $search_param = "%" . $salninputsearch . "%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();
        nosiloaddata($result, $year, $month,$dayattendance);
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
    $dayattendance = $_POST['dayattendance'];
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $sql = "SELECT empNo, name as fullname FROM attendance_table_person WHERE  dept = '$dept' ORDER BY name";
    $result = $con->query($sql);
    nosiloaddata($result, $year, $month,$dayattendance);
}

function nosiloaddata($result, $year, $month,$dayattendance) {
    include "connection.php";
    $no = 0;
    if ($result->num_rows > 0) {
        // action="submit_attendance.php"
        echo '
        <form id="attflagform" method="POST">
        <table class="table table-bordered table-hover" style="position: sticky; background-color: white; top: 0;">
            <thead style="position: sticky; background-color: white; top: 0;">
                <tr class="text-center" style="position: sticky; background-color: white; top: 0;">
                    <th style="width: 50px;">No.</th>
                    <th>Name</th>
                    <th class="w-25">Attendance</th>
                </tr>
            </thead>
            <tbody>';
        while ($row = $result->fetch_assoc()) {
            $selectid = $row['empNo'];
            $no = $no + 1;
            
            echo '<tr>
                <td>'. $no .'</td>
                <td>' . $row['fullname'] . '</td>';
                $sql = "SELECT * FROM attendance_monitoring WHERE empNo ='$selectid' AND month = '$month' AND day = '$dayattendance' AND year = '$year' AND attend = '1' GROUP BY month, day, year";
                $resultt = $con->query($sql);
                if ($resultt->num_rows > 0) {
                    echo'<td class="text-center"><input type="checkbox" name="attendance[]" value="' . $row['empNo'] . '" checked></td>';
                }else{
                    echo '<td class="text-center"><input type="checkbox" name="attendance[]" value="' . $row['empNo'] . '"></td>';
                }
                echo'</tr>';
        }
        echo '<tr><td></td><td></td><td class="text-center">SELECT: <input type="checkbox" checked id="checkAll" class="form-check-input" style="width: 20px; height: 20px;"></td></tr>';
        echo '</tbody></table>';
        echo '<label class="mb-2"><b>NOTE1:</b> <i>Please exercise caution and verify the person you are selecting.</i><br><b>NOTE2:</b> <i>
        To handle errors during selection, please follow these steps:
        <b>[1. ] </b>Uncheck all selected items if an error occurs.
        <b>[2. ] </b>Identify the specific item that caused the error and select it again.
        <b>[3. ] </b>To reset the values, click the "REMOVE CHECK" button.</i></label>';
        echo '<div class="modal-footer"><button type="submit" class="btn btn-primary">SUBMIT ATTENDANCE</button>';
        echo '<button type="button" id="resetbtn" class="btn btn-dark">REMOVE CHECK</button></div>';
        echo '</form>';
    } else {
        echo '<tr><td colspan="3" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}


// $con->close();
?>

<script>
    $(document).ready(function(){
        
        $('#checkAll').change(function(){
            if($(this).is(':checked')){
                $('input[name="attendance[]"]').prop('checked',true);
            }else{
                $('input[name="attendance[]"]').each(function(){
                    $(this).prop('checked',false);
                }); 
            }
        });

        $("#resetbtn").on('click',function(e) {
            var attendvalue = "0";
            insertattendance(attendvalue)
        })
        $("#attflagform").on('submit',function(e) {
            e.preventDefault();
            var attendvalue = "1";
            insertattendance(attendvalue)
        })

        function insertattendance(attendvalue){
            var attform = new FormData($("#attflagform")[0]);
            var monthselected = $("#monthselected").text();
            var dayattendance = $("#dayattendance").val();
            var yearselected = $("#yearselected").text();
            var attend = attendvalue;
            attform.append('monthselected', monthselected);
            attform.append('dayattendance', dayattendance);
            attform.append('yearselected', yearselected);
            attform.append('attend', attend);
            // alert(attend);
            if (dayattendance!=""){
                $.ajax({
                    url: "flagcere_attendance_submit.php",
                    method: "POST",
                    data: attform,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                    if (response.trim() === "Attendance submitted successfully") {
                        iziToast.success({
                        title: 'SAVE',
                        message: 'SAVING ATTENDANCE COMPLETE SUCCESSFUL'
                        });
                                            // iload ang data na nilagyan ng bagong data
                        displayemptyadd()
                    }else{
                        iziToast.warning({
                        title: 'ERROR',
                        message: 'SOMETHING WENT WRONG, TRY AGAIN'
                        });
                    }
                    }
                });
            }else{
                iziToast.warning({
                    title: 'UNSELECTED',
                    message: 'PLEASE SELECT THE DATE BEFORE PROCEEDING.'
                });
            }
        }

        // duplicate code of refresh the value
        function attendancetableload(){
            var selectedOption = $("#attyear").find(":selected");
            var yearload = new Date(selectedOption.val()).getFullYear();
            var month = $("#attmonth option:selected").val();
            var deptname = $("#deptname").val();
            // alert(month);
            $.ajax({
                url:"flagcere_attendance_proc.php",
                method:"POST",
                data: {yearload: yearload,month:month,deptname:deptname},

                success:function(data){
                    $("#listperdepartment").html(data);
                }
            });
        }
    });
</script>
                        <style>
                           .bi-check2-circle {
                                width: 55px;
                                height: 55px;
                                cursor: pointer;
                            }
                        </style>