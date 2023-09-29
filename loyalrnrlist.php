<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:views_login.php");
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'  ?>
    <?php include 'navbar.php'; ?>

        <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylehome.css">

    <script>
        $(document).ready(function(){
            $.ajax({
        type: "GET",
        url: "proc_loyalty.php?proc=benefits",
        dataType: "html",
        success: function(response){
            $("#content").html(response);
            // Add a click event listener to the name column header
           
        }
        
    });
    
        })
    </script>
    <style>
        @media print{
        body *:not(#my-section):not(#my-section *){
        visibility: hidden;
         }
         #my-section{
        position: absolute;
        top: 0;
        left: 0;
         }
      
        }
        
    </style>
</head>
<body>
    <section>
        <div class="d-flex justify-content-end container pt-3">
    <button class="btn-outline-success btn"onclick="window.print()"><i class="fi fi-rr-print"></i> | Print this page</button>
    </div>
    </section>
    <section id="my-section">
    <div class="container bg-white mt-2">

    <table class="table">
        <th>NAME</th>
        <th>DATE OF EMPLOYMENT</th>
        <th class="text-center">NO. OF YEARS IN SERVICE</th>
        <tbody id="content">

        </tbody>
    </table>
    </div>
    </section>
</body>
</html>