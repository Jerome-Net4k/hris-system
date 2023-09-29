<?php

$connect = mysqli_connect("localhost", "root", "", "hr_management");

$name = mysqli_real_escape_string($connect, $_POST['name']);

$file = $_FILES['file']['name'];
$temp = $_FILES['file']['tmp_name'];
$error = $_FILES['file']['error'];

// Check if file is uploaded successfully
if ($error == UPLOAD_ERR_OK) {
    // Validate file type and size
    $allowed_extensions = array('pdf', 'doc', 'docx');
    $max_size = 5 * 1024 * 1024; // 5MB
    $file_extension = pathinfo($file, PATHINFO_EXTENSION);
    $file_size = $_FILES['file']['size'];
    if (in_array($file_extension, $allowed_extensions) && $file_size <= $max_size) {
        $target = "referencefiles/" . uniqid() . '_' . basename($file);
        if (move_uploaded_file($temp, $target)) {
            $query = "INSERT INTO rnr_reference_files (name, file) 
                      VALUES (?, ?)";
            $stmt = mysqli_prepare($connect, $query);
            mysqli_stmt_bind_param($stmt, 'ss', $name, $target);
            if (mysqli_stmt_execute($stmt)) {
                echo "success";
            } else {
                echo "failed";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Failed to upload file.";
        }
    } else {
        echo "Error: Invalid file type or size.";
    }
} else {
    echo "Error: File upload error.";
}

mysqli_close($connect);

?>
