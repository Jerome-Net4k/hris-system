<?php include "partials_header2.php"?>
<script src="flagcere_script.js"></script>

<div class="modal-body">
        <div>
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
            </div>

        <div class="row" style="height: 100%;">
            <div class="col">
            <!-- attendance sheet -->
            <!-- <div class="modal fade" id="attendancesheet" tabindex="-1" aria-labelledby="attendancesheetLabel" aria-hidden="true"> -->
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="attendancesheetLabel"></h4>
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
                <!-- </div> -->
            </div>
        
            <div class="col">
              <div style="float: right;" class="mb-2" id="delpdfbtn">
                <button type="button" class="btn btn-danger" id="deletepdffileBtn"><i class="bi bi-trash3"></i> PDF</button>
              </div>
              
              <div id="viewpdffile">
                
              </div>

            </div>
        </div>
    </div>
</div>

<div class="modal-footer" style="background: white; position: fixed; bottom: 0; left: 0; right: 0; padding-right: 3%;">
    <h4>PDF UPLOAD FILE:</h4>
    <form id="attfile" method="POST" enctype="multipart/form-data">
      <input type="file" name="pdfFile" id="pdfFile">
      <button type="button" class="btn btn-info"id="cancelBtn">CANCEL</button>
      <button type="submit" class="btn btn-success" id="uploadBtn" disabled>UPLOAD</button>
    </form>
</div>

<script>
    $(document).ready(function(){
      $("#deletepdffileBtn").on("click", function(){
        var delattdayupload = $("#dayattendance").val();
        var delattmonthupload = $("#attmonth").val();
        var delattyearupload = $("#attyear").val();
        var deldeptnameupload = $("#deptname").val();
        
        var deldateconfirm = delattmonthupload + " " + delattdayupload + ", "+ delattyearupload;
        var confirmation = confirm("Date: " + deldateconfirm + "\nDepartment: " + deldeptnameupload + "\n\nAre you sure you want to DELETE the file?"); // Show confirmation dialog
        
        if (confirmation){
            $.ajax({
                url: "flagcere_crud.php",
                method: "POST",
                data: {
                    delattdayupload: delattdayupload,
                    delattmonthupload: delattmonthupload,
                    delattyearupload: delattyearupload,
                    deldeptnameupload: deldeptnameupload
                },
                success: function(response) {
                    if (response === "File deleted successfully") {
                        iziToast.success({
                            title: 'DELETED',
                            message: 'PDF FILE DELETED SUCCESSFULLY!'
                        });
                        loadfile();
                    } else {
                        iziToast.warning({
                            title: 'ERROR',
                            message: 'SOMETHING WENT WRONG, PLEASE TRY AGAIN'
                        });
                    }
                },
                // error: function(xhr, status, error) {
                //   $("#viewpdffile").html("NO PDF FILE YET!");
                // }
            });
        }
    });


      $("#pdfFile, #dayattendance").on("change", function() {
        var fileInput = $("#pdfFile");
        var uploadBtn = $("#uploadBtn");
        var pdfFile = fileInput.val();
        var viewattdayupload = $("#dayattendance").val();

        if (viewattdayupload !== "" && pdfFile !== "") {
          uploadBtn.prop("disabled", false);
        } else {
          uploadBtn.prop("disabled", true);
        }
      });

      $("#dayattendance").on("change", function() {
        loadfile();
      });

      loadfile()

      $("#attfile").on("submit", function(event) {
        event.preventDefault(); // Prevent form submission and page reload

        var attfileupload = new FormData(this);
        var attdayupload = $("#dayattendance").val();
        var attmonthupload = $("#attmonth").val();
        var attyearupload = $("#attyear").val();
        var deptnameupload = $("#deptname").val();
        attfileupload.append('deptname', deptnameupload);
        attfileupload.append('dayattendance', attdayupload);
        attfileupload.append('attmonth', attmonthupload);
        attfileupload.append('attyear', attyearupload);
        var dateconfirm = attmonthupload + " " + attdayupload + ", " + attyearupload;
        // alert(attfileupload);

      var confirmation = confirm("Date: " + dateconfirm + "\nDepartment: " + deptnameupload + "\n\nAre you sure you want to upload the file?"); // Show confirmation dialog

      if (confirmation) {
        if (attdayupload !="") {
        $.ajax({
            url: "flagcere_crud.php",
            method: "POST",
            data: attfileupload,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response === "Uploaded file") {
                    iziToast.success({
                        title: 'SUCCESS',
                        message: 'FILE UPLOADED SUCCESSFULLY!'
                    });
                    $("#uploadBtn").prop("disabled", true);
                    $("#pdfFile").val("");
                    loadfile();
                } else {
                    iziToast.warning({
                        title: 'ERROR',
                        message: 'SOMETHING WENT WRONG, PLEASE TRY AGAIN'
                    });
                }
            },
            error: function() {
                iziToast.error({
                    title: 'ERROR',
                    message: 'An error occurred during the file upload process'
                });
            }
        });
        } else {
          iziToast.warning({
            title: 'ERROR',
            message: 'Please provide a valid day attendance value'
          });
        }
      }
      });

      $("#cancelBtn").on("click", function(){
        $("#pdfFile").val("");
        $("#uploadBtn").prop("disabled", true);
      })

      function loadfile() {
        var viewattdayupload = $("#dayattendance").val();
        var viewattmonthupload = $("#attmonth").val();
        var viewattyearupload = $("#attyear").val();
        var viewdeptnameupload = $("#deptname").val();
        // alert(viewdeptnameupload + viewattmonthupload + viewattdayupload + viewattyearupload);
        $.ajax({
          url: "flagcere_crud.php",
          method: "POST",
          data: {
            viewattdayupload: viewattdayupload,
            viewattmonthupload: viewattmonthupload,
            viewattyearupload: viewattyearupload,
            viewdeptnameupload: viewdeptnameupload
          },
          success: function(data) {
            $("#viewpdffile").html(data);
            var filedisplay = $("#viewpdffile").text();
            if (filedisplay === "NO PDF FILE UPLOAD YET") {
              $("#delpdfbtn").css("visibility", "hidden");
            } else {
              $("#delpdfbtn").css("visibility", "visible");
            }
          },
          // error: function(xhr, status, error) {
          //   $("#viewpdffile").html("NO PDF FILE YET!");
          // }
        });
      }

      
      // function emptyfile(){
      //   $("#pdfFile").val("");
      // }
  })
</script>