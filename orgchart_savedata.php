<?php

// save orgchart here
    include("connection.php");

    if (!$con) {
      die("Connection failed: " . mysqli_connect_error());
    }
    
    // if($_FILES['image']['error'] == UPLOAD_ERR_OK) {
    //    echo "image successfully!";
    //   } else {
    //     echo "Error uploading image: " . $_FILES['image']['error'];
    //   }
    
    // Check if the form was submitted
    // if(isset($_POST["submit"])) {
      // Get the image file
      $name = $_POST["name"];
      $sg = $_POST['sg'];
      $position = $_POST['position'];
      $underorg = $_POST['underorg'];
      $headoffice = $_POST['other-call'];
      $subline = $_POST['subline'];
      
      $image = $_FILES["image"]["name"];
    
      // Generate a unique name for the image
      $image_name = $name . '.png'; // Change the extension to PNG
      
      // Prepare the SELECT statement
      $select_stmt = mysqli_prepare($con, "SELECT * FROM orgchart WHERE name = ? OR position = ?");

      // Bind the parameters to the prepared statement
      mysqli_stmt_bind_param($select_stmt, "ss", $name, $position);

      // Execute the SELECT statement
      mysqli_stmt_execute($select_stmt);

      // Get the result set from the executed SELECT statement
      $result_set = mysqli_stmt_get_result($select_stmt);

      // Check if any duplicate data was found
      if (mysqli_num_rows($result_set) > 0) {
          echo "Duplicate data found";
      } else {
          // Prepare the INSERT statement
          $insert_stmt = mysqli_prepare($con, "INSERT INTO orgchart (name, sg, position, under, head_office, subline, image) VALUES (?, ?, ?, ?, ?, ?, ?)");

          // Bind the parameters to the prepared statement
          mysqli_stmt_bind_param($insert_stmt, "sssssss", $name, $sg, $position, $underorg, $headoffice, $subline, $image_name);

          // Execute the INSERT statement
          if (mysqli_stmt_execute($insert_stmt)) {
              echo "Data added successfully";
    
              // Get the temporary location of the image
              $image_tmp = $_FILES["image"]["tmp_name"];
            
              // Move the image to the folder with the new name and extension
              move_uploaded_file($image_tmp, "images/" . $image_name);
          } else {
              echo "Error uploading image: " . mysqli_error($con);
          }
      }

      // Close the database connection
      mysqli_close($con);
    ?>