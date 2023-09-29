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

    <script>
  $(document).ready(function() {
    showMoaRecords("");

$("#search").on("keyup", function() {
  var input = $(this).val();
  showMoaRecords(input);
});

function showMoaRecords(input) {
  $.ajax({
    type: "POST",
    url: "proc_moa.php",
    dataType: "html",
    data: { input: input },
    success: function(response) {
      $("#content").html(response);
    }
  });
}

    $('form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:"moaupload.php",
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
                    load();
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
    
    $('#submitBtn').click(function(e) {
    e.preventDefault(); // prevent the default form submission

    // get the values from the input fields
    var name = $('#name').val();
    var subdate = $('#subdate').val();

    // get the id of the row to update
    var id = $('#update').val();

    if (name == '' || subdate == '') {
        iziToast.error({
            title: 'Error',
            message: 'Name and Submitted Date cannot be empty',
            position: 'topRight'
        });
        return;
    }

    // send an AJAX request to update the data
    $.ajax({
        url: 'moaupdate.php',
        type: 'POST',
        data: {id: id, name: name, subdate: subdate},
        success: function(response) {
            iziToast.success({
                title: 'Success',
                message: 'Data has been successfully submitted.',
                position: 'topRight'
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            iziToast.error({
                title: 'Error',
                message: 'Failed to update data.',
                position: 'topRight'
            });
        }
    });
});
});

   


    </script>
</head>
<body>
      <div class="container">
        <div class="d-flex justify-content-start">
        <h1 class="title fw-bold fs-2 pt-2">LIST OF MOA</h1>
        </div>
          <div class="row">
           <div class="input-group w-50 rounded col-6 pt-2">
          <span class="input-group-text">SEARCH</span>
          <input type="text" class="form-control" id="search">
          <button type="button" id="search-btn" class="btn-outline btn-outline-primary btn"><i class="fi fi-rr-search"></i></button>
        </div>
      <div class="col pt-2 d-flex justify-content-end">
      <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <i class="fi fi-rr-layer-plus"></i> | ADD NEW MOA
        </button>        </div>
        </div>
        </div>


      <div class="container table-responsive">
        <div class="d-flex justify-content-center pt-1">
            <table class="table bg-white shadow-sm roundTable table-sm">
               <tr>
                <th>SCHOOL MOA</th>
                <th>SUBMITTED DATE</th>
                <th class="text-center">ACTION</th>
               </tr>
               <!-- ajax request -->
               <tbody id="content">

               </tbody>      
            </table>

            
        </div>
      </div>

  
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ADD MOA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>           
      <form enctype="multipart/form-data" method="post">
      <div class="modal-body">
      <div class="row g-2">
      <div class="col-md">
            <div class="form-floating">
            <input type="text" class="form-control" name="name" require>
            <label for="floatingSelectGrid">Name of File</label>
            </div>
        </div>
      <div class="col-md">
            <div class="form-floating">
            <input type="DATE" class="form-control" name="subdate" require>
            <label for="floatingSelectGrid">DATE SUBMITTED</label>
            </div>
        </div>
        </div>      
        <div class="col-md">
            <div class="form-floating">
            <div class="input-group mb-3">
        <input type="file" class="form-control-lg" name="moafile">
        </div>
        </div>
        </div>
        
</div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="exampleModalLabel">UPDATE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
  <div class="modal-body">
    <div class="row">
      <div class="col">
        <div class="form-floating">
          <input type="text" class="form-control" name="name" id="name" required>
          <label for="floatingSelectGrid">NAME OF FILE</label>
        </div>

        <div class="form-floating mt-2">
          <input type="DATE" class="form-control" name="subdate" id="subdate" required>
          <label for="floatingSelectGrid">DATE SUBMITTED</label>
        </div>
        <div class="d-flex justify-content-end mt-2 pb-2">
          <button type="submit"  id="submitBtn"class="btn btn-outline-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
 

      </div>
    </div>
  </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</html> 