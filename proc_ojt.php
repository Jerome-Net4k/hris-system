<?php

include 'table_ojt.php';
$ojtrec = new ojtrec();

if(!isset($_GET['input']) && !isset($_GET['id'])){
    loaddata($ojtrec);
}
if(isset($_GET['id'])){ 
    echo getinternInfo($ojtrec);
}



function getinternInfo($ojtrec){
    $id = $_GET['id'];
    $result = $ojtrec->get_ojtTbl('idnum',$id);
    $row = $result->fetch_assoc();
    return json_encode($row);
}

function loadData($ojtrec) {
  include 'connection.php';
  $input = $_POST['input'];
  $sortby = isset($_POST['sortby']) ? $_POST['sortby'] : 'idnum';
  $sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'ASC';

  $query = "SELECT * FROM ojt_tbl";

  if ($input != "") {
    $query .= " WHERE nameintern LIKE '{$input}%' OR idnum LIKE '{$input}%' OR school LIKE '{$input}%' OR dept LIKE '{$input}%' ";
  }

  // Add the sorting clause to the query
  $query .= " ORDER BY {$sortby} {$sortorder}";

  $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result)>0){
      while($row = mysqli_fetch_Assoc($result)){
        echo '<tr>
        <td>' . $row['idnum'] . '</td>
        <td>' . $row['fname'] . '</td>
        <td>' . $row['mname'] . '</td>
        <td>' . $row['lname'] . '</td>
        <td>' . $row['school'] . '</td>
        <td>' . $row['dept'] . '</td>
        <td class="text-center" style="width:110px;"><button class="btn btn-outline-success btn-sm" id="view" value="' . $row['idnum'] . '" data-toggle="modal" data-target="#modal1"><i class="fi fi-rr-eye p-1"></i> | VIEW</button></td>
        <td class="text-center" style="width:120px;"><button class="btn btn-outline-primary btn-sm" id="update" value="' . $row['idnum'] . '" data-toggle="modal" data-target="#modal2"><i class="fi fi-rr-refresh"></i> | UPDATE</button></td>
        </tr>';
      }
    } else {
      echo '<tr>
        <td colspan="7" class="text-center"><h1>No Record Found</h1></td>
      </tr>';
    } 
    echo '<script>
    $("button#view").on("click", function() {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "proc_ojt.php?id=" + id,
            success: function(data) {
                var conv = jQuery.parseJSON(data);
                $("#viewidnum").text(conv.idnum);
                $("#viewnameintern").text(conv.nameintern);
                $("#viewinternpic").attr("src", "internpic/" + conv.internpic);
                $("#viewext").text(conv.ext);
                $("#viewdob").text(conv.dob);
                $("#viewschool").text(conv.school);
                $("#viewdept").text(conv.dept);
                $("#viewbtype").text(conv.btype);
                $("#viewnameguard").text(conv.nameguard);
                $("#viewrel").text(conv.rel);
                $("#viewaddress").text(conv.address);
                $("#viewcontactnum").text(conv.contactnum);
                $("#viewremarks").text(conv.remarks);
                $("#viewfile").html("<a href=\'ojtfiles/" + conv.file + "\' target=\'_blank\' class=\'btn btn-outline-primary\'><i class=\'fi fi-rr-poll-h\'></i> | VIEW DOCUMENT</a>");                                  }
        });
    });
    $("button#update").on("click", function() {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "proc_ojt.php?id=" + id,
            success: function(data) {
                var conv = jQuery.parseJSON(data);
                $("#idnum").val(conv.idnum);
                $("#nameintern").val(conv.nameintern);
                $("#internpic").attr(conv.internpic);
                $("#ext").val(conv.ext);
                $("#dob").val(conv.dob);
                $("#school").val(conv.school);
                $("#dept").val(conv.dept);
                $("#btype").val(conv.btype);
                $("#nameguard").val(conv.nameguard);
                $("#rel").val(conv.rel);
                $("#address").val(conv.address);
                $("#contactnum").val(conv.contactnum);
                $("#file").html("<a href=\'ojtfiles/" + conv.file + "\' target=\'_blank\' class=\'text-dark\'>View Document</a>");                                  }
        });
    });
</script>
';
}

