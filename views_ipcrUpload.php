<?php
session_start();
include 'connection.php';
include 'table_personalInfoTable.php';
$personalInfo = new personalInfo();
$noCheck = $personalInfo->get_existYear();
$ipcrNoCheck = $personalInfo->get_existIpcrNo();


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
    <?php include 'partials_header.php'; ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>Document</title>

    <script>
        $(document).ready(function(){
        load(); 

        setInterval(function(){
            
        },500)

        $('#staticBackdrop').on('hidden.bs.modal', function () {
          // $.ajax({
          //   url:"proc_personalInfoInactive201.php",
          //   type: "POST",
          //   success: function(data){
          //    $("#content2").html(data)
          //   }
          // })
        })    
          $("#fil").change(function(){
          var yearSelect = $("#yearSelect option:selected").val();
          fil = $("#fil").val();
          var regionFil = $("#regionInactive").val();
          var searchBar = $("input#searchBarInactive").val();
          $.ajax({
                  url: "proc_ipcrUpload.php",
                  type: "POST",
                  data: {searchBar: searchBar,
                    yearSelected: yearSelect,
                          fil: fil, regionFil: 'all'},
                  success: function(data){
                    $("#content2").html(data)
                  }
                })
        })

          $("input#searchBarInactive").keyup(function(){
            var yearSelect = $("#yearSelect option:selected").val();
            // document.getElementById('regionInactive').value = 'all';
            var regionFil = $("#regionInactive").val();
            var searchBar = $("input#searchBarInactive").val();
              if(searchBar.length >= 0){
                $.ajax({
                  url: "proc_ipcrUpload.php",
                  type: "POST",
                  data: {searchBar: searchBar,
                    yearSelected: yearSelect,
                          fil: fil, regionFil: 'all'},
                  success: function(data){
                    $("#content2").html(data)
                  }
                })
              }
              else{
                // $.ajax({
                // url:"proc_personalInfoInactive201.php",
                // type: "POST",
                // success: function(data){
                // $("#content2").html(data)
                // }
                // })
              }
          })

        //   $("#regionInactive").change(function(){
        //     regionFil = $("#regionInactive").val();
        //     var searchBar = $("input#searchBarInactive").val();
        //     if(regionInactive != 'all'){
        //       $.ajax({
        //           url: "proc_performanceRating.php",
        //           type: "POST",
        //           data: {searchBar: searchBar,
        //                   fil: fil, regionFil: regionFil},
        //           success: function(data){
        //             $("#content2").html(data)
        //           }
        //         })
        //     } else {
        //       // load();
        //     }

        // })


        })
        var fil = 'sname';
        function load(){

          var pcrSelect = 'ipcr';
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

          // document.getElementById('opcrHeader').innerHTML = 'OPCR - ' + yearSelect;

          $.ajax({
            
            data: {
              yearSelected: yearSelect
            },
            url:"proc_ipcrUpload.php",
            type: "POST",
            success: function(data){
            $("#content2").html(data)
            }
          })

          $("#yearSelect").change(function(){

            var yearSelect = $("#yearSelect option:selected").val();

            // document.getElementById('opcrHeader').innerHTML = 'OPCR - ' + yearSelect;


            $.ajax({
            
            data: {
              yearSelected: yearSelect
            },
            url:"proc_ipcrUpload.php",
            type: "POST",
            success: function(data){
             $("#content2").html(data)
            }
          })
          
        })

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
                        url: "fileUpload.php",
                        success: function(data){
                          window.location.href = "views_ipcrUpload.php"
                        }
                      })
      
              }, true],
              ['<button>NO</button>', function (instance, toast) {
      
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
      
              }],
          ]

          });



        })

        $("#newData").on("click",function(){
          window.location.href="views_ipcrEncoding.php";
        })

        $("button#editSubmitBtn").on("click",function(){
            $("#editIpcrForm").submit();
        })

        $("#editIpcrForm").on('submit', function(e){
          e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "upload_ipcrEncoding.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data){
                            if (data == "success"){
                                iziToast.success({
                                position: "center",
                                timeout: 1000,
                                title: "OK",
                                message: "Data Edited Successfully!!",
                                messageSize: '30',
                                titleSize: '25'
                                });

                                setTimeout(function() {
                                  window.location.href = "views_ipcrUpload.php";
                                }, 2000);

                            } else {
                              iziToast.error({
                                position: "center",
                                title: "",
                                message: data,
                                messageSize: '30',
                                titleSize: '25'
                            });
                            }
                        },
                        error: function() {
                            iziToast.error({
                                position: "center",
                                title: "",
                                message: "Something went wrong..",
                                messageSize: '30',
                                titleSize: '25'
                            });
                        }
                    })
        })


        // var outputCount = 2;        

        // $("button#outputAdd").on("click",function(){
        //   outputCount += 1;
        //         $("#computeRatingView").append('<tr><td><input type="text" name="" id="" value="' + outputCount +'" style="width: 50px; font-weight: bold;" disabled></td><td><input type="number" name="" id="" style="width: 75px;" step="0.25" max="5" min="0"></td><td><input type="number" name="" id="" style="width: 75px;" step="0.25" max="5" min="0"></td><td><input type="number" name="" id="" style="width: 75px;" step="0.25" max="5" min="0"></td><td><input type="text" name="" id="" style="width: 75px;" disabled></td></tr>');
        //     })

        // $("button#computeModalCloseBtn").on("click",function(){
        //   $("#computeRatingView").html('<tr><td><input type="text" name="" id="" value="1" style="width: 50px; font-weight: bold;" disabled></td><td><input type="number" name="" id="" style="width: 75px;" step="0.25" max="5" min="0"></td><td><input type="number" name="" id="" style="width: 75px;" step="0.25" max="5" min="0"></td><td><input type="number" name="" id="" style="width: 75px;" step="0.25" max="5" min="0"></td><td><input type="text" name="" id="" style="width: 75px;" disabled></td></tr><tr><td><input type="text" name="" id="" value="2" style="width: 50px; font-weight: bold;" disabled></td><td><input type="number" name="" id="" style="width: 75px;" step="0.25" max="5" min="0"></td><td><input type="number" name="" id="" style="width: 75px;" step="0.25" max="5" min="0"></td><td><input type="number" name="" id="" style="width: 75px;" step="0.25" max="5" min="0"></td><td><input type="text" name="" id="" style="width: 75px;" disabled></td></tr>');
        //   outputCount = 2;
        //     })

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

        function checkIpcrNo(){
                var a = document.getElementById("ipcrEmpNo").value;
                const numbers = <?php echo $ipcrNoCheck ?>;
                if(numbers.some(item => item.empno == a)){
                document.getElementById("dupeCheck").style.display = 'inline';
                document.getElementById("editSubmitBtn").disabled = true;
                } else {
                document.getElementById("dupeCheck").style.display = 'none';
                document.getElementById("editSubmitBtn").disabled = false;
                }
            }


    </script>

