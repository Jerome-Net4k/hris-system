<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:views_login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "partials_header2.php"?>
    <!-- fontawesome 5 link -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="loading2.css">
	<script src="loading.js" defer></script>
    <link rel="stylesheet" href="arrow.css">
</head>

<script>
    $(document).ready(function(){

        $('#upforminfo').on('submit', function(e) {
            e.preventDefault();
            var upformData = $(this).serialize();
            alert(upformData);

            $.ajax({
                url: "ojt_tablecrud.php",
                method: "POST",
                data: upformData,
                success: function(response) {
                if (response === "DTR info updated") {
                    iziToast.success({
                    title: 'UPDATED',
                    message: 'NEW RECORD SUCCESSFULLY UPDATED'
                    });
                    $('#updateojt-record').modal('hide');
                    setTimeout(function() {
                        loadojttable();
                    }, 1000);
                } else {
                    iziToast.warning({
                    title: 'ERROR',
                    message: 'FAILED TO UPDATE THE RECORD'
                    });
                }
                },
                error: function(xhr, status, error) {
                iziToast.warning({
                    title: 'Something went wrong',
                    message: 'Please try again!'
                });
                }
            });
        });
        
        $("#ojt-search").on("input", function() {
            var searchinput= $(this).val();
            var searchstatus =$("#searchojtstatus").val();
            // alert(searchinput);
            $.ajax({
				url:"ojt_tablelist_proc.php",//orgsearchunder.php
				method:"POST",
                data: {searchinput:searchinput,searchstatus:searchstatus},
  
				// if the data successful the data will show
				success:function(data){
					$("#ojt-info").html(data);
				}
			});
        });

        loadojttable();
        loadojttoday();
        loadojtconcern();

        $("#searchojtstatus").change(function(){
            $("#ojt-search").val("");
            loadojttable();
        });

        function loadojttable(){
            $("#ojt-info").html("");
            var statusojtsearch =$("#searchojtstatus").val();
            
            var toast = iziToast.show({
                theme: '#ffffff', // Set the theme to 'dark' (you can also use 'light')
                // title: 'Loading',
                message: '<img src="images/loading3.gif" width="150" height="150">', // Include the path to your animated GIF
                timeout: false, // Disable timeout for the toast
                position: 'center', // Set the toast position to center
                titleColor: '#ffffff', // Set the title color
                messageColor: '#ffffff', // Set the message color
                iconColor: '#ffffff', // Set the icon color
                close: false // Disable the close button
            });
            // alert(statusojtsearch);

            $.ajax({
			// it direct to the php file with this ID input
				url:"ojt_tablelist_proc.php",//orgsearchunder.php
				method:"POST",
                data: {statusojtsearch:statusojtsearch},
  
				// if the data successful the data will show
				success:function(data){
					$("#ojt-info").html(data);
				},
                complete: function() {
                    iziToast.destroy(toast);
                }
			});
        }
        
        function loadojttoday(){
            const today = new Date();
            const options = { year: 'numeric', month: 'long', day: '2-digit' };
            const dateString = today.toLocaleDateString('en-US', options);
            // alert(dateString);
            $.ajax({
                url: "ojt_tablelist_procday.php",
                method: "POST",
                data: { datetoday: dateString },
                success: function(data) {
                    $("#ojt-intoday").html(data);
                }
            });
        }
        
        $("#ojtconcernselect").change(function(){
            loadojtconcern();
        });

        function loadojtconcern(){
            var statusojtstatus =$("#ojtconcernselect").val();

            // alert(statusojtsearch);

            $.ajax({
			// it direct to the php file with this ID input
				url:"ojt_tablelist_procconcern.php",//orgsearchunder.php
				method:"POST",
                data: {statusojtstatus:statusojtstatus},
  
				// if the data successful the data will show
				success:function(data){
					$("#ojt-concern").html(data);
				}
			});
        }
        
        // SCRIPT FOR CONCERN
        $(document).on("click", ".submitconcern button", function() {
        var pendingid = $(this).val();
        // alert(pendingid);
        $.ajax({
                url: "ojt_tablecrud.php",
                method: "POST",
                data: {pendingid:pendingid},
                success: function(response) {
                if (response.trim() === "Pending update") {
                    iziToast.success({
                    title: 'DONE',
                    message: 'CONCERN ACCOMPLISH'
                    });
                    loadojtconcern();

                } else {
                    iziToast.warning({
                    title: 'WARNING',
                    message: 'PLEASE TRY AGAIN'
                    });
                }
                },
                error: function(xhr, status, error) {
                iziToast.warning({
                    title: 'Something went wrong',
                    message: 'Please try again!'
                });
                }
            });
    });

    });
