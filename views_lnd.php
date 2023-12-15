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
                url: "proc_lnd.php",
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
            <p><strong>smt(s)/rs(s)/conducted by: </strong><span id="modalCond"></span></p>
            </div>
            <div class="col">
            <p><strong>Date:</strong> <span id="date"></span></p>
            <p><strong>Venue:</strong> <span id="modalVenue"></span></p>
            </div>
        </div>
        <p><strong>Remarks:</strong> <span id="modaRemarks"></span></p>
        <hr>
        <h4>Expenses</h4>
           <table class="table table-bordered" id="table_expenses">
                <thead>
                    <tr>
                        <th>Type of Expenses</th>
                        <th>Amount</th>
                    </tr>
                    <tbody>

                    </tbody>
                </thead>
           </table>
           <h4>Total: <span id="modalTotal"></span></h4>
        <hr>
        <h4>Office Order/Travel Oder </h4>
        <a id="modalOfficeOrder"></a>
        <hr>
        <h4>Objective/s</h4>
            <p id="modalObj"></p>
        <hr>
        <h4>Reference Files</h4>
        <ul id="reference">
            
        </ul>
        <hr>
        <h4>Participants</h4>
        <table class="table table-bordered">

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
      
<!-- Your script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
            $('body').on('change', '.selectname', function() {
                var fnameDropdown = $('#fnameDropdown'); // Get the first name dropdown
                var lnameDropdown = $('#lnameDropdown'); // Get the last name dropdown

                if (!fnameDropdown.length || !lnameDropdown.length) {
                    console.error('Dropdowns not found');
                    return;
                }

                var fname = fnameDropdown.val(); // Get the selected first name
                var lname = lnameDropdown.val(); // Get the selected last name

                $.ajax({
                    url: 'fetch_participants.php',
                    method: 'GET',
                    data: { fname: fname, lname: lname },
                    success: function(data) {
                        var participant = JSON.parse(data);
                        var newRow = `
                            <tr>
                                <td>${participant.bpNo}</td>
                                <td>${participant.fname}</td>
                                <td>${participant.lname}</td>
                            </tr>
                        `;
                        $('#participantsTable').append(newRow);
                    }
                });
            });
</script>
   
</body>
</html>