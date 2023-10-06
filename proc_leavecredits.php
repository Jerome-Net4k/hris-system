<?php
include 'table_serviceRecTable.php';
include 'table_personalInfoTable.php';
include 'table_rnr.php';

$personalInfo = new personalInfo();
$serviceRec = new serviceRec();
$Rnrrec = new Rnrrec();

if(isset($_GET['proc'])){
    $proc = $_GET['proc'];
    if($proc == 'load'){
        loadlistofservicerec($serviceRec);
    }else if($proc == 'upload'){
        uploadrnrrec($serviceRec,$Rnrrec);
    }
    else if($proc == 'record'){
        leaverecord($Rnrrec,$serviceRec);
    }else if($proc == 'getLeaveData'){
        $id = $_GET['id'];
        echo getLeaveData($id,$Rnrrec);
    }

}
/**
 * Retrieves the leave data for a specific ID.
 *
 * @param int $id The ID of the leave data to retrieve.
 * @param datatype $Rnrrec The Rnrrec object used to retrieve the leave data.
 * @throws Some_Exception_Class If there is an error retrieving the leave data.
 * @return string The leave data encoded in JSON format.
 */
function getLeaveData($id,$Rnrrec){
    $result = $Rnrrec->get_rnrleaveTbl($id);
    $row = $result->fetch_assoc();
    return json_encode($row);
}


/**
 * Generates the function comment for the given function body.
 *
 * @param object $Rnrrec The Rnrrec object.
 * @throws None
 * @return None
 */
function leaverecord($Rnrrec){
    $id = $_GET['id'];  
    $result =  $Rnrrec->get_rnrrecordTbl($id);
    if($result->num_rows > 0){
        $currentMonth = '';
        $monthRecords = array();
        while($row = $result->fetch_assoc()){
            $leavedate_from = date('F', strtotime($row['leavemonth'])); // Get month name from date
            if($leavedate_from != $currentMonth) { // Check if the month has changed
                // Display the records of the previous month
                if(!empty($monthRecords)){
                    displayRecords($monthRecords);
                }
                // Start a new group for the current month
                $currentMonth = $leavedate_from;
                $monthRecords = array();
            }
            // Add the record to the current month's group
            $monthRecords[] = $row;
        }
        // Display the records of the last month
        if(!empty($monthRecords)){
            displayRecords($monthRecords);
        }
    }
    else{
        echo'<tr><td class=" text-center fw-bold fs-5"colspan="10">NO DATA FOUND PLEASE ADD RECORD</td></tr>';
    }
}
//for displaying Month records to leavemanage.php credits
function displayRecords($monthRecords){
    echo '<tr>
        <td class="fw-bold">MONTH OF '.date('F', strtotime($monthRecords[0]['leavemonth'])).'</td>
        <td class="text-center">2.50</td>
        <td></td>
        <td class="text-center">+ 1.25</td>
        <td class="text-center">+ 1.25</td>
        <td colspan="5"></td>
        
        
        </tr>';
    foreach($monthRecords as $row){
        echo '<tr>
                <td>'.$row['day'].'-'.$row['hrs'].'-'.$row['min'].'</td>
                <td></td>
                <td class="text-center">'.$row['auwp'].'</td>
                <td class="text-center">'.$row['vl_bal'].'</td>
                <td class="text-center">'.$row['sl_bal'].'</td>
                <td>'.$row['leavetype'].'</td>';
        if($row['leavedate_from'] != '0000-00-00') {
            echo '<td>'.date('F j, Y', strtotime($row['leavedate_from'])).'</td>';
        } else {
            echo '<td></td>';
        } if($row['leavedate_to'] != '0000-00-00') {
            echo '<td>'.date('F j, Y', strtotime($row['leavedate_to'])).'</td>';
        } else {
            echo '<td></td>';
        }
        echo '<td class="text-center">';
        if ($row['auwop'] != '0.000') {
        echo $row['auwop'];
        };
    }
}



    function loadlistofservicerec($serviceRec){
        $result =  $serviceRec->load_allRec();
        if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo ' <tr>
            <td>'.$row['name'].'</td>
            
            <td>'.$row['name'].'</td>
    
            <td>'.$row['designation'].'</td>
                
            <td style="text-align: left;">
                <button class="btn btn-outline-success p-1" id="view" value="'.$row['empNo'].'" ><i class="far fa-eye"></i> |  Records</button>
                <button class="btn btn-outline-secondary p-1" value="'.$row['empNo'].'" id="edit"><i class="far fa-edit"></i> | Manage Leave </button>
            </td>
        </tr>';
        }
    }
    else{
        echo '<tr>
            <td colspan="7" class="text-center"><h1>No Record Found</h1></td>
        </tr>';
    }
    echo '<script>
    $("button#view").on("click",function(){
        var empNo = $(this).val();
        window.location.href="leaverecords.php?id=" + empNo;
    })
    $("button#edit").on("click",function(){
        var empNo = $(this).val();
        window.location.href="leavemanage.php?id=" + empNo;
    })

</script>';
}


/**
 * Uploads the Rnrrec using the provided serviceRec.
 *
 * @param object $serviceRec The serviceRec object.
 * @param object $Rnrrec The Rnrrec object.
 * @throws None
 * @return None
 */
function uploadrnrrec($serviceRec,$Rnrrec){
    $day = $_POST['day'];
    $hrs = $_POST['hrs'];
    $min = $_POST['min'];
    $id = $_POST['id'];
    $leavetype = $_POST['leavetype'];
    $auwp = $_POST['auwp'];
    $auwop = $_POST['auwop'];
    $credits = $_POST['credits'];
    $leavemonth = $_POST['leavemonth'];
    $leavedate_from = $_POST['leavedate_from'];
    $leavedate_to = $_POST['leavedate_to'];
    $vl_bal = $_POST['vl_bal'];
    $sl_bal = $_POST['sl_bal'];
    $Rnrrec->upload_rnrrec($id,$day,$hrs,$min,$leavetype,$auwp,$auwop,$credits,$leavemonth,$leavedate_from,$leavedate_to,$vl_bal,$sl_bal);
    echo 'nice';

}










?>