</script>
<body style="overflow-x: hidden;">
    <div class="loader"></div>
    <?php include 'navbar.php'; ?>
    <div  style="padding: 20px 60px 0px 60px">
        <div class="header-content">
            <div class="row">
                <div class="col-3">
                    <h3>ON-THE-JOB TRAINING RECORD</h3>
                </div>
                <div class="col-3">
                    <div class="colorcode">
                        <div class="row" style="margin-left: 5px;">
                            <div class="col">
                                <i class="bi bi-box-fill" style="font-size: 10px; color: #0dcaf0;"><b style="font-size: 15px;"> ACTIVE</b></i>
                            </div>
                            <div class="col">
                                <i class="bi bi-box-fill" style="font-size: 10px; color: #212529;"><b style="font-size: 15px;"> DISPATCHED</b></i>
                            </div>
                        </div>
                        <div class="row" style="margin-left: 5px;">
                            <div class="col">
                                <i class="bi bi-box-fill" style="font-size: 10px; color: #dc3545;"><b style="font-size: 15px;"> COMPLETED</b></i>
                            </div>
                            <div class="col">
                                <i class="bi bi-box-fill" style="font-size: 10px; color: #ced4da;"><b style="font-size: 15px;"> NO STATUS</b></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        <div class="row">
            <div class="input-group w-50 rounded col-4 pt-2">
                <span class="input-group-text">SEARCH&nbsp; <i class="bi bi-search"></i></span>
                <input type="search" id="ojt-search" name="ojt-search" class="form-control">
                <div class="col-2">
                <select name="searchojtstatus" id="searchojtstatus" class="form-select">
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="COMPLETED">COMPLETED</option>
                    <option value="DISPATCHED">DISPATCHED</option>
                    <option value="ALL RECORD">ALL RECORD</option>
                </select>
                </div>
            </div>
        </div>
            <!-- <div class="d-flex" style="display: block;"><p id="datetoday" name="datetoday"></p></div> -->

        </div>
        <div class="row">
            <div class="col-9">
                <div style="height: 600px; overflow-y: scroll;">
                    <table class="table bg-white shadow-sm roundTable">
                        <thead class="table bg-white shadow-sm roundTable" style="position: sticky; top: 0;background: white;">
                        <tr>
                            <th></th>
                            <th>
                                <div class="d-flex justify-content-center firstnamesort">ID
                                    <div class="sort" data-value="idnum">
                                        <div class="arrow arrow1 chevron1"></div>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <div class="d-flex justify-content-center firstnamesort">NAME
                                    <div class="sort" data-value="nameintern">
                                        <div class="arrow arrow1 chevron1"></div>
                                    </div>
                                </div>
                            </th>
                            <th>DUTY<br>HOURS</th>
                            <th>TOTAL<br>RENDER</th>
                            <th>LATEST<br>DATE IN</th>
                            <th>STATUS</th>
                            <th class="header text-center">ACTION</th>
                        </tr>
                        </thead>
                       
                        <tbody id="ojt-info">
                            <div id="error-message"></div>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-3">
                    <h3>TRAINEE WHO DUTY TODAY</h3>
                    <div style="height: 600px; overflow-y: auto;">
                        <table class="table bg-white shadow-sm roundTable">
                        <thead class="table bg-white shadow-sm roundTable" style="position: sticky; top: 0;background: white;">
                        <tr>
                            <th>NAME</th>
                            <th>IN</th>
                            <th>OUT</th>
                            <th>RENDER</th>
                        </tr>
                        </thead>

                        <tbody id="ojt-intoday">
                            <div id="error-message"></div>

                        </tbody>
                        </table>
                        

                        
                    </div>
            </div>
            
        </div>
    </div>
