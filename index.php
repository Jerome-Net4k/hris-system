<?php
  session_start();
  if(isset($_SESSION['user'])){
    header("Location: views_index.php");
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylelogin.css">
</head>
<style>
  *{
    font-family: 'Poppins', sans-serif;
  }
</style>
  <script>
    $(document).ready(function(){
      
      $("#login").on("click",function(e){
        e.preventDefault();
        var id = $(this).val();
        var uname = $("#uname").val();
        var pass = $("#pass").val();

        $.ajax({
          data: {
                  id:id,
                  uname: uname,
                  pass: pass},
          url: "proc_userTable.php",
          type: "POST",
          success: function(data){
            if(data == "Account Found"){
            window.location.href="views_index.php";
            }
            else if(data == "No Account Found"){
                iziToast.error({
                title: 'Login failed',
                message: 'Please check your username or password'
                });
                $("#uname").val("");
                $("#pass").val("");
            }
            else{
                iziToast.warning({
                title: 'Failed',
                message: 'Please check your input.'
                });
            }
          }
        })
      })
    })
  </script>
<body>
    
</body>
</html>
</head>
    <body>
	<div class="col-lg-5 d-flex align-items-center pt-5">
              <div class="card-body p-2 p-lg-5">

                <form>

                  <div class="d-flex align-items-center mb-3 pb-1 pt-5 ">
                    <span class="h1 fw-bold mb-0">Land Transportation Office<br><span><h4>Human Resource Development Section</h4></span></span>
                 
                  </div>
                  

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>
            
                  <div class="form-outline mb-4">
                    <input type="text" id="uname" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example17">Username</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" id="pass" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example27">Password</label>
                  </div>

                  <div class="pt-1 mb-4">
                  <button class="btn btn-dark btn-lg btn-block" id="login" value="userLogin">Login</button>
                  </div>
                
              </div>
            </div>

			
		</div>
	</div>
	<div id="notif"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
    
</body>
</html>