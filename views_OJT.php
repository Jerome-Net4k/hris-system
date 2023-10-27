<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:OJT.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HRIS</title>
    <?php include 'partials_header.php';  ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">

    <script>
        $(document).ready(function(){
        load(); 
        
        $("#newData").on("click",function(){
          window.location.href="OJTinfo.php";
        })

        $("#fil").change(function(){
          fil = $("#fil").val();
        })
          $("input#searchBar").keypress(function(){
            var searchBar = $("input#searchBar").val();
              if(searchBar.length >= 2){
                $.ajax({
                  url: "proc_OJTinfo.php",
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
        })
        var fil = 'name';
        function load(){
          $.ajax({
            url:"proc_OJTinfo.php",
            type: "POST",
            success: function(data){
             $("#content").html(data)
            }
          })
        }
    </script>
</head>
<body>
        <?php include 'navbar.php'; ?>
      <div class="container">
        <div class="d-flex justify-content-start">
          <h1 class="title">On-The-Job Training</h1>
        </div>
          <div class="row">
          <div class="input-group w-50 rounded col-6 pt-2">
          <select name="" class="form-control filter" id="fil">
              <option value="" hidden>Filter</option>
              <option value="Name">First Name</option>
              <option value="NoS">School</option>
            </select>
          <input type="text" class="form-control" id="searchBar">
            <button class="btn btn-primary" id="search"><i class="fi fi-rr-search p-1"></i>Search</button>
        </div>
        <div class="col pt-2 d-flex justify-content-end">
          <button class="btn btn-dark p-1" id="newData"><i class="fi fi-rr-layer-plus p-1"></i>New OJT</button>
        </div>
        </div>
      </div>
      <div class="container table-responsive">
        <div class="d-flex justify-content-center pt-1">
            <table class="table bg-white shadow-sm roundTable">
               <tr>
                <th>MASTER LIST</th>
                </tr>
               <!-- ajax request -->
               <tbody id="content">

               </tbody>      
            </table>

            
        </div>
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View OJT PDS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <table class="table table-borderless">
       <tbody>
            <tr>
                <th>Name: </th>
                <td id='viewName'></td>
            </tr>

            <tr>
                <th>Address:</th>
                <td id="viewAddress"></td>
            </tr>
            
            <tr>
                <th>Mobile No.:</th>
                <td id="viewMobileno"></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td id="vieweAddress"></td>
            </tr>
            <tr>
                <th>School:</th>
                <td id='viewNoS'></td>
            </tr>
            <tr>
                <th>Guardian:</th>
                <td id='viewGname'></td>
            </tr>
            
            <tr>
                <th>Mobile No.:</th>
                <td id="viewGmobileno"></td>
            </tr>
        </tbody>
       </table>
      </div>
    </div>
  </div>
</div>

      
      
    
</body>
</html>