<!-- LIST OF MESSAGES -->
    <div class="" style="padding: 0px 60px">
        <div class="row">
            <div class="col-3">
                <h3>OJT's List of concern (message)</h3>
            </div>
            <div class="col-3">
                <div class="colorcode">
                    <div class="row" style="margin-left: 5px;">
                        <div class="col">
                            <i class="bi bi-box-fill" style="font-size: 10px; color: #40E0D0;"><b style="font-size: 15px;"> DONE</b></i>
                        </div>
                        <div class="col">
                            <i class="bi bi-box-fill" style="font-size: 10px; color: #ced4da;"><b style="font-size: 15px;"> PENDING</b></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <select name="ojtconcernselect" id="ojtconcernselect" class="form-select mb-2 mt-2 w-25">
            <option value="PENDING">PENDING</option>
            <option value="DONE">DONE</option>
            <option value="DISPLAY ALL">DISPLAY ALL</option>
        </select>

        <div style="height: 300px; overflow-y: auto;">
            <table class="table bg-white shadow-sm roundTable">
                <thead class="table bg-white shadow-sm roundTable" style="position: sticky; top: 0;background: white;">
                    <tr>
                        <th style="width: 100px">ID</th>
                        <th>NAME</th>
                        <th style="width: 100px">TIME</th>
                        <th style="width: 150px">DATE</th>
                        <th style="width: 180px">TYPE OF CONCERN</th>
                        <th>MESSAGE</th>
                        <th style="width: 100px">STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <tbody id="ojt-concern">
                    <div id="error-message"></div>

                </tbody>
            </table>
                        

                        
        </div>
    </div>

        <div class="modal fade" id="updateojt-record" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">OJT DTR RECORD</h4>
                        <button class="btn-close" data-bs-dismiss="#exampleModalToggle" data-bs-toggle="modal"></button>
                    </div>
                    <!-- id="upforminfo" action="ojt_tablecrud.php" -->
                <form id="upforminfo" method="POST">
                    <div class="modal-body">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" id="remarks" name="remarks" class="form-control required">
                                <label for="sname">Remarks</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-floating mb-2">
                                <input type="text" id="ojtid" name="ojtid" class="form-control required" required>
                                <label for="sname">ID</label>
                            </div>
                        </div>

                        <div class="row row-cols-2 ">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" id="ojtname" name="ojtname" class="form-control required" required>
                                    <label for="sname">OJT Name</label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" id="latestin" name="latestin" class="form-control required">
                                    <label for="fname">Latest in</label>
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-2 ">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" id="dutyhours" name="dutyhours" class="form-control required" required>
                                    <label for="fname">Duty hours</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-2">
                                <select name="ojtstatus" id="ojtstatus" class="form-select">
                                    <option id="optionojtstatus"></option> 
                                    <option><i class="bi bi-three-dots-vertical"></i></option> 
                                    <option>ACTIVE</option>
                                    <option>COMPLETED</option>
                                    <option>DISPATCHED</option>
                                </select>
                                <label for="sname">STATUS</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer"> 
						<button type="submit" class="btn btn-primary mb-2" name="" id="">UPDATE</button>
					</div>
                </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="updateojt-recordview" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">OJT Information</h4>
                        <button class="btn-close" data-bs-dismiss="#exampleModalToggle" data-bs-toggle="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="col">
                                    <label for="sname"><strong>ID:</strong></label>
                                </div>
                            </div>
                                <div class="col">
                                    <label for="sname" id="ojtviewid"></label>
                                </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col">
                                <div class="row">
                                <div class="col">
                                    <label for="sname"><strong>Name: </strong></label>
                                </div>
                                
                                <div class="col">
                                    <label for="sname" id="ojtviewname"></label>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col">
                                <div class="row">
                                <div class="col">
                                    <label for="sname"><strong>School: </strong></label>
                                </div>
                                
                                <div class="col">
                                    <label for="sname" id="ojtviewschool"></label>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col">
                                <div class="row">
                                <div class="col">
                                    <label for="sname"><strong>Department: </strong></label>
                                </div>
                                
                                <div class="col">
                                    <label for="sname" id="ojtviewdept"></label>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer"> 
						<!-- <button type="submit" class="btn btn-primary mb-2" name="" id="">UPDATE</button> -->
					</div>

                </div>
            </div>
        </div>

