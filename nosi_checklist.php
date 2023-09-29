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
    <link rel="stylesheet" type="text/css" href="arrow.css">
	<link rel="stylesheet" type="text/css" href="loading.css">
	<script src="loading.js" defer></script>
</head>
<script>
    $(document).ready(function(){

        $("#ojt-search").on("keyup", function() {
            var searchinput= $(this).val();
            var nosimonth = $("#dtrmonth").val();
            var nosiyear = $("#nosiyear option:selected").text();
            var sortval = "sname";
            var sortwhat = "ASC";
            // alert(searchinput);
            $.ajax({
				url:"nosi_checklistproc.php",//orgsearchunder.php
				method:"POST",
                data: {
                    searchinput:searchinput,
                    nosimonth: nosimonth,
                    nosiyear: nosiyear,
                    sortval:sortval,
                    sortwhat:sortwhat
                },
  
				// if the data successful the data will show
				success:function(data){
					$("#nosilist").html(data);
				}
			});
        });

        $("#nosiyear").change(function(){
            loadojttable();
        });

        loadojttable();

        function loadojttable(){
            var nosimonth = $("#dtrmonth").val();
            var nosiyear = $("#nosiyear option:selected").text();
            var sortval = "sname";
            var sortwhat = "ASC";
            // alert(dtrmonth);
            $.ajax({
                url:"nosi_checklistproc.php",
                method:"POST",
                data: {
                    nosimonth: nosimonth,
                    nosiyear: nosiyear,
                    sortval:sortval,
                    sortwhat:sortwhat
                },

                // if the data successful the data will show
                success:function(data){
                    $("#nosilist").html(data);
                }
            });
        }
        const buttons = $('.sort');
        const arrows = $('.arrow');

        let arr = ['active', 'active1', 'active2'];

        buttons.on('click', function() {
            var sortval = $(this).data('value');
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
            var nosiyear = $("#nosiyear option:selected").text();
        $.ajax({
            url: "nosi_checklistproc.php",
            type: "POST",
            data: {
                nosiyear:nosiyear,
                sortval: sortval,
                sortwhat:sortwhat
            },
            success: function(data) {
                $("#nosilist").html(data);
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
            <h3>NOSI</h3>
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
                <input type="search" id="ojt-search" name="ojt-search" class="form-control">
                <button class="btn btn-primary" id=""><i class="fi fi-rr-search p-1"></i>Search</button>

                <select name="nosiyear" id="nosiyear" class="form-select" style="width: 0px; margin-left: 10px;">
                <script>
                    // create date options for the past 10 years
                    for (var i = 0; i < 120; i++) {
                    var date = new Date();
                    date.setFullYear(date.getFullYear() - i);
                    var option = document.createElement("option");
                    option.value = date.toISOString().slice(0, 10);
                    option.text = date.getFullYear();
                    document.getElementById("nosiyear").appendChild(option);
                    }
                </script>
                </select>
                
                
                
            </div>
            
            <div class="col-6">
                <div style="margin-right: 100px; float: right;">
                    *<b>Note1 : </b> <i>Move your mouse cursor over the check button to see this.</i>: <b>DE</b> -<i>Date of Effectivity</i> / <b>DU</b> - <i>Date upload</i><br>
                    *<b>Note2 : </b> <i>NOSI FILE UPLOAD EVERY<b> THREE YEARS.</b></i>
                </div>     
            </div>  
        </div>
        </div>

        <div class="dtr-table" style="padding: 0 50px;">
            <div class="day-scroll" style="height: 700px; overflow-y: scroll;">
            <table class="table table-bordered mt-2 table-hover">
                <thead class="table bg-white shadow-sm roundTable" style="position: sticky; top: 0;">
                <tr class="text-center">
                    <th style="width: 125px;">
                        <div class="d-flex justify-content-center bpsort">GSIS #
                            <div class="sort" data-value="empno">
                                <div class="arrow arrow1 chevron1"></div>
                            </div>
                        </div>
                    </th>
                    <th style="width: 350px; position: sticky; left: 0; top: 0; background: white; z-index: 20">
                        <div class="d-flex justify-content-center bpsort">NAME
                            <div class="sort" data-value="sname">
                                <div class="arrow arrow1 chevron2"></div>
                            </div>
                        </div>
                    </th>
     
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>May</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Aug</th>
                    <th>Sep</th>
                    <th>Oct</th>
                    <th>Nov</th>
                    <th>Dec</th>
                </tr>
                </thead>
                <tbody id="nosilist">

                </tbody>
                
            </table>
            
            </div>
        </div>
    </div>
    <!-- modal for ot -->
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
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#inputojtot" class="btn btn-dark mb-2 inputojt" name="" id="" style="width: 150px">OT COUNT</button>
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#inputdtr" class="btn btn-primary mb-2 inputdtr" name="" id="" style="width: 150px">ADD DTR</button>
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
                        <h4 class="modal-title">INPUT DTR</h4>
                        <button class="btn-close" data-bs-toggle="modal" data-bs-target="#ojtmenu"></button>
                    </div>

                    <div class="modal-body">
                            <input type="text" id="ojtiddtr" name="ojtiddtr">
                            <input type="text" id="ojtnamedtr" name="ojtnamedtr">
                        
                    </div>

                </div>
            </div>
        </div>
    
    <!-- input ots -->
        <div class="modal fade" id="inputojtot" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">OJT OVERTIME</h4>
                        <button class="btn-close" data-bs-toggle="modal" data-bs-target="#ojtmenu"></button>
                    </div>

                    <div class="modal-body">

                    </div>

                </div>
            </div>
        </div>
</body>
</html>