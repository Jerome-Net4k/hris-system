<?php
include "connection.php";
if (isset($_POST['month'])) {
    $month = $_POST['month'];
    $yearload = $_POST['yearload'];

    for ($i = 1; $i <= 31; $i++) {
        // Query to fetch attendance data for the specific day
        $sql = "SELECT * FROM attendance_date WHERE dmonth = '$month' AND dday = '$i' AND dyear = '$yearload' GROUP BY dmonth, dday, dyear";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Generate HTML for each dateinfo element with a unique ID
                echo '<div class="col" style="border: 1px solid #e9ecef;" data-bs-toggle="modal" data-bs-target="#editdate">
                        <div  style="cursor: pointer;" class="in-out" id="dateinfo-' . $row['dday'] . '" data-value="' . $row['dday'] . '">' . $row['dmonth'] . ' ' . $row['dday'] . ' <i class="bi bi-pencil-square"></i></div>
                    </div>';
                // Your code logic here
            }
        }
        echo '<script>
            $(document).ready(function(){
                // Bind click event to each dateinfo element using the unique ID
                $(\'#dateinfo-' . $i . '\').on("click", function(){
                    var dateinfo = $(this).attr(\'data-value\');
                    var datemonth = $("#attmonth").val();
                    var dateyear = $("#attyear").val();
                    // alert(dateinfo + datemonth + dateyear);
                    $("#editdateinfomonth").text(datemonth);
                    $("#editdateinfoday").text(dateinfo);
                    $("#editdateinfoyear").text(dateyear);
                    
                    $("#deletedateinfo").text(datemonth + " " + dateinfo + " " + dateyear);
                    $("#editdateheader").text(datemonth + " " + dateinfo + " " + dateyear);
                    $("#monthupdate").text(datemonth);
                    $("#yearupdate").text(dateyear);
                });
            });
        </script>';
    }
}
// $con->close();
?>
