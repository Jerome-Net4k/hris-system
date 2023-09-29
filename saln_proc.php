
<?php
session_start();
include 'table_uploadfile.php';
$personalInfo = new personalInfo();
if ((!isset($_POST['searchBar']) && !isset($_GET['id'])) && isset($_POST['yearSelected'])) {
    loadPersonalInfo($personalInfo);
}
if(isset($_POST['searchBar'])){
    searchPersonalInfo($personalInfo);
}

function loadPersonalInfo($personalInfo){
    
    include 'connection.php';

    $yearSelected = $_POST['yearSelected'];

    $ipcrQuery = $conn->prepare("SELECT pds.empno, saln_monitoring_table.saln, saln_monitoring_table.datetoday, saln_monitoring_table.dateupload FROM ipcr_encoding_table AS pds INNER JOIN saln_monitoring_table ON pds.empNo = saln_monitoring_table.empNo WHERE saln_monitoring_table.year = $yearSelected AND saln_monitoring_table.empNo = ?");
    
    $yearQuery = $conn->prepare("SELECT `year` FROM `performance_rating_year` ORDER BY `year` DESC");
    $yearQuery->execute();
    $yearQueryResult = $yearQuery->fetchAll(PDO::FETCH_ASSOC);

    $result = $personalInfo->get_all();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){


            $ipcr1Exist = 'disabled';

            $eye1 = 'btn-outline-light';

            $prompt1 = 'Are you sure you want to upload this file??';
// id="viewindividualchecker" value="'. $row['empno'] .'"
            echo '<tr> // data-bs-toggle="modal" data-bs-target="#listdaterecord"
            <td class="emp-view" data-value="' . $row['empno'] . '" style="vertical-align: middle;" data-bs-toggle="modal" data-bs-target="#listdaterecord"><button class="btn btn-primary"><i class="fa fa-table"></i></button></td>
            <td style="vertical-align: middle;">'. $row['empno'] .'</td>
            <td style="vertical-align: middle;">'.$row['sname'].'</td>
            <td style="vertical-align: middle;">'.$row['fname'].'</td>
            <td style="vertical-align: middle;">'.$row['mname'].'</td>';

            $ipcrQuery->execute(array($row['empno']));
            $ipcrQueryResult = $ipcrQuery->fetchAll(PDO::FETCH_ASSOC);
            foreach ($ipcrQueryResult as $ipcrCheck){                  
                if ($ipcrCheck['saln'] == 1) {
                    $dateToday = $ipcrCheck['datetoday'];
                    $dateUpload = $ipcrCheck['dateupload'];
                    $ipcr1Exist = '';
                    $eye1 = '';
                    $prompt1 = 'File already exists; uploading another file will result in overwriting it!! Proceed??';
                }
                
            }

            echo '<td style="text-align: center; vertical-align: middle;">' .
            // '<form method="post" id="uploadFile1' . $row['emp_id'] . '" enctype="multipart/form-data" action="fileUpload.php" onsubmit="return confirm(\'' . $prompt . '\');">' .
            '<form id="uploadFile1' . $row['empno'] . '" enctype="multipart/form-data">' .
            '<div class="d-flex" style="text-align: center; vertical-align: middle;">
            <button class="btn btn-outline-success '. $eye1 .' p-1" id="viewBtn1' . $row['empno'] . '" type="button" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ' . $ipcr1Exist . '><i class="fa fa-eye" aria-hidden="true" style="font-size: 25px;"  data-bs-toggle="tooltip" data-bs-placement="right" title="DE: '. $dateToday .' DU: ' . $dateUpload .'" ></i></button>' .
            '<input type="hidden" name="salnUp" value="SALN">' .    // change the value hre        
            '<input type="hidden" name="ipcr1" value="">' .            
            '<input type="hidden" name="empno" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            '<input type="hidden" name="yearSelected" id="yearSelected' . $row['empno'] . '" value="'. $yearSelected .'">' .
            '<input type ="file" class="form-control" name="pcrDocs" id="uploadFileSelect1' . $row['empno'] . '" accept=".pdf" required style="width: 250px; display: inline-block; margin-right: 10px;">' .
            '<button type="button" class="btn btn-outline-primary btn-outline-light" id="uploadBtn1' . $row['empno'] . '"  value="Submit" disabled style="font-weight: 700;">UPLOAD</button>' .
            '<div class="d-flex" style="width: 350px;">
            <select name="salnmonthselect' . $row['empno'] . '" id="salnmonthselect' . $row['empno'] . '" class="form-select btn-outline-light" style="margin-left: 10px;" disabled>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>' .

            '<select name="salndayselect' . $row['empno'] . '" id="salndayselect' . $row['empno'] . '" class="form-select btn-outline-light" style="margin-left: 10px;" disabled>
                <script>
                for (var i = 1; i < 32; i++) {
                    var option = document.createElement("option");
                    option.value = i;
                    option.text = i;
                    document.getElementById("salndayselect' . $row['empno'] . '").appendChild(option);
                }
                </script>
            </select>
            </div></div>' .

            '</form>' .
            '</td>' .
            
            '<td class="delete-file" data-value="' . $row['empno'] . ' ' . $row['sname'] . '" style="vertical-align: middle;">
                <button class="btn btn-outline-danger ' . $eye1 .' p-1" id="deletebtn' . $row['empno'] . '" type="button" style="margin-right: 10px;" ' . $ipcr1Exist . ' value="' . $row['empno'] . '">
                    <i class="fa fa-trash-o"></i>
                </button>
            </td>'

            . '</tr>';

            echo '<script>' .

            '$("#viewBtn1' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        salnView: true,
                        yearSelect:yearSelect,
                        folderSelect:\'SALN\'
                        // folder file
                    },
                    url:"saln_folderfile.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . '";
                     $("#pendingView").html(data)
                    }
                  })

              })

              $(document).on(\'change\', \'#uploadFileSelect1' . $row['empno'] . '\', function () {
                            document.getElementById("uploadBtn1' . $row['empno'] . '").disabled = false;
                            $( "#uploadBtn1' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            
                            document.getElementById("salnmonthselect' . $row['empno'] . '").disabled = false;
                            $( "#salnmonthselect' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            
                            document.getElementById("salndayselect' . $row['empno'] . '").disabled = false;
                            $( "#salndayselect' . $row['empno'] . '" ).removeClass("btn-outline-light");
             });' . 


            '$("#uploadBtn1' . $row['empno'] . '").click(function(){
                $("#uploadFile1' . $row['empno'] . '").submit();
            });' .


            '$("#uploadFile1' . $row['empno'] . '").on(\'submit\', function(e){
                e.preventDefault();
                var aa = $(this).serialize();
                // alert(aa);
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

                            $( "#deletebtn' . $row['empno'] . '").removeClass("btn-outline-light");
                            document.getElementById("deletebtn' . $row['empno'] . '").disabled = false;

                            $( "#salnmonthselect' . $row['empno'] . '" ).addClass("btn-outline-light");
                            document.getElementById("salnmonthselect' . $row['empno'] . '").disabled = true;

                            $( "#salndayselect' . $row['empno'] . '" ).addClass("btn-outline-light");
                            document.getElementById("salndayselect' . $row['empno'] . '").disabled = true;
    
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
                

            });'
            .
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

    $ipcrQuery = $conn->prepare("SELECT pds.empno, saln_monitoring_table.saln, saln_monitoring_table.datetoday FROM ipcr_encoding_table AS pds INNER JOIN saln_monitoring_table ON pds.empno = saln_monitoring_table.empNo WHERE saln_monitoring_table.year = $yearSelected AND saln_monitoring_table.empNo = ?");
    
    $yearQuery = $conn->prepare("SELECT `year` FROM `performance_rating_year` ORDER BY `year` DESC");
    $yearQuery->execute();
    $yearQueryResult = $yearQuery->fetchAll(PDO::FETCH_ASSOC);

    // $result = $personalInfo->get_PROCMonitoringTbl($fil,$regionFil,$name);
    $result = $personalInfo->get_PROCMonitoringTbl($name);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){


            $ipcr1Exist = 'disabled';

            $eye1 = 'btn-outline-light';

            $prompt1 = 'Are you sure you want to upload this file??';
// id="viewindividualchecker" value="'. $row['empno'] .'"
            echo '<tr> // data-bs-toggle="modal" data-bs-target="#listdaterecord"
            <td class="emp-view" data-value="' . $row['empno'] . '" style="vertical-align: middle;" data-bs-toggle="modal" data-bs-target="#listdaterecord"><button class="btn btn-primary"><i class="fa fa-table"></i></button></td>
            <td style="vertical-align: middle;">'. $row['empno'] .'</td>
            <td style="vertical-align: middle;">'.$row['sname'].'</td>
            <td style="vertical-align: middle;">'.$row['fname'].'</td>
            <td style="vertical-align: middle;">'.$row['mname'].'</td>';

            $ipcrQuery->execute(array($row['empno']));
            $ipcrQueryResult = $ipcrQuery->fetchAll(PDO::FETCH_ASSOC);
            foreach ($ipcrQueryResult as $ipcrCheck){                  
                if ($ipcrCheck['saln'] == 1) {
                    $dateToday = $ipcrCheck['datetoday'];
                    $dateUpload = $ipcrCheck['dateupload'];
                    $ipcr1Exist = '';
                    $eye1 = '';
                    $prompt1 = 'File already exists; uploading another file will result in overwriting it!! Proceed??';
                }
                
            }

            echo '<td style="text-align: center; vertical-align: middle;">' .
            // '<form method="post" id="uploadFile1' . $row['emp_id'] . '" enctype="multipart/form-data" action="fileUpload.php" onsubmit="return confirm(\'' . $prompt . '\');">' .
            '<form id="uploadFile1' . $row['empno'] . '" enctype="multipart/form-data">' .
            '<div class="d-flex" style="text-align: center; vertical-align: middle;">
            <button class="btn btn-outline-success '. $eye1 .' p-1" id="viewBtn1' . $row['empno'] . '" type="button" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" ' . $ipcr1Exist . '><i class="fa fa-eye" aria-hidden="true" style="font-size: 25px;"  data-bs-toggle="tooltip" data-bs-placement="right" title="DE: '. $dateToday .' DU: ' . $dateUpload .'" ></i></button>' .
            '<input type="hidden" name="salnUp" value="SALN">' .    // change the value hre        
            '<input type="hidden" name="ipcr1" value="">' .            
            '<input type="hidden" name="empno" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            '<input type="hidden" name="yearSelected" id="yearSelected' . $row['empno'] . '" value="'. $yearSelected .'">' .
            '<input type ="file" class="form-control" name="pcrDocs" id="uploadFileSelect1' . $row['empno'] . '" accept=".pdf" required style="width: 250px; display: inline-block; margin-right: 10px;">' .
            '<button type="button" class="btn btn-outline-primary btn-outline-light" id="uploadBtn1' . $row['empno'] . '"  value="Submit" disabled style="font-weight: 700;">UPLOAD</button>' .
            '<div class="d-flex" style="width: 350px;">
            <select name="salnmonthselect' . $row['empno'] . '" id="salnmonthselect' . $row['empno'] . '" class="form-select btn-outline-light" style="margin-left: 10px;" disabled>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>' .

            '<select name="salndayselect' . $row['empno'] . '" id="salndayselect' . $row['empno'] . '" class="form-select btn-outline-light" style="margin-left: 10px;" disabled>
                <script>
                for (var i = 1; i < 32; i++) {
                    var option = document.createElement("option");
                    option.value = i;
                    option.text = i;
                    document.getElementById("salndayselect' . $row['empno'] . '").appendChild(option);
                }
                </script>
            </select>
            </div></div>' .

            '</form>' .
            '</td>' .
            
            '<td class="delete-file" data-value="' . $row['empno'] . ' ' . $row['sname'] . '" style="vertical-align: middle;">
                <button class="btn btn-outline-danger ' . $eye1 .' p-1" id="deletebtn' . $row['empno'] . '" type="button" style="margin-right: 10px;" ' . $ipcr1Exist . ' value="' . $row['empno'] . '">
                    <i class="fa fa-trash-o"></i>
                </button>
            </td>'
            . '</tr>';

            echo '<script>' .

            '$("#viewBtn1' . $row['empno'] . '").on("click",function (e){

                var yearSelect = $("#yearSelect option:selected").val();
                
                $.ajax({
                    data: {
                        empId:\'' . $row['empno'] . '\',
                        sname:\'' . $row['sname'] . '\',
                        salnView: true,
                        yearSelect:yearSelect,
                        folderSelect:\'SALN\'
                        // folder file
                    },
                    url:"saln_folderfile.php",
                    type: "POST",
                    success: function(data){
                    document.getElementById("staticBackdropLabel").innerHTML = "' . $row['empno'] . ' ' . $row['sname'] . ' - ' . $yearSelected . '";
                     $("#pendingView").html(data)
                    }
                  })

              })

              $(document).on(\'change\', \'#uploadFileSelect1' . $row['empno'] . '\', function () {
                            document.getElementById("uploadBtn1' . $row['empno'] . '").disabled = false;
                            $( "#uploadBtn1' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            
                            document.getElementById("salnmonthselect' . $row['empno'] . '").disabled = false;
                            $( "#salnmonthselect' . $row['empno'] . '" ).removeClass("btn-outline-light");
                            
                            document.getElementById("salndayselect' . $row['empno'] . '").disabled = false;
                            $( "#salndayselect' . $row['empno'] . '" ).removeClass("btn-outline-light");
             });' . 


            '$("#uploadBtn1' . $row['empno'] . '").click(function(){
                $("#uploadFile1' . $row['empno'] . '").submit();
            });' .


            '$("#uploadFile1' . $row['empno'] . '").on(\'submit\', function(e){
                e.preventDefault();
                var aa = $(this).serialize();
                // alert(aa);
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

                            $( "#deletebtn' . $row['empno'] . '").removeClass("btn-outline-light");
                            document.getElementById("deletebtn' . $row['empno'] . '").disabled = false;

                            $( "#salnmonthselect' . $row['empno'] . '" ).addClass("btn-outline-light");
                            document.getElementById("salnmonthselect' . $row['empno'] . '").disabled = true;

                            $( "#salndayselect' . $row['empno'] . '" ).addClass("btn-outline-light");
                            document.getElementById("salndayselect' . $row['empno'] . '").disabled = true;
    
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
<!-- this code for button at the left side -->
<script>
    $(".emp-view").on("click", function() {
    var myid = $(this).data('value');
    // var empnum = $(".emp-view").data('value');
    // alert(myid);
        $.ajax({
            url: 'nos_select_info.php',
            type: 'GET',
            data: { id: myid },
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    $('#viewnameindividual').text(data[0].fullname);
                    $('#viewidindividual').text(data[0].empno);
                } else {
                    $('#viewnameindividual').text('No data found');
                    $('#viewidindividual').text('');
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });

        $.ajax({
            url: 'saln_indiload_year.php',
            type: 'GET',
            data: { id: myid },
            dataType: 'json',
            success: function(data) {
                var options = '';
                options += '<option value=""></option>';
                data.forEach(function(item) {
                    options += '<option value="' + item.year + '">' + item.year + '</option>';
                });
                $("#dateselect").html(options);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });

    });

    $(".delete-file").on("click", function() {
    var myidsurname = $(this).data('value');
    var myidonly = $(this).find("button").val();
    var year = $("#yearSelect").val();
    // alert(myidsurname);
    var confirmation = confirm("Please proceed with deleting this file by clicking 'OK'.");
    if (confirmation){
        $.ajax({
            url: 'saln_proc_delete.php',
            type: 'POST',
            data: {
                myidsurname: myidsurname,
                myidonly: myidonly,
                year: year
            },
            success: function(response) {
                if (response === "Deleted successfully") {
                    // iziToast.success({
                    //     title: 'DELETED',
                    //     message: 'FILE DELETED SUCCESSFULLY',
                    //     // Additional options...
                    // });
                    loadagain();
                } else {
                    iziToast.error({
                        title: 'ERROR',
                        message: 'PLEASE TRY AGAIN',
                        // Additional options...
                    });
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }
    });

    function loadagain(){
        var yearSelect = $("#yearSelect option:selected").val();
        var sortwhat = "ASC";
        var sortval = "sname";
        
            var yearSelect = $("#yearSelect option:selected").val();
            var toast = iziToast.show({
                theme: '#ffffff', // Set the theme to 'dark' (you can also use 'light')
                // title: 'Loading',
                message: '<img src="images/deletegif.gif" width="200px;" height="200px;">', // Include the path to your animated GIF
                timeout: false, // Disable timeout for the toast
                position: 'center', // Set the toast position to center
                titleColor: '#ffffff', // Set the title color
                messageColor: '#ffffff', // Set the message color
                iconColor: '#ffffff', // Set the icon color
                close: false // Disable the close button
            });
            
        $.ajax({
            data: {
            yearSelected: yearSelect,
            sortwhat:sortwhat,
            sortval:sortval
            },
            url:"coe_proc.php",
            type: "POST",
            success: function(data){
                $("#content2").html(data)
            },
            complete: function() {
                iziToast.destroy(toast);
            }
        })
    }
    

</script>