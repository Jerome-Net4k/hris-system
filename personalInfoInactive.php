
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include 'partials_header.php'; 
    include 'table_personalInfoTable.php';
    $personalInfo = new personalInfo();
    $noCheck = $personalInfo->get_existNo();
    ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>New Account</title>
   
    <script>
              function checkNo(){
                var a = document.getElementById("inactive201").value;
                const numbers = <?php echo $noCheck ?>;
                if(numbers.some(item => item.idNo == a)){
                document.getElementById("dupeCheck").style.display = 'inline';
                } else {
                document.getElementById("dupeCheck").style.display = 'none';
                }
            }

      $(document).ready(function(){

        $("button#submit").on("click",function(){
          var valid = true;
          $(".required").each(function(){
              var val = $(this).val();
              if(val == ''){
                valid = false;
                $(this).css("border-color","#DF2E38")
                iziToast.warning({
                          displayMode: 1, 
                          position: 'topRight',
                          title: 'Failed',
                          message: 'Please check your input.'
                          });
              }
              else{
                $(this).css("border-color","#cfcfcf")
              }      
                })
              
                if(valid == true){
                
                var newInactive = true;
                var remarks = $("#remarks").val();
                var idNo = $("#inactive201").val();
                var sname = $("#sname").val();
                var fname = $("#fname").val();
                var mname = $("#mname").val();
                var ext = $("#ext").val();
                var region = $("#region option:selected").val();
               

                $.ajax({
                  data: {
                        newInactive: newInactive,
                        remarks: '"' + remarks + '"',
                        idNo: idNo,
                        sname: '"' + sname + '"',
                        fname: '"' + fname + '"',
                        mname: '"' + mname + '"',
                        region: '"' + region + '"',
                        ext: '"' + ext + '"'
                      },
                        type: "POST",
                        url: "uploadPDInactive.php",
                        success: function(data){
                          if (data == 'success'){
                            // window.location.href = "views_201Files.php?";
                            iziToast.success({
                                position: "center",
                                timeout: 1500,
                                title: "OK",
                                message: "Data submitted successfully!!",
                                messageSize: '30',
                                titleSize: '25',
                            });

                            // document.getElementById("newInactiveForm").reset();
                            window.location.href = "personalInfoInactive.php?";
                            
                          } else {
                            iziToast.warning({
                            title: 'Failed',
                            message: 'Possible duplicate, please check your input.'
                            });
                          }                          
                        },
                        error: function() {
                            window.location.href = "views_201Files.php?";
                        }
                      })
                      
                }
              
        })

        $("button#prev").on("click",function(){
                window.location.href = "views_201Files.php"
            })

        // $("button#submit").on("click",function(){
        //         document.getElementById("newInactiveForm").reset();
        //     })

      })
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container bg-white rounded mt-4 mb-4">
    <button class="btn btn-primary m-2 p-1" id="prev"><< Back</button>
    <h1 class="fw-bolder text-center mb-2 pt-2">INACTIVE 201</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">I. Personal Information</div>

    <form id="newInactiveForm">
    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="remarks" class="form-control" value="">
  <label for="sname">Remarks</label>
    </div>
    </div>

    <div class="col col-md-2">
    <div class="form-floating mb-3">
  <input type="text" id="inactive201" class="form-control required" required oninput="checkNo();">
  <label for="inactive201">201 No.*</label>
  <span id="dupeCheck" style="color: red; display: none;"><b><i>this no. already exist!</b><i></span>
    </div>
    </div>
    
<div class="row row-cols-2 ">

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="sname" class="form-control required" required>
  <label for="sname">Surname*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="fname" class="form-control required" required>
  <label for="fname">First Name*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="mname" class="form-control">
  <label for="mname">Middle Name</label>
    </div>
    </div>

    <div class="col col-md-3">
    <div class="form-floating mb-3">
  <input type="text" id="ext" class="form-control" >
  <label for="ext">Name Extension (Jr. Sr.)</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
    <select name="" id="region" class="form-control w-50 p-1">
                        <option value="N/A">N/A</option>
                        <option value="Central Office">Central Office</option>
                        <option value="NCR East">NCR East</option>
                        <option value="NCR West">NCR West</option>
                        <option value="1">1 - San Fernando, La Union</option>
                        <option value="2">2 - Tuguegarao, Cagayan</option>
                        <option value="3">3 - San Fernando, Pampanga</option>
                        <option value="4A">4A - Lipa City, Batangas</option>
                        <option value="4B">4B - MIMAROPA</option>
                        <option value="5">5 - Legazpi City, Albay</option>
                        <option value="6">6 - Iloilo City</option>
                        <option value="7">7 - Cebu City</option>
                        <option value="8">8 - Tacloban City</option>
                        <option value="9">9 - Zamboanga City</option>
                        <option value="10">10 - Cagayan de Oro City</option>
                        <option value="11">11 - Davao City</option>
                        <option value="12">12 - Koronadal City</option>
                        <option value="14">14 - Baguio City (CAR)</option>
                        <option value="15">15 - Butuan City (CARAGA)</option>  
    </select>
    </div>
    </div>
    </form>

</div>
<div class="d-flex justify-content-end">
          <button class="btn btn-primary mb-2" id="submit">Submit</button>
        </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>