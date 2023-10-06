<?php
session_start();
include 'connection.php';

        $stmtPending = $conn->prepare("SELECT COUNT(idno) AS pendingcount FROM `pending_inactive_table`");
        $stmtPending->execute();
        $stmtPendingResult = $stmtPending->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($stmtPendingResult as $pending){
            $pendingCount = $pending['pendingcount'];
        }

// $pendingCount = 0;
if(isset($_SESSION['insertSuccess'])){
  if($_SESSION['insertSuccess'] == 'true'){
    $insertSuccess = 'true';
    $_SESSION['insertSuccess'] = 'false';
    } else {
    $insertSuccess = 'false';
    }
} else{
  $insertSuccess = 'false';
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">    
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>Document</title>  

    <script>
      
        $(document).ready(function(){
          var pendingCountJS = <?php echo $pendingCount ?>;
        load(); 

        setInterval(function(){
          // $.ajax({
          //   url:"proc_personalInfoPending201.php",
          //   type: "POST",
          //   success: function(data){
          //    $("#pendingView").html(data)
          //   }
          // })

          $.ajax({
            data: {
              checkCount: true
            },
            url:"uploadPDInactive.php",
            type: "POST",
            success: function(data){
              if(data > 0){
              document.getElementById("pendingSpan").textContent = data;
              document.getElementById("pendingSpan").style.display = 'inline';
              }
            }
          })
        },500)

        $('#staticBackdrop').on('hidden.bs.modal', function () {
          $.ajax({
            url:"proc_personalInfoInactive201.php",
            type: "POST",
            success: function(data){
             $("#content2").html(data)
            }
          })
        })
        
        $("#newData").on("click",function(){
          window.location.href="personalInfoInactive.php";
        })

        $("#fil").change(function(){
          fil = $("#fil").val();
        })
          $("input#searchBar").keypress(function(){
            var searchBar = $("input#searchBar").val();
              if(searchBar.length >= 2){
                $.ajax({
                  url: "proc_personalInfo201.php",
                  type: "POST",
                  data: {searchBar: searchBar,
                          fil: fil},
                  success: function(data){
                    $("#content").html(data)
                  }
                })
              }
              else{
                load();
              }
          })

          $("#fil").change(function(){
          fil = $("#fil").val();
          var regionFil = $("#regionInactive").val();
          var searchBar = $("input#searchBarInactive").val();
          $.ajax({
                  url: "proc_personalInfoInactive201.php",
                  type: "POST",
                  data: {searchBar: searchBar,
                          fil: fil, regionFil: regionFil},
                  success: function(data){
                    $("#content2").html(data)
                  }
                })
        })
          $("input#searchBarInactive").keyup(function(){
            // document.getElementById('regionInactive').value = 'all';
            var regionFil = $("#regionInactive").val();
            var searchBar = $("input#searchBarInactive").val();
              if(searchBar.length >= 0){
                $.ajax({
                  url: "proc_personalInfoInactive201.php",
                  type: "POST",
                  data: {searchBar: searchBar,
                          fil: fil, regionFil: regionFil},
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

          $("#regionInactive").change(function(){
            regionFil = $("#regionInactive").val();
            var searchBar = $("input#searchBarInactive").val();
            if(regionInactive != 'all'){
              $.ajax({
                  url: "proc_personalInfoInactive201.php",
                  type: "POST",
                  data: {searchBar: searchBar,
                          fil: fil, regionFil: regionFil},
                  success: function(data){
                    $("#content2").html(data)
                  }
                })
            } else {
              // load();
            }

        })

          $("button#pending").on("click",function(){
            $.ajax({
            url:"proc_personalInfoPending201.php",
            type: "POST",
            success: function(data){
             $("#pendingView").html(data)
            }
          })
          })

          $("button#viewVacantBtn").on("click",function(){
            $.ajax({
            data: {
              viewVacant: 'true'
            },
            url:"proc_personalInfoInactive201.php",
            type: "POST",
            success: function(data){
             $("#content2").html(data)
            }
          })
          })

        })
        var fil = 'surname';
        function load(){
          
          var insertSuccess = '<?php echo $insertSuccess == 'true' ? 'true' : 'false'; ?>';
          if (insertSuccess == 'true'){
            iziToast.success({
                                position: "center",
                                title: "OK",
                                message: "Successfully inserted record!",
                                messageSize: '30',
                                titleSize: '25'
                            });
          }

          var editSuccess = '<?php echo $editSuccess == 'true' ? 'true' : 'false'; ?>';
          if (editSuccess == 'true'){
            iziToast.success({
                                position: "center",
                                title: "OK",
                                message: "Personal Info edited successfully!",
                                messageSize: '30',
                                titleSize: '25'
                            });
          }
                            
          $.ajax({
            url:"proc_personalInfo201.php",
            type: "POST",
            success: function(data){
            //  $("#content").html(data)
            }
          })
          $.ajax({
            url:"proc_personalInfoInactive201.php",
            type: "POST",
            success: function(data){
             $("#content2").html(data)
            }
          })

          // $.ajax({
          //   url:"proc_personalInfoPending201.php",
          //   type: "POST",
          //   success: function(data){
          //    $("#pendingView").html(data)
          //   }
          // })
          // var pendingCountJS = <?php echo $pendingCount ?>;
          // document.getElementById("pendingSpan").textContent = pendingCountJS;
        }
    </script>

</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container-fluid pt-2">

    <h1>201 Files</h1>
    
    <div class="row pt-2 rounded bg-white">
        <div class="col m-1 border">
            <h2>Regular Active</h2>
            <div class="row mb-2">
                <div class="col">
                    <h4>Region:</h4>
                </div>
                <div class="col-10 ps-1">
                    <select name="" id="" class="form-control w-50 p-1">
                        <option value="">Central Office</option>
                        <option value="">NCR East</option>
                        <option value="">NCR West</option>
                        <option value="">1 - San Fernando, La Union</option>
                        <option value="">2 - Tuguegarao, Cagayan</option>
                        <option value="">3 - San Fernando, Pampanga</option>
                        <option value="">4A - Lipa City, Batangas</option>
                        <option value="">4B - MIMAROPA</option>
                        <option value="">5 - Legazpi City, Albay</option>
                        <option value="">6 - Iloilo City</option>
                        <option value="">7 - Cebu City</option>
                        <option value="">8 - Tacloban City</option>
                        <option value="">9 - Zamboanga City</option>
                        <option value="">10 - Cagayan de Oro City</option>
                        <option value="">11 - Davao City</option>
                        <option value="">12 - Koronadal City</option>
                        <option value="">14 - Baguio City (CAR)</option>
                        <option value="">15 - Butuan City (CARAGA)</option>
                        

                    </select>
                </div>
            </div>
                <div class="input-group w-50">
                <select name="" id="" class="form-control" style="max-width: 28%;">
                    <option value="">Assigned No.</option>
                    <option value="">Surname</option>
                    <option value="">Firstname</option>
                    <option value="">Middle Name</option>
                    <option value="">Region</option>
                </select>
                <input type="text" class="form-control">
                <button class="btn btn-primary">Search</button>
                </div>
            
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th  style="width: min-content">Ext</th>
                        <th>Region</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="content">

                </tbody>
            </table>
        </div>

        <div class="col border m-1">
          <div class="col pt-2 d-flex justify-content-end">
            <h2 style="display:inline-block;">Inactive</h2>
            <!-- <button type="button" id="pending" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="margin-left: auto;">
                Pending
                <span id="pendingSpan" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: inline;">
                <span class="visually-hidden">Pending Inactive</span>
                </span>
                </button> -->
                <button type="button" id="viewVacantBtn" class="btn btn-primary" style="margin-left: auto;">
                #201#
                </button>
          </div>

            <div class="row mb-2">
                <div class="col">
                    <h4>Region:</h4>
                </div>
                <div class="col-10 ps-1">
                    <select name="" id="regionInactive" class="form-control w-50 p-1">
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
            <div class="input-group w-100">
                <select name="" id="fil" class="form-control filter" style="max-width: 28%;">
                    <option value="surname">Surname</option>
                    <option value="idno">201 No.</option>
                    <option value="firstname">Firstname</option>
                    <option value="middlename">Middle Name</option>
                </select>
                <input type="text" class="form-control" id="searchBarInactive">               
                <button class="btn btn-primary" id="searchInactive"><i class="fi fi-rr-search p-1"></i>Search</button>
                <div class="col pt-2 d-flex justify-content-end">
                <!-- <button type="button" id="viewVacantBtn" class="btn btn-primary" style="margin-right: 10px;">
                201
                </button> -->
                <button type="button" id="pending" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="margin-right: 15px;">
                Pending
                <span id="pendingSpan" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: inline;">
                <span class="visually-hidden">Pending Inactive</span>
                </span>
                </button>
                    <button class="btn btn-dark p-1" id="newData"><i class="fi fi-rr-layer-plus p-1"></i>New Data</button>
                </div>
            </div>

            <div class="container" style="height: 600px; overflow-y:scroll; margin-top: 5px; border: 1px solid darkgray;">
            <table class="table table-bordered mt-2">
            <thead>
                    <tr>
                        <th></th>
                        <th style="width: 90px">201 No.</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th  style="width: min-content">Ext</th>
                        <th>Region</th>
                        <th colspan=3 style="text-align: center;">Action</th>
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
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Pending Employees</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered mt-2">
            <thead>
                    <tr>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Name Extension</th>
                        <th>Region</th>
                        <!-- <th style="width: 90px">201 No.</th> -->
                        <th>Assign 201 No.</th>
                    </tr>
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
    <div class="modal fade" id="staticBackdrop1" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel1"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered mt-2">
            <thead>
            </thead>
                <tbody id="fileView">
            <form id="uploadFile1' . $row['emp_id'] . '" enctype="multipart/form-data" style="text-align: center;">
            <input type="hidden" name="ipcrUp" value="">         
            <input type="hidden" name="ipcr1" value="">         
            <input type="hidden" name="empNo" value="' . $row['emp_id'] .'">
            <input type="hidden" name="sname" value="' . $row['sname'] . '">
            <input type="hidden" name="yearSelected" id="yearSelected' . $row['emp_id'] . '" value="'. $yearSelected .'">
            <input type ="file" class="form-control" name="pcrDocs" id="uploadFileSelect1' . $row['emp_id'] . '" accept=".pdf" required style="width: 250px; display: inline-block; margin-right: 10px;">
            <button type="button" class="btn btn-outline-primary" id="uploadBtn1' . $row['emp_id'] . '"  value="Submit" style="font-weight: 700;">UPLOAD</button>
            </form>
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