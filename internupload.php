<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'; ?>
    <?php include 'navbar.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    </head>

    <script>
  $(document).ready(function(){
    
       
    $("input:text").keyup(function(){
        var val = $(this).val();
        $(this).val(val.toUpperCase());
    })

  

    $('form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
        url:"ojtupload.php",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        processData:false,
        success:function(data)
        {
            if (data == "success") {
                $('form')[0].reset();
                iziToast.success({
                    title: 'Success',
                    message: 'Data has been successfully submitted.',
                    position: 'topRight'
                });
                load_data();
            } else if (data == "duplicate") {
                iziToast.error({
                    title: 'Error',
                    message: 'ID Number already exists.',
                    position: 'topRight'
                });
            } else {
                iziToast.error({
                    title: 'Error',
                    message: 'Failed to submit data.',
                    position: 'topRight'
                });
            }
        },
        
    }); 
 
});

})

</script>

<body>
<div class="container bg-white rounded mt-4 mb-4">
    <h1 class="fw-bolder text-center mb-2 pt-2">OJT DATA SHEET</h1>
    <hr>
<div class="row row-cols-2">

<div class="col-6">
<form enctype="multipart/form-data" method="post">

    <div class="form-floating mb-3 ">
  <input type="text" id="idnum" name="idnum" class="form-control required w-50" required>
  <label for="idnum">ID Number*</label>
    </div>
    </div>

    <div class="col-6">
    <div class="input-group mb-3">
  <label class="input-group-text bg-dark text-white" for="inputGroupFile01">Upload Profile Picture</label>
  <input type="file" class="form-control" name="internpic" id="inputGroupFile01">
</div>
    </div>
  
    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="name" name="nameintern" class="form-control required" required>
  <label for="sname">Fullname* (Last name, First name, MI)</label>
    </div>
    </div>

    <div class="col col-md-3">
    <div class="form-floating mb-3">
  <input type="text" id="ext" name="ext"class="form-control" >
  <label for="ext">Name Extension (Jr. Sr.)</label>
    </div>
    </div>

    <div class="col ">
    <div class="form-floating mb-3">
  <input type="date" class="form-control required" id="dob" name="dob" required>
  <label for="dob">Date of Birth*</label>
    </div>
    </div>

    <div class="col ">
    <div class="form-floating mb-3">
 <input type="school" id="school" name="school" class="form-control" required>
  <label for="pob">School*</label>
    </div>
    </div>

    <div class="col ">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required"  name="dept"id="dept" required>
  <label for="pob">Department*</label>
    </div>
    </div>

    <div class="col col-sm-2">
    <div class="form-floating mb-3">
    <input type="text" class="form-control required"  name="btype" id="btype" >
  <label for="pob">Bloodtype*</label>
    </div>
    </div>
</div>
<hr>
<div class="text-center fs-4 fw-bold"> In Case of Emergency </div>

<div class="row row-cols-2">
<div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="nameguard" name="nameguard" class="form-control required" required>
  <label for="sname">Name*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
    <select class="form-select" id="inputGroupSelect04" id="rel" name="rel"aria-label="Example select with button addon">
              <option selected>MOTHER</option>
              <option value="FATHER">FATHER</option>
              <option value="GUARDIAN">GUARDIAN</option>
            </select>  <label for="sname">Relationship</label>
    </div>
    </div>

    <div class="col-8">
    <div class="form-floating mb-3">
  <input type="text" id="address" name="address" class="form-control required" required>
  <label for="sname">Address*</label>
    </div>
    </div>

    <div class="col-4">
    <div class="form-floating mb-3">
  <input type="text" id="contactnum" name="contactnum"class="form-control required" required>
  <label for="sname">Contact Number*</label>
    </div>
    </div>
    

</div>
<hr>

<div class="text-center fs-4 fw-bold"> Upload Files </div>
<div class="input-group input-group-lg">
  <input type="file" name="file" class="form-control mb-3" id="files">
</div>

<div class="col-12">
    <div class="form-floating mb-3">
  <textarea class="form-control" id="remarks" name="remarks" cols="30" rows="10" style="height: 70px"></textarea>
  <label for="sname">Remarks*</label>
    </div>
    </div>

<div class="d-flex justify-content-end">
<button type="submit" name="submit" class="btn btn-success mb-2" id="save"><i class="fi fi-rr-disk"> SAVE</i></button>
</div>

</div>
</form>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<html>