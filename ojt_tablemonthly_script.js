
$(document).ready(function(){
        
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

    $("#dtrmonth").change(function(){
        loadojttable();
    });

    $("#dtryear").change(function(){
        loadojttable();
    });

    $("#searchojtstatus").change(function(){
        loadojttable();
    });
    
    loadojttable();

    function loadojttable(){
        var dtrmonth = $("#dtrmonth option:selected").text();
        var dtryear = $("#dtryear option:selected").text();
        var searchojtstatus = $("#searchojtstatus option:selected").text();
        // alert(dtrmonth);
        $.ajax({
            url:"ojt_tablemonthly_proc.php",
            method:"POST",
            data: {dtrmonth: dtrmonth, dtryear: dtryear,searchojtstatus:searchojtstatus},

            // if the data successful the data will show
            success:function(data){
                $("#ojt-info").html(data);
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
        $('#dayselectot').val("1");
        $('#ojtottimein').val("");
        $('#ojtottimeout').val("");
        $('#ojtottimerender').val("");
        $("#hideojtottimerender").val("");
        $("#countaddtodtr option:selected").text("00:00:00");
    })

    $(".btn-adddtr").click(function() {
        $('#dayselectdtr').val("1");
        $('#dtrtimein').val("");
        $('#dtrtimeout').val("");
        $("#dtrtimerender").val("");
        $("#otaddtodtr option:selected").text("00:00:00");
        // $('#ojtottimerender').val("");
    })

    // // this code for selecting the time for ot
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
                            iziToast.warning({
                                title: 'Save',
                                message: 'Saving new dtr record'
                            });
                            // iload ang data na nilagyan ng bagong data
                            displayemptyadd()
                        }else if (response.trim() === "DTR record updated") {
                            iziToast.warning({
                                title: 'Save',
                                message: 'Update your DTR'
                            });    
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
        var upformData = new FormData($(this)[0]);
        var dtrmonth = $("#dtrmonth option:selected").text();
        var dtryear = $("#dtryear option:selected").text();
        var headernameot = $("#headernameot").text();
        var headeridot = $("#headeridot").val();
        upformData.append('dtrmonth', dtrmonth);
        upformData.append('dtryear', dtryear);
        upformData.append('headeridot', headeridot);
        upformData.append('headernameot', headernameot);
        alert(upformData);

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

                $('#dayselectdtr').val("1");
                $('#dtrtimein').val("");
                $('#dtrtimeout').val("");
                $("#dtrtimerender").val("");
                $("#otaddtodtr option:selected").text("00:00:00");
            }


    // this code for selecting the time for ot
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
            }else{
                $('#ojtottimein').val(data[0].Timein);
                $('#ojtottimeout').val(data[0].timeout);
                $('#ojtottimerender').val(data[0].timerender);
                $('#hideojtottimerender').val(data[0].timerender);
                var otcount = parseInt($("#countaddtodtr").val());
                alert(otcount);
                otcountcompute(otcount)
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

    function otcountcompute(otcount){
    var ojtottimein = $("#ojtottimein").val();
    // var ojtottimeout = $("#ojtottimeout").val();

    // time in     
    // var timeinvalue = $("#ojtottimein").val();

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

            var result = hours + ":" + minutes + ":" + seconds;

            console.log(result);

            var rhours = realdiff.getUTCHours().toString().padStart(2, "0");
            var rminutes = realdiff.getUTCMinutes().toString().padStart(2, "0");
            var rseconds = realdiff.getUTCSeconds().toString().padStart(2, "0");

            var rresult = rhours + ":" + rminutes + ":" + rseconds;

            console.log(rresult);

            $("#ottotalcompute").text(rresult);

            var date = new Date("2000-01-01T" + result);
            // Step 2: Add 30 minutes to the time
            date.setMinutes(date.getMinutes() + otcount);

            // Step 3: Format the updated time
            var updatedTime = date.toTimeString().slice(0, 8);

            $("#ojtottimerender").val(updatedTime);

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
        alert(otcount);
        computerender(otcount);
    })

    function computerender(otcount){
    var ojtottimein = $("#dtrtimein").val();
    var ojtottimeout = $("#dtrtimeout").val();

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

            var result = hours + ":" + minutes + ":" + seconds;

            console.log(result);

            var rhours = realdiff.getUTCHours().toString().padStart(2, "0");
            var rminutes = realdiff.getUTCMinutes().toString().padStart(2, "0");
            var rseconds = realdiff.getUTCSeconds().toString().padStart(2, "0");

            var rresult = rhours + ":" + rminutes + ":" + rseconds;

            console.log(rresult);

            $("#inputtotalcompute").text(rresult);

            var date = new Date("2000-01-01T" + result);
            // Step 2: Add 30 minutes to the time
            date.setMinutes(date.getMinutes() + otcount);

            // Step 3: Format the updated time
            var updatedTime = date.toTimeString().slice(0, 8);

            $("#dtrtimerender").val(updatedTime);

        } else {
            console.log("Invalid time input");
            // alert("Invalid time input");
        }
    }
  

    // save new input dtr
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
