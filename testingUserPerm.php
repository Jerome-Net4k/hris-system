<?php

include 'connection.php';

$query = "SELECT * FROM `user_table`";
$stmt = $con->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()){
    echo '<tr>
    <td>'.$row['user_name'].'</td>';
    echo '
    <td class="text-center"><div class="form-check form-switch form-check-inline">
    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
    <label class="form-check-label" for="flexSwitchCheckDefault">View</label>
    </div>';
    if($row['edit'] == 1){
        echo '<div class="form-check form-switch form-check-inline">
        <input class="form-check-input" type="checkbox" role="switch" id="add" checked>
        <label class="form-check-label" for="add">Edit</label>
        </div>';
    }
    else{
        echo '<div class="form-check form-switch form-check-inline">
        <input class="form-check-input" type="checkbox" role="switch" id="add">
        <label class="form-check-label" for="add">Edit</label>
        </div>';
    }
    echo '</tr>';
}

echo '<script>
$("#add").click(function(){
    var checked;
    if($("#add").is(":checked")){
        checked = 1;
    }
    else{
        checked = 0;
    }
    $.ajax({
        data: {checked: checked},
        type: "POST",
        url: "upUserPerm.php"
    })
})</script>'

?>