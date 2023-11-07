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
    loadData();
    $("#newData").on("click",function(){
      window.location.href="internupload.php";
    });


    $("input:text").keyup(function(){
        var val = $(this).val();
        $(this).val(val.toUpperCase());
    })
    

    $('form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
        url:"ojtupdate.php",
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
                    message: 'DATA HAS BEEN SUCCESSFULLY UPDATED.',
                    position: 'topRight'
                });
                load_data();
            
            } else {
                iziToast.error({
                    title: 'Error',
                    message: 'FAILED TO SUBMIT DATA.',
                    position: 'topRight'
                });
            }
        },
        
    }); 
});


// Function to load the data
function loadData() {
  var searchValue = $('#search').val();
  $.ajax({
    url: 'proc_ojt.php',
    method: 'POST',
    data: { input: searchValue },
    success: function(data) {
      $('#content').html(data);
    }
  });
}

// Bind the click event to the search button
$('#search-btn').click(function() {
  loadData();
});

// Bind the keyup event to the search input
$('#search').keyup(function(e) {
  if (e.keyCode == 13) {
    loadData();
  }
});

// Bind the click event to the table headers for sorting
$('#id, #name').click(function() {
  // Get the sorting order from the data-sortby attribute
  var sortby = $(this).data('sortby');

  // Determine the new sorting order based on the current table state
  var sortorder = 'ASC';
  if ($(this).hasClass('sorted-asc')) {
    sortorder = 'DESC';
  }

  // Send an AJAX request to the server to sort the data
  $.ajax({
    url: 'proc_ojt.php',
    method: 'POST',
    data: { input: $('#search').val(), sortby: sortby, sortorder: sortorder },
    success: function(data) {
      // Update the table with the sorted data
      $('#content').html(data);

      // Update the sorting indicator in the table header
      $('#id, #name').removeClass('sorted-asc sorted-desc');
      if (sortorder == 'ASC') {
        $(this).addClass('sorted-asc');
      } else {
        $(this).addClass('sorted-desc');
      }
    }
  });
});
   })


   


    </script>
