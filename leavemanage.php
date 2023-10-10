<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'; ?>
    <?php include 'navbar.php'; ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>Document</title>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
}
    </style>

  <script>
    //Edit the month selection option
    // Get the month value from the PHP code
    var selectedMonth = '<?php echo date('F', strtotime($monthRecords[0]['leavemonth'])); ?>';

    // Find the select element
    var monthSelect = document.getElementById('month');

    // Loop through the options and set the selected option based on the value
    for (var i = 0; i < monthSelect.options.length; i++) {
      if (monthSelect.options[i].text === selectedMonth) {
        monthSelect.options[i].selected = true;
        break;
      }
    }
  </script>
  <script>






//
$(document).ready(function() {
      $(".show-modal").on("click", function() {
        $(".modal").show();
      });
      
      $(".hide-modal").on("click", function() {
        $(".modal").hide();
      });

      $(".toggle-form1").on("click", function() {
        $(".form1").toggle();
      });

      $(".toggle-form2").on("click", function() {
        $(".form2").toggle();
      });
    });


// Starting of the code Adding Leave
$(document).ready(function() {
  $("#addrec").on("click",function(){
            $.ajax({
                type: "GET",
                url: "proc_leavecredits.php?id=" + <?php echo $_GET['id']?> +  "&proc=getLeaveData",
                success: function(data){
                    var conv = jQuery.parseJSON(data);
                    $("#vl_bal").val(conv.vl_bal)
                    $("#sl_bal").val(conv.sl_bal)

                }
            })

        })

        $("#save").on("click", function() {
  var id = "<?php echo $_GET['id'] ?>";
  var day = $('#day').val();
  var hrs = $('#hrs').val();
  var min = $('#min').val();
  var leavetype = $('#leavetype').val();
  var auwp = $('#auwp').val();
  var auwop = $('#auwop').val();
  var credits = parseFloat($('#credits').val());
  var leavemonth = $('#leavemonth').val();
  var leavedate_from = $('#leavedate_from').val();
  var leavedate_to = $('#leavedate_to').val();
  var vl_bal = parseFloat($('#vl_bal').val());
  var sl_bal = parseFloat($('#sl_bal').val());

  if (leavemonth === "") {
    iziToast.error({
      title: 'Error!',
      message: 'Please select a month.',
      position: 'topRight'
    });
    return;
  }

  var halfCredits = credits / 2;

  if (isNaN(vl_bal)) {
    vl_bal = halfCredits;
  } else {
    vl_bal += halfCredits;
  }

  if (isNaN(sl_bal)) {
    sl_bal = halfCredits;
  } else {
    sl_bal += halfCredits;
  }

  if (isNaN(vl_bal) || isNaN(sl_bal)) {
    iziToast.show({
      title: 'Reminder!',
      message: 'Please fill up the previous balance leave first before adding a record.',
      position: 'center',
      timeout: 5000,
      displayMode: 'once',
      close: false,
      buttons: [
        ['<button>Fill Balances</button>', function(instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          if (isNaN(vl_bal)) {
            $('#vl_bal').focus();
          } else {
            $('#sl_bal').focus();
          }
        }],
        ['<button>Ignore</button>', function(instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          // Open the modal or perform any other actions you want
          $('#staticBackdrop').modal('show');
        }]
      ]
    });
    return false; // Prevent the form from submitting
  }

  $.ajax({
    data: {
      id: id,
      day: day,
      hrs: hrs,
      min: min,
      leavetype: leavetype,
      auwp: auwp,
      auwop: auwop,
      credits: credits,
      leavemonth: leavemonth,
      leavedate_from: leavedate_from,
      leavedate_to: leavedate_to,
      vl_bal: vl_bal,
      sl_bal: sl_bal
    },
    type: "POST",
    url: "proc_leavecredits.php?proc=upload",
    success: function(data) {
      iziToast.success({
        title: 'Success!',
        message: 'The data has been uploaded successfully.',
        position: 'topRight'
      });
    },
    error: function(xhr, status, error) {
      iziToast.error({
        title: 'Error!',
        message: 'An error occurred while uploading the data.',
        position: 'topRight'
      });
    }
  });
});


$.ajax({
          type: "GET",
          url: "proc_leavecredits.php?id=" + <?php echo $_GET['id']?> +  "&proc=record",
          success: function(data){
          $("#leaverecords").html(data);
          }
        })

    $.ajax({
          type: "GET",
          url: "proc_leavecredits.php?id=" + <?php echo $_GET['id']?> +  "&proc=balance",
          success: function(data){
          $("#balance").html(data);
          }
        })


        $("select#leavetype").on("click",function(){
            var leave = $("select#leavetype").val();
            var day = $("input#day").val();
            var hour =  $("input#hrs").val();
            var min = $("input#min").val();
            var convday = day * 480;
            var convHour = hour * 60;
            var total = convday + convHour + Number(min);
            var compute = (1 / 480) * total;
            var conv = parseFloat(compute.toFixed(3));
            var vl_bal = $('#vl_bal').val().trim();
            var sl_bal = $('#sl_bal').val().trim(); 

            // Check if vl_bal and sl_bal are empty
            

            if(leave == 'Vacation Leave'){
            var convert = Number(vl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#vl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(vl_bal);
            } else {
                $("#vl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            
            }   
            
            else if(leave == 'Privelage Leave'){
            var convert = Number(vl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#vl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(vl_bal);
            } else {
                $("#vl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            
            }
            else if(leave == 'Force Leave'){
            var convert = Number(vl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#vl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(vl_bal);
            } else {
                $("#vl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            
            }
            else if(leave == 'Undertime'){
            var convert = Number(vl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#vl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(vl_bal);
            } else {
                $("#vl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            
            }
            else if(leave == 'Sick Leave'){
            var convert = Number(sl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#sl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(sl_bal);
            } else {
                $("#sl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            }
            

            })
            $('#leavemonth').on('click', function() {
                $('#credits').val('2.50');
              });

              
              $("#leavemonth").on("click", function() {
  var vl_bal = parseFloat($('#vl_bal').val());
  var sl_bal = parseFloat($('#sl_bal').val());

  if (isNaN(vl_bal) && isNaN(sl_bal)) {
    iziToast.show({
      title: 'Reminder!',
      message: 'Please provide the previous balance leave first before selecting a month.',
      position: 'center',
      timeout: 5000,
      displayMode: 'once',
      close: false,
      buttons: [
        ['<button>Fill Balances</button>', function(instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          $('#vl_bal').focus();
        }],
        ['<button>Ignore</button>', function(instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          // Perform any other actions you want
        }]
      ]
    });
  }
});
    })

//End of Adding Record

//Start of the code Editing Leave
$(document).ready(function() {
  $("#editrec").on("click",function(){
            $.ajax({
                type: "GET",
                url: "proc_leavecredits.php?id=" + <?php echo $_GET['id']?> +  "&proc=getLeaveData",
                success: function(data){
                    var conv = jQuery.parseJSON(data);
                    $("#vl_bal").val(conv.vl_bal)
                    $("#sl_bal").val(conv.sl_bal)

                }
            })

        })

        $("#save").on("click", function() {
  var id = "<?php echo $_GET['id'] ?>";
  var day = $('#day').val();
  var hrs = $('#hrs').val();
  var min = $('#min').val();
  var leavetype = $('#leavetype').val();
  var auwp = $('#auwp').val();
  var auwop = $('#auwop').val();
  var credits = parseFloat($('#credits').val());
  var leavemonth = $('#leavemonth').val();
  var leavedate_from = $('#leavedate_from').val();
  var leavedate_to = $('#leavedate_to').val();
  var vl_bal = parseFloat($('#vl_bal').val());
  var sl_bal = parseFloat($('#sl_bal').val());

  /**if (leavemonth === "") {
    iziToast.error({
      title: 'Error!',
      message: 'Please select a month.',
      position: 'topRight'
    });
    return;
  }*/

  var halfCredits = credits / 2;

  if (isNaN(vl_bal)) {
    vl_bal = halfCredits;
  } else {
    vl_bal += halfCredits;
  }

  if (isNaN(sl_bal)) {
    sl_bal = halfCredits;
  } else {
    sl_bal += halfCredits;
  }

  if (isNaN(vl_bal) || isNaN(sl_bal)) {
    iziToast.show({
      title: 'Reminder!',
      message: 'Please fill up the previous balance leave first before adding a record.',
      position: 'center',
      timeout: 5000,
      displayMode: 'once',
      close: false,
      buttons: [
        ['<button>Fill Balances</button>', function(instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          if (isNaN(vl_bal)) {
            $('#vl_bal').focus();
          } else {
            $('#sl_bal').focus();
          }
        }],
        ['<button>Ignore</button>', function(instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          // Open the modal or perform any other actions you want
          $('#staticBackdrop').modal('show');
        }]
      ]
    });
    return false; // Prevent the form from submitting
  }

  $.ajax({
    data: {
      id: id,
      day: day,
      hrs: hrs,
      min: min,
      leavetype: leavetype,
      auwp: auwp,
      auwop: auwop,
      credits: credits,
      leavemonth: leavemonth,
      leavedate_from: leavedate_from,
      leavedate_to: leavedate_to,
      vl_bal: vl_bal,
      sl_bal: sl_bal
    },
    type: "POST",
    url: "proc_leavecredits.php?proc=upload",
    success: function(data) {
      iziToast.success({
        title: 'Success!',
        message: 'The data has been uploaded successfully.',
        position: 'topRight'
      });
    },
    error: function(xhr, status, error) {
      iziToast.error({
        title: 'Error!',
        message: 'An error occurred while uploading the data.',
        position: 'topRight'
      });
    }
  });
});


$.ajax({
          type: "GET",
          url: "proc_leavecredits.php?id=" + <?php echo $_GET['id']?> +  "&proc=record",
          success: function(data){
          $("#leaverecords").html(data);
          }
        })

    $.ajax({
          type: "GET",
          url: "proc_leavecredits.php?id=" + <?php echo $_GET['id']?> +  "&proc=balance",
          success: function(data){
          $("#balance").html(data);
          }
        })


        $("select#leavetype").on("click",function(){
            var leave = $("select#leavetype").val();
            var day = $("input#day").val();
            var hour =  $("input#hrs").val();
            var min = $("input#min").val();
            var convday = day * 480;
            var convHour = hour * 60;
            var total = convday + convHour + Number(min);
            var compute = (1 / 480) * total;
            var conv = parseFloat(compute.toFixed(3));
            var vl_bal = $('#vl_bal').val().trim();
            var sl_bal = $('#sl_bal').val().trim(); 

            // Check if vl_bal and sl_bal are empty
            

            if(leave == 'Vacation Leave'){
            var convert = Number(vl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#vl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(vl_bal);
            } else {
                $("#vl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            
            }   
            
            else if(leave == 'Privelage Leave'){
            var convert = Number(vl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#vl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(vl_bal);
            } else {
                $("#vl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            
            }
            else if(leave == 'Force Leave'){
            var convert = Number(vl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#vl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(vl_bal);
            } else {
                $("#vl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            
            }
            else if(leave == 'Undertime'){
            var convert = Number(vl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#vl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(vl_bal);
            } else {
                $("#vl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            
            }
            else if(leave == 'Sick Leave'){
            var convert = Number(sl_bal) - conv;
            $("#auwp").val(conv);
            if (convert < 0) {
                $("#sl_bal").val(0);
                $("#auwop").val(-convert);
                $("#auwp").val(sl_bal);
            } else {
                $("#sl_bal").val(convert);
                $("#auwp").val(conv);
                
            }
            }
            

            })
            $('#leavemonth').on('click', function() {
                $('#credits').val('2.50');
              });

              
              $("#leavemonth").on("click", function() {
  var vl_bal = parseFloat($('#vl_bal').val());
  var sl_bal = parseFloat($('#sl_bal').val());

  if (isNaN(vl_bal) && isNaN(sl_bal)) {
    iziToast.show({
      title: 'Reminder!',
      message: 'Please provide the previous balance leave first before selecting a month.',
      position: 'center',
      timeout: 5000,
      displayMode: 'once',
      close: false,
      buttons: [
        ['<button>Fill Balances</button>', function(instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          $('#vl_bal').focus();
        }],
        ['<button>Ignore</button>', function(instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          // Perform any other actions you want
        }]
      ]
    });
  }
});
    })

//End of the Editing Records


    </script>
</head>



<body>
            <div class="container-fluid pt-2">
            <div class="d-flex justify-content-end ">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success" id="addrec" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fi fi-rr-layer-plus"> ADD RECORD</i> </button>
            <button type="button" class="btn btn-warning" id="editrec" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fi fi-rr-layer-plus"> EDIT RECORD</i> </button> 
            </div>
            <div class="row align-items">
          
            <div class="col">     
            <table class="table table-sm caption-top">
                <caption class="fw-bold fs-4">Records</caption>
                    <tr>
                        <th class="text-start">Period|Particular</th>
                        <th class="text-center">Earned</th>
                        <th class="text-center">Absence|Undertimes<br> with Pay</th>
                        <th class="text-center">Balance VL</th>
                        <th class="text-center">Balance SL</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th class="text-center">Absence|Undertimes<br> without Pay</th>
                    </tr>
                    <tbody id="leaverecords">   
                    </tbody>
                </tbody>
                </table>
                
            </div>
            </div>
            </div>

<!-- Modal Adding Record-->
            
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="staticBackdropLabel" button="onclick" >ADD RECORD |</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
      <div class="row g-2">
        <div class="col-md">
          <tr>
            <td>Data</td>
          </tr>
       <!-- <div class="form-floating">
        <input type="month" id="leavemonth" onchange="updateLeaveDates()"  class="form-control w-25" require>
        <label for="sname">MONTH FOR*</label>
          </div>-->
          <label for="month">Select Month:</label>
  <select id="month" name="month">
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
  </select>
    </div>
  </div>
      <table class="table table-sm table-borderless">
      <tr>
                    <tbody id="body">
                        <th class="text-center">Day|Time</th>
                        <th class="text-center">Absence|Undertimes<br> with Pay</th>
                        <th class="text-center">Credits</th>
                        <th class="text-center">Leave Type</th>
                        <th class="text-center">From</th>
                        <th class="text-center">To</th>
                        <th class="text-center">Absence|Undertimes<br> without Pay</th>
                    </tr>

                    <tr>
                    <td class="text-center"><div class="input-group"> <input type="number" class="form-control input-group clr" placeholder="Day" id="day"><input type="number" class="form-control clr" placeholder="Hrs" id="hrs"> <input type="number" class="form-control clr" placeholder="Min" id="min">    </div></td>
                    <td class="text-center clr"> <input type="text" class="form-control text-center clr"  id="auwp" readonly></td>
                    <td><input type="text" class="form-control text-center" id="credits"></td>
                    <td><select name="" class="form-select clr" id="leavetype" style="width: 150px;" >
                            <option hidden value =''disabled selected>Type of Leave</option>
                            <option value="Vacation Leave">Vacation</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Undertime">Undertime</option>
                            <option value="Privelage Leave">Privelage Leave</option>
                            <option value="Force Leave">Force Leave</option>
                            <option value="Anniversary Leave">Anniversary Leave</option>
                            <option value="Birthday Leave">Birthday Leave</option>
                            <option value="Relocate Leave">Relocate Leave</option>
                            <option value="Adoptive Leave">Adoptive Leave</option>
                            <option value="Maternity Leave">Maternity Leave</option>
                            <option value="Paternity Leave">Paternity Leave</option>
                            <option value="Miscarriage Leave">Miscarriage Leave</option>
                            <option value="Solo Parent Leave">Solo Parent Leave</option>
                            <option value="Rehabilitation Leave">Rehabilitation Leave</option>
                        </select></td>

                    <td><input type="date" id="leavedate_from" class="form-control clr"></td> 
                    <td><input type="date" id="leavedate_to" class="form-control clr"></td> 
                    <td><input class="form-control text-center" id="auwop" readonly ></td>
                    
                    </tr> 
                    <tr>
                    
                    </tr>     
                    </table>
                    <table class="table table-sm table-borderless">
                    <tr>
                      <th>Type:</th>
                      <th>Leave Balance</th>
                    </tr>
                    <tr>
                      <td>Vacation Leave</td>
                      <td><input type="number" id="vl_bal" class="form-control form-control-sm text-center w-50"></td>
                    </tr>
                    <tr>
                      <td>Sick Leave</td>
                      <td><input type="number" id="sl_bal" class="form-control form-control-sm text-center w-50"></td>
                    </tr>
                    
                    <tr>
                      <td colspan="6" class="text-end">
                      </td>
                    </tr>
                  </table>
          </div>
      
  </div>

</div>

<div class="modal-footer">
        <button type="submit" class="btn btn-success" id="save" data-bs-dismiss="modal"> Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </div>
 </div>
</div>


<!-- Modal Editing Record-->
            
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="" button="onclick" >EDIT RECORD</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
      <div class="row g-2">
        <div class="col-md">
          <tr>

          </tr>
        <div class="form-floating">

    </div>
  </div>
     <table class="table table-sm table-borderless">
      <tr>
                    <tbody id="body">
                        <th class="text-center">Day|Time</th>
                        <th class="text-center">Absence|Undertimes<br> with Pay</th>
                        <th class="text-center">Credits</th>
                        <th class="text-center">Leave Type</th>
                        <th class="text-center">From</th>
                        <th class="text-center">To</th>
                        <th class="text-center">Absence|Undertimes<br> without Pay</th>
                    </tr>

                     <tr>
                    <td class="text-center"><div class="input-group"> <input type="number" class="form-control input-group clr" placeholder="Day" id="day"><input type="number" class="form-control clr" placeholder="Hrs" id="hrs"> <input type="number" class="form-control clr" placeholder="Min" id="min">    </div></td>
                    <td class="text-center clr"> <input type="text" class="form-control text-center clr"  id="auwp" readonly></td>
                    <td><input type="text" class="form-control text-center" id="credits"></td>
                    <td><select name="" class="form-select clr" id="leavetype" style="width: 150px;" >
                            <option hidden value =''disabled selected>Type of Leave</option>
                            <option value="Vacation Leave">Vacation</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Undertime">Undertime</option>
                            <option value="Privelage Leave">Privelage Leave</option>
                            <option value="Force Leave">Force Leave</option>
                            <option value="Anniversary Leave">Anniversary Leave</option>
                            <option value="Birthday Leave">Birthday Leave</option>
                            <option value="Relocate Leave">Relocate Leave</option>
                            <option value="Adoptive Leave">Adoptive Leave</option>
                            <option value="Maternity Leave">Maternity Leave</option>
                            <option value="Paternity Leave">Paternity Leave</option>
                            <option value="Miscarriage Leave">Miscarriage Leave</option>
                            <option value="Solo Parent Leave">Solo Parent Leave</option>
                            <option value="Rehabilitation Leave">Rehabilitation Leave</option>
                        </select></td>
                 
                    <td><input type="date" id="leavedate_from" class="form-control clr"></td> 
                    <td><input type="date" id="leavedate_to" class="form-control clr"></td> 
                    <td><input class="form-control text-center" id="auwop" readonly ></td>
                    
                    </tr> 
                    <tr>
                    
                    </tr>     
                    </table>
                    <table class="table table-sm table-borderless">
                    <tr>
                      <th>Type:</th>
                      <th>Leave Balance</th>
                    </tr>
                    <tr>
                      <td>Vacation Leave</td>
                      <td><input type="number" id="vl_bal" class="form-control form-control-sm text-center w-50"></td>
                    </tr>
                    <tr>
                      <td>Sick Leave</td>
                      <td><input type="number" id="sl_bal" class="form-control form-control-sm text-center w-50"></td>
                    </tr>
                    
                    <tr>
                      <td colspan="6" class="text-end">
                      </td>
                    </tr>
                  </table>
          </div>
      
  </div>

</div>

<div class="modal-footer">
        <button type="submit" class="btn btn-success" id="save" data-bs-dismiss="modal"> Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </div>
  </div>
</div>



<button onclick="openModal('modal1')">Update Modal 1</button>
    <button onclick="openModal('modal2')">Update Modal 2</button>

    <!-- Modal 1 -->
    <div id="modal1" class="modal fade">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal1')">&times;</span>
            <h2>Modal 1</h2>
            <p>This is the content of Modal 1.</p>
        </div>
    </div>

    <!-- Modal 2 -->
    <div id="modal2" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal2')">&times;</span>
            <h2>Modal 2</h2>
            <p>This is the content of Modal 2.</p>
        </div>
    </div>

    <script>
        // Function to open a modal
        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "block";
        }

        // Function to close a modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
        }
    </script>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</html>