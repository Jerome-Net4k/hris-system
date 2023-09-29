<?php
if(isset($_POST['datetoday'])){
    $loadsearch = $_POST['datetoday'];
    loadsearch($loadsearch);
}

// search the year

function loadsearch($loadsearch){
    include "connection.php";
   
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $sql = "SELECT * FROM tbl_logs where lastdate_in = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s',$loadsearch);
    $stmt->execute();
    $result = $stmt->get_result();
    $todayojt = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $todayojt++;
            echo '<tr>
                <td>' . $row['nameintern'] . '</td>
                <td>' . $row['Timein'] . '</td>
                <td>' . $row['timeout'] . '</td>
                <td>' . $row['timerender'] . '</td>
            </tr>';      
        }
        echo '<tr d-flex>
        <td d-flex>Total OJT today: <b style="font-size: 25px;">'. $todayojt .'<b/></td></tr>';
    }else{
        echo 'No data found';
    }
    $con->close();
}
?>
<script>
    $(document).ready(function(){
        function loadtotal(){

        }
    });
</script>
