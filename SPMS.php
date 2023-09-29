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
    <link rel="stylesheet" type="text/css" href="stylehome.css">

    <script>
        $(document).ready(function(){
        load(); 
        
        $("#newData").on("click",function(){
          window.location.href="personalInfo.php";
        })

        $("#fil").change(function(){
          fil = $("#fil").val();
        })
          $("input#searchBar").keypress(function(){
            var searchBar = $("input#searchBar").val();
              if(searchBar.length >= 2){
                $.ajax({
                  url: "proc_personalInfo.php",
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
        var fil = 'surname';
        function load(){
          $.ajax({
            url:"proc_personalInfo.php",
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
          <h1 class="title">SPMS</h1>
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
            <button class="btn btn-primary" id="search"><i class="fi fi-rr-search p-1"></i>Search</button>
        </div>
        <div class="col pt-2 d-flex justify-content-end">
          <button class="btn btn-dark p-1" id="newData"><i class="fi fi-rr-layer-plus p-1"></i>New Data</button>
        </div>
        </div>
      </div>
      <div class="container table-responsive">
        <div class="d-flex justify-content-center pt-1">
            <table class="table bg-white shadow-sm roundTable">
               <tr>
                <th>SURNAME</th>
                <th>FIRST NAME</th>
                <th>MIDDLE NAME</th>
                <th>NAME EXTENSION</th>
                <th class="header">Action</th>
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
        <h5 class="modal-title" id="exampleModalLabel">View SPMS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <table class="table table-borderless">
       <tbody>
            <tr>
                <th>Surname: </th>
                <td id='viewsname'></td>
                
                <th>Suffix:</th>
                <td id='viewsfx'> N/A</td>
                <td rowspan="3" colspan="2"><img src="images/profile.png" alt=""></td>
            </tr>
            
            <tr>
                <th>First Name:</th>
                <td id='viewfname'></td>
            </tr>

            <tr>
                <th>Middle Name:</th>
                <td id='viewmname'></td>
            </tr>

            <tr>
                <th>Date of Birth:</th>
                <td id='viewdob'></td>
            </tr>
            
            <tr>
                <th>Place of Birth:</th>
                <td id="viewpob"></td>
                
                

                <th>ID NO.</th>
                <td id="viewempNo"></td>
            </tr>

            <tr>
                <th>Gender:</th>
                <td id="viewgender"></td>
            </tr>

            <tr>
                <th>Civil Status:</th>
                <td id="viewcivil"></td>
            </tr>

            <tr>
                <th>House/Block/Lot No.</th>
                <td id="viewresHouse"></td>
            </tr>

            <tr>
                <th>Barangay:</th>
                <td id="viewresBrgy"></td>
            </tr>

            <tr>
                <th>City:</th>
                <td id="viewresCity"></td>
            </tr>

            <tr>
                <th>Zipcode:</th>
                <td id="viewresZip"></td>

                <th>Position</th>
                <td>Testing Position</td>
            </tr>

            <tr>
                <th>Email:</th>
                <td id="viewemail"></td>

                <th>Department:</th>
                <td>Testing dept</td>
            </tr>

            <tr>
                <th>Citizenship:</th>
                <td id="viewciti"></td>

                <th>Plantilla:</th>
                <td>Testing plantilla</td>
            </tr>

            <tr>
                <th>Height:</th>
                <td id="viewheight"></td>

                <th>Employment Type:</th>
                <td>Regular</td>
            </tr>

            <tr>
                <th>Weight:</th>
                <td id="viewweight"></td>

                <th>Employment Status:</th>
                <td>ACTIVE</td>
            </tr>

            <tr>
                <th>Blood Type:</th>
                <td id="viewbtype"><td>

            </tr>

            <tr>
                <th>GSIS ID No.</th>
                <td id="viewgsis"></td>

                <th>Contact Number</th>
                <td id="viewmobile"></td>
            </tr>

            <tr>
                <th>Pag-Ibig ID No.:</th>
                <td id="viewpagibig"></td>
            </tr>

            <tr>
                <th>Philhealth:</th>
                <td id="viewphealth"></td>
            </tr>

            <tr>
                <th>TIN:</th>
                <td id="viewtin"></td>
            </tr>
        </tbody>
       </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">PDS</button>
        <button type="button" class="btn btn-primary">Appointment</button>
      </div>
    </div>
  </div>
</div>

      
      
    
</body>
</html>