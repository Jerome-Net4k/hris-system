<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:views_login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "partials_header2.php"?>
    <title>Daily time record</title>
    <link rel="stylesheet" href="ojt_dtrform.css">
    <script src="flagcere_script.js"></script>
	<link rel="stylesheet" type="text/css" href="loading2.css">
	<script src="loading.js" defer></script>
    <link rel="stylesheet" href="arrow.css">
</head>

<body style="overflow: hidden;">
    <div class="loader"></div>
    <?php include 'navbar.php'; ?>
        <div  style="padding: 20px 0px 20px 50px">
            <h3>ATTENDANCE MONITORING</h3>
            <div class="d-flex align-items-center text-center mb-2">
                <h6>Department: </h6>
                <select class="form-select deptname" id="deptname" style="width: 15%;">
                    <?php
                    include "connection.php";
                    $sql = "SELECT * FROM attendance_department";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option>' . $row['department'] . '</option>';
                        }
                    }
                    ?>
                    <!-- <option value="HRDS">HRDS</option>
                    <option value="PROPERTY SECTION">PROPERTY SECTION</option>
                    <option value="PLATE UNIT">PLATE UNIT</option>
                    <option value="EQUIPMENT UNIT">EQUIPMENT UNIT</option> -->
                    
                </select>


                <select name="attmonth" id="attmonth" class="form-select" style="width: 8%; margin-left: 10px;">
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
                </select>

                <select name="attyear" id="attyear" class="form-select"style="width: 5%; margin-left: 10px;"></select>
                <!-- <script>
                    $(document).ready(function() {
                        var currentYear = new Date().getFullYear();
                        for (var i = currentYear; i >= currentYear - 10; i--) {
                            var option = $('<option>', {
                                value: i,
                                text: i
                            });
                            $('#attyear').append(option);
                        }
                    });
                </script> -->
            </div>

            <div class="row">
                <div class="col-7 input-group rounded" style="width: 35.5%;">
                    <span class="input-group-text">SEARCH&nbsp; <i class="bi bi-search"></i></span>
                    <input type="search" id="att-search" name="att-search" class="form-control">
                    <button class="btn btn-primary" id="search-btn"><i class="fi fi-rr-search p-1"></i>Search</button>
                </div>
            </div>
            <div class="mt-3">
                <div style="float: right; padding-right: 50px;"> <!-- Adjusted col size from col-3 to col-5 -->

                    <button class="btn" style= "background-color: #6c3ec1; color: white;" data-bs-toggle="modal" data-bs-target="#adddepart">
                        <i class="fa fa-plus-square"></i> ADD DEPARTMENT
                    </button>
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#pdffile" id="attendfile">
                        <i class="fa fa-plus-square"></i> ATTENDANCE FILES
                    </button>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createdate">
                        <i class="fa fa-plus-square"></i> CREATE DATE
                    </button>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnewpersonnel" id="addnewpersonnelform">
                        <i class="fa fa-plus-square"></i> ADD PERSON
                    </button>

                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#attendancesheet" id="attendancesheetform">
                        <i class="fa fa-plus-square"></i> ATTENDANCE SHEET
                    </button>
                </div>
                <h1 id="title-change">title here</h1>
            </div>
        </div>

        <div class="dtr-table" style="padding: 0 50px;">
            <div class="day-scroll" style="height: 700px;">
            <table class="table table-bordered table-hover" style="position: sticky; background-color: white; top: 0;">
                <thead style="position: sticky; background-color: white; top: 0;">
                    <tr class="text-center" style="position: sticky; background-color: white; top: 0;">
                        <div style="position: absolute; z-index: 100;">
                            <th style="width: 50px; position: sticky; left: 0; top: 0; background: white; z-index: 20"></th>
                            <th style="width: 100px; position: sticky; left: 0; top: 0; background: white; z-index: 20">#.</th>
                            <th style="width: 350px; position: sticky; left: 0; top: 0; background: white; z-index: 20">
                                <div class="d-flex justify-content-center firstnamesort">Name
                                    <div class="sort" data-value="name">
                                        <div class="arrow arrow1 chevron1"></div>
                                    </div>
                                </div>
                            </th>
                            <th style="width: 100px; position: sticky; left: 0; top: 0; background: white; z-index: 20">JOB<br>STATUS</th>
                        </div>
                        
                        <th style="padding: 0; margin: 0;">
                            <div class="d-flex justify-content-center">
                                <p id="monthdisplay"></p> 
                                <!-- &nbsp;
                                <label style="cursor: pointer;"><i class="bi bi-pencil-square"></i></label> -->
                            </div>
                            <hr><div class="border-right in-out d-flex justify-content-center" id="headerdate">
                                
                            </div>
                        </th>
                        <th style="width: 150px;">Monthly<br>attendance<br>total</th>
                        <th style="width: 150px;">Total <br>attendance <br>annual basis.</th>
                        <th style="width: 150px;">Overall <br>attendance<br>count.</th>
                    </tr>
                </thead>
                <tbody id="listperdepartment">

                </tbody>
                
            </table>
            
            </div>
        </div>
    </div>


    <div class="modal fade" id="adddepart" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">DEPARTMEENT INFORMATION</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <p class="mb-2"><b>Note: </b>Please verify the name of the department you have entered!</p>
                    <div class="form-floating">
                        <input type="text" id="newdepartment" name="newdepartment" class="form-control required" required>
                        <label for="sname">NAME OF DEPARTMENT</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="addnewdepartment"><i class="bi bi-house-add-fill"></i></button>
                </div>
                
            </div>
        </div>
    </div>
