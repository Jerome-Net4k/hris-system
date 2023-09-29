<?php
if(isset($_POST['searchinput'])){
    $loadsearch = $_POST['searchinput'];
    searchloadall($loadsearch);
}


if(isset($_POST['statusojtsearch'])){
    $loadsearchstatus = $_POST['statusojtsearch'];
    $sortval = "nameintern";
    $sortwhat = "ASC";
    loadsortstatus($loadsearchstatus, $sortval, $sortwhat);
}

if(isset($_POST['sortsortval'])){
    $loadsearchstatus = $_POST['searchojtstatus'];
    $sortval = $_POST['sortsortval'];
    $sortwhat = $_POST['sortwhat'];
    loadsortstatus($loadsearchstatus, $sortval, $sortwhat);
}

function searchloadall($loadsearch) {
    include "connection.php";
    // SEARCH THE RECORD NA GUSTONG SEARCH SA TEXTBOX
    $loadsearchstatus = $_POST['searchstatus'];
    if ($loadsearch!==""){
        // display the search item
        $stmt = $con->prepare("SELECT ojt_tbl.idnum as ojtid, ojt_tbl.nameintern, tbl_biostatus.*
        FROM ojt_tbl 
        LEFT JOIN tbl_biostatus 
        ON ojt_tbl.idnum = tbl_biostatus.idnum WHERE CONCAT(ojt_tbl.idnum, ojt_tbl.nameintern) LIKE CONCAT('%', ?, '%') 
        ORDER BY ojt_tbl.nameintern");
        $nameintern = "%" . $loadsearch . "%"; // add wildcard characters
        $stmt->bind_param("s", $nameintern);
        $stmt->execute();
        $result = $stmt->get_result();

        // Assuming looprecord() is defined somewhere
        looprecord($result,$loadsearchstatus);
    }elseif ($loadsearchstatus!==""){
        // $loadsearchstatus = $loadsearchstatus;
        $sortval = "nameintern";
        $sortwhat = "ASC";
        loadsortstatus($loadsearchstatus, $sortval, $sortwhat);
    }
    else{
        $sortval = "nameintern";
        $sortwhat = "ASC";
        loadsortstatus($loadsearchstatus, $sortval, $sortwhat);
    }
}


function loadsortstatus($loadsearchstatus, $sortval, $sortwhat) {
    include "connection.php";
    if ($loadsearchstatus == "ALL RECORD") {
        $sql = "SELECT ojt_tbl.idnum as ojtid, ojt_tbl.nameintern, tbl_biostatus.*
        FROM ojt_tbl 
        LEFT JOIN tbl_biostatus 
        ON ojt_tbl.idnum = tbl_biostatus.idnum 
        ORDER BY ojt_tbl.$sortval $sortwhat";
        $stmt = $con->prepare($sql);
    } else {
        $sql = "SELECT ojt_tbl.idnum as ojtid, ojt_tbl.nameintern, tbl_biostatus.*
        FROM ojt_tbl 
        LEFT JOIN tbl_biostatus 
        ON ojt_tbl.idnum = tbl_biostatus.idnum WHERE tbl_biostatus.status = ? 
        ORDER BY ojt_tbl.$sortval $sortwhat";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $loadsearchstatus);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    looprecord($result, $loadsearchstatus);
}


    function looprecord($result, $loadsearchstatus){
        // loop the record in the tbody record
        include "connection.php";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $remarks = $row['remarks'];
                $dutyhour = $row['duty_hour'];
                $status = $row['status'];
                $idojt = $row['ojtid'];
                
                // display the render total
                $stmt = $con->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(STR_TO_DATE(timerender, '%H:%i')))) AS totalrender FROM tbl_logs WHERE idnum = ?");
                $stmt->bind_param("s", $idojt);
                $stmt->execute();
                global $totalrender;
                $resultrender = $stmt->get_result();
                if ($resultrender->num_rows > 0) {
                    while ($rowrender = $resultrender->fetch_assoc()) {
                        $totalrender = $rowrender['totalrender'];
                    }
                }

                // $string = "100:00:00";
                $parts = explode(":", $totalrender);
                $firstValue = $parts[0];
                // echo $firstValue; 

                // echo '<tr><td>' . $firstValue . '</td></tr>';

                if ($loadsearchstatus == "ALL RECORD") {
                    if ($status == "ACTIVE") {
                        echo '<tr class="text-bg-info">';
                    } elseif ($status == "COMPLETED") {
                        echo '<tr class="text-bg-danger">';
                    } elseif ($status == "DISPATCHED") {
                        echo '<tr class="text-bg-dark">';
                    } else {
                        echo '<tr class="text-bg-light">';
                    }
                } else {
                    if (isset($firstValue) && $firstValue !== "" && $firstValue >= $dutyhour) {                    
                        echo '<tr class="text-bg-danger">';
                    } else {
                        echo '<tr>';
                    }
                }

                if ($remarks != "") {
                    echo '<td class="view_remarks" style="text-align: center;"><button class="btn btn-warning" value="'. $row['remarks'] .'"><i class="bi bi-file-earmark-break"></i></button></td>';
                } else {
                    echo '<td></td>';
                }
                echo '<td>' . $row['ojtid'] . '</td>';
                echo '<td>' . $row['nameintern'] . '</td>';
                echo '<td>' . $row['duty_hour'] . '</td>';

                for ($i = 1; $i < 32; $i++) {
                }

                echo '<td>'. $totalrender .'</td>';

                // echo '<td>'.$i.'</td>';
                echo '<td>' . $row['lastdate_in'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '<td class="text-center"><button class="btn btn-success view_ojtrecord" data-bs-toggle="modal" data-bs-target="#updateojt-recordview" id="view_ojtrecord" name="view_ojtrecord" value="'. $row['ojtid'] .'">VIEW</button>';
                echo '<button style="margin-left: 10px;" class="btn btn-primary update_ojtrecord" data-bs-toggle="modal" data-bs-target="#updateojt-record" id="update_ojtrecord" name="update_ojtrecord" value="'. $row['ojtid'] .'">UPDATE</button>';
                echo '<button style="margin-left: 10px;" class="btn btn-dark dtr_tableojt" data-bs-toggle="modal" data-bs-target="#dtr_tableojt" value="'. $row['ojtid'] .'">DTR</button>';
                echo '</td></tr>';
            }
        }else{
            echo '<tr><td colspan="22" class="text-center"><h1>No Data Found</h1></td></tr>';
        }
       echo "<script>
       $(document).ready(function() {
            $('.view_ojtrecord').click(function() {
                var myid = $(this).val();
                // alert(myid);
                $.ajax({
                url: 'ojt_tablecrud.php?id=' + myid,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#ojtviewid').html(data[0].idnum);
                    $('#ojtviewname').html(data[0].nameintern);
                    $('#ojtviewschool').html(data[0].school);
                    $('#ojtviewdept').html(data[0].dept);
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error.message);
                }
                });
            });

            $('.dtr_tableojt').click(function() {
                var myid = $(this).val();
                // alert(myid);
                $.ajax({
                url: 'ojt_tablecrud.php?id=' + myid,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#ojt_tableviewid').html(data[0].idnum);
                    $('#ojt_tableviewname').html(data[0].nameintern);
                    // $('#ojtviewschool').html(data[0].school);
                    // $('#ojtviewdept').html(data[0].dept);
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error.message);
                }
                });
            });
        });

     </script>";
        // REMOVE DUE TO THE VARIABLE IS IN THE OTHER FUNCTION
        // $stmt->close();
        // $con->close();
    }

    // function loadrendertime(){
    //     include "connection.php";
    //     $stmt = $con->prepare("SELECT * FROM ojt_tbl WHERE CONCAT(idnum, nameintern) LIKE CONCAT('%', ?, '%')");
    //     $nameintern = "%" . $loadsearch . "%"; // add wildcard characters
    //     $stmt->bind_param("s", $nameintern);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             echo '<tr>';
    //             echo '<td>' . $row['idnum'] . '</td>';
    //             echo '<td>' . $row['nameintern'] . '</td>';
    //             echo '<td>500</td>';

    //             for ($i = 1; $i < 32; $i++) {
    //             }

    //             echo '<td>'.$i.'</td>';
    //             echo '<td>' . $row['lastdate_in'] . '</td>';
    //             echo '<td>' . $row['status'] . '</td>';
    //             echo '<td><button class="btn btn-success view_ojtrecord" data-bs-toggle="modal" data-bs-target="#updateojt-recordview" id="view_ojtrecord" name="view_ojtrecord" value="'. $row['idnum'] .'">VIEW</button>';
    //             echo '<button style="margin-left: 10px;" class="btn btn-primary update_ojtrecord" data-bs-toggle="modal" data-bs-target="#updateojt-record" id="update_ojtrecord" name="update_ojtrecord" value="'. $row['idnum'] .'">UPDATE</button></td>';
    //             echo '</tr>';
    //         }
    //     }
    // }