</head>
<body>
      <div class="container">
        <div class="d-flex justify-content-start">
          <h1 class="title fw-bold fs-2 pt-2">LIST OF INTERN</h1>
        </div>
          <div class="row">
          <div class="input-group w-50 rounded col-6 pt-2">
          <span class="input-group-text">SEARCH</span>
          <input type="text" class="form-control" id="search">
          <button type="button" id="search-btn" class="btn-outline btn-outline-primary btn"><i class="fi fi-rr-search"></i></button>
        </div>
      <div class="col pt-2 d-flex justify-content-end">
          <button class="btn btn-dark p-1" id="newData"><i class="fi fi-rr-layer-plus p-1"></i> | New Data</button>
        </div>
        </div>
        </div>


      <div class="container table-responsive">
        <div class="d-flex justify-content-center pt-1">
        <table class="table bg-white shadow-sm roundTable">
          <thead>
            <tr>
              <th id="id" data-sortby="idnum" style="width:54px;">ID <i class="fi fi-br-angle-up"></i></th>
              <th id="name" data-sortby="nameintern">NAME <i class="fi fi-br-angle-up"></i></th>
              <th>SCHOOL</th> 
              <th>DEPARTMENT</th>
              <th colspan="2"class="header text-center">Action</th>
            </tr>
          </thead>
          <tbody id="content"></tbody>
        </table>
     
            
        </div>
      </div>

  
      <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modal1Label">INTERN INFORMATION</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
            </div>
      <div class="modal-body">
      <table class="table table-borderless">
       <tbody id="body">
           <tr style="height: 10px;">
            <th>ID NUMBER:</th>
            <td id="viewidnum"></td>
            <td class="text-center" colspan="2" rowspan="6" style="width: 300px; border:1px solid #000000">
            <img id="viewinternpic" src="internpic/<?php echo $row['viewinternpic']; ?>" style="width: 150px; height: 225px;">
            </td>            
          </tr>
            <tr>
            <th>NAME:</th>
            <td id="viewnameintern"></td>
            </tr>

            <tr>
            <th>DATE OF BIRTH:</th>
            <td id="viewdob"></td>
            </tr>

            <tr>
            <th>SCHOOL:</th>
            <td id="viewschool"></td>
            </tr>

            <tr>
            <th>DEPARTMENT:</th>
            <td id="viewdept"></td>
            </tr>

            <tr>
            <th>BLOOD TYPE:</th>
            <td id="viewbtype"></td>
            </tr>

            <tr>
              <td colspan="3" class="fw-bold fs-5 text-center text-uppercase">Incase of Emergency</td>
            </tr>

            <tr>
              <th>Name:</th>
              <td colspan="2" id="viewnameguard"></td>
            </tr>

            <tr>
            <th>RELATIONSHIP:</th>
              <td colspan="2" id="viewrel"></td>
            </tr>
            <tr>
              <th>ADDRESS:</th>
              <td colspan="2" id="viewaddress"></td>
            </tr>
            <tr>
              <th>CONTACT NUMBER:</th>
              <td colspan="2" id="viewcontactnum"></td>
            </tr>
            <tr>
              <th>REMARKS:</th>
              <td colspan="2" id="viewremarks"></td>
            </tr>
            <tr>
              <th>FILES</th>
                  <td id="viewfile"></td>
            </tr>
        </tbody>
       </table>
      </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
                                                                  <!--UPDATE MODAL-->
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2Label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modal2Label">UPDATE INFORMATION</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
      <table class="table table-borderless">
       <tbody id="body">
           <tr style="height: 10px;">
           <form enctype="multipart/form-data" method="post" >

            <th>ID NUMBER:</th>
            <td><input type="text" class="form-control w-25" id="idnum" name="idnum" readonly></td>          
          </tr>

            <th>PROFILE PICTURE:</th>            
             <td><input type="file" class="form-control" id="internpic" name="internpic" aria-label="file example"></td> 

            <tr>
            <th>NAME:</th>
            <td><input type="text" class="form-control" id="nameintern" name="nameintern" required></td>
            </tr>

            <tr>
              <th>NAME EXTENSION:</th>
              <td><input type="text" class="form-control" id="ext" name="ext"></td>
            </tr>

            <tr>
            <th>DATE OF BIRTH:</th>
            <td><input type="date" class="form-control" id="dob" name="dob"></td>
            </tr>

            <tr>
            <th>SCHOOL:</th>
            <td><input type="text" class="form-control" id="school" name="school"></td>
            </tr>

            <tr>
            <th>DEPARTMENT:</th>
            <td><input type="text" class="form-control" id="dept" name="dept"></td>
            </tr>

            <tr>
            <th>BLOOD TYPE:</th>
            <td><input type="text" class="form-control" id="btype" name="btype"></td>
            </tr>

            <tr>
              <td colspan="3" class="fw-bold fs-5 text-center text-uppercase">Incase of Emergency</td>
            </tr>

            <tr>
              <th>NAME:</th>
              <td><input type="text" class="form-control" id="nameguard" name="nameguard"></td>
            </tr>

            <tr>
            <th>RELATIONSHIP:</th>
              <td>  <select class="form-select" id="inputGroupSelect04" id="rel" name="rel"aria-label="Example select with button addon" required>
              <option value="MOTHER">MOTHER</option>
              <option value="FATHER">FATHER</option>
              <option value="GUARDIAN">GUARDIAN</option>
            </select></td>
            </tr>
            <tr>
              <th>ADDRESS:</th>
              <td><input type="text" class="form-control" id="address" name="address"></td>
            </tr>
            <tr>
              <th>CONTACT NUMBER:</th>
              <td><input type="text" class="form-control" id="contactnum" name="contactnum"></td>
            </tr>
            <tr>
              <th>REMARKS:</th>
              <td>  <textarea class="form-control" id="remarks" name="remarks" cols="30" rows="10" style="height: 70px"></textarea></td>
            </tr>
            <tr>
              <th>FILES</th>
                  <td><input type="file" class="form-control" id="file" name="file"></td>
            </tr>
            
        </tbody>
        
      </table>
      
      <div class="d-flex justify-content-end me-2">
            <button type="submit" class="btn btn-outline-primary" id="submit" name="submit"><i class="fi fi-rr-disk"></i> | SAVE</button>
      </form></div>
            
            </div>
          

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

      
    

    
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</html>