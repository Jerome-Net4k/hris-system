<?php

include 'table_psipopTable.php';
$psipop = new psipop();
if(isset($_POST['proc'])){
    $proc= $_POST['proc'];
    $div = $_POST['div'];
    $year = $_POST['year'];
    $psipop->set_division($div);
    $psipop->set_year($year);

    if($proc == 'load'){
        getAll($psipop);
    }
    else if($proc == 'grandTotal'){
        getGrandTotal($psipop);
    }
    else if($proc == 'filledTotal'){
        getFilledTotal($psipop);
    }
    else if($proc == 'unfilledTotal'){
        getUnFilledTotal($psipop);
    }
}

if(isset($_POST['action'])){
    $id = $_POST['id'];
    echo getData($psipop,$id);
}

function getData($psipop,$id){
    $result = $psipop->get_data($id);
    $row = $result->fetch_assoc();
    return json_encode($row);
}

function getAll($psipop){
    $result = $psipop->get_all();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo '<tr class="data"> 
            <td class="text-start textdata data">'.$row['item_num'].'</td>
            <td class="text-start textdata data">'.$row['pos_title']." - ".$row['salary_grade'].'</td>
            <td class="text-start textdata data">'.number_format($row['authorize']).'</td>
            <td class="text-start textdata data">'.number_format($row['actual']).'</td>
            <td class="text-start textdata data">'.$row['step'].'</td>
            <td class="text-start textdata data">'.$row['code'].'</td>
            <td class="text-start textdata data">'.$row['type'].'</td>
            <td class="text-start textdata data">'.$row['level'].'</td>
            <td class="text-start textdata data">'.$row['attr'].'</td>
            <td class="text-start textdata data">'.$row['name'].'</td>
            <td class="text-start textdata data">'.substr($row['sex'],0,1).'</td>
            <td class="text-start textdata data">'.substr($row['dob'],5,2)."/".substr($row['dob'],strlen($row['dob'])-2,2).'/'.substr($row['dob'],2,2).'</td>
            <td class="text-start textdata data">'.$row['tin'].'</td>
            <td class="text-center textdata data">'.substr($row['dooa'],5,2)."/".substr($row['dooa'],-2)."/".substr($row['dooa'],2,2).'</td>
            <td class="text-center textdata data">'.substr($row['dolp'],5,2)."/".substr($row['dolp'],-2)."/".substr($row['dolp'],2,2).'</td>
            <td class="text-center textdata data">'.$row['status'].'</td>
            <td class="text-center textdata data">'.$row['cse'].'</td>
    </tr>';
        }
    }
    else{
        echo '<tr class="data">
            <td class="text-start textdata data text-center" colspan = "17"><h1>No Record Found</h1></td>
        </tr>';
    }
  
}

function getGrandTotal($psipop){
    $result = $psipop->get_grandTotal();
    $row = $result->fetch_assoc();
    $pos = $row['totalPos'];
    $totAuth = number_format($row['totalAuth']);
    $totAct = number_format($row['totalAct']);
    $gTotal = array("position"=>$pos, "auth"=>$totAuth, "act"=>$totAct);
    echo json_encode($gTotal);
}

function getFilledTotal($psipop){
    $result = $psipop->get_filledTotal();
    $row = $result->fetch_assoc();
    $pos = $row['totalPos'];
    $totAuth = number_format($row['totalAuth']);
    $totAct = number_format($row['totalAct']);
    $gTotal = array("position"=>$pos, "auth"=>$totAuth, "act"=>$totAct);
    echo json_encode($gTotal);  
}

function getUnFilledTotal($psipop){
    $result = $psipop->get_unfilledTotal();
    $row = $result->fetch_assoc();
    $pos = $row['totalPos'];
    $totAuth = number_format($row['totalAuth']);
    $totAct = number_format($row['totalAct']);
    $gTotal = array("position"=>$pos, "auth"=>$totAuth, "act"=>$totAct);
    echo json_encode($gTotal);  
}

?>