?>

    <script>
        // THIS SCRIPT IS FOR SELECT KUNG ANO IUPDATE SA RECORD
        $(document).ready(function(){
            $(".update_ojtrecord").click(function() {
                var $tr = $(this).closest('tr');
                var data = $tr.find("td:not(:last-child)").map(function() {
                    return $(this).text().trim();
                }).get();
                console.log(data);
                $('#remarks').val($(this).closest('tr').find('td:first-child button').val());
                $('#ojtid').val(data[1]);
                $('#ojtname').val(data[2]);
                $('#latestin').val(data[5]);
                $('#optionojtstatus').html(data[6]);
                $('#dutyhours').val(data[3]);
            })

            $(".view_remarks").click(function() {
                var $tr = $(this).closest('tr');
                var data = $tr.find("td:not(:last-child)").map(function() {
                    return $(this).text().trim();
                }).get();
                console.log(data);

                var remarks =$(this).closest('tr').find('td:first-child button').val();
                // alert(remarks);
                $.ajax({
                    success: function(response) {
                        iziToast.success({
                            title: 'REMARKS: ',
                            message: remarks,
                            position: 'center', // Set the position to 'center'
                            onOpen: function(instance, toast) {
                                toast.querySelector('.iziToast-message').style.fontSize = '16px'; // Adjust the font size as needed
                            }
                        });
                    }
                });
            })
        });
    </script>