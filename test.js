
// Script
$(document).ready(function(){
    // all input text will be written iin upper case
    $("input:text").keyup(function(){
        var val = $(this).val();
        $(this).val(val.toUpperCase());
    });

    // clicking addnewchart display on under the name of the person
    $(".addnewchart").click("click",function(){
        var underorg = $("#searchchart").html();
        // alert(underorg);
        $("#underorg").val(underorg);
    });
    
    $("#printchartbtn").click("click",function(){
        var underorg = $("#searchchart").html();
        window.location.href="orgchart_print.php?under=" + underorg;
    });


    loadchart();
    // Load the orgchart

    function loadchart(){
        var under = "ASSISTANT SECRETARY";
        loadselectchart(under);
    }
    
    $(".select-item").click("click",function(){
        
          var under = $(this).html();
          // alert(under);
        // loadupdatechart();
          document.getElementById("updateside").disabled = false;
          document.getElementById("printchartbtn").disabled = false;
          document.getElementById("addnewchart").disabled = false;
        loadselectchart(under);
    });

    function loadupdatechart(){
        var under = $('#searchchart').html();
        window.location.href="orgchart_list.php?select=" + under;
    }
    // if your getting variable from one function to another get the variable to read to another
    function loadselectchart(under){
        if(under != ""){
            $.ajax({
                // it direct to the php file with this ID input
                url:"orgchart_loadchart.php",//orgsearchunder.php
                method:"POST",
                data:{under:under}, //the value of this is the value you want to search

                // if the data successful the data will show
                success:function(data){
                    $("#content").html(data);
                }
            });
        }else{
            // display none
            $("#content").css("display","none");
        }
    }

// load the record you want to update
    // $("#sidecontent").change(function(){
    $("#updateside").click("click",function(){
        // var sidecontent = $(this).val();
        var sidecontent = $("#searchchart").val();
        // alert(sidecontent);
          if(sidecontent != ""){
            // alert(sidecontent);
            $.ajax({
            // alert(under);
                // it direct to the php file with this ID input
                url: "orgchart_search.php",//orgsearchunder.php
                method: "POST",
                data:{sidecontent:sidecontent}, //the value of this is the value you want to search

                // if the data successful the data will show
                success:function(data){
                // alert(under);
                    $("#load-to-update").html(data);
                    var upname = $("#upname").val();
                    var upid = $("#upid").val();
                    var upimg = $("#up-img").val();
                    $("#deleid").val(upid);
                    $("#delename").val(upname + ".png");
                    $("#personelname").text(upname);
                }
            });
          }else{
            // display none
            $("#load-to-update").html("<b style='font-size: 25px;'>NO DATA FOUND</b>");
          }
    });

    $('#delmyform').on('submit', function(e) {
        e.preventDefault();
        var upformData = $(this).serialize();
        alert(upformData);
    
        $.ajax({
            url: "orgchart_delete.php",
            method: "POST",
            data: upformData,
            success: function(response) {
                if (response === "delete successfully") {
                    iziToast.warning({
                        title: 'Deleted',
                        message: 'Personnel information deleted successfully'
                    });
    
                    // Reload the webpage after the data is deleted successfully
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }else if (response === "type yes") {
                    iziToast.warning({
                        title: 'Wrong',
                        message: 'Type yes /YES to confirm!'
                    });
                } else {
                    iziToast.warning({
                        title: 'Something went wrong',
                        message: 'Please try again!'
                    });
                }
            },
            error: function(xhr, status, error) {
                iziToast.warning({
                    title: 'Something went wrong',
                    message: 'Please tryy again!'
                });
            }
        });
    });

    $('#myform').on('submit', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        alert(formData);
        if(formData){
            $.ajax({
                url: "orgchart_savedata.php",
                type: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    if(response == "Duplicate data found"){
                        iziToast.warning({
                        title: 'duplicate',
                        message: 'Please check the name / position!'
                        });
                        // const modal = document.getElementById("myModal");
                        // modal.style.display = "none";

                    }else if(response == "Data added successfully"){
                        iziToast.success({
                        title: 'success',
                        message: 'New personnel added successful'
                        });

                        $("#name").val("");
                        $("#image").val("");
                        $('#sg').val("");
                        $('#position').val("");
                        $('#underorg').val("");

                        // it will call the chart to load
                        var under = $("#searchchart").html();
                        alert(under);
                        loadselectchart(under);
                    }
                }
            });
        }
        else{
            $.ajax({
                success: function(response) {
                    iziToast.warning({
                        title: 'Empty',
                        message: 'Please fill out this form completely'
                    });
                }
            });
        }
    });

