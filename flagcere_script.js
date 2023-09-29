$(document).ready(function(){
    
  $('#attnewform').on('submit', function(event) {
		event.preventDefault();
		var formData = $(this).serialize();

		alert(formData);
		if(formData){
			$.ajax({
				url: "flagcere_attendance_add.php",
				type: "POST",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				success: function(response) {
					if(response == "Data added successfully"){
						iziToast.success({
				  		title: 'SAVE',
				  		message: 'RECORD HAS BEEN SAVED'
						});
            $('.modal').modal('hide');
            $('#attempno').val("");
            $('#attempname').val("");
            $('#attdept').val("");
            $('#jobstatus').val("");
            attendancetableload();
            // attendanceformtableload();
					}else{
            iziToast.warning({
              title: 'NOT SAVE',
              message: 'RECORD NOT SAVED!'
            });
          }
				}
			});
		}
	});

  
  $("#delenablebtn").on("click", function() {
    var attempname = $("#attempname").val();
    $("#personnelinfo").text(attempname);
    // alert(attempname);
  });


  $("#deletepersoninfo").on("click", function() {
    var delattempno = $("#attempno").val();
    var yesdel = $("#delpertypeyes").val();
    alert(yesdel + delattempno);
    if (yesdel === "YES" || yesdel === "yes") {
        $.ajax({
            url:"flagcere_attendance_add.php",
            method:"POST",
            data: {delattempno: delattempno},

            success:function(response){
            if(response == "Employee deleted"){
                iziToast.success({
                title: 'DELETED',
                message: 'ALL RECORD DELETED SUCCESSFULLY!'
                });
                $('.modal').modal('hide');
                attendancetableload();
            }else{
                iziToast.warning({
                title: 'ERROR',
                message: 'SOMETHING WENT WRONG, PLEASE TRY AGAIN!'
                });
            }
            }
        });
    }else{
        iziToast.warning({
            title: 'ERROR',
            message: 'SOMETHING WENT WRONG, PLEASE TRY AGAIN!'
        });
    }
  });

// delete the date selected
  $("#deletedirdate").on('click', function(){
    var deltypeyes = $("#deltypeyes").val();
    var editdateinfomonth = $("#editdateinfomonth").text();
    var editdateinfoday = $("#editdateinfoday").text();
    var editdateinfoyear = $("#editdateinfoyear").text();
    if (deltypeyes === "YES" || deltypeyes === "yes") {
      // alert(deltypeyes + editdateinfomonth + editdateinfoday + editdateinfoyear);
      $.ajax({
        url:"flagcere_crud.php",
        method:"POST",
        data: {deltypeyes:deltypeyes,editdateinfomonth:editdateinfomonth,editdateinfoday:editdateinfoday,editdateinfoyear:editdateinfoyear},
        success:function(response){
          if(response == "Date deleted"){
            iziToast.success({
              title: 'DELETED',
              message: 'DATE DELETED SUCCESSFULLY'
            });
            $('.modal').modal('hide');
            $('#deltypeyes').val('');
            loadattendance();
            attendancetableload();
            attendanceformtableload();
            dayselectionload();
          }else{
            iziToast.warning({
              title: 'ERROR',
              message: 'SOMETHING WENT WRONG, PLEASE TRY AGAIN!'
            });
          }
        }
      });
    }else{
      iziToast.warning({
        title: 'ERROR',
        message: 'PLEASE TRY yes/YES TO CONTINUE'
      });
    }
  })
  
  $("#updatedirdate").on('click', function(){
    var dayupdate = $("#dayupdate").val();
    var editdateinfomonth = $("#editdateinfomonth").text();
    var editdateinfoday = $("#editdateinfoday").text();
    var editdateinfoyear = $("#editdateinfoyear").text();
    // alert(dayupdate + editdateinfomonth + editdateinfoday + editdateinfoyear);
    $.ajax({
      url:"flagcere_crud.php",
      method:"POST",
      data: {dayupdate:dayupdate,editdateinfomonth:editdateinfomonth,editdateinfoday:editdateinfoday,editdateinfoyear:editdateinfoyear},
      success:function(response){
        if(response == "Date updated"){
          iziToast.success({
            title: 'UPDATED',
            message: 'DATE UPDATED SUCCESSFULLY'
          });
          $('.modal').modal('hide');
          $('#deltypeyes').val('');
          loadattendance();
          attendancetableload();
          attendanceformtableload();
          dayselectionload();
        }else{
          iziToast.warning({
            title: 'ERROR',
            message: 'SOMETHING WENT WRONG, PLEASE TRY AGAIN!'
          });
        }
      }
    });
  })
  

  $("#addnewpersonnelform").on("click", function() {
    $('#attempno').val("");
    $('#attempname').val("");
    $('#attdept').val("");
    $('#jobstatus').val("");
    $('#delenablebtn').prop('disabled', true);
  })
// Select the date
  const date = new Date();
  const month = date.toLocaleString('default', { month: 'long' });

        // search the date
  const select = document.getElementById("attmonth");

  const searchValue = month.trim().toLowerCase();
  let found = false;

  for (let i = 0; i < select.options.length; i++) {
    const optionValue = select.options[i].text.trim().toLowerCase();
    if (optionValue.includes(searchValue)) {
      select.value = select.options[i].value;
      found = true;
      break;
    }
  }

// display current year
  var currentYear = new Date().getFullYear();
  for (var i = currentYear; i >= currentYear - 10; i--) {
    var option = $('<option>', {
      value: i,
      text: i
    });
    $('#attyear').append(option);
  }

  $("#att-search").on("keyup", function() {
    var searchinput = $(this).val();
    var selectedOption = $("#attyear").find(":selected");
    var yearload = new Date(selectedOption.val()).getFullYear();
    var month = $("#attmonth option:selected").val();
    var deptname = $("#deptname").val();
    // alert(searchinput);
    $.ajax({
        url: "flagcere_attendance_proc.php",
        method: "POST",
        data: {
            searchinput: searchinput,
            yearload: yearload,
            month: month,
            deptname: deptname
        },
        success: function(data) {
            $("#listperdepartment").html(data);
        }
    });
  }); 
  
  $("#createdirdate").on('click', function(){
    var attmonth = $("#attmonth").val();
    var attyear = $("#attyear").val();
    var daycreate = $("#daycreate").val();
    // alert(daycreate);
    $.ajax({
      url:"flagcere_crud.php",
      method:"POST",
      data: {attmonth: attmonth,attyear:attyear,daycreate:daycreate},

      success:function(response){
        if(response == "Create date directory"){
          iziToast.success({
            title: 'CREATED',
            message: 'NEW DATE SAVE SUCCESSFULLY'
          });
          // $('#createdate').modal('hide');
          loadattendance();
          attendancetableload();
          attendanceformtableload();
          dayselectionload();
        }else if (response == "Record already exists"){
          iziToast.warning({
            title: 'EXIST',
            message: 'THE DATE ALREADY EXIST!'
          });
        }else{
          iziToast.warning({
            title: 'ERROR',
            message: 'SOMETHING WENT WRONG, PLEASE TRY AGAIN!'
          });
        }
      }
    });
  })

  // load the table at the frontpage
  dayselectionload();
  attendancetableload();

  $("#deptname, #attmonth, #attyear").on("change", function() {
    loadattendance();
    attendancetableload();
    attendanceformtableload();
    dayselectionload();
    
    $("#viewpdffile").text("");
    $("#delpdfbtn").css("visibility", "hidden");
  })

  $("#dayattendance").on("change", function() {
    loadattendance();
    attendancetableload();
    attendanceformtableload();
    // alert("ads");
  })


  function attendancetableload(){
    // var selectedOption = $("#attyear").find(":selected");
    // var yearload = new Date(selectedOption.val()).getFullYear();
    var yearload = $("#attyear").val();
    var month = $("#attmonth option:selected").val();
    var deptname = $("#deptname").val();
    // alert(yearload);
    $.ajax({
      url:"flagcere_attendance_proc.php",
      method:"POST",
      data: {yearload: yearload,month:month,deptname:deptname},

      success:function(data){
        $("#listperdepartment").html(data);
      }
    });
  }
  
  $("#attendancesheetform").on('click', function(){
    attendanceformtableload()
    // alert("hello");
  })
  
  attendanceformtableload();

  function attendanceformtableload(){
    // var selectedOption = $("#attyear").find(":selected");
    // var yearload = new Date(selectedOption.val()).getFullYear();
    var yearload = $("#attyear").val();
    var month = $("#attmonth option:selected").val();
    var deptname = $("#deptname").val();
    var dayattendance = $("#dayattendance").val();
    // alert(deptname);
    $.ajax({
      url:"flagcere_attendance_proc_check.php",
      method:"POST",
      data: {
        yearload: yearload,
        month:month,
        deptname:deptname,
        dayattendance:dayattendance
      },

      success:function(data){
        $("#attendancechecklist").html(data);
      }
    });

    $.ajax({
      url:"flagcere_attendance_headerdate.php",
      method:"POST",
      data: {yearload: yearload,month:month,deptname:deptname},

      success:function(data){
        $("#headerdate").html(data);
      }
    });
    
  }
        
  function dayselectionload(){
    var yearload = $("#attyear").val();
    var month = $("#attmonth option:selected").val();
    // alert(yearload);
    $.ajax({
      url:"flagcere_crud.php",
      method:"POST",
      data: {yearload: yearload,month:month},

      success:function(data){
        $("#dayattendance").html(data);
      }
    });
  }

        
  loadattendance();
  function loadattendance() {
    var deptname = $(".deptname").val();
    var attmonth = $("#attmonth").val();
    var attyear = $("#attyear").val();
    $("#title-change").text(deptname);
    $("#monthdisplay").text(attmonth);
    $("#attendancesheetLabel").text(deptname);
    $("#monthselected").text(attmonth);
    $("#yearselected").text(attyear);
    $("#createdatelabel").text(attmonth + ' ' + attyear);
            
  }


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
      var yearload = $("#attyear").val();
      var month = $("#attmonth option:selected").val();
      var deptname = $("#deptname").val();
      var sortsortval = sortval;
      // alert(month + yearload + deptname + sortsortval + sortwhat);
      $.ajax({
          url: "flagcere_attendance_proc.php",
          type: "POST",
          data: {
              yearload: yearload,
              month:month,
              deptname:deptname,
              sortsortval: sortsortval,
              sortwhat:sortwhat
          },
          success: function(data) {
              $("#listperdepartment").html(data);
          }
      });
  }
  // $("#resetbtn").on('click',function(e) {
  //   var attendvalue = "0";
  //   insertattendance(attendvalue)
  // })

  // $("#attflagform").on('submit',function(e) {
  //   e.preventDefault();
  //   var attendvalue = "1";
  //   insertattendance(attendvalue)
  // })

  // function insertattendance(attendvalue){
  //   var attform = new FormData($("#attflagform")[0]);
  //   var monthselected = $("#monthselected").text();
  //   var dayattendance = $("#dayattendance").val();
  //   var yearselected = $("#yearselected").text();
  //   var attend = attendvalue;
  //   attform.append('monthselected', monthselected);
  //   attform.append('dayattendance', dayattendance);
  //   attform.append('yearselected', yearselected);
  //   attform.append('attend', attend);
  //   // alert(attend);
  //   if (dayattendance!=""){
  //     $.ajax({
  //       url: "flagcere_attendance_submit.php",
  //       method: "POST",
  //       data: attform,
  //       processData: false,
  //       contentType: false,
  //       success: function(response) {
  //         if (response.trim() === "Attendance submitted successfully") {
  //           iziToast.success({
  //             title: 'SAVE',
  //             message: 'SAVING ATTENDANCE COMPLETE SUCCESSFUL'
  //           });
  //                               // iload ang data na nilagyan ng bagong data
  //             displayemptyadd()
  //         }else{
  //           iziToast.warning({
  //             title: 'ERROR',
  //             message: 'SOMETHING WENT WRONG, TRY AGAIN'
  //             });
  //         }
  //       }
  //     });
  //   }else{
  //     iziToast.warning({
  //       title: 'UNSELECTED',
  //       message: 'PLEASE SELECT THE DATE BEFORE PROCEEDING.'
  //       });
  //   }
  // }


  // $("#attendancesheetform").on('click', function(){
  //   dayselectionload()
  // })

});