<!-- attendance sheet -->
    <div class="modal fade" id="attendancesheet" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="attendancesheetLabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                         <div class="d-flex align-items-center text-center mb-2">
                            <h6><b>DATE:</b> &nbsp; </h6>
                            <h6 id="monthselected"></h6> &nbsp; 
                            <select name="dayattendance" id="dayattendance" class="form-select" style="width: auto; margin-left: 10px;">
                            
                            </select> &nbsp; 
                                <h6 id="yearselected"></h6> &nbsp; 
                            </div>
                        </div>
                    <h4 class="modal-title text-center mb-2">FLAG CEREMORY ATTENDANCE SHEET</h4>
                    <div id="attendancechecklist">

                    </div>
                </div>
                
            </div>
        </div>
    </div>

<!-- create date directory -->
    <div class="modal fade" id="createdate" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createdatelabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex align-items-center text-center mb-2">
                        <h6><b>SELECT DAY: </b></h6>
                        <select name="daycreate" id="daycreate" class="form-select" style="width: auto; margin-left: 10px;"></select> &nbsp; 
                            <script>
                                // Create date options for the past 31 days
                                var select = document.getElementById("daycreate");
                                for (var i = 1; i <= 31; i++) {
                                    var option = document.createElement("option");
                                    option.value = i.toString();
                                    option.text = i.toString();
                                    select.appendChild(option);
                                }
                            </script>
                        </div>
                    </div>
                </div>
                <!-- <button type="submit" class="btn btn-primary" id="createdirdate"><i class="bi bi-calendar-plus"></i></button>
                <button type="submit" class="btn btn-danger" id="deletedirdate"><i class="bi bi-trash3"></i></button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editdate" id="editdirdate"><i class="bi bi-pencil-square"></i></button> -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="createdirdate"><i class="bi bi-calendar-plus"></i></button>
                    
                    <!-- <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletedate" id="deletelabelinfo"><i class="bi bi-trash3"></i></button>
                    
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editdate" id="editlabelinfo"><i class="bi bi-pencil-square"></i></button> -->
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- edit/delete option date here -->
    <div class="modal fade" id="editdate" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">DATE UPDATE DIRECTORY</h4>
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <div class="row"> -->
                        <!-- <div class="d-flex align-items-center text-center mb-2"> -->
                        <p class="text-center mt-2" style="font-size: 15px;">You are making a selection for the date <b id="editdateinfomonth" style="color: #0d6efd; font-size: 18px"></b> <b id="editdateinfoday" style="color: #0d6efd; font-size: 18px"></b> <b id="editdateinfoyear" style="color: #0d6efd; font-size: 18px"></b> you are presented with two choices: <b>DELETE or UPDATE.</b></p>
                        
                    <!-- </div> -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletedate" id="deletelabelinfo">DELETE</button>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editdaterecord">UPDATE</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- delete date here -->
    <div class="modal fade" id="deletedate" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deletedateinfo"></h4>
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#editdate" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex align-items-center text-center">
                            <p class="text-center"><b style="font-size: 18px;">ARE YOU SURE DO YOU WANT TO <i style="color: red;">DELETE</i> THIS DATE?</b></p>
                        </div>
                        <div class="form-floating">
                            <input type="text" id="deltypeyes" name="deltypeyes" class="form-control required" required>
                            <label for="sname">Type YES/yes to continue...</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deletedirdate"><i class="bi bi-trash3"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit date infomation -->
    <div class="modal fade" id="editdaterecord" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editdateheader"></h4>
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#editdate" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: 25px;">
                    <p class="text-center mt-2"><strong>UPDATE<br>TO</strong></p>
                    <div class="d-flex justify-content-center">
                        <strong><label for="" id="monthupdate"></label></strong>
                        
                        <select name="dayupdate" id="dayupdate" class="form-select" style="width: auto; margin-left: 10px;"></select>
                            <script>
                                // Create date options for the past 31 days
                                var select = document.getElementById("dayupdate");
                                for (var i = 1; i <= 31; i++) {
                                    var option = document.createElement("option");
                                    option.value = i.toString();
                                    option.text = i.toString();
                                    select.appendChild(option);
                                }
                            </script>
                    <strong><label for="" id="yearupdate"></label></strong>
                    </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="updatedirdate"><i class="bi bi-pencil-square"></i></button>
                </div>
            </div>
        </div>
    </div>


