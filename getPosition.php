<?php

if(isset($_POST['val'])){
    include 'connection.php';
    $pos = $_POST['val'];
    $query = "SELECT * FROM `psipop_table` WHERE `division` = ? AND `name` = '' ORDER BY `salary_grade` DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$pos);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        echo '<option>Position List</option>';
        while($row = $result->fetch_assoc()){
            echo '<option value="'.$row['id'].'">'.$row['pos_title'].'</option>';
        }
        echo '<option value="other">OTHERS</option>';
        
    }
    else{
        echo '<option disabled>No Data Found</option>';
    }
    
    
    echo $convReturn;
}

?>