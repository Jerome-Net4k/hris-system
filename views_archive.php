<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:index.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HRIS</title>
    <?php include 'partials_header.php';  ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    
</head>

<style>
    td{cursor: pointer;}
    
    *{

       font-family: 'Poppins', sans-serif;
    }

    a{
      text-decoration: none; 
    }

    td:hover{
      background-color: #EAEAEA;
    }
</style>

<script>
    $(document).ready(function(){
          load()

          $("#confirm").on("click",function(){
              var upID = $(this).val();
              var newDate = $("#upDate").val();
              $.ajax({
                data: {upID:upID,
                  newDate:newDate},
                type: "POST",
                url: "proc_archive.php",
              })
          })

        $("#new").on("click",function(){
            $("form").show();
            $("#upload").show();
            $("#upDate").hide();
            $("#labelDate").hide();
            $("#confirm").hide();
        })

        $("#sbar").keyup(function(){
          var sbar = $(this).val();
          var action = "search";
          if(sbar.length >= 3){
            $.ajax({
              data: {sbar: sbar,
              action: action},
              type: "POST",
              url: "proc_archive.php",
              success: function(data){
                $("tbody#content").html(data);
              }
            })
          }
          else{
            load();
          }
        })
        
        $("form#form").submit(function(e){
          var archive = new FormData(this);
          archive.append('action','upload');
          e.preventDefault();
          $.ajax({
            url: "proc_archive.php",
            data : archive,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data){
             if(data == 'Duplicate'){
              iziToast.warning({
              position: "topRight",
              title: 'Duplicate!',
              message: 'File already exist.'
              });
             }
             else{
              $("#exampleModal").modal('toggle');
              window.location.href="views_archive.php";
             }
            }
          })
        })

        function load(){
            $.ajax({
                type: "GET",
                url: "proc_archive.php?action=load",
                success: function(data){
                    $("tbody#content").html(data);
                }
            })
        }
    })
</script>
<body>
        <?php include 'navbar.php'; ?>
    
        <div class="container-fluid">
 
        
            <h1 class="title fs-1 fw-bold pt-2">Archive</h1>

            <div class="row mb-2">
              <div class="col">
                <div class="input-group">

                <input type="text" class="form-control" id="sbar">
                <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                </div>
              </div>
            <div class="col">
                <div class="d-flex justify-content-end">
                <button class="btn btn-outline-dark " id="new" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-file-circle-plus"></i> | New File</button>
                </div>
            </div>
            </div>
   


        <div class="container-fluid bg-white rounded p-2">
            <table class="table table-bordered">

            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th>File Name</th>
                <th class="text-center">Date</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
                <tbody id="content">
                    
                </tbody>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="mbody">
        <label for="" id="labelDate">Date</label>
        <input type="date" id="upDate" class="form-control">
          <form id="form" enctype="multipart/form-data">
          <label for="">File</label>
          <input type="file" class="form-control" accept=".pdf,.docx" id="file" name="file[]" multiple>
          <label for="">Date</label>
          <input type="date" class="form-control" name="date">
       
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="upload"><i class="fa-solid fa-file-arrow-up"></i> Upload</button>
        <button class="btn btn-success" id="confirm"><i class="fa-solid fa-check"></i> Confirm</button>
      </div>
      </form>
    </div>
  </div>
</div>
        </div>
        </div>

        

      <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>