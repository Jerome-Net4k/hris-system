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
	<link rel="stylesheet" type="text/css" href="loading2.css">
	<script src="loading.js" defer></script>
    <link rel="stylesheet" href="arrow.css">
</head>
<script>

    $(document).ready(function(){
        
        $('#deletesavedtrrecord').on('click', function() {
            var delday = $("#dayselectot option:selected").text();
            var delmonth = $("#dtrmonth option:selected").text();
            var delyear = $("#dtryear option:selected").text();
            var deltypeyes = $("#deltypeyes").val();
            var delheaderidot = $("#headeridot").val();
            alert(delday + " " + delmonth + " " + delyear + " " + delheaderidot + " " + deltypeyes);
            if (deltypeyes === "YES" || deltypeyes === "yes") {
                $.ajax({
                    url: "ojt_tablecrud.php",
                    method: "POST",
                    data: {delday:delday,delmonth:delmonth,delyear:delyear,delheaderidot:delheaderidot},
                    success: function(response) {
                        if (response.trim() === "DTR record deleted") {
                            iziToast.success({
                            title: 'DELETED',
                            message: 'DTR RECORD DELETED SUCCESSFULLY'
                            });
                            // Load the data with new records
                            // loadojttable();
                            displayemptyadd();
                        } else {
                            iziToast.warning({
                            title: 'ERROR',
                            message: 'FAILED TO DELETE THE RECORD'
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
            }else{
                iziToast.warning({
                    title: 'ERROR',
                     message: 'PLEASE TRY yes/YES TO CONTINUE'
                });
            }
        });
        // Select the date
        const date = new Date();
        const month = date.toLocaleString('default', { month: 'long' });

        // search the date
        const select = document.getElementById("dtrmonth");

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

        if (!found) {
        select.value = "";
        }

        // search
        $("#ojt-search").on("keyup", function() {
            var searchinput= $(this).val();
            searchload(searchinput);
        });

        function searchload(searchinput){
            var dtrmonth = $("#dtrmonth option:selected").text();
            var dtryear = $("#dtryear option:selected").text();
            var searchojtstatus = $("#searchojtstatus option:selected").text();
            // alert(dtrmonth);
            $.ajax({
				url:"ojt_tablemonthly_proc.php",//orgsearchunder.php
				method:"POST",
                data: {searchinput:searchinput,dtrmonth: dtrmonth, dtryear: dtryear,searchojtstatus:searchojtstatus},
  
				// if the data successful the data will show
				success:function(data){
					$("#ojt-info").html(data);
				}
			});
        }

        $("#dtrmonth, #dtryear, #searchojtstatus").on("change", function() {
            loadojttable();
        });
        
        loadojttable();

        function loadojttable(){
            $("#ojt-info").html("");
            var dtrmonth = $("#dtrmonth option:selected").text();
            var dtryear = $("#dtryear option:selected").text();
            var searchojtstatus = $("#searchojtstatus option:selected").text();
            // alert(dtrmonth);

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

            $.ajax({
                url:"ojt_tablemonthly_proc.php",
                method:"POST",
                data: {dtrmonth: dtrmonth, dtryear: dtryear,searchojtstatus:searchojtstatus},

                // if the data successful the data will show
                success:function(data){
                    $("#ojt-info").html(data);
                },
                complete: function() {
                    iziToast.destroy(toast);
                }
            });
        }
        //  script for days
        var selectot = document.getElementById("dayselectot");
        var selectdtr = document.getElementById("dayselectdtr");

        // ot count
        for (var i = 1; i <= 31; i++) {
            var option = document.createElement("option");
            option.text = i;
            option.value = i;
            selectot.add(option);
        }

        // dtr
        for (var i = 1; i <= 31; i++) {
            var option = document.createElement("option");
            option.text = i;
            option.value = i;
            selectdtr.add(option);
        }

        $(".btn-ot").click(function() {
            $('#dayselectot').val("");
            $('#ojtottimein').val("");
            $('#ojtottimeout').val("");
            $('#ojtottimerender').val("");
            $("#hideojtottimerender").val("");
            $("#countaddtodtr option:selected").text("00:00:00");
            $("#ottotalcompute").text("00");
        })

        $(".btn-adddtr").click(function() {
            $('#dayselectdtr').val("1");
            $('#dtrtimein').val("");
            $('#dtrtimeout').val("");
            $("#dtrtimerender").val("");
            $("#otaddtodtr option:selected").text("00:00:00");
            $("#inputtotalcompute").text("00");
            // $('#ojtottimerender').val("");
        })

        // this code for selecting the time for ot
        // $("#dayselectot").change(function() {
        // var dayselect = $(this).val();
        // var headerid = $("#headeridot").val();
        // var dtrmonth = $("#dtrmonth option:selected").text();
        // var dtryear = $("#dtryear option:selected").text();
        // // alert(dtryear);
        //     $.ajax({
        //         url: 'ojt_tablecrud.php',
        //         type: 'POST',
        //         data: {
        //         dayselect: dayselect,
        //         headerid: headerid,
        //         dtrmonth: dtrmonth,
        //         dtryear: dtryear
        //         },
        //         dataType: 'json',
        //         success: function(data) {
        //         if (data === "No data found") {
        //             $('#ojtottimein').val("");
        //             $('#ojtottimeout').val("");
        //             $("#ojtottimerender").val("");
        //             $("#hideojtottimerender").val("");
        //         }else{
        //             $('#ojtottimein').val(data[0].Timein);
        //             $('#ojtottimeout').val(data[0].timeout);
        //             $('#ojtottimerender').val(data[0].timerender);
        //             $('#hideojtottimerender').val(data[0].timerender);
        //         } },
        //         error: function(xhr, status, error) {
        //             alert('Error: ' + error);
        //         }
        //     });
        // });


        // Add new dtr input hereformupdatedtr
                $('#formnewdtr').on('submit', function(e) {
                    e.preventDefault();
                    var addformData = new FormData($(this)[0]);
                    var dtrmonth = $("#dtrmonth option:selected").text();
                    var dtryear = $("#dtryear option:selected").text();
                    var headernamedtr = $("#headernamedtr").text();
                    var headeriddtr = $("#headeriddtr").val();
                    addformData.append('dtrmonth', dtrmonth);
                    addformData.append('dtryear', dtryear);
                    addformData.append('headeriddtr', headeriddtr);
                    addformData.append('headernamedtr', headernamedtr);
                    // alert(addformData);
                    
                    $.ajax({
                        url: "ojt_tablecrud.php",
                        method: "POST",
                        data: addformData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.trim() === "DTR record inserted") {
                                iziToast.success({
                                    title: 'Save',
                                    message: 'Saving new dtr record'
                                });
                                // iload ang data na nilagyan ng bagong data
                                var daynum = parseInt($('#dayselectdtr').val());
                                var plusone = daynum + 1;
                                $('#dayselectdtr').val(plusone);
                                displayemptyadd()
                            }else if (response.trim() === "DTR record updated") {
                                iziToast.info({
                                    title: 'Save',
                                    message: 'Update your DTR'
                                });    
                                var daynum = parseInt($('#dayselectdtr').val());
                                var plusone = daynum + 1;
                                $('#dayselectdtr').val(plusone);
                                displayemptyadd()
                            } else {
                                iziToast.warning({
                                    title: 'Unsave',
                                    message: 'Failed to save dtr record'
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

    // update dtr form
        $('#formupdatedtr').on('submit', function(e) {
            e.preventDefault();
            var form = $(this).serialize();
            // alert(form);
            var upformData = new FormData($(this)[0]);
            var dtrmonth = $("#dtrmonth option:selected").text();
            var dtryear = $("#dtryear option:selected").text();
            var headernameot = $("#headernameot").text();
            var headeridot = $("#headeridot").val();
            upformData.append('dtrmonth', dtrmonth);
            upformData.append('dtryear', dtryear);
            upformData.append('headeridot', headeridot);
            upformData.append('headernameot', headernameot);
            // alert(upformData);

            $.ajax({
                url: "ojt_tablecrud.php",
                method: "POST",
                data: upformData,
                processData: false,
                contentType: false,
                success: function(response) {
                if (response.trim() === "DTR record updated") {
                    iziToast.success({
                    title: 'Save',
                    message: 'Saving new dtr record'
                    });
                    // Load the data with new records
                    displayemptyadd();
                } else {
                    iziToast.warning({
                    title: 'Unsave',
                    message: 'Failed to save dtr record'
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

                // DISPLAY EMPTY FIELD FOR ADDING NEW
                function displayemptyadd(){
                    
                    var searchinput= $("#headernamedtr").text();
                    searchload(searchinput);

                    $('#dtrtimein').val("");
                    $('#dtrtimeout').val("");
                    $("#dtrtimerender").val("");
                    $("#otaddtodtr option:selected").text("00:00:00");
                    $("#inputtotalcompute").text("00");
                }

    $("#dayselectot").change(function() {
        var dayselect = $(this).val();
        var headerid = $("#headeridot").val();
        var dtrmonth = $("#dtrmonth option:selected").text();
        var dtryear = $("#dtryear option:selected").text();
        // alert(dtryear);
            $.ajax({
                url: 'ojt_tablecrud.php',
                type: 'POST',
                data: {
                dayselect: dayselect,
                headerid: headerid,
                dtrmonth: dtrmonth,
                dtryear: dtryear
                },
                dataType: 'json',
                success: function(data) {
                if (data === "No data found") {
                    $('#ojtottimein').val("");
                    $('#ojtottimeout').val("");
                    $("#ojtottimerender").val("");
                    $("#hideojtottimerender").val("");
                    $("#ottotalcompute").text("00");
                    $('#showdeletecommand').prop("disabled", true);
                    $('#submitcommand').prop("disabled", true);
                }else{
                    $('#ojtottimein').val(data[0].Timein);
                    $('#ojtottimeout').val(data[0].timeout);
                    $('#ojtottimerender').val(data[0].timerender);
                    $('#hideojtottimerender').val(data[0].timerender);
                    var otcount = parseInt("0");
                    otcountcomputeshow(otcount)
                    $('#showdeletecommand').prop("disabled", false);
                    $('#submitcommand').prop("disabled", false);
                    
                    
                } },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
    });

        $(".cancelotcompute").click(function() {
            var otcount = parseInt("0");
            $("#countaddtodtr option:selected").text("00:00:00");
            otcountcompute(otcount)
        })

        $(".otcompute").click(function() {
            var otcount = parseInt($("#countaddtodtr").val());
            otcountcompute(otcount)
        })

        // $(".dayselectot").on("change", function() {
        //     var otcount = parseInt($("#countaddtodtr").val());
        //     alert(otcount);
        //     otcountcompute();
        // })


// compute ot time here
        function otcountcompute(otcount){
        var ojtottimein = $("#ojtottimein").val();
        var ojtottimeout = $("#ojtottimeout").val();

        // time in     
        var timeinvalue = $("#ojtottimein").val();

        var timein = new Date(); // Assuming `timein` is a valid Date object
        var timeArray = ojtottimein.split(':');
        timein.setHours(parseInt(timeArray[0]));
        timein.setMinutes(parseInt(timeArray[1]));
        timein.setSeconds(parseInt(timeArray[2]));
        
        var hoursFormatted = timein.getHours().toString().padStart(2, "0");
        var minutesFormatted = timein.getMinutes().toString().padStart(2, "0");
        var secondsFormatted = timein.getSeconds().toString().padStart(2, "0");

        var timeOfDay = hoursFormatted + ":" + minutesFormatted + ":" + secondsFormatted;
        
        // time out
        var timeoutvalue = $("#ojtottimeout").val();

        var timeout = new Date(); // Assuming `timein` is a valid Date object
        var timeArray = timeoutvalue.split(':');
        timeout.setHours(parseInt(timeArray[0]));
        timeout.setMinutes(parseInt(timeArray[1]));
        timeout.setSeconds(parseInt(timeArray[2]));
        
        var hoursFormattedout = timeout.getHours().toString().padStart(2, "0");
        var minutesFormattedout = timeout.getMinutes().toString().padStart(2, "0");
        var secondsFormattedout = timeout.getSeconds().toString().padStart(2, "0");

        var timeOfDayout = hoursFormattedout + ":" + minutesFormattedout + ":" + secondsFormattedout;

        var formattedTime = "";
        // alert(timeOfDayout)

        var readlvalue = 0;

        var time2valueout = document.getElementById("ojtottimeout").value;
        var time2Value = "";

        if (timeOfDayout >= "17:00:00" && timeOfDayout <= "20:30:00") {
            time2Value = "17:00:00";
        }else{
            time2Value = time2valueout;
        }

        readlvalue = time2valueout;

        if (!isNaN(timein.getTime())) { 
            if (timeOfDay >= "05:00:00" && timeOfDay <= "12:59:59" && !(timeOfDayout >= "05:00:00" && timeOfDayout <= "12:59:59")) {
                var updatedTime = new Date(timein.getTime() + (60 * 60 * 1000));
                var hours = updatedTime.getHours().toString().padStart(2, "0");
                var minutes = updatedTime.getMinutes().toString().padStart(2, "0");
                var seconds = updatedTime.getSeconds().toString().padStart(2, "0");

                formattedTime = hours + ":" + minutes + ":" + seconds; 
                
            } else if (timeOfDay >= "13:00:00" && timeOfDay <= "17:30:00") {
                console.log(timeinvalue); // Output original time
                // document.getElementById("timecheck").value = timeinvalue;
                formattedTime=timeinvalue;
                //alert("asdaaa");
            } else {
                formattedTime=timeinvalue;
                //alert("asd");
                //alert("Time in is outside the specified range (not between 5am and 5pm)");
            }

            var time1Value = formattedTime;
           
            console.log(time1Value);
            console.log(time2Value);
            console.log(otcount);

            var time1 = new Date("2000-01-01T" + time1Value);
            var time2 = new Date("2000-01-01T" + time2Value);
            var time3 = new Date("2000-01-01T" + readlvalue);
            //alert("time1: " + time1 + "\ntime2: " + time2);

            if (!isNaN(time1.getTime()) && !isNaN(time2.getTime())) {
                var diff = new Date(time2 - time1);
                var realdiff = new Date(time3 - time1);
                console.log(diff);
                console.log(realdiff);

                var hours = diff.getUTCHours().toString().padStart(2, "0");
                var minutes = diff.getUTCMinutes().toString().padStart(2, "0");
                var seconds = diff.getUTCSeconds().toString().padStart(2, "0");

                if (hours >= 8) {
                    var result = "08:00:00";
                } else {
                    var result = hours + ":" + minutes + ":" + seconds;
                }

                var date = new Date("2000-01-01T" + result);
                // Step 2: Add 30 minutes to the time

                date.setMinutes(date.getMinutes() + otcount);

                // Step 3: Format the updated time
                var updatedTime = date.toTimeString().slice(0, 8);

                $("#ojtottimerender").val(updatedTime);
                
                console.log(result);

                var rhours = realdiff.getUTCHours().toString().padStart(2, "0");
                var rminutes = realdiff.getUTCMinutes().toString().padStart(2, "0");
                var rseconds = realdiff.getUTCSeconds().toString().padStart(2, "0");

                var rresult = rhours + ":" + rminutes + ":" + rseconds;

                console.log(rresult);

                $("#ottotalcompute").text(rresult);

            } else {
                console.log("Invalid time input");
                // alert("Invalid time input");
            }
        }
        }

                    
        $(".cancelcompute").click(function() {
            var otcount = "0";
            $("#otaddtodtr option:selected").text("00:00:00");
            computerender(otcount);
        })

        $(".dtrcompute").click(function() {
            var otcount = parseInt($("#otaddtodtr").val());
            // alert(otcount);
            computerender(otcount);
        })

// compute dtr record
        function computerender(otcount){
        var ojtottimein = $("#dtrtimein").val();
        var ojtottimeout = $("#dtrtimeout").val();
        $(".submitdtrbtn").prop("disabled", false);

        // time in     
        var timeinvalue = $("#dtrtimein").val();

        var timein = new Date(); // Assuming `timein` is a valid Date object
        var timeArray = ojtottimein.split(':');
        timein.setHours(parseInt(timeArray[0]));
        timein.setMinutes(parseInt(timeArray[1]));
        timein.setSeconds(parseInt(timeArray[2]));
        
        var hoursFormatted = timein.getHours().toString().padStart(2, "0");
        var minutesFormatted = timein.getMinutes().toString().padStart(2, "0");
        var secondsFormatted = timein.getSeconds().toString().padStart(2, "0");

        var timeOfDay = hoursFormatted + ":" + minutesFormatted + ":" + secondsFormatted;
        
        // time out
        var timeoutvalue = $("#dtrtimeout").val();

        var timeout = new Date(); // Assuming `timein` is a valid Date object
        var timeArray = timeoutvalue.split(':');
        timeout.setHours(parseInt(timeArray[0]));
        timeout.setMinutes(parseInt(timeArray[1]));
        timeout.setSeconds(parseInt(timeArray[2]));
        
        var hoursFormattedout = timeout.getHours().toString().padStart(2, "0");
        var minutesFormattedout = timeout.getMinutes().toString().padStart(2, "0");
        var secondsFormattedout = timeout.getSeconds().toString().padStart(2, "0");

        var timeOfDayout = hoursFormattedout + ":" + minutesFormattedout + ":" + secondsFormattedout;

        var formattedTime = "";
        // alert(timeOfDayout)
        var readlvalue = 0;

        var time2valueout = document.getElementById("dtrtimeout").value;
        var time2Value = "";

        if (timeOfDayout >= "17:00:00" && timeOfDayout <= "20:30:00") {
            time2Value = "17:00:00";
        }else{
            time2Value = time2valueout;
        }

        readlvalue = time2valueout;

        if (!isNaN(timein.getTime())) { 
            if (timeOfDay >= "05:00:00" && timeOfDay <= "12:59:59" && !(timeOfDayout >= "05:00:00" && timeOfDayout <= "12:59:59")) {
                var updatedTime = new Date(timein.getTime() + (60 * 60 * 1000));
                var hours = updatedTime.getHours().toString().padStart(2, "0");
                var minutes = updatedTime.getMinutes().toString().padStart(2, "0");
                var seconds = updatedTime.getSeconds().toString().padStart(2, "0");

                formattedTime = hours + ":" + minutes + ":" + seconds; 
                
            } else if (timeOfDay >= "13:00:00" && timeOfDay <= "17:30:00") {
                console.log(timeinvalue); // Output original time
                // document.getElementById("timecheck").value = timeinvalue;
                formattedTime=timeinvalue;
                //alert("asdaaa");
            } else {
                formattedTime=timeinvalue;
                //alert("asd");
                //alert("Time in is outside the specified range (not between 5am and 5pm)");
            }

            var time1Value = formattedTime;
           
            console.log(time1Value);
            console.log(time2Value);
            console.log(otcount);

            var time1 = new Date("2000-01-01T" + time1Value);
            var time2 = new Date("2000-01-01T" + time2Value);
            var time3 = new Date("2000-01-01T" + readlvalue);
            //alert("time1: " + time1 + "\ntime2: " + time2);

            if (!isNaN(time1.getTime()) && !isNaN(time2.getTime())) {
                var diff = new Date(time2 - time1);
                var realdiff = new Date(time3 - time1);
                console.log(diff);
                console.log(realdiff);

                var hours = diff.getUTCHours().toString().padStart(2, "0");
                var minutes = diff.getUTCMinutes().toString().padStart(2, "0");
                var seconds = diff.getUTCSeconds().toString().padStart(2, "0");

                if (hours >= 8) {
                    var result = "08:00:00";
                } else {
                    var result = hours + ":" + minutes + ":" + seconds;
                }

                var date = new Date("2000-01-01T" + result);
                // Step 2: Add 30 minutes to the time

                date.setMinutes(date.getMinutes() + otcount);

                // Step 3: Format the updated time
                var updatedTime = date.toTimeString().slice(0, 8);

                $("#dtrtimerender").val(updatedTime);
                
                console.log(result);

                var rhours = realdiff.getUTCHours().toString().padStart(2, "0");
                var rminutes = realdiff.getUTCMinutes().toString().padStart(2, "0");
                var rseconds = realdiff.getUTCSeconds().toString().padStart(2, "0");

                var rresult = rhours + ":" + rminutes + ":" + rseconds;

                console.log(rresult);

                $("#inputtotalcompute").text(rresult);




            } else {
                console.log("Invalid time input");
                // alert("Invalid time input");
            }
        }
      

        // save new input dtr
        }


// for displaying the real computation
    function otcountcomputeshow(otcount){
        var ojtottimein = $("#ojtottimein").val();
        var ojtottimeout = $("#ojtottimeout").val();

        // time in
        var timeinvalue = $("#ojtottimein").val();

        var timein = new Date(); // Assuming `timein` is a valid Date object
        var timeArray = ojtottimein.split(':');
        timein.setHours(parseInt(timeArray[0]));
        timein.setMinutes(parseInt(timeArray[1]));
        timein.setSeconds(parseInt(timeArray[2]));
        
        var hoursFormatted = timein.getHours().toString().padStart(2, "0");
        var minutesFormatted = timein.getMinutes().toString().padStart(2, "0");
        var secondsFormatted = timein.getSeconds().toString().padStart(2, "0");

        var timeOfDay = hoursFormatted + ":" + minutesFormatted + ":" + secondsFormatted;
        
        // time out
        var timeoutvalue = $("#ojtottimeout").val();

        var timeout = new Date(); // Assuming `timein` is a valid Date object
        var timeArray = timeoutvalue.split(':');
        timeout.setHours(parseInt(timeArray[0]));
        timeout.setMinutes(parseInt(timeArray[1]));
        timeout.setSeconds(parseInt(timeArray[2]));
        
        var hoursFormattedout = timeout.getHours().toString().padStart(2, "0");
        var minutesFormattedout = timeout.getMinutes().toString().padStart(2, "0");
        var secondsFormattedout = timeout.getSeconds().toString().padStart(2, "0");

        var timeOfDayout = hoursFormattedout + ":" + minutesFormattedout + ":" + secondsFormattedout;

        var formattedTime = "";
        // alert(timeOfDayout);

        var readlvalue = 0;

        var time2valueout = document.getElementById("ojtottimeout").value;
        var time2Value = "";

        if (timeOfDayout >= "17:00:00" && timeOfDayout <= "20:30:00") {
            time2Value = "17:00:00";
        }else{
            time2Value = time2valueout;
        }

        readlvalue = time2valueout;

        if (!isNaN(timein.getTime())) { 
            if (timeOfDay >= "05:00:00" && timeOfDay <= "12:59:59" && !(timeOfDayout >= "05:00:00" && timeOfDayout <= "12:59:59")) {
                var updatedTime = new Date(timein.getTime() + (60 * 60 * 1000));
                var hours = updatedTime.getHours().toString().padStart(2, "0");
                var minutes = updatedTime.getMinutes().toString().padStart(2, "0");
                var seconds = updatedTime.getSeconds().toString().padStart(2, "0");

                formattedTime = hours + ":" + minutes + ":" + seconds; 
                
            } else if (timeOfDay >= "13:00:00" && timeOfDay <= "17:30:00") {
                console.log(timeinvalue); // Output original time
                // document.getElementById("timecheck").value = timeinvalue;
                formattedTime=timeinvalue;
                //alert("asdaaa");
            } else {
                formattedTime=timeinvalue;
                //alert("asd");
                //alert("Time in is outside the specified range (not between 5am and 5pm)");
            }

            var time1Value = formattedTime;
           
            console.log(time1Value);
            // console.log(time2Value);
            console.log(otcount);

            var time1 = new Date("2000-01-01T" + time1Value);
            var time2 = new Date("2000-01-01T" + time2Value);
            var time3 = new Date("2000-01-01T" + readlvalue);
            //alert("time1: " + time1 + "\ntime2: " + time2);

            if (!isNaN(time1.getTime()) && !isNaN(time2.getTime())) {
                // var diff = new Date(time2 - time1);
                var realdiff = new Date(time3 - time1);
                // console.log(diff);
                console.log(realdiff);

                // var hours = diff.getUTCHours().toString().padStart(2, "0");
                // var minutes = diff.getUTCMinutes().toString().padStart(2, "0");
                // var seconds = diff.getUTCSeconds().toString().padStart(2, "0");

                // var result = hours + ":" + minutes + ":" + seconds;

                // console.log(result);

                var rhours = realdiff.getUTCHours().toString().padStart(2, "0");
                var rminutes = realdiff.getUTCMinutes().toString().padStart(2, "0");
                var rseconds = realdiff.getUTCSeconds().toString().padStart(2, "0");

                var rresult = rhours + ":" + rminutes + ":" + rseconds;
                // alert(rresult);
                console.log(rresult);

                $("#ottotalcompute").text(rresult);

                // var date = new Date("2000-01-01T" + result);
                // // Step 2: Add 30 minutes to the time
                // date.setMinutes(date.getMinutes() + otcount);

                // // Step 3: Format the updated time
                // var updatedTime = date.toTimeString().slice(0, 8);

                // $("#ojtottimerender").val(updatedTime);

            } else {
                console.log("Invalid time input");
                // alert("Invalid time input");
            }
        }
    }


$("#showdtr").click(function() {
var dtrid = $("#headeridot").val();
var dtrmonth = $("#dtrmonth option:selected").text();
var dtryear = $("#dtryear option:selected").text();
// alert(dtrid);
    $.ajax({
        url: "ojt_dtrform.php",
        method: "GET",
        success: function(data) {
            window.open("ojt_dtrform.php?dtrid=" + dtrid + "&dtrmonth=" + dtrmonth + "&dtryear=" + dtryear , "_blank");
        }
    });
});






});
    

</script>

<body style="overflow: hidden">
    <div class="loader"></div>
    <?php include 'navbar.php'; ?>
        <div  class="mb-3" style="padding: 20px 0px 0px 20px">
            <div class="mb-4">
                <h3>ON-THE-JOB TRAINING RECORD</h3>
            </div>
            <div class="row">
                <div class="col-9 input-group w-50 rounded">
                    <span class="input-group-text">SEARCH&nbsp; <i class="bi bi-search"></i></span>
                    <input type="search" id="ojt-search" name="ojt-search" class="form-control w-25">

                    <select name="dtrmonth" id="dtrmonth" class="form-select" style="margin-left: 10px;">
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

                    <select name="dtryear" id="dtryear" class="form-select" style="width: auto; margin-left: 10px;">
                    <script>
                        // create date options for the past 10 years
                        for (var i = 0; i < 10; i++) {
                        var date = new Date();
                        date.setFullYear(date.getFullYear() - i);
                        var option = document.createElement("option");
                        option.value = date.toISOString().slice(0, 10);
                        option.text = date.getFullYear();
                        document.getElementById("dtryear").appendChild(option);
                        }
                    </script>
                    </select>
                    
                    <select name="searchojtstatus" id="searchojtstatus" class="form-select" style="margin-left: 10px;">
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="COMPLETED">COMPLETED</option>
                        <option value="DISPATCHED">DISPATCHED</option>
                        <option value="ALL RECORD">ALL RECORD</option>
                    </select>
                </div>
            
                <div class="col-3">
                    <label for=""><b>NOTE: </b>The color coding will be displayed based on the selection of <i>'ALL RECORD'</i>, and the collection status will depend on it.</label>
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
        </div>

        <div class="dtr-table" style="padding: 0 20px;">
            <div class="day-scroll" style="height: 600px;">
            <table class="table table-hover table-bordered" style="width: 5000px; overflow: scroll;">
                <thead style="background: white; position: sticky; top: 0;">
                <tr class="text-center">
                    <div style="position: absolute; z-index: 100;">
                        <th style="width: 100px; position: sticky; left: 0; top: 0; background: white; z-index: 20">
                            <div class="d-flex justify-content-center firstnamesort">ID
                                <div class="sort" data-value="idnum">
                                    <div class="arrow arrow1 chevron1"></div>
                                </div>
                            </div>
                        </th>
                        <th style="position: sticky; left: 0; top: 0; background: white; z-index: 20">
                            <div class="d-flex justify-content-center firstnamesort">NAME
                                <div class="sort" data-value="nameintern">
                                    <div class="arrow arrow1 chevron1"></div>
                                </div>
                            </div>
                        </th>
                    </div>
                    
                    <th class="m-0 p-0">Monthly <br>Rendering hours</th>
                    <th class="m-0 p-0">Total <br>Rendering hours</th>
                    <td>1<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                 <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                 <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>2<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                 <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                 <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>3<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>4<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>5<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>6<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>7<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>8<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>9<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>10<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>11<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>12<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>13<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>14<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>
                    
                    <td>15<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>
                    
                    <td>16<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    
                    <td>17<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>
                    
                    <td>18<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>
                    
                    <td>19<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>
                    
                    <td>20<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>21<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>22<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>23<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>24<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>25<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>26<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>


                    <td>27<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>28<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>29<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>30<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>31<hr>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col">
                                <div class="in-out">In</div>
                            </div>
                            <div class="col">
                                <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>


                </tr>
                </thead>
                <tbody id="ojt-info">
                    <div id="error-message"></div>

                </tbody>
                
            </table>
            
            </div>
        </div>
    </div>

    <!-- modal for option for ojt -->
    <div class="modal fade" id="ojtmenu" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="ojtidheader"></h6>
                        <button class="btn-close" data-bs-dismiss="#exampleModalToggle" data-bs-toggle="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mb-2" name="showdtr" id="showdtr" style="width: 150px">DTR</button>
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#inputojtot" class="btn btn-dark mb-2 btn-ot" name="" id="" style="width: 150px">COUNT OT</button>
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#inputdtr" class="btn btn-primary mb-2 btn-adddtr" name="" id="" style="width: 150px">INPUT DTR</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <!-- input dtr -->
        <div class="modal fade" id="inputdtr" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="headernamedtr"></h4>
                    <input type="hidden" id="headeriddtr" name="headeriddtr">
                    <button class="btn-close" data-bs-toggle="modal" data-bs-target="#ojtmenu"></button>
                </div>

                <form id="formnewdtr" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <h4 class="text-center mb-4"><strong>ENTER NEW DAILY TIME RECORD</strong></h4>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <select id="dayselectdtr" name="dayselectdtr" class="form-select" >
                                    </select>
                                    <label for="dayselectdtr">Please select the Day</label>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-2">
                                            <input type="text" id="dtrtimein" name="dtrtimein" required data-mask="00.00" class="form-control">
                                            <label for="dtrtimein">Time in</label>
                                        </div>
                                    </div>
                                        =
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                            <select name="inputtimeinhours" id="inputtimeinhours" class="form-select">
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13  &nbsp;  (1pm)</option>
                                                <option value="14">14  &nbsp;  (2pm)</option>
                                                <option value="15">15  &nbsp;  (3pm)</option>
                                                <option value="16">16  &nbsp;  (4pm)</option>
                                                <option value="17">17  &nbsp;  (5pm)</option>
                                                <option value="18">18  &nbsp;  (6pm)</option>
                                                <option value="19">19  &nbsp;  (7pm)</option>
                                            </select>
                                            <p class="text-center">hours</p>
                                            </div>

                                            <div class="col">
                                            <select name="inputtimeinminutes" id="inputtimeinminutes" class="form-select">
                                                <option value="00">00</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                            </select>
                                            <p class="text-center">mins</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $("#inputtimeinhours, #inputtimeinminutes").on("change click", function() {
                                            var inhours = $("#inputtimeinhours").val();
                                            var inminutes = $("#inputtimeinminutes").val();
                                            var formattedTime = inhours.padStart(2, '0') + ":" + inminutes.padStart(2, '0') + ":00";
                                            $("#dtrtimein").val(formattedTime);
                                        });
                                    });
                                </script>
                                
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-2">
                                            <input type="text" id="dtrtimeout" name="dtrtimeout" required class="form-control">
                                            <label for="dtrtimeout">Time out</label>
                                        </div>
                                    </div>
                                        =
                                    <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <select name="inputtimeouthours" id="inputtimeouthours" class="form-select">
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13  &nbsp;  (1pm)</option>
                                                <option value="14">14  &nbsp;  (2pm)</option>
                                                <option value="15">15  &nbsp;  (3pm)</option>
                                                <option value="16">16  &nbsp;  (4pm)</option>
                                                <option value="17">17  &nbsp;  (5pm)</option>
                                                <option value="18">18  &nbsp;  (6pm)</option>
                                                <option value="19">19  &nbsp;  (7pm)</option>
                                            </select>
                                            <p class="text-center">hours</p>
                                            </div>

                                            <div class="col">
                                            <select name="inputtimeoutminutes" id="inputtimeoutminutes" class="form-select">
                                                <option value="00">00</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                            </select>
                                            <p class="text-center">mins</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $("#inputtimeouthours, #inputtimeoutminutes").on("change click", function() {
                                            var inhours = $("#inputtimeouthours").val();
                                            var inminutes = $("#inputtimeoutminutes").val();
                                            var outformattedTime = inhours.padStart(2, '0') + ":" + inminutes.padStart(2, '0') + ":00";
                                            $("#dtrtimeout").val(outformattedTime);
                                        });
                                    });
                                </script>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <select id="otaddtodtr" name="otaddtodtr" class="form-select">
                                        <option value="0">00:00:00</option>
                                        <option value="30">00:30:00</option>
                                        <option value="40">00:40:00</option>
                                        <option value="50">00:50:00</option>
                                        <option value="60">01:00:00</option>
                                        <option value="70">01:10:00</option>
                                        <option value="80">01:20:00</option>
                                        <option value="90">01:30:00</option>
                                        <option value="100">01:40:00</option>
                                        <option value="110">01:50:00</option>
                                        <option value="120">02:00:00</option>
                                    </select>
                                    <label for="sname">Select counted OT</label>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark dtrcompute">COMPUTE</button>
                                    <button type="button" class="btn btn-secondary cancelcompute">CANCEL</button>
                                </div>

                                <div class="form-floating">
                                    <input type="text" id="dtrtimerender" required name="dtrtimerender" class="form-control">
                                    <label for="dtrtimerender">Time render</label>
                                </div>
                                <label for="">Real computation : <b style="color: red;" id="inputtotalcompute">00</b></label>
                                
                            </div>
                        </div>
                    </div>
                    <div style="padding: 0px 15px;">
                        <p>Note:<br>
                            <i>
                            - If the OJT Time-in is between 5 am and 12 pm, <b>subtract one hour</b> (lunchtime)<br>
                            - However, if the Time-out is also between 5 am and 12 pm, <b>no hour is subtracted</b><br>
                            - If the Time-out is 5:30 pm or 5:00pm, it is considered as 5 pm.<br>
                            - To include <b>OJT overtime</b>, choose "Select counted OT" option.<br>
                            - The time in this field uses the <b>24-hour format.</b><br>
                            </i>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary submitdtrbtn" disabled>Submit</button>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $("#dtrtimerender, #dtrtimein, #dtrtimeout").on("change", function() {
                                var dtrtimerender = $("#dtrtimerender").val();
                                var dtrtimein = $("#dtrtimein").val();
                                var dtrtimeout = $("#dtrtimeout").val();

                                if (dtrtimerender !== "" && dtrtimein !== "" && dtrtimeout !== "") {
                                    $(".submitdtrbtn").prop("disabled", false);
                                } else {
                                    $(".submitdtrbtn").prop("disabled", true);
                                }
                            });
                        });
                    </script>
                </form>     
            </div>
        </div>
    </div>

    
    <!-- input ots -->
        <div class="modal fade" id="inputojtot" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="headernameot"></h4>
                        <input type="hidden" id="headeridot" name="headeridot">
                        <button class="btn-close" data-bs-toggle="modal" data-bs-target="#ojtmenu"></button>
                    </div>
<!-- id="formupdatedtr" action="ojt_tablecrud.php"  -->
                    <form id="formupdatedtr" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <h4 class="text-center mb-4"><strong>COUNT OJT OVERTIME</strong></h4>
                        <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                            <select id="dayselectot" name="dayselectot" class="form-select dayselectot"></select>
                            <label for="dayselectot">Please select the Day.</label>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="text" id="ojtottimein" name="ojtottimein" class="form-control" required>
                                        <label for="ojtottimein">Time in</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                        <select name="ottimeinhours" id="ottimeinhours" class="form-select">
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13  &nbsp;  (1pm)</option>
                                            <option value="14">14  &nbsp;  (2pm)</option>
                                            <option value="15">15  &nbsp;  (3pm)</option>
                                            <option value="16">16  &nbsp;  (4pm)</option>
                                            <option value="17">17  &nbsp;  (5pm)</option>
                                            <option value="18">18  &nbsp;  (6pm)</option>
                                            <option value="19">19  &nbsp;  (7pm)</option>
                                        </select>
                                        <p class="text-center">hours</p>
                                        </div>

                                        <div class="col">
                                            <select name="ottimeinminutes" id="ottimeinminutes" class="form-select">
                                                <option value="00">00</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                            </select>
                                            <p class="text-center">mins</p>
                                        </div>

                                        <div class="col-1 m-0 p-0 timeinot" style="cursor: pointer;">
                                            <i class="bi bi-calculator"></i>
                                        </div>
                                <script>
                                    $(document).ready(function(){
                                        $(".timeinot").on("click", function() {
                                            var inhours = $("#ottimeinhours").val();
                                            var inminutes = $("#ottimeinminutes").val();
                                            var outformattedTime = inhours.padStart(2, '0') + ":" + inminutes.padStart(2, '0') + ":00";
                                            var confirmation = confirm("The timein will be modified/updated!");
                                            if (confirmation) {
                                                $("#ojtottimein").val(outformattedTime);
                                            }
                                        });
                                    });
                                </script>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="text" id="ojtottimeout" name="ojtottimeout" class="form-control" required>
                                        <label for="ojtottimeout">Time out</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                        <select name="ottimeouthours" id="ottimeouthours" class="form-select">
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13  &nbsp;  (1pm)</option>
                                            <option value="14">14  &nbsp;  (2pm)</option>
                                            <option value="15">15  &nbsp;  (3pm)</option>
                                            <option value="16">16  &nbsp;  (4pm)</option>
                                            <option value="17">17  &nbsp;  (5pm)</option>
                                            <option value="18">18  &nbsp;  (6pm)</option>
                                            <option value="19">19  &nbsp;  (7pm)</option>
                                        </select>
                                        <p class="text-center">hours</p>
                                        </div>

                                        <div class="col">
                                            <select name="ottimeoutminutes" id="ottimeoutminutes" class="form-select">
                                                <option value="00">00</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                            </select>
                                            <p class="text-center">mins</p>
                                        </div>
                                        
                                        <div class="col-1 m-0 p-0 timeoutot" style="cursor: pointer;">
                                            <i class="bi bi-calculator"></i>
                                        </div>
                                <script>
                                    $(document).ready(function(){
                                        $(".timeoutot").on("click", function() {
                                            var inhours = $("#ottimeouthours").val();
                                            var inminutes = $("#ottimeoutminutes").val();
                                            var outformattedTime = inhours.padStart(2, '0') + ":" + inminutes.padStart(2, '0') + ":00";
                                            var confirmation = confirm("The timeout will be modified/updated!");
                                            if (confirmation) {
                                                $("#ojtottimeout").val(outformattedTime);
                                            }
                                        });
                                    });
                                </script>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-1">
                            <select id="countaddtodtr" name="countaddtodtr" class="form-select">
                                <option value="0">00:00:00</option>
                                <option value="30">00:30:00</option>
                                <option value="40">00:40:00</option>
                                <option value="50">00:50:00</option>
                                <option value="60">01:00:00</option>
                                <option value="70">01:10:00</option>
                                <option value="80">01:20:00</option>
                                <option value="90">01:30:00</option>
                                <option value="100">01:40:00</option>
                                <option value="110">01:50:00</option>
                                <option value="120">02:00:00</option>
                            </select>
                            <label for="countaddtodtr">Select counted OT</label>
                            </div>

                            <div class="modal-footer">
                            <button type="button" class="btn btn-dark otcompute">RECOMPUTE</button>
                            <button type="button" class="btn btn-secondary cancelotcompute">CANCEL</button>
                            </div>

                            <input type="hidden" id="hideojtottimerender" name="hideojtottimerender" class="form-control">
                            <div class="form-floating mb-2">
                            <input type="text" id="ojtottimerender" name="ojtottimerender" class="form-control" required>
                            <label>Render time</label>
                            </div>
                            <label for="">Real computation : <b id="ottotalcompute" style="color: red;">00</b></label>
                        </div>
                        </div>
                        <div style="padding: 0px 15px;">
                        <p>Note:<br>
                            <i>
                            - If the OJT Time-in is between 5 am and 12 pm, <b>subtract one hour</b> (lunchtime)<br>
                            - However, if the Time-out is also between 5 am and 12 pm, <b>no hour is subtracted</b><br>
                            - If the Time-out is 5:30 pm or 5:00pm, it is considered as 5 pm.<br>
                            - To include <b>OJT overtime</b>, choose "Select counted OT" option.<br>
                            - The time in this field uses the <b>24-hour format.</b><br>
                            </i>
                        </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- id="deletesavedtrrecord" name="deletesavedtrrecord" -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletedtrrecord" id="showdeletecommand" disabled>DELETE</button>
                        <button type="submit" class="btn btn-primary" id="submitcommand" disabled>SUBMIT</button>
                    </div>
                    </form>
                </div>
                
            </div>
        </div>

        <div class="modal" id="deletedtrrecord" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">DELETE COMMAND</h4>
                        <button class="btn-close" data-bs-target="#inputojtot" data-bs-toggle="modal"></button>
                    </div>
                        <div class="modal-body">
                            <p class="text-center mt-2" style="font-size: 12px;">The DTR record for <b id="ojtnamelabel"></b> (<b id="ojtidlabel"></b>) dated <b id="monthlabel"></b> <b id="daylabel"></b> <b id="yearlabel"></b> will be permanently deleted.</p>
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" id="deltypeyes" name="deltypeyes" placeholder=" " class="form-control required" required>
                                    <label for="sname">Please type yes/YES to continue deleting...</label>
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer"> 
                                <button type="submit" class="btn btn-danger mb-2" name="deletesavedtrrecord" id="deletesavedtrrecord">Delete</button>
                            </div>
                        </div>
                </div>
            </div> 
        </div>
</body>
<script>
    $(document).ready(function(){
        $('#showdeletecommand').on('click', function() {
            var delday = $("#dayselectot option:selected").text();
            var delmonth = $("#dtrmonth option:selected").text();
            var delyear = $("#dtryear option:selected").text();
            var delheaderidot = $("#headeridot").val();
            var delheadernameot = $("#headernameot").text();
            // alert(delday + " " + delmonth + " " + delyear + " " + delheaderidot + " " + delheadernameot);
            $("#ojtnamelabel").text(delheadernameot);
            $("#ojtidlabel").text(delheaderidot);
            $("#monthlabel").text(delmonth);
            $("#daylabel").text(delday);
            $("#yearlabel").text(delyear);
        });

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
      var dtryear = $("#dtryear option:selected").text();
      var dtrmonth = $("#dtrmonth option:selected").val();
      var searchojtstatus = $("#searchojtstatus").val();
      var sortsortval = sortval;
      alert(dtrmonth + dtryear + searchojtstatus + sortsortval + sortwhat);
      $.ajax({
          url: "ojt_tablemonthly_proc.php",
          type: "POST",
          data: {
            dtryear: dtryear,
            dtrmonth:dtrmonth,
            searchojtstatus:searchojtstatus,
            sortsortval: sortsortval,
            sortwhat:sortwhat
          },
          success: function(data) {
              $("#ojt-info").html(data);
          }
      });
  }





        
        // $(".cancelotcompute").click(function() {
        //     var otcount = parseInt("0");
        //     $("#countaddtodtr option:selected").text("00:00:00");
        //     otcountcompute(otcount)
        // })

        // $(".otcompute").click(function() {
        //     var otcount = parseInt($("#countaddtodtr").val());
        //     otcountcompute(otcount)
        // })

        // $(".dayselectot").on("change", function() {
        //     var otcount = parseInt($("#countaddtodtr").val());
        //     alert(otcount);
        //     otcountcompute();
        // })

        // function otcountcompute(otcount){
        //     // var rendertime = $("#hideojtottimerender").val();
        //     // var date = new Date("2000-01-01T" + rendertime);
        //     //     // Step 2: Add 30 minutes to the time
        //     // date.setMinutes(date.getMinutes() + otcount);

        //     // var updatedTime = date.toTimeString().slice(0, 8);
        //     // $("#ojtottimerender").val(updatedTime);
        // var ojtottimein = $("#ojtottimein").val();
        // var ojtottimeout = $("#ojtottimeout").val();

        // // time in     
        // var timeinvalue = $("#ojtottimein").val();

        // var timein = new Date(); // Assuming `timein` is a valid Date object
        // var timeArray = ojtottimein.split(':');
        // timein.setHours(parseInt(timeArray[0]));
        // timein.setMinutes(parseInt(timeArray[1]));
        // timein.setSeconds(parseInt(timeArray[2]));
        
        // var hoursFormatted = timein.getHours().toString().padStart(2, "0");
        // var minutesFormatted = timein.getMinutes().toString().padStart(2, "0");
        // var secondsFormatted = timein.getSeconds().toString().padStart(2, "0");

        // var timeOfDay = hoursFormatted + ":" + minutesFormatted + ":" + secondsFormatted;
        
        // // time out
        // var timeoutvalue = $("#ojtottimeout").val();

        // var timeout = new Date(); // Assuming `timein` is a valid Date object
        // var timeArray = timeoutvalue.split(':');
        // timeout.setHours(parseInt(timeArray[0]));
        // timeout.setMinutes(parseInt(timeArray[1]));
        // timeout.setSeconds(parseInt(timeArray[2]));
        
        // var hoursFormattedout = timeout.getHours().toString().padStart(2, "0");
        // var minutesFormattedout = timeout.getMinutes().toString().padStart(2, "0");
        // var secondsFormattedout = timeout.getSeconds().toString().padStart(2, "0");

        // var timeOfDayout = hoursFormattedout + ":" + minutesFormattedout + ":" + secondsFormattedout;

        // var formattedTime = "";
        // // alert(timeOfDayout)

        // var readlvalue = 0;

        // var time2valueout = document.getElementById("ojtottimeout").value;
        // var time2Value = "";

        // if (timeOfDayout >= "17:00:00" && timeOfDayout <= "20:30:00") {
        //     time2Value = "17:00:00";
        // }else{
        //     time2Value = time2valueout;
        // }

        // readlvalue = time2valueout;

        // if (!isNaN(timein.getTime())) { 
        //     if (timeOfDay >= "05:00:00" && timeOfDay <= "12:59:59" && !(timeOfDayout >= "05:00:00" && timeOfDayout <= "12:59:59")) {
        //         var updatedTime = new Date(timein.getTime() + (60 * 60 * 1000));
        //         var hours = updatedTime.getHours().toString().padStart(2, "0");
        //         var minutes = updatedTime.getMinutes().toString().padStart(2, "0");
        //         var seconds = updatedTime.getSeconds().toString().padStart(2, "0");

        //         formattedTime = hours + ":" + minutes + ":" + seconds; 
                
        //     } else if (timeOfDay >= "13:00:00" && timeOfDay <= "17:30:00") {
        //         console.log(timeinvalue); // Output original time
        //         // document.getElementById("timecheck").value = timeinvalue;
        //         formattedTime=timeinvalue;
        //         //alert("asdaaa");
        //     } else {
        //         formattedTime=timeinvalue;
        //         //alert("asd");
        //         //alert("Time in is outside the specified range (not between 5am and 5pm)");
        //     }

        //     var time1Value = formattedTime;
           
        //     console.log(time1Value);
        //     console.log(time2Value);
        //     console.log(otcount);

        //     var time1 = new Date("2000-01-01T" + time1Value);
        //     var time2 = new Date("2000-01-01T" + time2Value);
        //     var time3 = new Date("2000-01-01T" + readlvalue);
        //     //alert("time1: " + time1 + "\ntime2: " + time2);

        //     if (!isNaN(time1.getTime()) && !isNaN(time2.getTime())) {
        //         var diff = new Date(time2 - time1);
        //         var realdiff = new Date(time3 - time1);
        //         console.log(diff);
        //         console.log(realdiff);

        //         var hours = diff.getUTCHours().toString().padStart(2, "0");
        //         var minutes = diff.getUTCMinutes().toString().padStart(2, "0");
        //         var seconds = diff.getUTCSeconds().toString().padStart(2, "0");

        //         var result = hours + ":" + minutes + ":" + seconds;

        //         console.log(result);

        //         var rhours = realdiff.getUTCHours().toString().padStart(2, "0");
        //         var rminutes = realdiff.getUTCMinutes().toString().padStart(2, "0");
        //         var rseconds = realdiff.getUTCSeconds().toString().padStart(2, "0");

        //         var rresult = rhours + ":" + rminutes + ":" + rseconds;

        //         console.log(rresult);

        //         $("#ottotalcompute").text(rresult);

        //         var date = new Date("2000-01-01T" + result);
        //         // Step 2: Add 30 minutes to the time
        //         date.setMinutes(date.getMinutes() + otcount);

        //         // Step 3: Format the updated time
        //         var updatedTime = date.toTimeString().slice(0, 8);

        //         $("#ojtottimerender").val(updatedTime);

        //     } else {
        //         console.log("Invalid time input");
        //         // alert("Invalid time input");
        //     }
        // }
        // }

                    
        // $(".cancelcompute").click(function() {
        //     var otcount = "0";
        //     $("#otaddtodtr option:selected").text("00:00:00");
        //     computerender(otcount);
        // })

        // $(".dtrcompute").click(function() {
        //     var otcount = parseInt($("#otaddtodtr").val());
        //     alert(otcount);
        //     computerender(otcount);
        // })

        // function computerender(otcount){
        // var ojtottimein = $("#dtrtimein").val();
        // var ojtottimeout = $("#dtrtimeout").val();

        // // time in     
        // var timeinvalue = $("#dtrtimein").val();

        // var timein = new Date(); // Assuming `timein` is a valid Date object
        // var timeArray = ojtottimein.split(':');
        // timein.setHours(parseInt(timeArray[0]));
        // timein.setMinutes(parseInt(timeArray[1]));
        // timein.setSeconds(parseInt(timeArray[2]));
        
        // var hoursFormatted = timein.getHours().toString().padStart(2, "0");
        // var minutesFormatted = timein.getMinutes().toString().padStart(2, "0");
        // var secondsFormatted = timein.getSeconds().toString().padStart(2, "0");

        // var timeOfDay = hoursFormatted + ":" + minutesFormatted + ":" + secondsFormatted;
        
        // // time out
        // var timeoutvalue = $("#dtrtimeout").val();

        // var timeout = new Date(); // Assuming `timein` is a valid Date object
        // var timeArray = timeoutvalue.split(':');
        // timeout.setHours(parseInt(timeArray[0]));
        // timeout.setMinutes(parseInt(timeArray[1]));
        // timeout.setSeconds(parseInt(timeArray[2]));
        
        // var hoursFormattedout = timeout.getHours().toString().padStart(2, "0");
        // var minutesFormattedout = timeout.getMinutes().toString().padStart(2, "0");
        // var secondsFormattedout = timeout.getSeconds().toString().padStart(2, "0");

        // var timeOfDayout = hoursFormattedout + ":" + minutesFormattedout + ":" + secondsFormattedout;

        // var formattedTime = "";
        // // alert(timeOfDayout)
        // var readlvalue = 0;

        // var time2valueout = document.getElementById("dtrtimeout").value;
        // var time2Value = "";

        // if (timeOfDayout >= "17:00:00" && timeOfDayout <= "20:30:00") {
        //     time2Value = "17:00:00";
        // }else{
        //     time2Value = time2valueout;
        // }

        // readlvalue = time2valueout;

        // if (!isNaN(timein.getTime())) { 
        //     if (timeOfDay >= "05:00:00" && timeOfDay <= "12:59:59" && !(timeOfDayout >= "05:00:00" && timeOfDayout <= "12:59:59")) {
        //         var updatedTime = new Date(timein.getTime() + (60 * 60 * 1000));
        //         var hours = updatedTime.getHours().toString().padStart(2, "0");
        //         var minutes = updatedTime.getMinutes().toString().padStart(2, "0");
        //         var seconds = updatedTime.getSeconds().toString().padStart(2, "0");

        //         formattedTime = hours + ":" + minutes + ":" + seconds; 
                
        //     } else if (timeOfDay >= "13:00:00" && timeOfDay <= "17:30:00") {
        //         console.log(timeinvalue); // Output original time
        //         // document.getElementById("timecheck").value = timeinvalue;
        //         formattedTime=timeinvalue;
        //         //alert("asdaaa");
        //     } else {
        //         formattedTime=timeinvalue;
        //         //alert("asd");
        //         //alert("Time in is outside the specified range (not between 5am and 5pm)");
        //     }

        //     var time1Value = formattedTime;
           
        //     console.log(time1Value);
        //     console.log(time2Value);
        //     console.log(otcount);

        //     var time1 = new Date("2000-01-01T" + time1Value);
        //     var time2 = new Date("2000-01-01T" + time2Value);
        //     var time3 = new Date("2000-01-01T" + readlvalue);
        //     //alert("time1: " + time1 + "\ntime2: " + time2);

        //     if (!isNaN(time1.getTime()) && !isNaN(time2.getTime())) {
        //         var diff = new Date(time2 - time1);
        //         var realdiff = new Date(time3 - time1);
        //         console.log(diff);
        //         console.log(realdiff);

        //         var hours = diff.getUTCHours().toString().padStart(2, "0");
        //         var minutes = diff.getUTCMinutes().toString().padStart(2, "0");
        //         var seconds = diff.getUTCSeconds().toString().padStart(2, "0");

        //         var result = hours + ":" + minutes + ":" + seconds;

        //         console.log(result);

        //         var rhours = realdiff.getUTCHours().toString().padStart(2, "0");
        //         var rminutes = realdiff.getUTCMinutes().toString().padStart(2, "0");
        //         var rseconds = realdiff.getUTCSeconds().toString().padStart(2, "0");

        //         var rresult = rhours + ":" + rminutes + ":" + rseconds;

        //         console.log(rresult);

        //         $("#inputtotalcompute").text(rresult);

        //         var date = new Date("2000-01-01T" + result);
        //         // Step 2: Add 30 minutes to the time
        //         date.setMinutes(date.getMinutes() + otcount);

        //         // Step 3: Format the updated time
        //         var updatedTime = date.toTimeString().slice(0, 8);

        //         $("#dtrtimerender").val(updatedTime);

        //     } else {
        //         console.log("Invalid time input");
        //         // alert("Invalid time input");
        //     }
        // }
      

        // // save new input dtr
        // }




        //         $("#showdtr").click(function() {
        //         var dtrid = $("#headeridot").val();
        //         var dtrmonth = $("#dtrmonth option:selected").text();
        //         var dtryear = $("#dtryear option:selected").text();
        //         // alert(dtrid);
        //             $.ajax({
        //                 url: "ojt_dtrform.php",
        //                 method: "GET",
        //                 success: function(data) {
        //                     window.open("ojt_dtrform.php?dtrid=" + dtrid + "&dtrmonth=" + dtrmonth + "&dtryear=" + dtryear , "_blank");
        //                 }
        //             });
        //         });
                
            });
        </script>
</html>