
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start();
    include 'partials_header.php'; 
    include 'table_personalInfoTable.php';
    $personalInfo = new personalInfo();
    $noCheck = $personalInfo->get_existIpcrNo();
    ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>New Account</title>
   
    <script>
              function checkNo(){
                var a = document.getElementById("ipcrEmpNo").value;
                const numbers = <?php echo $noCheck ?>;
                if(numbers.some(item => item.empno == a)){
                document.getElementById("dupeCheck").style.display = 'inline';
                } else {
                document.getElementById("dupeCheck").style.display = 'none';
                }
            }

      $(document).ready(function(){

        $("#newIpcrForm").on('submit', function(e){
                e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "upload_ipcrEncoding.php",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data){
                            if (data == "success"){
                                iziToast.success({
                                position: "center",
                                timeout: 1000,
                                title: "OK",
                                message: "Data Encoded Successfully!!",
                                messageSize: '30',
                                titleSize: '25'
                                });

                                setTimeout(function() {
                                  window.location.href = "views_ipcrEncoding.php";
                                }, 1200);

                            } else {
                              iziToast.error({
                                position: "center",
                                title: "",
                                message: data,
                                messageSize: '30',
                                titleSize: '25'
                            });
                            }
                        },
                        error: function() {
                            iziToast.error({
                                position: "center",
                                title: "",
                                message: "Something went wrong..",
                                messageSize: '30',
                                titleSize: '25'
                            });
                        }
                    })

            });

        $("button#prev").on("click",function(){
                window.location.href = "views_ipcrUpload.php"
            })

      })
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container bg-white rounded mt-4 mb-4">
    <button class="btn btn-primary m-2 p-1" id="prev"><< Back</button>
    <h1 class="fw-bolder text-center mb-2 pt-2">IPCR ENCODING</h1>
    <hr>

    <form id="newIpcrForm" enctype="multipart/form-data" onsubmit="return confirm('Are you sure all data are correct??')">
    <input type="hidden" name="newIpcr" value="true">

    <div class="col col-md-2">
    <div class="form-floating mb-3">
  <input type="text" name="ipcrEmpNo" id="ipcrEmpNo" class="form-control" required oninput="checkNo();">
  <label for="inactive201">GSIS BP No.*</label>
  <span id="dupeCheck" style="color: red; display: none;"><b><i>this no. already exist!</b><i></span>
    </div>
    </div>
    
<div class="row row-cols-2 ">

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" name="sname" id="sname" class="form-control" required>
  <label for="sname">Surname*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" name="fname" id="fname" class="form-control" required>
  <label for="fname">First Name*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" name="mname" id="mname" class="form-control">
  <label for="mname">Middle Name</label>
    </div>
    </div>

    <div class="col col-md-3">
    <div class="form-floating mb-3">
  <input type="text" name="ext" id="ext" class="form-control" >
  <label for="ext">Name Extension (Jr. Sr.)</label>
    </div>
    </div>

    </form>

</div>
    <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary mb-2" id="submit">SUBMIT</button>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>