<!-- dtr goto -->
        <div class="modal fade" id="dtr_tableojt" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">DAILY TIME RECORD!</h4>
                        <button class="btn-close" data-bs-dismiss="#exampleModalToggle" data-bs-toggle="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="col">
                                    <label for="sname"><strong>ID:</strong></label>
                                </div>
                            </div>

                            <div class="col">
                                <label for="sname" id="ojt_tableviewid"></label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="col">
                                    <label for="sname"><strong>NAME:</strong></label>
                                </div>
                            </div>

                            <div class="col">
                                <label for="sname" id="ojt_tableviewname"></label>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                        <select name="ojt_tablemonth" id="ojt_tablemonth" class="form-select" style="">
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

                        <select name="ojt_tableyear" id="ojt_tableyear" class="form-select" style="margin-left: 10px;"></select>
                        <script>
                            $(document).ready(function() {
                                var currentYear = new Date().getFullYear();
                                for (var i = currentYear; i >= currentYear - 10; i--) {
                                    var option = $('<option>', {
                                        value: i,
                                        text: i
                                    });
                                    $('#ojt_tableyear').append(option);
                                }
                            });
                        </script>
                        </div>

                    </div>

                    <div class="modal-footer"> 
						<button type="submit" class="btn btn-primary mb-2" name="dtrgenerate" id="dtrgenerate"><i class="bi bi-cloud-sleet-fill"></i></button>
					</div>

                </div>
            </div>
        </div>

    <script>
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
            $('#dtrgenerate').click(function() {
                var ojtmonth = $("#ojt_tablemonth").val();
                var ojtyear = $("#ojt_tableyear").val();
                var ojtidtable = $("#ojt_tableviewid").text();
                // alert(ojtidtable+ojtmonth+ojtyear);

                window.open("ojt_dtrform.php?dtrid=" + ojtidtable + "&dtrmonth=" + ojtmonth + "&dtryear=" + ojtyear , "_blank");
            })

// SORTING THE LIST DEPARTMENT
const buttons = $('.sort');
  const arrows = $('.arrow');

  let arr = ['active', 'active1',];

  buttons.on('click', function() {
      var sortval = $(this).data('value');
      // alert(sortval);
      const buttonIndex = buttons.index(this);
      arrows.each(function(arrowIndex) {
      const arrow = $(this);
      if (arrowIndex === buttonIndex) {
          if (!arrow.hasClass(arr[buttonIndex])) {
          arrow.addClass(arr[buttonIndex]);
          var sortwhat = "DESC";
          load2(sortval, sortwhat);
          } else {
          arrow.removeClass(arr[buttonIndex]);
          var sortwhat = "ASC";
          load2(sortval, sortwhat);
          // DECREMENT VALUE
          // alert("down");
          }
      } else {
          arrow.removeClass(arr[arrowIndex]);
      }
      });
  });

  function load2(sortval, sortwhat) {
      // alert(sortval + sortwhat);
      var searchojtstatus = $("#searchojtstatus").val();
      var sortsortval = sortval;
      alert(searchojtstatus + sortsortval + sortwhat);
      $.ajax({
          url: "ojt_tablelist_proc.php",
          type: "POST",
          data: {
            searchojtstatus:searchojtstatus,
            sortsortval: sortsortval,
            sortwhat:sortwhat
          },
          success: function(data) {
              $("#ojt-info").html(data);
          }
      });
  }



        });

     </script>
</body>
</html>