<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location:views_login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "partials_header.php"?>
    <title>Daily time record</title>
    <link rel="stylesheet" href="ojt_dtrform.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="arrow.css">
    <link rel="stylesheet" type="text/css" href="loading.css">
    <script src="loading.js" defer></script>
</head>
<script>
    $(document).ready(function(){

        $("#pds-search").on("keyup", function() {
            var searchinput= $(this).val();
            var selectedOption = $("#pdsyear").find(":selected");
            var yearload = new Date(selectedOption.val()).getFullYear();
            var endload = yearload - 15;
            var sortval = "lname";
            var sortwhat = "ASC";
            $.ajax({
                url:"pds_checklistproc.php",//orgsearchunder.php
                method:"POST",
                data: {
                    searchinput:searchinput,
                    yearload: yearload,
                    endload:endload,
                    sortval:sortval,
                    sortwhat:sortwhat
                },
  
                // if the data successful the data will show
                success:function(data){
                    $("#pdslist").html(data);
                }
            });
        });

        $("#pdsyear").change(function(){
            looptryear();
        });

        looptryear();

        funtion looptryear(){
            var selectedOption = $("#pdsyear").find(":selected");
            var yearload = new Date(selectedOption.val()).getFullYear();
            var endload = yearload - 15;
            var sortval = "lname";
            var sortwhat = "ASC";c
            $.ajax({
                url:"pds_year.php",
                method:"POST",
                data: {
                    yearload: yearload,
                    endload:endload
                },

                success:function(data){
                    $("#loopyear").html(data);
                }
            });

            $.ajax({
                url:"pds_checklistproc.php",
                method:"POST",
                data: {
                    yearload: yearload,
                    endload:endload,
                    sortval:sortval,
                    sortwhat:sortwhat
                },

                success:function(data){
                    $("#pdslist").html(data);
                }
            });
        }
    });
</script>
<body style="overflow: hidden;">
<div class="loader">
    <img src="images/loading2.gif" width="20%" height="40%">
</div>
    <?php include 'navbar.php'; ?>
        <div  style="padding: 20px 0px 20px 50px">
            <h3>Monitoring</h3>
            <div class="row mb-2">
                <div class="col" style="max-width: fit-content">
                    <h4>Department:</h4>
                </div>
                <div class="col-10 ps-1">
                    <select name="" id="regionInactive" class="form-control w-25 p-1">
                        <option></option>
                        <option value="HRDS">HRDS</option>
                        <option value="Property Section">Property Section</option>
                    </select>
                </div>
            </div>
            <div class="row">
            <div class="col-6 input-group w-50 rounded">
                <span class="input-group-text">SEARCH&nbsp; <i class="bi bi-search"></i></span>
                <input type="search" id="pds-search" name="pds-search" class="form-control">
                <button class="btn btn-primary" id=""><i class="fi fi-rr-search p-1"></i>Search</button>

                <select name="pdsyear" id="pdsyear" class="form-select" style="width: 0px; margin-left: 10px;">
                    <script>
                        // change the value of 120 if you want to extend the year display
                        for (var i = 0; i < 120; i++) {
                        var date = new Date();
                        date.setFullYear(date.getFullYear() - i);
                        var option = document.createElement("option");
                        option.value = date.toISOString().slice(0, 10);
                        option.text = date.getFullYear();
                        document.getElementById("pdsyear").appendChild(option);
                        }
                    </script>
                </select>
                
            </div>

            <div class="col-6">
                <div style="margin-right: 100px; float: right;">
                    *<b>Note1 : </b> <i>Move your mouse cursor over the check button to see this.</i>: <b>DE</b> -<i>Date of Effectivity</i> / <b>DU</b> - <i>Date upload</i><br>
                    *<b>Note2 : </b> <i>JO MONITORING FILE UPLOAD <b>EVERY QUARTER.</b></i>
                </div>     
            </div>  
            </div>
        </div>

        <div class="dtr-table" style="padding: 0 50px;">
            <div class="day-scroll" style="height: 700px; overflow-y: scroll;">
            <table class="table table-bordered mt-2 table-hover">
                <thead class="table bg-white shadow-sm roundTable" style="position: sticky; top: 0;">
                    <tr id="loopyear" class="text-center">
                    </tr>
                </thead>
                <tbody id="pdslist">
                    <!-- <tr style="cursor: pointer;">
                    <td>ID DITO</td>
                    <td>NAME NAMAN DITO</td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023" checked disabled></td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023"></td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023"></td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023"></td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023"></td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023"></td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023"></td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023"></td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023"></td>
                    <td><input type="checkbox" style="width: 40px;"data-bs-toggle="tooltip" data-bs-placement="right" title="January 05, 2023"></td> -->
                </tbody>
                
            </table>
            
            </div>
        </div>
    </div>


</body>

</html>