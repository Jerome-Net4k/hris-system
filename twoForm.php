<!DOCTYPE html>
<html>
<head>
  <style>
    
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>

    
    $(document).ready(function() {
      $(".show-modal").on("click", function() {
        $(".modal").show();
      });
      
      $(".hide-modal").on("click", function() {
        $(".modal").hide();
      });

      $(".toggle-form1").on("click", function() {
        $(".form1").toggle();
      });

      $(".toggle-form2").on("click", function() {
        $(".form2").toggle();
      });
    });
  </script>
</head>
<body>
  <button class="show-modal">Show Modal</button>

  <div class="modal">
    <div class="modal-content">
      <h2>Modal Title</h2>
      <form class="form1">
        <h3>Form 1</h3>
        <!-- Form 1 fields here -->
      </form>
      <button class="toggle-form1">Toggle Form 1</button>
      <form class="form2 hide">
        <h3>Form 2</h3>
        <!-- Form 2 fields here -->
      </form>
      <button class="toggle-form2">Toggle Form 2</button>
      <button class="hide-modal">Close Modal</button>
    </div>
  </div>
</body>
</html>