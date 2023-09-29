<?php
    include "connection.php";
// for search box hrer
if(isset($_POST['searchinput'])){
    $loadsearch = $_POST['searchinput'];
    loadall($loadsearch);
}

// for the status search
if(isset($_POST['statusojtstatus'])){
    $loadsearchstatus = $_POST['statusojtstatus'];
    if ($loadsearchstatus == "DISPLAY ALL"){
        loadallrecord($loadsearchstatus);
    } else {
        statussearch($loadsearchstatus);
    }   
}

function loadall($loadsearch) {
    include "connection.php";
    // SEARCH THE RECORD NA GUSTONG SEARCH SA TEXTBOX
    $searchstatus = $_POST['searchstatus'];
    if ($loadsearch!==""){
        // display the search item
        $stmt = $con->prepare("SELECT * FROM ojt_tbl WHERE CONCAT(idnum, nameintern) LIKE CONCAT('%', ?, '%')");
        $nameintern = "%" . $loadsearch . "%"; // add wildcard characters
        $stmt->bind_param("s", $nameintern);
        $stmt->execute();
        $result = $stmt->get_result();
        looprecord($result);
    }elseif ($searchstatus!==""){
        $loadsearchstatus = $searchstatus;
        statussearch($loadsearchstatus);
    }
    else{
        echo "no record";
    }
}

    function statussearch($loadsearchstatus) {
        // SEARCH ALL RECORD NA SELECT SA STATUS
        include "connection.php";
        if ($loadsearchstatus!==""){
            // display all the record
            $sql = "SELECT * FROM ojt_concern WHERE status = ? ORDER BY datesent DESC";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $loadsearchstatus);
            $stmt->execute();
            $result = $stmt->get_result();
            looprecord($result);
        }else{
            echo 'NO RECORD';
        }
    }

    function loadallrecord($loadsearchstatus) {
        // DISPLAY ALL THE RECORD IN THE TABLES
            include "connection.php";
            // display all the record
            $sql = "SELECT * FROM ojt_concern ORDER BY datesent DESC";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            looprecord($result);
    }

    function looprecord($result){
        // loop the record in the tbody record
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $status = $row['status'];
                if ($status == "PENDING") {
                    echo '<tr class="text-bg-light">';
                } else if ($status == "DONE") {
                    echo '<tr style="background: #40E0D0;">';
                } else {
                    echo '<tr>';
                }

                echo '<td>' . $row['idnum'] . '</td>';
                echo '<td>' . $row['nameintern'] . '</td>';
                echo '<td>' . $row['timesent'] . '</td>';
                echo '<td>' . $row['datesent'] . '</td>';
                echo '<td>' . $row['type'] . '</td>';
                echo '<td style="width: 250px; max-width: 250px; white-space: normal; word-wrap: break-word;">' . $row['message'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '<td class="submitconcern"><button value="' . $row['idnum'] . '" class="btn btn-success">READ</button></td>';
            }
        }else{
            echo '<tr><td colspan="22" class="text-center"><h1>No Data Found</h1></td></tr>';
        }
       
    }

?>
<script>
    
</script>