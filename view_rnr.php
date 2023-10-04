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
    <?php include 'partials_header.php';  ?>
    <?php include 'navbar.php';  ?>

    <link rel="stylesheet" type="text/css" href="stylehome.css">

    <script>
    $(document).ready(function() {
        load();
   

function load(){
    $.ajax({    //create an ajax request to display.php
    type: "GET",
    url: "proc_rnr.php?proc=load",             
    dataType: "html",   //expect html to be returned                
    success: function(response){                    
        $("#content").html(response);  
     //alert(response);
    }
})
}  
 });
    </script>
</head>
<body>
        
      <div class="container">
        <div class="d-flex justify-content-start">
          <h1 class="title">RnR</h1>
        </div>
          <div class="row">
          <div class="input-group w-50 rounded col-6 pt-2">
            <select name="" class="form-control filter" id="fil">
              <option value="" hidden>Filter</option>
              <option value="sname">Surname</option>
              <option value="fname">First Name</option>
              <option value="mname">Middle Name</option>
              <option value="ext">Name Extension</option>
              
            </select>
          <input type="text" class="form-control" id="searchBar">
        </div>
        </div>
      </div>

      <div class="container table-responsive">
        <div class="d-flex justify-content-center pt-1">
            <table class="table bg-white shadow-sm roundTable">
              <tr>
              <th>NAME</th>
                <th>DIVISION</th>
                <th class="header">Action</th>
              </tr>
              <!-- ajax request -->
              <tbody id="content">

              </tbody>      
            </table>

            
        </div>
      </div>

  
      
    
</body>
</html>