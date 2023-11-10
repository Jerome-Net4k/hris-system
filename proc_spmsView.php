<?php

if(isset($_POST['viewFirstEdition'])){
    if(file_exists("spms/firstEdition.pdf")){
        echo '<iframe src="spms/firstEdition.pdf" width="100%" style="height:68vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 25%;">File not available.</h1></center></div>';
    }
} else if(isset($_POST['viewEnhancedEdition'])){
    if(file_exists("spms/enhancedEdition.pdf")){
        echo '<iframe src="spms/enhancedEdition.pdf" width="100%" style="height:68vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 25%;">File not available.</h1></center></div>';
    }
    
}

?>