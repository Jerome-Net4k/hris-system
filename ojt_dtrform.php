<?php
    if(isset($_GET['dtrid'])){
        $ojtid = $_GET['dtrid'];
        $ojtmonth = $_GET['dtrmonth'];
        $ojtyear = $_GET['dtryear'];
    }else{
        $ojtid ="None";
        $ojtmonth = "None";
        $ojtyear = "None";
    }

    include "connection.php";
    $stmt = $con->prepare("SELECT * FROM ojt_tbl WHERE idnum = ?");
    $stmt->bind_param("s", $ojtid);
    $stmt->execute();
    $resultdtr = $stmt->get_result();
    if ($resultdtr->num_rows > 0) {
        while ($rowdtr = $resultdtr->fetch_assoc()) {
            $ojtname = $rowdtr['nameintern'];
            $department = $rowdtr['dept'];
    }
    }else{
        $ojtname = "None";
        $department = "None";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "partials_header2.php"?>
    <title>Daily time record</title>
    <link rel="stylesheet" href="ojt_dtrform.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
</head>
<body style="font-size: 10px">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="text-center d-inline-block">
                <img src="images/logo/logo.png" alt="LTO logo" class="logo" style="width: 75px; height: 75px;"><br>
                <div class="d-flex flex-column">
                    <span><b>REPUBLIC OF THE PHILIPPINES</b></span>
                    <span><b>DEPARTMENT OF TRANSACTION</b></span>
                    <span style="font-family: times new romans; font-size: 13px"><b>LAND TRANSPORTATION OFFICE</b></span>
                    <p style="font-size: 10px">East Avenue, Quezon City<br>
                    E-mail Address: <a href="mailto:ltomailbox@lto.gov.ph">ltomailbox@lto.gov.ph</a>&#9642; <a href="https://portal.lto.gov.ph/" target="_blank">www.lto.gov.ph</a></p>          
                </div>
            </div>
        </div>
        <div class="dtr-body" style="font-size: 12px">
            <p style="font-size: 15px;">Department Assign:  <b><?php echo $department;?></b></p>
            <div class="d-flex">
                <p>Daily Time Record for the month of : </p>
                <p style="font-size: 15px;">&nbsp;<b><?php echo $ojtmonth;?>&nbsp;<?php echo $ojtyear;?></b></p>
            </div>
        </div>

        <div class="row">
            <div class="col" style="margin: 0; padding: 0;">
            <div class="dtr-table">
            <table class="table table-bordered">
            <thead>
                <div class="row">
                <div class="col-sm-6">
                <tr class="text-center">
                    <td style="width: 0px;">Date</td>

                    <td style="margin: 0; padding: 0;"><label class="mb-1 mt-1">Morning</label>
                        <div class="border-right in-out d-flex justify-content-center   ">
                            <div class="col" style="border-top: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
                                 <div class="in-out">In</div>
                            </div>
                            <div class="col" style="border-top: 1px solid #dee2e6;">
                                 <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td style="margin: 0; padding: 0;"><label class="mb-1 mt-1">Afternoon</label>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col" style="border-top: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
                                 <div class="in-out">In</div>
                            </div>
                            <div class="col" style="border-top: 1px solid #dee2e6;">
                                 <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>Total</td>
                </tr>
                </div>
                </div>
            <thead>
            <tbody>
                <?php
                    include "connection.php";
                    for ($i = 1; $i <= 15; $i++) {
                    $stmt = $con->prepare("SELECT * FROM tbl_logs WHERE idnum = ? and  month = ? and  day = ? and  year = ?");
                    $stmt->bind_param("ssss", $ojtid, $ojtmonth, $i, $ojtyear);
                    $stmt->execute();
                    $result2 = $stmt->get_result();
                    if ($result2->num_rows > 0) {
                        while($row2 = $result2->fetch_assoc()) {
                        echo '<tr class="text-center">
                        
                        <td style="width: 0px; padding: 2px 0; margin: 0;">' . $i . '</td>
                        <td>
                            <div class="border-right in-out d-flex justify-content-center">
                                <div class="col">';
                                $dtrtimein =  $row2['Timein'];
                                $timein = new DateTime(); // Assuming `$timein` is a valid DateTime object

                                $timeArrayin = explode(':', $dtrtimein);
                                $timein->setTime(
                                    intval($timeArrayin[0]),
                                    intval($timeArrayin[1]),
                                    intval($timeArrayin[2])
                                );
                                $inhoursFormatted = str_pad($timein->format('H'), 2, "0", STR_PAD_LEFT);
                                $inminutesFormatted = str_pad($timein->format('i'), 2, "0", STR_PAD_LEFT);
                                $insecondsFormatted = str_pad($timein->format('s'), 2, "0", STR_PAD_LEFT);
                                $realtimein = $inhoursFormatted . ":" . $inminutesFormatted;
                                $intimeOfDay = $inhoursFormatted;
                                if ($intimeOfDay == "13") {echo '<div class="in-out">01:' . $inminutesFormatted .'</div>';}
                                else if ($intimeOfDay == "14") {echo '<div class="in-out">02:' . $inminutesFormatted .'</div>';}
                                else if ($intimeOfDay == "15") {echo '<div class="in-out">03:' . $inminutesFormatted .'</div>';}
                                else if ($intimeOfDay == "16") {echo '<div class="in-out">04:' . $inminutesFormatted .'</div>';}
                                else if ($intimeOfDay == "17") {echo '<div class="in-out">05:' . $inminutesFormatted .'</div>';}
                                else if ($intimeOfDay == "18") {echo '<div class="in-out">06:' . $inminutesFormatted .'</div>';}
                                else if ($intimeOfDay == "19") {echo '<div class="in-out">07:' . $inminutesFormatted .'</div>';}
                                else if ($intimeOfDay == "20") {echo '<div class="in-out">08:' . $inminutesFormatted .'</div>';}
                                else {echo '<div class="in-out">' . $realtimein . '</div>';}

                            // echo '<div class="in-out">' . $row2['timeout'] . '</div>';

                            echo '</div>
                                <div class="col">
                                    <div class="in-out">12:00</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="border-right in-out d-flex justify-content-center">
                                <div class="col">
                                    <div class="in-out">01:00</div>
                                </div>
                                <div class="col">';
                                $dtrtimeout =  $row2['timeout'];
                                $timeout = new DateTime(); // Assuming `$timein` is a valid DateTime object

                                $timeArray = explode(':', $dtrtimeout);
                                $timeout->setTime(
                                    intval($timeArray[0]),
                                    intval($timeArray[1]),
                                    intval($timeArray[2])
                                );
                                $outhoursFormatted = str_pad($timeout->format('H'), 2, "0", STR_PAD_LEFT);
                                $outminutesFormatted = str_pad($timeout->format('i'), 2, "0", STR_PAD_LEFT);
                                $outsecondsFormatted = str_pad($timeout->format('s'), 2, "0", STR_PAD_LEFT);
                                $outtimeOfDay = $outhoursFormatted;
                                if ($outtimeOfDay == "13") {echo '<div class="in-out">01:' . $outminutesFormatted .'</div>';}
                                else if ($outtimeOfDay == "14") {echo '<div class="in-out">02:' . $outminutesFormatted .'</div>';}
                                else if ($outtimeOfDay == "15") {echo '<div class="in-out">03:' . $outminutesFormatted .'</div>';}
                                else if ($outtimeOfDay == "16") {echo '<div class="in-out">04:' . $outminutesFormatted .'</div>';}
                                else if ($outtimeOfDay == "17") {echo '<div class="in-out">05:' . $outminutesFormatted .'</div>';}
                                else if ($outtimeOfDay == "18") {echo '<div class="in-out">06:' . $outminutesFormatted .'</div>';}
                                else if ($outtimeOfDay == "19") {echo '<div class="in-out">07:' . $outminutesFormatted .'</div>';}
                                else if ($outtimeOfDay == "20") {echo '<div class="in-out">08:' . $outminutesFormatted .'</div>';}
                                else {echo '<div class="in-out">' . $row2['timeout'] . '</div>';}

                            // echo '<div class="in-out">' . $row2['timeout'] . '</div>';

                            echo '</div>
                            </div>
                        </td>
                        <td>';
                            $dtrtimerender =  $row2['timerender'];
                            $timerender = new DateTime(); // Assuming `$timein` is a valid DateTime object

                            $timeArrayrender = explode(':', $dtrtimerender);
                            $timerender->setTime(
                                intval($timeArrayrender[0]),
                                intval($timeArrayrender[1]),
                                intval($timeArrayrender[2])
                            );
                            $renderhoursFormatted = str_pad($timerender->format('H'), 2, "0", STR_PAD_LEFT);
                            $renderminutesFormatted = str_pad($timerender->format('i'), 2, "0", STR_PAD_LEFT);
                            $rendersecondsFormatted = str_pad($timerender->format('s'), 2, "0", STR_PAD_LEFT);
                            $realtimeout = $renderhoursFormatted . ":" . $renderminutesFormatted;
                            echo $realtimeout;
                        echo '</td>';

                        echo '</tr>';
                        }
                    }else{
                        echo '<tr class="text-center">
                        
                        <td style="width: 0px; padding: 2px 0; margin: 0;">' . $i . '</td>
                        <td>
                            <div class="border-right in-out d-flex justify-content-center">
                                <div class="col">
                                    <div class="in-out">-</div>
                                </div>
                                <div class="col">
                                    <div class="in-out">-</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="border-right in-out d-flex justify-content-center">
                                <div class="col">
                                    <div class="in-out">-</div>
                                </div>
                                <div class="col">
                                    <div class="in-out">-</div>
                                </div>
                            </div>
                        </td>
                        <td>
                        -
                        </td>';

                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
            </table>
        </div>
            </div>

            <div class="col" style="margin: 0; padding: 0;">
            <div class="dtr-table">
            <table class="table table-bordered">
            <thead>
                <div class="row">
                <div class="col-sm-6">
                <tr class="text-center">
                    <td style="width: 0px;">Date</td>

                    <td style="margin: 0; padding: 0;"><label class="mb-1 mt-1">Morning</label>
                        <div class="border-right in-out d-flex justify-content-center   ">
                            <div class="col" style="border-top: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
                                 <div class="in-out">In</div>
                            </div>
                            <div class="col" style="border-top: 1px solid #dee2e6;">
                                 <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td style="margin: 0; padding: 0;"><label class="mb-1 mt-1">Afternoon</label>
                        <div class="border-right in-out d-flex justify-content-center">
                            <div class="col" style="border-top: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
                                 <div class="in-out">In</div>
                            </div>
                            <div class="col" style="border-top: 1px solid #dee2e6;">
                                 <div class="in-out">Out</div>
                            </div>
                        </div>
                    </td>

                    <td>Total</td>
                </tr>
                </div>
                </div>
            <thead>
            <tbody>
                <?php
                    include "connection.php";
                    for ($i = 16; $i <= 31; $i++) {
                    $stmt = $con->prepare("SELECT * FROM tbl_logs WHERE idnum = ? and  month = ? and  day = ? and  year = ?");
                    $stmt->bind_param("ssss", $ojtid, $ojtmonth, $i, $ojtyear);
                    $stmt->execute();
                    $result2 = $stmt->get_result();
                    if ($result2->num_rows > 0) {
                        while($row2 = $result2->fetch_assoc()) {
                        echo '<tr class="text-center">
                        
                        <td style="width: 0px; padding: 2px 0; margin: 0;">' . $i . '</td>
                        <td>
                            <div class="border-right in-out d-flex justify-content-center">
                                <div class="col">';
                                $dtrtimein2 =  $row2['Timein'];
                                $timein2 = new DateTime(); // Assuming `$timein` is a valid DateTime object

                                $timeArrayin2 = explode(':', $dtrtimein2);
                                $timein2->setTime(
                                    intval($timeArrayin2[0]),
                                    intval($timeArrayin2[1]),
                                    intval($timeArrayin2[2])
                                );
                                $inhoursFormatted2 = str_pad($timein2->format('H'), 2, "0", STR_PAD_LEFT);
                                $inminutesFormatted2 = str_pad($timein2->format('i'), 2, "0", STR_PAD_LEFT);
                                $insecondsFormatted2 = str_pad($timein2->format('s'), 2, "0", STR_PAD_LEFT);
                                $realtimeout2 = $inhoursFormatted2 . ":" . $inminutesFormatted2;
                                $intimeOfDay2 = $inhoursFormatted;
                                if ($intimeOfDay2 == "13") {echo '<div class="in-out">01:' . $inminutesFormatted2 .'</div>';}
                                else if ($intimeOfDay2 == "14") {echo '<div class="in-out">02:' . $inminutesFormatted2 .'</div>';}
                                else if ($intimeOfDay2 == "15") {echo '<div class="in-out">03:' . $inminutesFormatted2 .'</div>';}
                                else if ($intimeOfDay2 == "16") {echo '<div class="in-out">04:' . $inminutesFormatted2 .'</div>';}
                                else if ($intimeOfDay2 == "17") {echo '<div class="in-out">05:' . $inminutesFormatted2 .'</div>';}
                                else if ($intimeOfDay2 == "18") {echo '<div class="in-out">06:' . $inminutesFormatted2 .'</div>';}
                                else if ($intimeOfDay2 == "19") {echo '<div class="in-out">07:' . $inminutesFormatted2 .'</div>';}
                                else if ($intimeOfDay2 == "20") {echo '<div class="in-out">08:' . $inminutesFormatted2 .'</div>';}
                                else {echo '<div class="in-out">' . $realtimeout2 . '</div>';}

                            // echo '<div class="in-out">' . $row2['timeout'] . '</div>';

                            echo '</div>
                                <div class="col">
                                    <div class="in-out">12:00</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="border-right in-out d-flex justify-content-center">
                                <div class="col">
                                    <div class="in-out">01:00</div>
                                </div>
                                <div class="col">';
                                    $dtrtimeout2 =  $row2['timeout'];
                                    $timeout2 = new DateTime(); // Assuming `$timein` is a valid DateTime object

                                    $timeArray2 = explode(':', $dtrtimeout2);
                                    $timeout2->setTime(
                                        intval($timeArray2[0]),
                                        intval($timeArray2[1]),
                                        intval($timeArray2[2])
                                    );
                                    $outhoursFormatted2 = str_pad($timeout2->format('H'), 2, "0", STR_PAD_LEFT);
                                    $outminutesFormatted2 = str_pad($timeout2->format('i'), 2, "0", STR_PAD_LEFT);
                                    $outsecondsFormatted2 = str_pad($timeout2->format('s'), 2, "0", STR_PAD_LEFT);
                                    $outtimeOfDay2 = $outhoursFormatted2;
                                    if ($outtimeOfDay2 == "13") {echo '<div class="in-out">01:' . $outminutesFormatted2 .'</div>';}
                                    else if ($outtimeOfDay2 == "14") {echo '<div class="in-out">02:' . $outminutesFormatted2 .'</div>';}
                                    else if ($outtimeOfDay2 == "15") {echo '<div class="in-out">03:' . $outminutesFormatted2 .'</div>';}
                                    else if ($outtimeOfDay2 == "16") {echo '<div class="in-out">04:' . $outminutesFormatted2 .'</div>';}
                                    else if ($outtimeOfDay2 == "17") {echo '<div class="in-out">05:' . $outminutesFormatted2 .'</div>';}
                                    else if ($outtimeOfDay2 == "18") {echo '<div class="in-out">06:' . $outminutesFormatted2 .'</div>';}
                                    else if ($outtimeOfDay2 == "19") {echo '<div class="in-out">07:' . $outminutesFormatted2 .'</div>';}
                                    else if ($outtimeOfDay2 == "20") {echo '<div class="in-out">08:' . $outminutesFormatted2 .'</div>';}
                                    else {echo '<div class="in-out">' . $row2['timeout'] . '</div>';}

                                // echo '<div class="in-out">' . $row2['timeout'] . '</div>';

                            echo '</div>
                            </div>
                        </td>
                        <td>';
                            $dtrtimerender2 =  $row2['timerender'];
                            $timerender2 = new DateTime(); // Assuming `$timein` is a valid DateTime object

                            $timeArrayrender2 = explode(':', $dtrtimerender2);
                            $timerender2->setTime(
                                intval($timeArrayrender2[0]),
                                intval($timeArrayrender2[1]),
                                intval($timeArrayrender2[2])
                            );
                            $renderhoursFormatted = str_pad($timerender2->format('H'), 2, "0", STR_PAD_LEFT);
                            $renderminutesFormatted = str_pad($timerender2->format('i'), 2, "0", STR_PAD_LEFT);
                            $rendersecondsFormatted = str_pad($timerender2->format('s'), 2, "0", STR_PAD_LEFT);
                            $realtimeout2 = $renderhoursFormatted . ":" . $renderminutesFormatted;
                            echo $realtimeout2;
                        echo '</td>';

                        echo '</tr>';
                        }
                    }else{
                        echo '<tr class="text-center">
                        
                        <td style="width: 0px; padding: 2px 0; margin: 0;">' . $i . '</td>
                        <td>
                            <div class="border-right in-out d-flex justify-content-center">
                                <div class="col">
                                    <div class="in-out">-</div>
                                </div>
                                <div class="col">
                                    <div class="in-out">-</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="border-right in-out d-flex justify-content-center">
                                <div class="col">
                                    <div class="in-out">-</div>
                                </div>
                                <div class="col">
                                    <div class="in-out">-</div>
                                </div>
                            </div>
                        </td>
                        <td>
                        -
                        </td>';

                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
            </table>
            <div class="text-end">
                <?php
                // $ojtmonth = $_GET['dtrmonth'];
                // $ojtyear = $_GET['dtryear'];
                $query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(STR_TO_DATE(timerender, '%H:%i:%s')))) AS monthrender FROM tbl_logs WHERE idnum = ? AND month = ? AND year = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sss", $ojtid, $ojtmonth, $ojtyear);
                $stmt->execute();
                $resultrender = $stmt->get_result();

                if ($rowrender = $resultrender->fetch_assoc()) {
                    echo '<p>Total hours: <b style="font-size: 15px">' . $rowrender['monthrender'] . '</b></p>';
                } //rendermonth
                ?>
                
            </div>
        </div>

        </div>
        
        <div class="dtr-signature" style="margin-top: 0px">
                <div class="d-flex justify-content-center text-center">
                    <div class="col">
                        <p><b style="font-size: 15px;"><?php echo $ojtname . '</b> <i style="font-size: 12px;">(' . $ojtid . ')</i>';?><br>On-the-job Traineee</p>
                    </div>
                    <div class="col">
                        <input type="text" class="text-center" id="supname" numfmt_set_attribute="supname" data-bs-toggle="modal" data-bs-target="#inputsupervisor" style="border: none; width: 250px; font-size: 15px; font-weight: 600; cursor: pointer;" placeholder="Authorize HR Supervisor">
                        <p>Authorized Supervisor</p>
                    </div>
                </div>
            </div>
    </div>
    </div>

    <div class="modal fade" id="inputsupervisor" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Assign supervisor</h3>
                    <button class="btn-close" data-bs-toggle="modal" data-bs-target="#inputsupervisor"></button>
                </div>

                    <div class="modal-body">
                        <div class="form-floating mb-2">
                            <input type="text" id="inputsupname" name="inputsupname" class="form-control">
                            <label style="font-size: 15px;" for="">Supervisor name</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary assign-supervisor">ASSIGN</button>
                    </div>
            </div>
        </div>
    </div>

	<script>
        $(document).ready(function(){
            $(".assign-supervisor").click("click",function(){
                var inputsupname = $("#inputsupname").val();
                $("#supname").val(inputsupname);
                $('#inputsupervisor').modal('hide');
            })
        })
    </script>
</body>
</html>