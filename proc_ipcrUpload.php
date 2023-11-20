<?php
session_start();
include 'table_personalInfoTable.php';
$personalInfo = new personalInfo();
if(!isset($_POST['searchBar']) && !isset($_GET['id'])){
    loadPersonalInfo($personalInfo);
}
if(isset($_POST['searchBar'])){
    searchPersonalInfo($personalInfo);
}





function loadPersonalInfo($personalInfo){
    
    include 'connection.php';

    $yearSelected = $_POST['yearSelected'];

    $ipcrQuery = $conn->prepare("SELECT pds.empno, ipcr_monitoring_table.firsthalf, ipcr_monitoring_table.secondhalf, ipcr_monitoring_table.target FROM ipcr_encoding_table AS pds INNER JOIN ipcr_monitoring_table ON pds.empno = ipcr_monitoring_table.empno WHERE ipcr_monitoring_table.year = '$yearSelected' AND ipcr_monitoring_table.empno = ?");

    $ipcrOutputQuery1 = $con->prepare("SELECT * FROM `ipcr_output_table` WHERE half = '1' AND year = $yearSelected AND `emp_id` = ?");
    $ipcrOutputQuery2 = $con->prepare("SELECT * FROM `ipcr_output_table` WHERE half = '2' AND year = $yearSelected AND `emp_id` = ?");
    
    $yearQuery = $conn->prepare("SELECT `year` FROM `performance_rating_year` ORDER BY `year` DESC");
    $yearQuery->execute();
    $yearQueryResult = $yearQuery->fetchAll(PDO::FETCH_ASSOC);

    $result = $personalInfo->get_allIpcr();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){

            $ipcr1Exist = 'disabled';
            $ipcr2Exist = 'disabled';
            $ipcrTargetExist = 'disabled';

            $eye1 = 'btn-outline-light';
            $eye2 = 'btn-outline-light';
            $eye3 = 'btn-outline-light';

            $calc1 = 'btn-outline-light';
            $calc2 = 'btn-outline-light';

            $prompt1 = 'Are you sure you want to upload this file??';
            $prompt2 = 'Are you sure you want to upload this file??';
            $prompt3 = 'Are you sure you want to upload this file??';

            $ipcrQuery->execute(array($row['empno']));
            $ipcrQueryResult = $ipcrQuery->fetchAll(PDO::FETCH_ASSOC);
            foreach ($ipcrQueryResult as $ipcrCheck){
                                                    
                if($ipcrCheck['firsthalf'] == 1){
                    $ipcr1Exist = '';
                    $eye1 = '';
                    $calc1 = 'btn-outline-danger';
                    $prompt1 = 'File already exists; uploading another file will result in overwriting it!! Proceed??';

                }
                if($ipcrCheck['secondhalf'] == 1){
                    $ipcr2Exist = '';
                    $eye2 = '';
                    $calc2 = 'btn-outline-danger';
                    $prompt2 = 'File already exists; uploading another file will result in overwriting it!! Proceed??';

                }
                if($ipcrCheck['target'] == 1){
                    $ipcrTargetExist = '';
                    $eye3 = '';
                    $prompt3 = 'File already exists; uploading another file will result in overwriting it!! Proceed??';

                }
                
            }

            //need to bind params for localhost 192.168.1.16

            $ipcrOutputQuery1->bind_param('s', $row['empno']);
            $ipcrOutputQuery1->execute();
            // $ipcrOutputQuery1->execute(array($row['empno']));
            $ipcrOutputQueryResult1 = $ipcrOutputQuery1->get_result();
            if($ipcrOutputQueryResult1->num_rows > 0){
                $calc1 = 'btn-outline-success';
            }

            $ipcrOutputQuery2->bind_param('s', $row['empno']);
            $ipcrOutputQuery2->execute();
            // $ipcrOutputQuery2->execute(array($row['empno']));
            $ipcrOutputQueryResult2 = $ipcrOutputQuery2->get_result();
            if($ipcrOutputQueryResult2->num_rows > 0){
                $calc2 = 'btn-outline-success';
            }

            echo '<tr id="ipcrRow' . $row['empno'] . '">
            <td style="vertical-align: middle;">
            <button id="editBtn'. $row['empno'] .'" class="btn btn-outline-success p-1" type="button"><i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 25px;"></i></button>
            <button id="deleteBtn'. $row['empno'] .'" class="btn btn-outline-danger p-1" type="button"><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 25px;"></i></button>
            </td>
            <td style="vertical-align: middle;">'. $row['empno'] .'</td>
            <td style="vertical-align: middle;">'.$row['sname'].'</td>
            <td style="vertical-align: middle;">'.$row['fname'].'</td>
            <td style="vertical-align: middle;">'.$row['mname'].'</td>
            <td style="vertical-align: middle;">'.$row['ext'].'</td>' .
//1st Row Display
            '<td style="text-align: center; vertical-align: middle;">' .         
            '<form id="uploadFile1' . $row['empno'] . '" enctype="multipart/form-data">' .
            '<button class="btn btn-outline-success '. $eye1 .' p-1" id="viewBtn1' . $row['empno'] . '" type="button" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ' . $ipcr1Exist . '><i class="fa fa-eye" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<button type="button" class="btn '. $calc1 . ' p-1" id="computeBtn1' . $row['empno'] . '" style="font-weight: 700; margin-right: 15px;" ' . $ipcr1Exist . '><i class="fa fa-calculator" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<button id="deleteBtn'. $row['empno'] .'" class="btn btn-outline-danger p-1" type="button"><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 25px;"></i></button>'.
            '<input type="hidden" name="ipcrUp" value="">' .            
            '<input type="hidden" name="ipcr1" value="">' .            
            '<input type="hidden" name="empNo" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            '<input type="hidden" name="yearSelected" id="yearSelected' . $row['empno'] . '" value="'. $yearSelected .'">' .
            '<input type ="file" class="form-control" name="pcrDocs" id="uploadFileSelect1' . $row['empno'] . '" accept=".pdf" required style="width: 225px; display: inline-block; margin-right: 10px;">' .
            '<button type="button" class="btn btn-outline-primary btn-outline-light" id="uploadBtn1' . $row['empno'] . '" disabled style="font-weight: 700;"><i class="fa fa-upload" aria-hidden="true"></i></button>' .
            '</form>' .
            '</td>' .


//2nd Row Display
            '<td style="text-align: center; vertical-align: middle;">' .
            '2nd_TEST'.
            '<form id="uploadFile2' . $row['empno'] . '" enctype="multipart/form-data">' .
            '<button class="btn btn-outline-success '. $eye2 .' p-1" id="viewBtn2' . $row['empno'] . '" type="button" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ' . $ipcr2Exist . '><i class="fa fa-eye" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<button type="button" class="btn '. $calc2 . ' p-1" id="computeBtn2' . $row['empno'] . '" style="font-weight: 700; margin-right: 15px;" ' . $ipcr2Exist . '><i class="fa fa-calculator" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<button id="deleteBtn'. $row['empno'] .'" class="btn btn-outline-danger p-1" type="button"><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 25px;"></i></button>'.
            '<input type="hidden" name="ipcrUp" value="">' .            
            '<input type="hidden" name="ipcr2" value="">' .            
            '<input type="hidden" name="empNo" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            '<input type="hidden" name="yearSelected" id="yearSelected' . $row['empno'] . '" value="'. $yearSelected .'">' .
            '<input type ="file" class="form-control" name="pcrDocs" id="uploadFileSelect2' . $row['empno'] . '" accept=".pdf" required style="width: 225px; display: inline-block; margin-right: 10px;">' .
            '<button type="button" class="btn btn-outline-primary btn-outline-light" id="uploadBtn2' . $row['empno'] . '"  value="Submit" disabled style="font-weight: 700;"><i class="fa fa-upload" aria-hidden="true"></i></button>' .
            '</form>' .
            '</td>' .

            '<td style="text-align: center; vertical-align: middle;">' .
            '<form id="uploadFile3' . $row['empno'] . '" enctype="multipart/form-data">' .
            '<button class="btn btn-outline-success '. $eye3 .' p-1" id="viewBtnTarget' . $row['empno'] . '" type="button" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ' . $ipcrTargetExist . '><i class="fa fa-eye" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<input type="hidden" name="ipcrUp" value="">' .            
            '<input type="hidden" name="ipcrTarget" value="">' .            
            '<input type="hidden" name="empNo" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            '<input type="hidden" name="yearSelected" id="yearSelected' . $row['empno'] . '" value="'. $yearSelected .'">' .
            '<input type ="file" class="form-control" name="pcrDocs" id="uploadFileSelect3' . $row['empno'] . '" accept=".pdf" required style="width: 225px; display: inline-block; margin-right: 10px;">' .
            '<button type="button" class="btn btn-outline-primary btn-outline-light" id="uploadBtn3' . $row['empno'] . '"  value="Submit" disabled style="font-weight: 700;"><i class="fa fa-upload" aria-hidden="true"></i></button>' .
            '</form>' .
            '</td>' .
            '</tr>';


            echo '<script>' .
        
            '$("#viewBtn1' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        ipcrView: true,
                        semiSelected: \'1st\',
                        yearSelect:yearSelect,
                        folderSelect:\'IPCR\'
                    },
                    url:"proc_performanceRatingView.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - 1st";
                    $("#pendingView").html(data)
                    }
                })

            })

            $("#viewBtn2' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        ipcrView: true,
                        semiSelected: \'2nd\',
                        yearSelect:yearSelect,
                        folderSelect:\'IPCR\'
                    },
                    url:"proc_performanceRatingView.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - 2nd";
                    $("#pendingView").html(data)
                    }
                })

            })

            $("#viewBtnTarget' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        ipcrView: true,
                        semiSelected: \'Target\',
                        yearSelect:yearSelect,
                        folderSelect:\'IPCR\'
                    },
                    url:"proc_performanceRatingView.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - Target";
                    $("#pendingView").html(data)
                    }
                })

            })


            $(document).on(\'change\', \'#uploadFileSelect1' . $row['empno'] . '\', function () {
                            document.getElementById("uploadBtn1' . $row['empno'] . '").disabled = false;
                            $( "#uploadBtn1' . $row['empno'] . '" ).removeClass("btn-outline-light");
            });

            $(document).on(\'change\', \'#uploadFileSelect2' . $row['empno'] . '\', function () {
                            document.getElementById("uploadBtn2' . $row['empno'] . '").disabled = false;
                            $( "#uploadBtn2' . $row['empno'] . '" ).removeClass("btn-outline-light");
            });
            
            $(document).on(\'change\', \'#uploadFileSelect3' . $row['empno'] . '\', function () {
                            document.getElementById("uploadBtn3' . $row['empno'] . '").disabled = false;
                            $( "#uploadBtn3' . $row['empno'] . '" ).removeClass("btn-outline-light");
            });' . 


            '$("#uploadBtn1' . $row['empno'] . '").click(function(){
                $("#uploadFile1' . $row['empno'] . '").submit();
            });

            $("#uploadBtn2' . $row['empno'] . '").click(function(){
                $("#uploadFile2' . $row['empno'] . '").submit();
            });

             $("#uploadBtn3' . $row['empno'] . '").click(function(){
                $("#uploadFile3' . $row['empno'] . '").submit();
            });' .


            '$("#uploadFile1' . $row['empno'] . '").on(\'submit\', function(e){
                e.preventDefault();

                if(confirm(\'' . $prompt1 . '\')){

                    $.ajax({
                        type: "POST",
                        url: "fileUpload.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data){
                            iziToast.success({
                                position: "center",
                                timeout: 1500,
                                title: "OK",
                                message: "File uploaded Successfully!!",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
    
                            document.getElementById("uploadBtn1' . $row['empno'] . '").disabled = true;
                            $( "#uploadBtn1' . $row['empno'] . '" ).addClass("btn-outline-light");
    
                            $( "#viewBtn1' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("viewBtn1' . $row['empno'] . '").disabled = false;

                            $( "#computeBtn1' . $row['empno'] . '" ).addClass("btn-outline-danger");
                            $( "#computeBtn1' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("computeBtn1' . $row['empno'] . '").disabled = false;

    
                            $("#uploadFileSelect1' . $row['empno'] . '").val("");
    
                        },
                        error: function() {
                            iziToast.error({
                                position: "center",
                                title: "",
                                message: "Something went wrong..",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
                        }
                    })
                    
                }
                
            });

            $("#uploadFile2' . $row['empno'] . '").on(\'submit\', function(e){
                e.preventDefault();
                
                if(confirm(\'' . $prompt2 . '\')){

                    $.ajax({
                        type: "POST",
                        url: "fileUpload.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(){
                            iziToast.success({
                                position: "center",
                                timeout: 1500,
                                title: "OK",
                                message: "File uploaded Successfully!!",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
    
                            document.getElementById("uploadBtn2' . $row['empno'] . '").disabled = true;
                            $( "#uploadBtn2' . $row['empno'] . '" ).addClass("btn-outline-light");
    
                            $( "#viewBtn2' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("viewBtn2' . $row['empno'] . '").disabled = false;

                            $( "#computeBtn2' . $row['empno'] . '" ).addClass("btn-outline-danger");
                            $( "#computeBtn2' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("computeBtn2' . $row['empno'] . '").disabled = false;
    
                            $("#uploadFileSelect2' . $row['empno'] . '").val("");
    
                        },
                        error: function() {
                            iziToast.error({
                                position: "center",
                                title: "",
                                message: "Something went wrong..",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
                        }
                    })
                    
                }


            });

            $("#uploadFile3' . $row['empno'] . '").on(\'submit\', function(e){
                e.preventDefault();

                if(confirm(\'' . $prompt3 . '\')){

                    $.ajax({
                        type: "POST",
                        url: "fileUpload.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(){
                            iziToast.success({
                                position: "center",
                                timeout: 1500,
                                title: "OK",
                                message: "File uploaded Successfully!!",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
    
                            document.getElementById("uploadBtn3' . $row['empno'] . '").disabled = true;
                            $( "#uploadBtn3' . $row['empno'] . '" ).addClass("btn-outline-light");
    
                            $( "#viewBtnTarget' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("viewBtnTarget' . $row['empno'] . '").disabled = false;
    
                            $("#uploadFileSelect3' . $row['empno'] . '").val("");
    
                        },
                        error: function() {
                            iziToast.error({
                                position: "center",
                                title: "",
                                message: "Something went wrong..",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
                        }
                    })
                    
                }
                

            });' .

            '$("#computeBtn1' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        semiSelected: \'1\',
                        yearSelect:yearSelect,
                    },
                    url:"proc_ipcrComputation.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel2").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - 1st";
                    $("#computeRatingView").html(data)
                    }
                })

                setTimeout(function() {
                    $(\'#staticBackdrop2\').modal(\'show\');
                }, 500);
                

            });' .

            '$("#computeBtn2' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        semiSelected: \'2\',
                        yearSelect:yearSelect,
                    },
                    url:"proc_ipcrComputation.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel2").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - 1st";
                    $("#computeRatingView").html(data)
                    }
                })

                setTimeout(function() {
                    $(\'#staticBackdrop2\').modal(\'show\');
                }, 500);
                

            });' .

            '$("#editBtn'. $row['empno'] .'").on("click",function (e){

                document.getElementById("ipcrEmpNo").value = "'. $row['empno'] .'";
                document.getElementById("editIpcrNo").value = "'. $row['empno'] .'";
                document.getElementById("editsname").value = "'. $row['sname'] .'";
                document.getElementById("editfname").value = "'. $row['fname'] .'";
                document.getElementById("editmname").value = "'. $row['mname'] .'";
                document.getElementById("editext").value = "'. $row['ext'] .'";
                setTimeout(function() {
                    $(\'#staticBackdrop3\').modal(\'show\');
                }, 500);
                

            });' .

            '$("#deleteBtn'. $row['empno'] .'").on("click",function (e){

                iziToast.error({
                    timeout: 15000,
                    close: false,
                    overlay: true,
                    displayMode: \'once\',
                    id: \'question\',
                    zindex: 999,
                    title: \'' . $row['sname'] . ', ' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['ext'] . '\',
                    titleSize: "25",
                    message: \'Confirm Delete??\',
                    messageSize: "30",
                    position: \'center\',
                    buttons: [
                        [\'<button><b>YES</b></button>\', function (instance, toast) {
                
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');                                    

                            $.ajax({
                                data: {
                                    delIpcr: true,
                                    delIpcrNo: \''. $row['empno'] .'\'            
                                },
                                    type: "POST",
                                    url: "upload_ipcrEncoding.php",
                                    success: function(data){
                                    if (data == "success"){
                                        iziToast.error({
                                            timeout: 1500,
                                            position: "center",
                                            title: "Record Deleted!",
                                            messageSize: "30",
                                            titleSize: "25",
                                            message: ""
                                        });
                                        document.getElementById("ipcrRow' . $row['empno'] . '").style.display = "none";
                                    } else {
                                    }
                                    }
                                })

                            
                
                        }, true],
                        [\'<button>NO</button>\', function (instance, toast) {
                
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');
                
                        }],
                    ]
                });

            });' .

            '</script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
        }   
    }
    else{
        echo '<tr><td colspan="10" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}


function searchPersonalInfo($personalInfo){
    $name = $_POST['searchBar']."%";
    $fil = $_POST['fil'];
    $regionFil = $_POST['regionFil'];

    include 'connection.php';

    $yearSelected = $_POST['yearSelected'];

    $ipcrQuery = $conn->prepare("SELECT pds.empno, ipcr_monitoring_table.firsthalf, ipcr_monitoring_table.secondhalf, ipcr_monitoring_table.target FROM ipcr_encoding_table AS pds INNER JOIN ipcr_monitoring_table ON pds.empno = ipcr_monitoring_table.empno WHERE ipcr_monitoring_table.year = '$yearSelected' AND ipcr_monitoring_table.empno = ?");

    $ipcrOutputQuery1 = $con->prepare("SELECT * FROM `ipcr_output_table` WHERE half = '1' AND year = $yearSelected AND `emp_id` = ?");
    $ipcrOutputQuery2 = $con->prepare("SELECT * FROM `ipcr_output_table` WHERE half = '2' AND year = $yearSelected AND `emp_id` = ?");
    
    $yearQuery = $conn->prepare("SELECT `year` FROM `performance_rating_year` ORDER BY `year` DESC");
    $yearQuery->execute();
    $yearQueryResult = $yearQuery->fetchAll(PDO::FETCH_ASSOC);

    $result = $personalInfo->get_wldcrdMonitoringTbl($fil,$regionFil,$name);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){

            $ipcr1Exist = 'disabled';
            $ipcr2Exist = 'disabled';
            $ipcrTargetExist = 'disabled';

            $eye1 = 'btn-outline-light';
            $eye2 = 'btn-outline-light';
            $eye3 = 'btn-outline-light';

            $calc1 = 'btn-outline-light';
            $calc2 = 'btn-outline-light';

            $prompt1 = 'Are you sure you want to upload this file??';
            $prompt2 = 'Are you sure you want to upload this file??';
            $prompt3 = 'Are you sure you want to upload this file??';

            $ipcrQuery->execute(array($row['empno']));
            $ipcrQueryResult = $ipcrQuery->fetchAll(PDO::FETCH_ASSOC);
            foreach ($ipcrQueryResult as $ipcrCheck){
                                                      
                if($ipcrCheck['firsthalf'] == 1){
                    $ipcr1Exist = '';
                    $eye1 = '';
                    $calc1 = 'btn-outline-danger';
                    $prompt1 = 'File already exists; uploading another file will result in overwriting it!! Proceed??';

                }
                if($ipcrCheck['secondhalf'] == 1){
                    $ipcr2Exist = '';
                    $eye2 = '';
                    $calc2 = 'btn-outline-danger';
                    $prompt2 = 'File already exists; uploading another file will result in overwriting it!! Proceed??';

                }
                if($ipcrCheck['target'] == 1){
                    $ipcrTargetExist = '';
                    $eye3 = '';
                    $prompt3 = 'File already exists; uploading another file will result in overwriting it!! Proceed??';

                }
                
              }

            //need to bind params for localhost 192.168.1.16

            $ipcrOutputQuery1->bind_param('s', $row['empno']);
            $ipcrOutputQuery1->execute();
            // $ipcrOutputQuery1->execute(array($row['empno']));
            $ipcrOutputQueryResult1 = $ipcrOutputQuery1->get_result();
            if($ipcrOutputQueryResult1->num_rows > 0){
                $calc1 = 'btn-outline-success';
            }

            //need to bind params for localhost 192.168.1.16

            $ipcrOutputQuery2->bind_param('s', $row['empno']);
            $ipcrOutputQuery2->execute();
            // $ipcrOutputQuery2->execute(array($row['empno']));
            $ipcrOutputQueryResult2 = $ipcrOutputQuery2->get_result();
            if($ipcrOutputQueryResult2->num_rows > 0){
                $calc2 = 'btn-outline-success';
            }

            echo '<tr id="ipcrRow' . $row['empno'] . '">
            <td style="vertical-align: middle;">
            test
            <button id="editBtn'. $row['empno'] .'" class="btn btn-outline-success p-1" type="button"><i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 25px;"></i></button>
            <button id="deleteBtn'. $row['empno'] .'" class="btn btn-outline-danger p-1" type="button"><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 25px;"></i></button>
            </td>
            <td style="vertical-align: middle;">'. $row['empno'] .'</td>
            <td style="vertical-align: middle;">'.$row['sname'].'</td>
            <td style="vertical-align: middle;">'.$row['fname'].'</td>
            <td style="vertical-align: middle;">'.$row['mname'].'</td>
            <td style="vertical-align: middle;">'.$row['ext'].'</td>' .

            '<td style="text-align: center; vertical-align: middle;">' .            
            '<form id="uploadFile1' . $row['empno'] . '" enctype="multipart/form-data">' .
            '<button class="btn btn-outline-success '. $eye1 .' p-1" id="viewBtn1' . $row['empno'] . '" type="button" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ' . $ipcr1Exist . '><i class="fa fa-eye" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<button type="button" class="btn '. $calc1 . ' p-1" id="computeBtn1' . $row['empno'] . '" style="font-weight: 700; margin-right: 15px;" ' . $ipcr1Exist . '><i class="fa fa-calculator" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<input type="hidden" name="ipcrUp" value="">' .            
            '<input type="hidden" name="ipcr1" value="">' .            
            '<input type="hidden" name="empNo" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            '<input type="hidden" name="yearSelected" id="yearSelected' . $row['empno'] . '" value="'. $yearSelected .'">' .
            '<input type ="file" class="form-control" name="pcrDocs" id="uploadFileSelect1' . $row['empno'] . '" accept=".pdf" required style="width: 225px; display: inline-block; margin-right: 10px;">' .
            '<button type="button" class="btn btn-outline-primary btn-outline-light" id="uploadBtn1' . $row['empno'] . '" disabled style="font-weight: 700;"><i class="fa fa-upload" aria-hidden="true"></i></button>' .
            '</form>' .
            '</td>' .

            '<td style="text-align: center; vertical-align: middle;">' .
            '<form id="uploadFile2' . $row['empno'] . '" enctype="multipart/form-data">' .
            '<button class="btn btn-outline-success '. $eye2 .' p-1" id="viewBtn2' . $row['empno'] . '" type="button" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ' . $ipcr2Exist . '><i class="fa fa-eye" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<button type="button" class="btn '. $calc2 . ' p-1" id="computeBtn2' . $row['empno'] . '" style="font-weight: 700; margin-right: 15px;" ' . $ipcr2Exist . '><i class="fa fa-calculator" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<input type="hidden" name="ipcrUp" value="">' .            
            '<input type="hidden" name="ipcr2" value="">' .            
            '<input type="hidden" name="empNo" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            '<input type="hidden" name="yearSelected" id="yearSelected' . $row['empno'] . '" value="'. $yearSelected .'">' .
            '<input type ="file" class="form-control" name="pcrDocs" id="uploadFileSelect2' . $row['empno'] . '" accept=".pdf" required style="width: 225px; display: inline-block; margin-right: 10px;">' .
            '<button type="button" class="btn btn-outline-primary btn-outline-light" id="uploadBtn2' . $row['empno'] . '"  value="Submit" disabled style="font-weight: 700;"><i class="fa fa-upload" aria-hidden="true"></i></button>' .
            '</form>' .
            '</td>' .

            '<td style="text-align: center; vertical-align: middle;">' .
            '<form id="uploadFile3' . $row['empno'] . '" enctype="multipart/form-data">' .
            '<button class="btn btn-outline-success '. $eye3 .' p-1" id="viewBtnTarget' . $row['empno'] . '" type="button" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ' . $ipcrTargetExist . '><i class="fa fa-eye" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '<input type="hidden" name="ipcrUp" value="">' .            
            '<input type="hidden" name="ipcrTarget" value="">' .            
            '<input type="hidden" name="empNo" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            '<input type="hidden" name="yearSelected" id="yearSelected' . $row['empno'] . '" value="'. $yearSelected .'">' .
            '<input type ="file" class="form-control" name="pcrDocs" id="uploadFileSelect3' . $row['empno'] . '" accept=".pdf" required style="width: 225px; display: inline-block; margin-right: 10px;">' .
            '<button type="button" class="btn btn-outline-primary btn-outline-light" id="uploadBtn3' . $row['empno'] . '"  value="Submit" disabled style="font-weight: 700;"><i class="fa fa-upload" aria-hidden="true"></i></button>' .
            '</form>' .
            '</td>' .
            '</tr>';


            echo '<script>' .
        
            '$("#viewBtn1' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        ipcrView: true,
                        semiSelected: \'1st\',
                        yearSelect:yearSelect,
                        folderSelect:\'IPCR\'
                    },
                    url:"proc_performanceRatingView.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - 1st";
                    $("#pendingView").html(data)
                    }
                })

            })

            $("#viewBtn2' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        ipcrView: true,
                        semiSelected: \'2nd\',
                        yearSelect:yearSelect,
                        folderSelect:\'IPCR\'
                    },
                    url:"proc_performanceRatingView.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - 2nd";
                    $("#pendingView").html(data)
                    }
                })

            })

            $("#viewBtnTarget' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        ipcrView: true,
                        semiSelected: \'Target\',
                        yearSelect:yearSelect,
                        folderSelect:\'IPCR\'
                    },
                    url:"proc_performanceRatingView.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - Target";
                     $("#pendingView").html(data)
                    }
                  })

              })


              $(document).on(\'change\', \'#uploadFileSelect1' . $row['empno'] . '\', function () {
                            document.getElementById("uploadBtn1' . $row['empno'] . '").disabled = false;
                            $( "#uploadBtn1' . $row['empno'] . '" ).removeClass("btn-outline-light");
             });

              $(document).on(\'change\', \'#uploadFileSelect2' . $row['empno'] . '\', function () {
                            document.getElementById("uploadBtn2' . $row['empno'] . '").disabled = false;
                            $( "#uploadBtn2' . $row['empno'] . '" ).removeClass("btn-outline-light");
             });
             
              $(document).on(\'change\', \'#uploadFileSelect3' . $row['empno'] . '\', function () {
                            document.getElementById("uploadBtn3' . $row['empno'] . '").disabled = false;
                            $( "#uploadBtn3' . $row['empno'] . '" ).removeClass("btn-outline-light");
             });' . 


            '$("#uploadBtn1' . $row['empno'] . '").click(function(){
                $("#uploadFile1' . $row['empno'] . '").submit();
            });

             $("#uploadBtn2' . $row['empno'] . '").click(function(){
                $("#uploadFile2' . $row['empno'] . '").submit();
            });

             $("#uploadBtn3' . $row['empno'] . '").click(function(){
                $("#uploadFile3' . $row['empno'] . '").submit();
            });' .


            '$("#uploadFile1' . $row['empno'] . '").on(\'submit\', function(e){
                e.preventDefault();

                if(confirm(\'' . $prompt1 . '\')){

                    $.ajax({
                        type: "POST",
                        url: "fileUpload.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data){
                            iziToast.success({
                                position: "center",
                                timeout: 1500,
                                title: "OK",
                                message: "File uploaded Successfully!!",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
    
                            document.getElementById("uploadBtn1' . $row['empno'] . '").disabled = true;
                            $( "#uploadBtn1' . $row['empno'] . '" ).addClass("btn-outline-light");
    
                            $( "#viewBtn1' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("viewBtn1' . $row['empno'] . '").disabled = false;

                            $( "#computeBtn1' . $row['empno'] . '" ).addClass("btn-outline-danger");
                            $( "#computeBtn1' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("computeBtn1' . $row['empno'] . '").disabled = false;

    
                            $("#uploadFileSelect1' . $row['empno'] . '").val("");
    
                        },
                        error: function() {
                            iziToast.error({
                                position: "center",
                                title: "",
                                message: "Something went wrong..",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
                        }
                    })
                    
                }
                

            });

            $("#uploadFile2' . $row['empno'] . '").on(\'submit\', function(e){
                e.preventDefault();
                
                if(confirm(\'' . $prompt2 . '\')){

                    $.ajax({
                        type: "POST",
                        url: "fileUpload.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(){
                            iziToast.success({
                                position: "center",
                                timeout: 1500,
                                title: "OK",
                                message: "File uploaded Successfully!!",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
    
                            document.getElementById("uploadBtn2' . $row['empno'] . '").disabled = true;
                            $( "#uploadBtn2' . $row['empno'] . '" ).addClass("btn-outline-light");
    
                            $( "#viewBtn2' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("viewBtn2' . $row['empno'] . '").disabled = false;

                            $( "#computeBtn2' . $row['empno'] . '" ).addClass("btn-outline-danger");
                            $( "#computeBtn2' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("computeBtn2' . $row['empno'] . '").disabled = false;
    
                            $("#uploadFileSelect2' . $row['empno'] . '").val("");
    
                        },
                        error: function() {
                            iziToast.error({
                                position: "center",
                                title: "",
                                message: "Something went wrong..",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
                        }
                    })
                    
                }


            });

            $("#uploadFile3' . $row['empno'] . '").on(\'submit\', function(e){
                e.preventDefault();

                if(confirm(\'' . $prompt3 . '\')){

                    $.ajax({
                        type: "POST",
                        url: "fileUpload.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(){
                            iziToast.success({
                                position: "center",
                                timeout: 1500,
                                title: "OK",
                                message: "File uploaded Successfully!!",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
    
                            document.getElementById("uploadBtn3' . $row['empno'] . '").disabled = true;
                            $( "#uploadBtn3' . $row['empno'] . '" ).addClass("btn-outline-light");
    
                            $( "#viewBtnTarget' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            document.getElementById("viewBtnTarget' . $row['empno'] . '").disabled = false;
    
                            $("#uploadFileSelect3' . $row['empno'] . '").val("");
    
                        },
                        error: function() {
                            iziToast.error({
                                position: "center",
                                title: "",
                                message: "Something went wrong..",
                                messageSize: \'30\',
                                titleSize: \'25\'
                            });
                        }
                    })
                    
                }
                

            });' .

            '$("#computeBtn1' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        semiSelected: \'1\',
                        yearSelect:yearSelect,
                    },
                    url:"proc_ipcrComputation.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel2").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - 1st";
                     $("#computeRatingView").html(data)
                    }
                  })

                  setTimeout(function() {
                    $(\'#staticBackdrop2\').modal(\'show\');
                }, 500);
                  

              });' .

            '$("#computeBtn2' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        semiSelected: \'2\',
                        yearSelect:yearSelect,
                    },
                    url:"proc_ipcrComputation.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel2").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . ' - 1st";
                    $("#computeRatingView").html(data)
                    }
                })

                setTimeout(function() {
                    $(\'#staticBackdrop2\').modal(\'show\');
                }, 500);
                

            });' .

            '$("#editBtn'. $row['empno'] .'").on("click",function (e){

                document.getElementById("ipcrEmpNo").value = "'. $row['empno'] .'";
                document.getElementById("editIpcrNo").value = "'. $row['empno'] .'";
                document.getElementById("editsname").value = "'. $row['sname'] .'";
                document.getElementById("editfname").value = "'. $row['fname'] .'";
                document.getElementById("editmname").value = "'. $row['mname'] .'";
                document.getElementById("editext").value = "'. $row['ext'] .'";

                setTimeout(function() {
                    $(\'#staticBackdrop3\').modal(\'show\');
                }, 500);
                

            });' .

            '$("#deleteBtn'. $row['empno'] .'").on("click",function (e){

                iziToast.error({
                    timeout: 15000,
                    close: false,
                    overlay: true,
                    displayMode: \'once\',
                    id: \'question\',
                    zindex: 999,
                    title: \'' . $row['sname'] . ', ' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['ext'] . '\',
                    titleSize: "25",
                    message: \'Confirm Delete??\',
                    messageSize: "30",
                    position: \'center\',
                    buttons: [
                        [\'<button><b>YES</b></button>\', function (instance, toast) {
                
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');                                    

                            $.ajax({
                                data: {
                                    delIpcr: true,
                                    delIpcrNo: \''. $row['empno'] .'\'            
                                },
                                    type: "POST",
                                    url: "upload_ipcrEncoding.php",
                                    success: function(data){
                                    if (data == "success"){
                                        iziToast.error({
                                            timeout: 1500,
                                            position: "center",
                                            title: "Record Deleted!",
                                            messageSize: "30",
                                            titleSize: "25",
                                            message: ""
                                        });
                                        document.getElementById("ipcrRow' . $row['empno'] . '").style.display = "none";
                                    } else {

                                    }
                                    }
                                })

                            
                
                        }, true],
                        [\'<button>NO</button>\', function (instance, toast) {
                            
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');
                        }],
                    ]
                });
            });' .
            '</script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
        }   
    }
    else{
        echo '<tr><td colspan="10" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}
?>