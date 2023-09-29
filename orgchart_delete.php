<?php

    include("connection.php");
    if(isset($_POST['deleid'])){ //put this code if the variable not working 
        $deleid = $_POST['deleid'];
        $typeyes = $_POST['typeyes'];
        if ($typeyes == 'yes' || $typeyes == 'YES')
        {
            $delename = $_POST['delename'];
            $sql = "DELETE FROM orgchart WHERE id = $deleid";
            $result = mysqli_query($con, $sql);
        
            if ($result) {
                echo 'delete successfully';

                
                // Delete the file in folder
                $folderpath = 'images/' . $delename;
                if (file_exists($folderpath)) {
                    if (unlink($folderpath)) {
                    }
                }
            }
        }else{
            echo 'type yes';
        }
        
    }

?>