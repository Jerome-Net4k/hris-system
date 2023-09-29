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

<style>
  

  .legend {
  display: flex;
  justify-content: center;
  margin: 10px 0;
}

.gold {
    background-color: gold;
}

.silver {
    background-color: silver;
}

.bronze {
    background-color: #cd7f32;
}
       
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

    <script>
  $(document).ready(function() {

    $.ajax({
        type: "GET",
        url: "proc_loyalty.php?proc=load",
        dataType: "html",
        success: function(response){
            $("#content").html(response);
            // Add a click event listener to the name column header
           
        }
    });

      $('#all').click(function() {
          filterRows('all');
      });
    // Add click event listeners to the filter buttons
    $('#bronze').click(function() {
        filterRows('bronze');
    });

    $('#silver').click(function() {
        filterRows('silver');
    });

    $('#gold').click(function() {
        filterRows('gold');
    });
    


function filterRows(color) {
    $('#content tr').each(function() {
        if ($(this).data('color') === color || color === 'all') {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}
$('form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:"rnrrefupload.php",
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
  

    $.ajax({
          type: "GET",
          url: "proc_loyalty.php?id=&proc=getrnrrecfile",
          success: function(data){
           $("#reffile").html(data);
          }
        })

        var rows = [];
        var ascending = true;

  
  // Handle click on name header
  $('#name-header').click(function() {
    // Sort rows alphabetically by name
    rows.sort(function(a, b) {
      var nameA = $(a).find('td:first').text().toUpperCase();
      var nameB = $(b).find('td:first').text().toUpperCase();
      if (nameA < nameB) {
        return ascending ? -1 : 1;
      }
      if (nameA > nameB) {
        return ascending ? 1 : -1;
      }
      return 0;
    });
    
    // Reverse sorting direction
    ascending = !ascending;
    
    // Rebuild table with sorted rows
    var tableBody = $('#content tbody');
    tableBody.empty();
    $.each(rows, function(index, row) {
      tableBody.append(row);
    });
  });


  $("#preview").on("click", function(){
    window.location.href = "loyalrnrlist.php";
});





      })
  
    </script>
</head>

<body>
      <div class="container bg-light mt-2">
        <div class="d-flex justify-content-start">
        <h1 class="title fw-bold fs-2 pt-3">LOYALTY AWARD</h1>
        </div>

          <div class="row">
          <div class="col-8">
            <div class="">
            <div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" id="bronze" class="btn bronze text-dark">10-15 YEARS</button>
    <button type="button" id="silver" class="btn silver text-dark">20-25 YEARS</button>
    <button type="button" id="gold" class="btn gold text-dark">30-35-40 YEARS</button>
    <button type="button" id="all" class="btn btn-dark">Show All</button>
</div>
            </div>
          </div>
          <div class="col-4">
            <div class="pb-2 d-flex justify-content-end">  
            <a class="btn btn-outline-primary  me-1" data-bs-toggle="modal" href="#exampleModalToggle" role="button"><i class="fi fi-rr-document"></i> | REFERENCE FILES</a>
            <a class="btn btn-outline-primary " id="preview"><i class="fi fi-rr-document"></i> | PREVIEW</a>

          </div>
          </div>  
      </div>
        </div>
        </div>


      <div class="container table-responsive bg-light rounded ">
        <div class="d-flex justify-content-center">
        <table class="table shadow-sm roundTable">
          <thead>
              <tr>
                  <th id="name-header">NAME <i class="btn fi fi-rr-caret-up"></i></th>
                  <th>DATE OF EMPLOYMENT</th>
                  <th class="text-center">NO. OF YEARS IN SERVICE</th>
              </tr>
          </thead>
          <tbody id="content">
              <!-- ajax request -->
          </tbody>
      </table>

            
        </div>
      </div>

      <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel">REFERENCE FILES</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="reffile">
        <div class="accordion" id="accordionExample"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">
          <i class="fi fi-rr-layer-plus"></i> | ADD FILE
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel2">ADD FILE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="post">
        <div class="modal-body">
          <div class="row g-2">
            <div class="col-md">
            <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Name of File</span>
          <input type="text" class="form-control" name="name" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
        </div>
             

            <div class="col-md">
              <div class="form-floating">
                <div class="input-group mb-3">
                  <input type="file" class="form-control" name="file">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</html> 