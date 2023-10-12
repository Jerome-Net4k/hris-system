<?php

$connect = mysqli_connect("localhost", "root", "", "hr_management");

$name = mysqli_real_escape_string($connect, $_POST['name']);
$subdate = mysqli_real_escape_string($connect, $_POST['subdate']);

$moafile = $_FILES['moafile']['name'];
$temp = $_FILES['moafile']['tmp_name'];
$error = $_FILES['moafile']['error'];

if ($error == UPLOAD_ERR_OK) {
    $target = "moafiles/" . basename($moafile);
    if (move_uploaded_file($temp, $target)) {
        $query ="INSERT INTO moa_tbl (name, moafile, subdate) 
                VALUES ('$name', '$moafile', '$subdate')";
    
        if (mysqli_query($connect, $query)) {
            echo "success";
        } else {
            echo "failed";
        }
    } else {
        echo "Error: Failed to upload file.";
    }
} else {
    echo "Error: File upload error.";
}

?>