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
</head>
  
<script>
    $(document).ready(function(){
        load();
        $("select#add").change(function(){
            var type = $(this).val();
            if(type == 'new'){
            window.location.href="views_addNewSeminar.php"
            }
            else{
                window.location.href="views_addExistingSeminar.php"
            }
        })

        function load(){
            var action = "load";
            $.ajax({
                type: "POST",
                data: {action:action},
                url: "proc_lnd_ESA.php",
                success: function(data){
                    $("table#mainTable tbody").html(data);
                }
            })
        }
    })
</script>
<body>
        <?php include 'navbar.php'; ?>
      <div class="container-fluid  bg-white rounded">

      <h1 class="mt-2">Learning and Development Intervention</h1>
      <h2 class="mt-1">IN-HOUSE TRAINING</h2>
        <div class="row">
            <div class="col-10">
                <div class="input-group w-50 ms-2">
                <select name="" id="" class="form-control" style="max-width: 20%">
                    <option value="" hidden>Filter</option>
                    <option value="">Date</option>
                </select>
                <input type="text" class="form-control">
                <button class="btn btn-primary"><i class="fi fi-rr-search pe-1"></i>Search</button>
                </div>
            </div>
            <div class="col d-flex justify-content-end me-2">
                <select name="" id="add" class="form-control w-50 text-center">
                    <option value="" hidden>Insert data</option>
                    <option value="new">New Data</option>
                    <option value="exist">Existing Data</option>
                </select>
        </div>
        <div class="d-flex justify-content-center">
            <table class="table table-hover table-bordered m-2" id="mainTable">
                <thead>
                    <tr>
                    <th rowspan="2" class="text-center">Title of Seminar or Training</th>
                    <th colspan="2" class="text-center">Date</th>
                    <th rowspan="2" class="text-center">No. of Hours</th>
                    <th rowspan="2" class="text-center" style="width: 7%">Type of L&D Intervention</th>
                    <th rowspan="2" class="text-center">SMT(s)/RS(s)/Conducted By</th>
                    <th rowspan="2" class="text-center">Venue</th>
                    <th rowspan="2" class="text-center">Expenses</th>
                    </tr>
                    <tr>
                        <th class="text-center">From</th>
                        <th class="text-center">To</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seminar/Training Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-8">
            <p><strong>Title:</strong> <span id="modalTitle"></span></p>
            <p><strong>Type of l&d intervention:</strong> <span id="modalType"></span></p>
            </div>
            <div class="col">
            <p><strong>Date:</strong> <span id="date"></span></p>
            <p><strong>Venue:</strong> <span id="modalVenue"></span></p>
            </div>
            
        <hr>
        <h4>Participants</h4>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Salary Grade</th>
                <th>Position</th>
                <th>Type Of Certificate</th>
                <th>Remarks</th>
            </tr>
            
            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
        </div>
    </div>
      
      
    
</body>
</html>