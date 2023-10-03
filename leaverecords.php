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
    <?php include 'navbar.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylepage.css">
</head>
<script>
$(document).ready(function(){

    $.ajax({
        type: "GET",
        url: "proc_leavecredits.php?id=" + <?php echo $_GET['id']?> +  "&proc=record",
        success: function(data){
        $("#leaverecords").html(data);
        }
        })
    
})
function printSection() {
                var printContents = document.getElementById("my-section").innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
</script>
<style>
        @media print {
            body *:not(#my-section):not(#my-section *) {
                visibility: hidden;
            }
            #my-section {
                position: static !important;
                left: 0;
                top: 0;
                width: auto;
            }
            #my-section table {
                width: 100%;
            }
        }
        
    </style>
</head>

<body>
    <section>
        <div class="container bg-light mt-2">
            <div class="row pt-2">
                <div class="col">
                    <select class="form-select w-25" aria-label="Default select example">
                        <option selected>YEAR</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-2">
                    <button class="btn-outline-success btn" onclick="printSection()"><i class="fi fi-rr-print"></i> | Print this page</button>
                </div>
            </div>
            <section id="my-section">
                <table class="table table-sm caption-top">
                    <caption class="fw-bold fs-4">Records</caption>
                    <tr>
                        <th class="text-start">Period/Particular</th>
                        <th class="text-center">Earned</th>
                        <th class="text-center">Absence/Undertimes<br> with Pay</th>
                        <th class="text-center">Balance VLLL</th>
                        <th class="text-center">Balance SL</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th class="text-center">Absence/Undertimes<br> without Pay</th>
                    </tr>
                    <tbody id="leaverecords">
                        <!-- Leave records content here -->
                    </tbody>
                </table>
            </section>
        </div>
    </section>
</body> 
















<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</html> 