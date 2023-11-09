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
          
          // var insertSuccess = '<?php echo $insertSuccess == 'true' ? 'true' : 'false'; ?>';
          // if (insertSuccess == 'true'){
          //   iziToast.success({
          //                       position: "center",
          //                       title: "OK",
          //                       message: "Successfully inserted record!",
          //                       messageSize: '30',
          //                       titleSize: '25'
          //                   });
          // }

          // var editSuccess = '<?php echo $editSuccess == 'true' ? 'true' : 'false'; ?>';
          // if (editSuccess == 'true'){
          //   iziToast.success({
          //                       position: "center",
          //                       title: "OK",
          //                       message: "Personal Info edited successfully!",
          //                       messageSize: '30',
          //                       titleSize: '25'
          //                   });
          // }
          
                            
          $.ajax({
            data: {
              viewFirstEdition: 'true'
            },
            url:"proc_spmsView.php",
            type: "POST",
            success: function(data){
             $("#firstEditionView").html(data)
            }
          })

          $.ajax({
            data: {
              viewEnhancedEdition: 'true'
            },
            url:"proc_spmsView.php",
            type: "POST",
            success: function(data){
             $("#enhancedEditionView").html(data)
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

    <h1>SPMS</h1>
    
    <div class="row pt-2 rounded bg-white">
        <div class="col m-1 border">
            <h2>1st Edition</h2>

    <form id="firstEditionFile" enctype="multipart/form-data" style="text-align: center; margin-bottom:15px;">
    <input type="hidden" name="firstEditionUpload">
    <input type ="file" class="form-control" name="spmsDocs" id="" accept=".pdf" required style="width: 400px; display: inline-block; margin-right: 10px;">
    <button id="firstEditionBtn" class="btn btn-outline-primary" style="font-weight: 700;">UPLOAD</button>
    </form>

    <div id="firstEditionView">

    </div>

        </div>

        <div class="col border m-1">
          <div class="col pt-2 d-flex">
            <h2>Enhanced Edition</h2>
          </div>

    <form id="enhancedEditionFile" enctype="multipart/form-data" style="text-align: center; margin-bottom:15px;">
    <input type="hidden" name="EnhanceEditionUpload">
    <input type ="file" class="form-control" name="spmsDocs" id="" accept=".pdf" required style="width: 400px; display: inline-block; margin-right: 10px;">
    <button id="enhanceEditionBtn" class="btn btn-outline-primary" style="font-weight: 700;">UPLOAD</button>
    </form>

    <div id="enhancedEditionView">

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

<script>

            //  $("#firstEditionBtn").click(function(){
            //     $("#firstEditionFile").submit();
            // });

            //  $("#enhanceEditionBtn").click(function(){
            //     $("#enhancedEditionFile").submit();
            // });

            $("#firstEditionFile").on('submit', function(e){
                e.preventDefault();

                if(confirm('Upload File??')){

                    $.ajax({
                        type: "POST",
                        url: "fileUpload.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(){
                            iziToast.success({
                                position: "center",
                                timeout: 1500,
                                title: "OK",
                                message: "File uploaded Successfully!!",
                                messageSize: '30',
                                titleSize: '25'
                            });

                                $.ajax({
                                  data: {
                                  viewFirstEdition: 'true'
                                },
                                url:"proc_spmsView.php",
                                type: "POST",
                                success: function(data){
                                $("#firstEditionView").html(data)
                                }
                              })
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
                }                

            });

            $("#enhancedEditionFile").on('submit', function(e){
                e.preventDefault();

                if(confirm('Upload File??')){

                    $.ajax({
                        type: "POST",
                        url: "fileUpload.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(){
                            iziToast.success({
                                position: "center",
                                timeout: 1500,
                                title: "OK",
                                message: "File uploaded Successfully!!",
                                messageSize: '30',
                                titleSize: '25'
                            });

                            $.ajax({
                              data: {
                              viewEnhancedEdition: 'true'
                            },
                            url:"proc_spmsView.php",
                            type: "POST",
                            success: function(data){
                            $("#enhancedEditionView").html(data)
                            }
                          })
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
                }                

            });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>