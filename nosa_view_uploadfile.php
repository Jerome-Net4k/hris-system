<?php
session_start();
include 'connection.php';
include 'table_uploadfile.php';
$personalInfo = new personalInfo();
$noCheck = $personalInfo->get_existYear();


        $yearQuery = $conn->prepare("SELECT `year` FROM `performance_rating_year` ORDER BY `year` DESC");
        $yearQuery->execute();
        $yearQueryResult = $yearQuery->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($yearQueryResult as $yearOpt){
            
        }

// $pendingCount = 0;
if(isset($_SESSION['uploadSuccess'])){
  if($_SESSION['uploadSuccess'] == 'true'){
    $uploadSuccess = 'true';
    $_SESSION['uploadSuccess'] = 'false';
    } else {
    $uploadSuccess = 'false';
    }
} else{
  $uploadSuccess = 'false';
}

if(isset($_SESSION['editSuccess'])){
  if($_SESSION['editSuccess'] == 'true'){
    $editSuccess = 'true';
    $_SESSION['editSuccess'] = 'false';
    } else {
    $editSuccess = 'false';
    }
} else{
  $editSuccess = 'false';
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php' ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- arrow for sorting -->
  <link rel="stylesheet" type="text/css" href="arrow.css">
	<link rel="stylesheet" type="text/css" href="loading.css">
	<script src="loading.js" defer></script>
    <title>Document</title>

    <script>
        $(document).ready(function(){
        load(); 

        setInterval(function(){
            
        },500)

        $('#staticBackdrop').on('hidden.bs.modal', function () {

        })    

          $("#fil").change(function(){
          var yearSelect = $("#yearSelect option:selected").val();
          fil = $("#fil").val();
          var regionFil = $("#regionInactive").val();
          var searchBar = $("input#searchBarInactive").val();
          var sortwhat = "ASC";
          var sortval = fil;
          $.ajax({
                  url: "nosa_proc.php",
                  type: "POST",
                  data: {
                    searchBar: searchBar,
                    yearSelected: yearSelect,
                    fil: fil, regionFil: 'all',
                    sortwhat:sortwhat,
                    sortval:sortval
                  },
                  success: function(data){
                  $("#content2").html(data)
                  }
                })
        })

          $("input#searchBarInactive").keyup(function(){
            var yearSelect = $("#yearSelect option:selected").val();
            var regionFil = $("#regionInactive").val();
            var searchBar = $("input#searchBarInactive").val();
            var sortwhat = "ASC";
            var sortval = "sname";
              if(searchBar.length >= 0){
                $.ajax({
                  url: "nosa_proc.php",
                  type: "POST",
                  data: {
                    searchBar: searchBar,
                    yearSelected: yearSelect,
                    fil: fil, regionFil: 'all',
                    sortwhat:sortwhat,
                    sortval:sortval
                  },
                  success: function(data){
                    $("#content2").html(data)
                  }
                })
              }
              else{
              }
          })

        })
        var fil = 'sname';
        function load(){
          var pcrSelect = 'NOSA';
          document.getElementById('pcrHeader').innerHTML = pcrSelect.toUpperCase();
          document.getElementById('pcrSelect').value = pcrSelect;
          
          
          var uploadSuccess = '<?php echo $uploadSuccess == 'true' ? 'true' : 'false'; ?>';
          if (uploadSuccess == 'true'){
            iziToast.success({
                                position: "center",
                                title: "OK",
                                message: "File uploaded Successfully!!",
                                messageSize: '30',
                                titleSize: '25'
                            });
          }                     
          
          var yearSelect = $("#yearSelect option:selected").val();
          var sortwhat = "ASC";
          var sortval = "sname";

          // document.getElementById('opcrHeader').innerHTML = 'OPCR - ' + yearSelect;

          $.ajax({
            
            data: {
              yearSelected: yearSelect,
              sortwhat:sortwhat,
              sortval:sortval
            },
            url:"nosa_proc.php",
            type: "POST",
            success: function(data){
            $("#content2").html(data)
            }
          })

          $("#yearSelect").change(function() {
      $("#content2").html("");
        var yearSelect = $("#yearSelect option:selected").val();
        var toast = iziToast.show({
          theme: '#ffffff', // Set the theme to 'dark' (you can also use 'light')
          // title: 'Loading',
          message: '<img src="images/loading.gif" width="100%" height="100%">', // Include the path to your animated GIF
          timeout: false, // Disable timeout for the toast
          position: 'center', // Set the toast position to center
          titleColor: '#ffffff', // Set the title color
          messageColor: '#ffffff', // Set the message color
          iconColor: '#ffffff', // Set the icon color
          close: false // Disable the close button
        });

        $.ajax({
          data: {
            yearSelected: yearSelect,
            sortwhat: sortwhat,
            sortval: sortval
          },
          url: "nosa_proc.php",
          type: "POST",
          success: function(data) {
            $("#content2").html(data);
          },
          complete: function() {
            iziToast.destroy(toast);
          }
        });
      });

          $("button#addYearBtn").on("click",function(){

          var yearInput = document.getElementById('addYearInput').value;

          iziToast.question({
          timeout: 20000,
          close: false,
          overlay: true,
          displayMode: 'once',
          id: 'question',
          zindex: 9999,
          title: 'Create File directory for the year ' + yearInput + '??',
          message: '',
          position: 'center',
          buttons: [
              ['<button><b>YES</b></button>', function (instance, toast) {
      
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                  $.ajax({
                    data: {
                      addYearDirectory: true,
                      yearInput: yearInput
                    },
                        type: "POST",
                        url: "uploadPerformanceRating.php",
                        success: function(data){
                          window.location.href = "nosa_view_uploadfile.php"
                        }
                      })
      
              }, true],
              ['<button>NO</button>', function (instance, toast) {
      
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
      
              }],
          ]

          });



        })

        }

        function checkNo(){
                var a = document.getElementById("addYearInput").value;
                const numbers = <?php echo $noCheck ?>;
                if(numbers.some(item => item.year == a) || a == "" || a == 0 || a < 1900 || a > 9999){
                document.getElementById("addYearBtn").disabled = true;
                } else {
                document.getElementById("addYearBtn").disabled = false;
                }

            }


    </script>

</head>
<body style="overflow: hidden;">
<div class="loader">
    <img src="images/loading2.gif" width="20%" height="40%">
</div>
    <?php include 'navbar.php'; ?>

    <div class="container-fluid pt-2">

    <!-- <h1>201 Files</h1> -->
    
    <div class="row pt-2 rounded bg-white">
        <div class="col border m-1">
            <h1 id="pcrHeader"></h1>
            <input type="hidden" name="pcrSelect" id="pcrSelect" value="">
            <div class="row mb-2">
              <div class="col" style="max-width: 5%;">
                    <h4>Year:</h4>
                </div>
                <div class="col-10 ps-1" style="display: inline-flex;">
                    <select name="" id="yearSelect" class="form-control p-1" style="max-width: 5%; font-size:20px;">
                      <?php

                        foreach ($yearQueryResult as $yearOpt){
                                                      
                          echo '<option value="' . $yearOpt['year'] . '">' . $yearOpt['year'] . '</option>';
                          
                        }
                        
                      ?>
                    </select>

                    <button class="btn btn-outline-success p-1" id="createYearBtn" style="margin-left: 10px;"><i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 25px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"></i></button>
                    <a href="nosa_checklist.php"><button class="btn btn-dark" id="searchInactive" style="margin-left: 10px;"><i class="fi fi-rr-search p-1"></i>View list</button></a>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col" style="max-width: 5%;">
                    <h4>Region:</h4>
                </div>
                <div class="col-10 ps-1">
                    <select name="" id="regionInactive" class="form-control w-25 p-1">
                        <option value="all">All</option>
                        <option value="N/A">N/A</option>
                        <option value="Central Office">Central Office</option>
                        <option value="NCR East">NCR East</option>
                        <option value="NCR West">NCR West</option>
                        <option value="1">1 - San Fernando, La Union</option>
                        <option value="2">2 - Tuguegarao, Cagayan</option>
                        <option value="3">3 - San Fernando, Pampanga</option>
                        <option value="4A">4A - Lipa City, Batangas</option>
                        <option value="4B">4B - MIMAROPA</option>
                        <option value="5">5 - Legazpi City, Albay</option>
                        <option value="6">6 - Iloilo City</option>
                        <option value="7">7 - Cebu City</option>
                        <option value="8">8 - Tacloban City</option>
                        <option value="9">9 - Zamboanga City</option>
                        <option value="10">10 - Cagayan de Oro City</option>
                        <option value="11">11 - Davao City</option>
                        <option value="12">12 - Koronadal City</option>
                        <option value="14">14 - Baguio City (CAR)</option>
                        <option value="15">15 - Butuan City (CARAGA)</option>
                    </select>
                </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="input-group w-75">
                  <!-- <select name="" id="fil" class="form-control filter" style="max-width: 20%;">
                      <option value="sname">Surname</option>
                      <option value="empno">Employee No.</option>
                      <option value="fname">Firstname</option>
                      <option value="mname">Middle Name</option>
                  </select> -->
                  <div style="padding: 10px 15px; background: #dee2e6; border-radius: 5px;">
                    <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                  </div>
                  <input type="text" class="form-control" id="searchBarInactive">               
                  <button class="btn btn-primary" id="searchInactive"><i class="fi fi-rr-search p-1"></i>Search</button>      
                </div>
              </div>
              <div class="col">
                
                <div style="margin-right: 100px; float: right;">
                  *<b>Note1 : </b> <i>Move your mouse cursor over the eye button to see this.</i>: <b>DE</b> -<i>Date of Effectivity</i> / <b>DU</b> - <i>Date upload</i><br>
                  *<b>Note2 : </b> <i>NOSA FILE UPLOAD <b>EVERY YEAR.</b></i>
                </div>     
              </div>
            </div>
             

            <div class="container" style="max-width:100vw; height: 63vh; overflow-y:scroll; margin: 10px; border: 1px solid darkgray; padding-left: 0px; padding-right: 0px;">
            <table class="table table-bordered mt-2 table-hover">
                <thead class="table bg-white shadow-sm roundTable" style="position: sticky; top: 0;">
                <tr>
                        <th></th>
                        <th style="width: 90px">
                          <div class="d-flex justify-content-center bpsort">BP#
                            <div class="sort" data-value="empno">
                                <div class="arrow arrow1 chevron1"></div>
                            </div>
                          </div>
                        </th>
                        <th>
                          <div class="d-flex justify-content-center surnamesort">Surname
                            <div class="sort" data-value="sname">
                                <div class="arrow arrow1 chevron2"></div>
                            </div>
                          </div>
                        </th>
                        <th><div class="d-flex justify-content-center firstnamesort">Firstname
                            <div class="sort" data-value="fname">
                                <div class="arrow arrow1 chevron3"></div>
                            </div>
                          </div>
                        </th>
                        <th>Middlename</th>
                        <!-- <th>Date</th> -->
                        <th style="text-align: center; vertical-align: middle;">File</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="content2">

                </tbody>
            </table>
            </div>

        </div>
    </div>

    </div>

    <!-- modal++ -->
    <div class="modal fade" id="staticBackdrop1" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel1">CREATE YEAR DIRECTORY</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered mt-2">
            <thead>
            </thead>
                <tbody id="">
                <input type="text" name="addYearInput" id="addYearInput" oninput="checkNo();">
                <button class="btn btn-outline-success p-1" id="addYearBtn" style="font-weight: 700; margin-left: 10px;" disabled> ADD </button>
                </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>
<!-- modal-- -->


    <!-- modal++ -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered mt-2">
            <thead>
            </thead>
                <tbody id="pendingView">

                </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>
<!-- modal-- -->


<!-- modal list date -->
  <div class="modal fade" id="listdaterecord" tabindex="-1" aria-labelledby="listdaterecordLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5"><b>DATE FILE UPLOAD CHECKER</b></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="unviewtable"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-2">
              <h1 class="modal-title fs-5">Fullname:</h1>
              <h1 class="modal-title fs-5">ID:</h1>
            </div>
            <div class="col-10">
              <h1 class="modal-title fs-5"><b id="viewnameindividual"></b></h1>
              <h1 class="modal-title fs-5"><b id="viewidindividual"></b></h1>
            </div>
          </div>

            <select class="form-select w-25 mt-3" id="dateselect">
            </select>
            <div class="row">
              <div class="col-2">
                <label style="color: red">Select Date</label>
              </div>
              
              <div class="col-10 ">
                <div style="text-align: right;">
                  <p>Note: *NOSA uploaded file needs to be issued every one years.</p>
                </div>
              </div>
            </div>

            <div class="container-fluid">
            <table class="table table-dark table-striped mt-3">
              <thead>
                <tr>
                  <th>Month</th>
                  <th class="text-center">Check</th>
                </tr>
              </thead>
              <div class="tableshow">
              <tbody id="nosaindiload">
                
                
              </tbody>
              </div>
            </table>
            </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="modal fade" id="listdaterecord" tabindex="-1" aria-labelledby="listdaterecordLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Date file checker  </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-2">
              <h1 class="modal-title fs-5">Fullname:</h1>
              <h1 class="modal-title fs-5">ID:</h1>
            </div>
            <div class="col-10">
              <h1 class="modal-title fs-5"><b id="viewnameindividual"></b></h1>
              <h1 class="modal-title fs-5"><b id="viewidindividual"></b></h1>
            </div>
          </div>

            <select class="form-select w-25 mt-3" id="dateselect">
            </select>
            <div class="row">
              <div class="col-2">
                <label style="color: red">Select Date</label>
              </div>
              
              <div class="col-10 ">
                <div style="text-align: right;">
                  <p>Note: *NOSA uploaded file needs to be issued every three years.</p>
                </div>
              </div>
            </div>

            <div class="container-fluid">
            <table class="table table-dark table-striped mt-3">
              <thead>
                <tr>
                  <th>Month</th>
                  <td>January</td>
                  <td>February</td>
                  <td>March</td>
                  <td>April</td>
                  <td>May</td>
                  <td>June</td>
                  <td>July</td>
                  <td>August</td>
                  <td>September</td>
                  <td>October</td>
                  <td>November</td>
                  <td>December</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Checklist</td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                  <td class="text-center"><input type="checkbox" disabled></td>
                </tr>
                
              </tbody>
            </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
  </div> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
<script>
  
  $("#dateselect").on("change", function() {
    var dtryear = $("#dateselect option:selected").text();
    selecttabledate(dtryear)
  }); 
  $("#unviewtable").on("click", function() {
    var dtryear = "";
    selecttabledate(dtryear)
  })

  function selecttabledate(dtryear){
    var gsis = $("#viewidindividual").text();
    // alert(dtryear);
      $.ajax({
        url: 'nosa_indiload_checkyear.php',
        method: 'POST',
        data: { dtryear: dtryear,gsis:gsis },
        success: function(data) {
          $("#nosaindiload").html(data);
        },
        error: function(xhr, status, error) {
          alert('Error: ' + error);
        }
      });
  }
  
  const buttons = $('.sort');
  const arrows = $('.arrow');

  let arr = ['active', 'active1', 'active2', 'active3'];

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
    var yearSelect = $("#yearSelect option:selected").val();
    $.ajax({
        url: "nosa_proc.php",
        type: "POST",
        data: {
            yearSelected: yearSelect,
            sortval: sortval,
            sortwhat:sortwhat
        },
        success: function(data) {
            $("#content2").html(data);
        }
    });
  }
  
</script>