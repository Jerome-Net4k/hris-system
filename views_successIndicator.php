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
        load(); 

          $("#indicator").change(function(){
            indicatorFil = $("#indicator").val();

              $.ajax({
                  url: "proc_successIndicator.php",
                  type: "POST",
                  data: {
                    indicatorFil: indicatorFil
                },
                  success: function(data){
                    $("#indicatorView").html(data)
                  }
                })

            })

        })
        function load(){   
            indicatorFil = $("#indicator").val();       
                            
          $.ajax({
            data: {
                indicatorFil: indicatorFil
            },
            url:"proc_successIndicator.php",
            type: "POST",
            success: function(data){
             $("#indicatorView").html(data)
            }
          })
        }
    </script>

</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container-fluid pt-2">

    <h1>SUCCESS INDICATOR</h1>
    
    <div class="row mb-2">
                <div class="col" style="max-width: 5%;">
                    <h4>Region:</h4>
                </div>
                <div class="col-10 ps-1">
                    <select name="" id="indicator" class="form-control w-25 p-1">
                        <option value="CIS">Common Success Indicator</option>
                        <option value="ADHRDS">Admin-HRDS</option>
                        <option value="ADGSS">Admin-GSS</option>
                        <option value="ADMD">Admin-Medical</option>
                        <option value="ADPROCURE">Admin-Procurement</option>
                        <option value="ADPROPERTY">Admin-Property</option>
                        <option value="DMPAO">DMPAO</option>
                        <option value="FDACCOUNTING">Financial-Accounting</option>
                        <option value="FDBUDGET">Financial-Budget</option>
                        <option value="FDTREASURY">Financial-Treasury</option>
                        <option value="LESFED">LES-FED</option>
                        <option value="LESIID">LES-IID</option>
                        <option value="LESTSD">LES-TSD</option>
                        <option value="MD">Management</option>
                        <option value="MIDCCTSS">MID-CCTSS</option>
                        <option value="MIDCOMPUTER">MID-Computer</option>
                        <option value="MIDRECORDS">MID-Records</option>
                        <option value="OAOED">OAssec, OED</option>
                        <option value="OPSC3">OPS-C3</option>
                        <option value="OPSL">OPS-License</option>
                        <option value="OPSR">OPS-Registration</option>
                        <option value="PS">Planning Staff</option>
                        <option value="TAS">TAS</option>
                    </select>
                </div>
            </div>

    <div class="row pt-2 rounded bg-white">
        <div class="col m-1 border">

    <div id="indicatorView">

    </div>

        </div>
    </div>

    </div>

<script>



</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>