<!-- add personnel -->

    <div class="modal fade" id="addnewpersonnel" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ADD FORM</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="text-center mt-3">
                        <h4 class="modal-title">EMPLOYEE INFORMATION</h4>
                        <p>All fields are requied</p>
                    </div>

                <form id="attnewform" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-floating mb-2">
                                <input type="text" id="attempno" name="attempno" placeholder="" class="form-control required" required>
                                <label for="attempno">Employee ID</label>
                            </div>
                        </div>

                    </div> 
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" id="attempname" name="attempname" placeholder="" class="form-control required" required>
                                <label for="attempname">Employee Name</label>
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-floating mb-2">
                                <select class="form-select attdept" id="attdept" name="attdept" required>
                                    <?php
                                    include "connection.php";
                                    $sql = "SELECT * FROM attendance_department";
                                    $result = $con->query($sql);
                                    if ($result->num_rows > 0) {
                                        echo '<option></option>';
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option>' . $row['department'] . '</option>';
                                        }
                                    }
                                    ?>
                                    <!-- <option value=""></option>
                                    <option value="HRDS">HRDS</option>
                                    <option value="PROPERTY SECTION">PROPERTY SECTION</option>
                                    <option value="PLATE UNIT">PLATE UNIT</option>
                                    <option value="EQUIPMENT UNIT">EQUIPMENT UNIT</option> -->
                                </select>
                                <label for="attempname">Department</label>
                            </div>
                        </div>
                    </div> 
                    <div class="form-floating mb-2 w-25">

                        <select class="form-select attdept" id="jobstatus" name="jobstatus" required>
                            <option value=""></option>
                            <option value="APPOINTED">APPOINTED</option>
                            <option value="CASUAL">CASUAL</option>
                            <option value="CONFIDENTIAL">CONFIDENTIAL</option>
                            <option value="CONTRACTUAL">CONTRACTUAL</option>
                            <option value="CO-TERMINAL">CO-TERMINAL</option>
                            <option value="ELECTIVE">ELECTIVE</option>
                            <option value="EMERGENCY">EMERGENCY</option>
                            <option value="LUMP SUM">LUMP SUM</option>
                            <option value="PARTT TIME">PARTT TIME</option>
                            <option value="PERMANENT">PERMANENT</option>
                            <option value="PROBATIONARY">PROBATIONARY</option>
                            <option value="PROVISIONAL">PROVISIONAL</option>
                            <option value="SUBTITUTE">SUBTITUTE</option>
                            <option value="TEMPORARY">TEMPORARY</option>
                            <option value="DETAILS">DETAILS</option>
                            <option value="OTHERS">OTHERS</option>
                         </select>
                        <label for="attempname">Job status</label>
                    </div>
                </div>
                
                <label class="mb-2" style="padding-left: 20px;"><b style="color: #0d6efd;">NOTE:</b> <i>Please verify the ID you have entered once again. Unfortunately, it cannot be modified or changed.</i></label>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteperson" id="delenablebtn" disabled>DELETE</button>
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
                </form>
                
            </div>
        </div>
    </div>

<!-- DELETE PERSON -->
    <div class="modal fade" id="deleteperson" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">DELETE OPTION</h4>
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#addnewpersonnel" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex align-items-center text-center">
                            <p class="text-center" style="font-size: 18px;">
                                <b style="color: red;">PERMANENTLY REMOVE ALL</b> ASSOCIATED RECORD WITH <b id="personnelinfo"></b> FROM THE SYSTEM.</b>
                            </p>
                        </div>
                        <div class="form-floating">
                            <input type="text" id="delpertypeyes" name="delpertypeyes" class="form-control required" required>
                            <label for="sname">Type YES/yes to continue...</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deletepersoninfo"><i class="bi bi-trash3"></i></button>
                </div>
                
            </div>
        </div>
    </div>


    
    <!-- PDF FILES UPLOAD/VIEW here -->
    <div class="modal fade" id="pdffile" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ATTENDANCE FILE UPLOAD/VIEW</h4>
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div id="iframeattendance" style= "width: 100%; height: 90%; overflow: hidden;">

                </div>
                
            </div>
        </div>
    </div>

</body>
</html>

<script>
    $(document).ready(function(){
        
        $("#attendfile").on("click", function() {
            attendfile();
        });

        attendfile();
        function attendfile(){
            var attendfile = "reload";
            // alert(attendfile);
                $.ajax({
                    url:"flagcere_crud.php",
                    method:"POST",
                    data: {attendfile: attendfile},

                    success:function(data){
                         $("#iframeattendance").html(data);
                    }
                });
        }

        $("#addnewdepartment").on("click", function() {
            var newdepartment = $("#newdepartment").val();
            alert(newdepartment);
                $.ajax({
                    url:"flagcere_crud.php",
                    method:"POST",
                    data: {newdepartment: newdepartment},

                    success:function(response){
                    if(response == "Add department"){
                        iziToast.success({
                        title: 'SUCCESS',
                        message: 'DEPARTMENT SUCCESSFULLY ADDED!'
                        });
                        $('.modal').modal('hide');
                        setTimeout(function() {
                            $("#newdepartment").val("");
                            location.reload();
						}, 1000);

                    }else{
                        iziToast.warning({
                        title: 'ERROR',
                        message: 'SOMETHING WENT WRONG, PLEASE TRY AGAIN!'
                        });
                    }
                    }
                });
        });


    })
</script>