<?php
session_start();

if(!empty($_POST['Name']) && !empty($_POST['Address']) && !empty($_POST['Mobileno']) && !empty($_POST['eAddress'])
&& !empty($_POST['NoS']) && !empty($_POST['Gname']) && !empty($_POST['Gmobileno']) ){

    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
    {
        include 'connection.php';
        $query = "INSERT INTO `ojtinfo_table`(`Name`, `Address`, `Mobileno`, `eAddress`, `NoS`, `Gname`, `Gmobileno`) VALUES ('','','','','','','')";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssssssssssssssssssssssssssssssssss", $_SESSION['Name'],$_SESSION['Address'],$_SESSION['Mobileno'],$_SESSION['eAddress'],$_SESSION['NoS'],$_SESSION['Gname'],$_SESSION['Gmobileno']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows < 1){
        $_SESSION['Name'] = $_POST['Name'];
        $_SESSION['Address'] = $_POST['Address'];
        $_SESSION['Mobileno'] = $_POST['Mobileno'];
        $_SESSION['eAddress'] = $_POST['eAddress'];
        $_SESSION['NoS'] = $_POST['NoS'];
        $_SESSION['Gname'] = $_POST['Gname'];
        $_SESSION['Gmobileno'] = $_POST['Gmobileno'];
       
        
        
        echo 'nc';
        }
        else{
            echo 'duplicate';
        }  
    }
    else{
        echo 'email';
}
}
else{
    echo 'sad';
}


?>