// update the value at the sidebar
    $('#upmyform').on('submit', function(event) {
        event.preventDefault();
        var upformData = $(this).serialize();

        alert(upformData);

        if(upformData){
            $.ajax({  
                url: "orgchart_search_update.php",
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                
                success: function(data) {
                    if (data === "update successfully") {
                        iziToast.info({
                            title: 'Updated',
                            message: 'New personnel added successfully'
                        });
                        form[0].reset();
                        var under = $("#searchchart").html();
                        // alert(under);
                        loadselectchart(under);
                    } else if (data === "Duplicate data found") {
                        iziToast.warning({
                            title: 'Duplicate',
                            message: 'Please check the name/position!'
                        });
                    } 
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    iziToast.error({
                        title: 'Error',
                        message: 'An error occurred while processing your request'
                    });
                }
            });
        }
    });

    $('#movemyform').on('submit', function(event) {
        event.preventDefault();
        var upformData = $(this).serialize();

        alert(upformData);

        if(upformData){
            $.ajax({  
                url: "orgchart_list_upmove.php",
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                
                success: function(data) {
                    if (data === "move personnel successfully") {
                        iziToast.info({
                            title: 'Updated',
                            message: 'New personnel added successfully'
                        });
                        // loadchart();
                        setTimeout(function() {
                            var moveload = $("#moveunder").val();
                            window.location.href="orgchart_list.php?select=" + moveload;
                        }, 1500);
                        // form[0].reset();
                    } else if (data === "Duplicate data found") {
                        iziToast.warning({
                            title: 'Duplicate',
                            message: 'Please check the name/position!'
                        });
                    } 
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    iziToast.error({
                        title: 'Error',
                        message: 'An error occurred while processing your request'
                    });
                }
            });
        }
    });



    
    // This code is for loading the data from the seach of who they reported.

    // Get the custom select element
    var customSelect = document.querySelector(".custom-select");

    // Get the selected element
    var selectSelected = customSelect.querySelector(".form-selected");

    // Get the items container element
    var selectItems = customSelect.querySelector(".select-items");

    // Get the item elements
    var selectItem = selectItems.querySelectorAll(".select-item");

    // Get the search input element
    var selectSearch = customSelect.querySelector(".form-control");

    // Add a click event listener to the selected element
    selectSelected.addEventListener("click", function() {
    // Toggle the active class on the selected element to show/hide the dropdown
    this.classList.toggle("select-arrow-active");

    // Toggle the active class on the items container to show/hide the items
    selectItems.classList.toggle("select-hide");
    });

    // Loop through the item elements and add a click event listener to each one
    for (var i = 0; i < selectItem.length; i++) {
    selectItem[i].addEventListener("click", function() {
        // Get the text content of the selected item
        var selectedText = this.textContent;

        // Set the text content of the selected element to the selected text
        selectSelected.textContent = selectedText;
        selectSelected.value = selectedText;

        // Remove the active class from all item elements
        for (var j = 0; j < selectItem.length; j++) {
        selectItem[j].classList.remove("same-as-selected");
        }

        // Add the active class to the selected item element
        this.classList.add("same-as-selected");

        // Hide the items container
        selectItems.classList.add("select-hide");

        // Remove the active class from the selected element
        selectSelected.classList.remove("select-arrow-active");
    });
    }

    // Add a keyup event listener to the search input to filter the items
    selectSearch.addEventListener("keyup", function() {
    // Get the value of the search input
    var input = this.value.toLowerCase();

    // Loop through the item elements and hide/show based on search input
    for (var i = 0; i < selectItem.length; i++) {
        // Get the text content of the current item
        var text = selectItem[i].textContent.toLowerCase();

        // If the search input matches the item text, show the item
        if (text.indexOf(input) > -1) {
        selectItem[i].style.display = "block";
        } else {
        // Otherwise, hide the item
        selectItem[i].style.display = "none";
        }
    }
    });

    

});