</head>
<body>
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

            <div class="input-group w-25">
                <select name="" id="fil" class="form-control filter" style="max-width: 28%;">
                    <option value="sname">Surname</option>
                    <option value="empno">Employee No.</option>
                    <option value="fname">Firstname</option>
                    <option value="mname">Middle Name</option>
                </select>
                <input type="text" class="form-control" id="searchBarInactive">               
                <button class="btn btn-primary" id="searchInactive"><i class="fi fi-rr-search p-1"></i>Search</button>
            </div>

            <div class="container" style="max-width:100vw; height: 63vh; overflow-y:scroll; margin: 10px; border: 1px solid darkgray; padding-left: 0px; padding-right: 0px;">
            <table class="table table-bordered mt-2 table-hover">
            <thead>
                    <tr>
                        <th><button class="btn btn-dark p-1" id="newData"><i class="fi fi-rr-layer-plus p-1"></i></button></th>
                        <th style="width: 90px">GSIS BP No.</th>                  
                        <th>Surname</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Ext</th>
                        <!-- <th>Region</th> -->
                        <!-- <th style="text-align: center;">Select Year <button class="btn btn-outline-success p-1" id="createYearBtn" style="margin-left: 10px;"><i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 25px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"></i></button></th> -->
                        <th style="text-align: center;">1st</th>
                        <th style="text-align: center;">2nd</th>
                        <th style="text-align: center;">Target</th>
                        <!-- <th>DPCR</th>
                        <th>IPCR</th> -->
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

    <!-- modal++ -->
    <div class="modal" id="staticBackdrop2" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel2"></h1>
        <button type="button" id="computeModalCloseBtn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id="computeRatingView" class="modal-body">


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
    <div class="modal fade" id="staticBackdrop3" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel3"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered mt-2">
            <thead>
            </thead>
                <tbody id="editView">

                    <form id="editIpcrForm" enctype="multipart/form-data" onsubmit="return confirm('Are you sure all data are correct??')">
                    <input type="hidden" name="editIpcr" value="true">

                    <div class="col col-md-2">
                    <div class="form-floating mb-3">
                    <input type="text" name="ipcrEmpNo" id="ipcrEmpNo" class="form-control" required oninput="checkIpcrNo();" disabled>
                    <input type="hidden" name="editIpcrNo" id="editIpcrNo">
                    <label for="inactive201">GSIS BP No.*</label>
                    <span id="dupeCheck" style="color: red; display: none;"><b><i>this no. already exist!</b><i></span>
                    </div>
                    </div>

                    <div class="row row-cols-2 ">

                    <div class="col">
                    <div class="form-floating mb-3">
                    <input type="text" name="editsname" id="editsname" class="form-control" required>
                    <label for="sname">Surname*</label>
                    </div>
                    </div>

                    <div class="col">
                    <div class="form-floating mb-3">
                    <input type="text" name="editfname" id="editfname" class="form-control" required>
                    <label for="fname">First Name*</label>
                    </div>
                    </div>

                    <div class="col">
                    <div class="form-floating mb-3">
                    <input type="text" name="editmname" id="editmname" class="form-control">
                    <label for="mname">Middle Name</label>
                    </div>
                    </div>

                    <div class="col col-md-3">
                    <div class="form-floating mb-3">
                    <input type="text" name="editext" id="editext" class="form-control" >
                    <label for="ext">Name Extension (Jr. Sr.)</label>
                    </div>
                    </div>

                    </form>

                    </div>
                    <div class="d-flex justify-content-end">
                          <button type="button" class="btn btn-primary mb-2" id="editSubmitBtn">SAVE</button>
                    </div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>