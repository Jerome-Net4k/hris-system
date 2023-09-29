<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:views_login.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HRIS</title>
    <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">

    <script>
        $(document).ready(function(){

          $.ajax({
            type: "GET",
            url: "proc_serviceRecord.php?proc=load",
            success: function(data){
              $("#content").html(data);
            } 
          })
        })
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
      <div class="container">
        <div class="d-flex justify-content-start">
          <h1 class="title">Service Record  </h1>
        </div>
          <div class="row">
          <div class="input-group w-50 rounded col-6 pt-2">
            <select name="" class="form-control filter" id="fil">
              <option value="" hidden>Filter</option>
              <option value="surname">Fullname</option>
              <option value="fname">Designation</option>
              <option value="mname">Status</option>
              <option value="ext">Salary</option>
              <option value="">Station/Place</option>
              <option value="">Branch</option>
              
            </select>
          <input type="text" class="form-control" id="searchBar">
            <button class="btn btn-primary" id="search"><i class="fi fi-rr-search p-1"></i>Search</button>
        </div>
        </div>
      </div>
      <div class="container rounded">
        <div class="d-flex justify-content-center pt-1">
            <table class="table bg-white shadow-sm table-bordered roundTable">
               <tr>
                <th rowspan="2" style="text-align: center; padding-top: 30px">FULLNAME</th>
                <th colspan="3" style="text-align: center;">RECORDS OF APPOINTMENT</th>
                <th colspan="2" style="text-align: center;">OFFICE/ENTITY/DIVISION</th>
                <th class="header" rowspan="2" style="padding-top: 30px">ACTION</th>
               </tr>

               <tr>
                
                <th style="text-align: center;">Designation</th>
                <th style="text-align: center;">STATUS</th>
                <th style="text-align: center;">SALARY</th>
                <th style="text-align: center;">STATION/PLACE</th>
                <th style="text-align: center;">BRANCH</th>
               </tr>
               <!-- ajax request -->
               <tbody id="content">
                   
                    
               </tbody>      
            </table>

            
        </div>
      </div>

      
      
    
</body>
</html>