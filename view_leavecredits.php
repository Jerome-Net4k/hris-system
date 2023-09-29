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
    <link rel="stylesheet" type="text/css" href="stylehome.css">
</head>
<script>
  $(document).ready(function(){

$.ajax({
  type: "GET",
  url: "proc_leavecredits.php?proc=load",
  success: function(data){
    $("#list").html(data);
  } 
})

})
</script>
</head>

<body>
      <div class="container bg-light mt-2">
        <table class="table">
            <th>NAME</th>
            <th>DESIGNATION</th>
            <th class="text-center">ACTION</th>
            <tbody id="list">

            </tbody>
        </table>
      </div>
</body> 
















<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</html> 