<?php
if(isset($_POST['searchinput'])){
    $dtrinputsearch = $_POST['searchinput'];
    $dtrmonth = $_POST['dtrmonth'];
    $dtryear = $_POST['dtryear'];
    $searchojtstatus = $_POST['searchojtstatus'];
    dtrloadsearch($dtrinputsearch,$dtryear,$dtrmonth,$searchojtstatus);
}
else if (isset($_POST['sortsortval'])) {
    $dtryear = $_POST['dtryear'];
    $dtrmonth = $_POST['dtrmonth'];
    $searchojtstatus = $_POST['searchojtstatus'];
    $sortval = $_POST['sortsortval'];
    $sortwhat = $_POST['sortwhat'];
    dtrloadall($dtryear, $dtrmonth, $searchojtstatus, $sortval, $sortwhat);
} 
else{
    loadlist();
}

function dtrloadsearch($dtrinputsearch, $dtryear, $dtrmonth,$searchojtstatus) {
    include "connection.php";
    if (!empty($dtrinputsearch)) { // use !empty() to check if the input search string is not empty
        // $stmt = $con->prepare("SELECT * FROM ojt_tbl WHERE nameintern LIKE ?");
        $stmt = $con->prepare("SELECT ojt_tbl.idnum as ojtid, ojt_tbl.nameintern, SEC_TO_TIME(SUM(TIME_TO_SEC(STR_TO_DATE(tbl_logs.timerender, '%H:%i:%s')))) AS totalrender, tbl_biostatus.*
        FROM ojt_tbl 
        LEFT JOIN tbl_logs ON ojt_tbl.idnum = tbl_logs.idnum 
        JOIN tbl_biostatus ON tbl_logs.idnum = tbl_biostatus.idnum 
        WHERE ojt_tbl.nameintern LIKE ?");

        $search_param = "%" . $dtrinputsearch . "%"; // add wildcard characters to allow partial matches
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();
        dtrloaddata($result, $dtryear, $dtrmonth, $searchojtstatus);
    }else{
        loadlist();
    }
}

// loadlist();

function loadlist(){
    $dtrmonth = $_POST['dtrmonth'];
    $dtryear = $_POST['dtryear'];
    $searchojtstatus = $_POST['searchojtstatus'];
    $sortval = "nameintern";
    $sortwhat = "ASC";
    dtrloadall($dtryear, $dtrmonth, $searchojtstatus, $sortval, $sortwhat);
}

function dtrloadall($dtryear, $dtrmonth, $searchojtstatus, $sortval, $sortwhat) {
    include "connection.php";
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    if ($searchojtstatus == "ALL RECORD"){
        $dtryear = $_POST['dtryear'];
        $sql = "SELECT ojt_tbl.idnum as ojtid, ojt_tbl.nameintern, tbl_biostatus.*
        FROM ojt_tbl 
        LEFT JOIN tbl_biostatus ON ojt_tbl.idnum = tbl_biostatus.idnum 
        ORDER BY ojt_tbl.$sortval $sortwhat;";
        //  WHERE ojt_tbl.idnum = '3444'
        $result = $con->query($sql);
        dtrloaddata($result, $dtryear, $dtrmonth, $searchojtstatus);
    }else{
        $dtryear = $_POST['dtryear'];
        $sql = "SELECT ojt_tbl.idnum as ojtid, ojt_tbl.nameintern, tbl_biostatus.*
        FROM ojt_tbl 
        JOIN tbl_biostatus ON ojt_tbl.idnum = tbl_biostatus.idnum 
        WHERE tbl_biostatus.status= '$searchojtstatus' 
        ORDER BY ojt_tbl.$sortval $sortwhat";
        //  WHERE ojt_tbl.idnum = '3444'
        $result = $con->query($sql);
        dtrloaddata($result, $dtryear, $dtrmonth, $searchojtstatus); 
    }
}

function dtrloaddata($result, $dtryear, $dtrmonth, $searchojtstatus) {
    include "connection.php";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $selectid = $row['ojtid'];
            $dailyrender = $row['ojtid'];
            $status = $row['status'];
                
            echo ' <tr style="cursor: pointer;" data-value="' . $row['ojtid'] . '" class="dtr-idview" data-bs-toggle="modal" data-bs-target="#ojtmenu">';
            if ($searchojtstatus == "ALL RECORD") {
                if ($status == "ACTIVE") {
                    echo '<td class="text-bg-info text-center btn-dtrid" style="padding: 5px 0; margin: 0;">' . $row['ojtid'] . '</td>';
                } elseif ($status == "COMPLETED") {
                    echo '<td class="text-bg-danger text-center btn-dtrid" style="padding: 5px 0; margin: 0;">' . $row['ojtid'] . '</td>';
                } elseif ($status == "DISPATCHED") {
                    echo '<td class="text-bg-dark text-center btn-dtrid" style="padding: 5px 0; margin: 0;">' . $row['ojtid'] . '</td>';
                } else {
                    echo '<td class="text-bg-light text-center btn-dtrid" style="padding: 5px 0; margin: 0;">' . $row['ojtid'] . '</td>';
                }
            } else {
                echo '<td class="text-center btn-dtrid" style="padding: 0; margin: 0; background: #e9ecef; border: 1px solid #e9ecef;">' . $row['ojtid'] . '</td>';
            }    
                echo '<td style="width: 320px; padding: 0; margin: 0; position: sticky; top: 10%; left: 0; background: #e9ecef;"><div style="width: fit-content; border: 1px solid #e9ecef; padding: 10px 10px; z-index: 20; margin: 0;">' . $row['nameintern'] . '</div></td>';

                $stmt = $con->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(STR_TO_DATE(timerender, '%H:%i:%s')))) AS monthrender FROM tbl_logs WHERE idnum = ? AND month = ? AND year = ?");
                $stmt->bind_param("sss", $selectid, $dtrmonth, $dtryear);
                $stmt->execute();
                $resultrender = $stmt->get_result();
                if ($resultrender->num_rows > 0) {
                    while ($rowrender = $resultrender->fetch_assoc()) {
                        echo '<td class="text-center" style="width: 170px;"><b>'. $rowrender['monthrender'] .'</b></td>';
                    }
                }//rendermonth

                $stmt = $con->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(STR_TO_DATE(timerender, '%H:%i:%s')))) AS totalrender FROM tbl_logs WHERE idnum = ?");
                $stmt->bind_param("s", $selectid);
                $stmt->execute();
                $resultyrender = $stmt->get_result();
                if ($resultyrender->num_rows > 0) {
                    while ($rowyrender = $resultyrender->fetch_assoc()) {
                        echo '<td class="text-center" style="width: 170px;"><b>' . $rowyrender['totalrender'] . '</b></td>';
                    }
                } 
                // totaltime render

            for ($i = 1; $i < 32; $i++) {
                $stmt = $con->prepare("SELECT * FROM tbl_logs WHERE idnum = ? AND month = ? AND day = ? AND year = ?");
                $stmt->bind_param("ssss", $selectid, $dtrmonth, $i, $dtryear);
                $stmt->execute();
                $result2 = $stmt->get_result();
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        echo '<td title="Render time: ' . $row2['timerender'] . '">
                            <div class="row">
                                <div class="border-right in-out d-flex justify-content-center">
                                    <div class="col text-center">
                                         <div class="in-out" style="padding: 0 2px;">' . $row2['Timein'] . '</div>
                                    </div>
                                    <div class="col text-center">
                                         <div class="in-out" style="padding: 0 2px;">' . $row2['timeout'] . '</div>
                                    </div>
                                </div>
                            </div>
                        </td>';
                    }
                } else {
                    echo '<td>
                        <div class="row">
                            <div class="border-right in-out d-flex justify-content-center">
                                <div class="col text-center">
                                     <div class="in-out">-</div>
                                </div>
                                <div class="col text-center">
                                     <div class="in-out">-</div>
                                </div>
                            </div>
                        </div>
                    </td>';
                }
            }
            echo '</tr>';
        }
    

       echo "<script>
       $(document).ready(function() {
            $('.dtr-idview').click(function() {
                var myid = $(this).data('value');
                // alert(myid);
                $.ajax({
                url: 'ojt_tablecrud.php?id=' + myid,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#headernamedtr').text(data[0].nameintern);
                    $('#headernameot').text(data[0].nameintern);
                    $('#headeriddtr').val(data[0].idnum);
                    $('#headeridot').val(data[0].idnum);
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error.message);
                }
                });
            });
        });

     </script>";
    }else{
        echo '<tr><td colspan="12" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}
// $con->close();


// insert new dtr

?>
<!-- <style>
    td[title] {
        font-size: 20px;
    }
</style> -->