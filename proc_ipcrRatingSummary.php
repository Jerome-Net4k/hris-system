<?php
session_start();
include 'table_personalInfoTable.php';
$personalInfo = new personalInfo();
if(!isset($_POST['searchBar']) && !isset($_GET['id'])){
    loadPersonalInfo($personalInfo);
}
if(isset($_POST['searchBar'])){
    searchPersonalInfo($personalInfo);
}





function loadPersonalInfo($personalInfo){
    
    include 'connection.php';

    $yearSelected = $_POST['yearSelected'];

    $ipcrQuery1 = $conn->prepare("SELECT pds.empno, ipcr_output_table.q, ipcr_output_table.e, ipcr_output_table.t, ipcr_output_table.a FROM ipcr_encoding_table AS pds INNER JOIN ipcr_output_table ON pds.empno = ipcr_output_table.emp_id WHERE ipcr_output_table.year = $yearSelected AND ipcr_output_table.half = '1' AND ipcr_output_table.emp_id = ?");
    $ipcrQuery2 = $conn->prepare("SELECT pds.empno, ipcr_output_table.q, ipcr_output_table.e, ipcr_output_table.t, ipcr_output_table.a FROM ipcr_encoding_table AS pds INNER JOIN ipcr_output_table ON pds.empno = ipcr_output_table.emp_id WHERE ipcr_output_table.year = $yearSelected AND ipcr_output_table.half = '2' AND ipcr_output_table.emp_id = ?");
    
    $yearQuery = $conn->prepare("SELECT `year` FROM `performance_rating_year` ORDER BY `year` DESC");
    $yearQuery->execute();
    $yearQueryResult = $yearQuery->fetchAll(PDO::FETCH_ASSOC);

    // $yearSelected = $_POST['yearSelected'];
    // $result = $personalInfo->get_monitoringTbl();
    $result = $personalInfo->get_allIpcr();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){

            $outputCount = 0;

            $totalQ1 = 0;
            $totalE1 = 0;
            $totalT1 = 0;
            $totalA1 = 0;

            $totalQ2 = 0;
            $totalE2 = 0;
            $totalT2 = 0;
            $totalA2 = 0;

            $countQ1 = 0;
            $countE1 = 0;
            $countT1 = 0;
            $countA1 = 0;

            $countQ2 = 0;
            $countE2 = 0;
            $countT2 = 0;
            $countA2 = 0;

            $averageQ1 = 0;
            $averageE1 = 0;
            $averageT1 = 0;
            $averageA1 = 0;

            $averageQ2 = 0;
            $averageE2 = 0;
            $averageT2 = 0;
            $averageA2 = 0;

            $ipcrQuery1->execute(array($row['empno']));
            $ipcrQueryResult1 = $ipcrQuery1->fetchAll(PDO::FETCH_ASSOC);
            foreach ($ipcrQueryResult1 as $count){
                $outputCount += 1;

                if($count['q'] != 0){
                    $countQ1 += 1;
                    $totalQ1 += $count['q'];
                }
                if($count['e'] != 0){
                    $countE1 += 1;
                    $totalE1 += $count['e'];
                }
                if($count['t'] != 0){
                    $countT1 += 1;
                    $totalT1 += $count['t'];
                }
                if($count['a'] != 0){
                    $countA1 += 1;
                    $totalA1 += $count['a'];
                }
              }

            if($countQ1 != 0){
                $averageQ1 = number_format($totalQ1/$countQ1, 2);
            } else {
                $averageQ1 = '-';
            }
            if($countE1 != 0){
                $averageE1 = number_format($totalE1/$countE1, 2);
            } else {
                $averageE1 = '-';
            }
            if($countT1 != 0){
                $averageT1 = number_format($totalT1/$countT1, 2);
            } else {
                $averageT1 = '-';
            }
            if($countA1 != 0){
                $averageA1 = number_format($totalA1/$countA1, 2);
            } else {
                $averageA1 = '-';
            }

            $ipcrQuery2->execute(array($row['empno']));
            $ipcrQueryResult2 = $ipcrQuery2->fetchAll(PDO::FETCH_ASSOC);
            foreach ($ipcrQueryResult2 as $count){
                $outputCount += 1;

                if($count['q'] != 0){
                    $countQ2 += 1;
                    $totalQ2 += $count['q'];
                }
                if($count['e'] != 0){
                    $countE2 += 1;
                    $totalE2 += $count['e'];
                }
                if($count['t'] != 0){
                    $countT2 += 1;
                    $totalT2 += $count['t'];
                }
                if($count['a'] != 0){
                    $countA2 += 1;
                    $totalA2 += $count['a'];
                }
              }

            if($countQ2 != 0){
                $averageQ2 = number_format($totalQ2/$countQ2, 2);
            } else {
                $averageQ2 = '-';
            }
            if($countE2 != 0){
                $averageE2 = number_format($totalE2/$countE2, 2);
            } else {
                $averageE2 = '-';
            }
            if($countT2 != 0){
                $averageT2 = number_format($totalT2/$countT2, 2);
            } else {
                $averageT2 = '-';
            }
            if($countA2 != 0){
                $averageA2 = number_format($totalA2/$countA2, 2);
            } else {
                $averageA2 = '-';
            }

            echo '<tr>
            <td style="vertical-align: middle; width: min-content;">'. $row['empno'] .'</td>
            <td style="vertical-align: middle; width: min-content;">'.$row['sname']. ", " . $row['fname'] . " " . $row['mname'] . " " . $row['ext'] .'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageQ1.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageE1.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageT1.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageA1.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageQ2.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageE2.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageT2.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageA2.'</td>' .
            '</tr>';

            echo '<script>' .
            
        
              '</script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
        }   
    }
    else{
        echo '<tr><td colspan="10" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}


function searchPersonalInfo($personalInfo){
    $name = $_POST['searchBar']."%";
    $fil = $_POST['fil'];
    $regionFil = $_POST['regionFil'];

    include 'connection.php';

    $yearSelected = $_POST['yearSelected'];
 
    $ipcrQuery1 = $conn->prepare("SELECT pds.empno, ipcr_output_table.q, ipcr_output_table.e, ipcr_output_table.t, ipcr_output_table.a FROM ipcr_encoding_table AS pds INNER JOIN ipcr_output_table ON pds.empno = ipcr_output_table.emp_id WHERE ipcr_output_table.year = $yearSelected AND ipcr_output_table.half = '1' AND ipcr_output_table.emp_id = ?");
    $ipcrQuery2 = $conn->prepare("SELECT pds.empno, ipcr_output_table.q, ipcr_output_table.e, ipcr_output_table.t, ipcr_output_table.a FROM ipcr_encoding_table AS pds INNER JOIN ipcr_output_table ON pds.empno = ipcr_output_table.emp_id WHERE ipcr_output_table.year = $yearSelected AND ipcr_output_table.half = '2' AND ipcr_output_table.emp_id = ?");

    $yearQuery = $conn->prepare("SELECT `year` FROM `performance_rating_year` ORDER BY `year` DESC");
    $yearQuery->execute();
    $yearQueryResult = $yearQuery->fetchAll(PDO::FETCH_ASSOC);

    $result = $personalInfo->get_wldcrdMonitoringTbl($fil,$regionFil,$name);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){

            $outputCount = 0;

            $totalQ1 = 0;
            $totalE1 = 0;
            $totalT1 = 0;
            $totalA1 = 0;

            $totalQ2 = 0;
            $totalE2 = 0;
            $totalT2 = 0;
            $totalA2 = 0;

            $countQ1 = 0;
            $countE1 = 0;
            $countT1 = 0;
            $countA1 = 0;

            $countQ2 = 0;
            $countE2 = 0;
            $countT2 = 0;
            $countA2 = 0;

            $averageQ1 = 0;
            $averageE1 = 0;
            $averageT1 = 0;
            $averageA1 = 0;

            $averageQ2 = 0;
            $averageE2 = 0;
            $averageT2 = 0;
            $averageA2 = 0;

            $ipcrQuery1->execute(array($row['empno']));
            $ipcrQueryResult1 = $ipcrQuery1->fetchAll(PDO::FETCH_ASSOC);
            foreach ($ipcrQueryResult1 as $count){
                $outputCount += 1;

                if($count['q'] != 0){
                    $countQ1 += 1;
                    $totalQ1 += $count['q'];
                }
                if($count['e'] != 0){
                    $countE1 += 1;
                    $totalE1 += $count['e'];
                }
                if($count['t'] != 0){
                    $countT1 += 1;
                    $totalT1 += $count['t'];
                }
                if($count['a'] != 0){
                    $countA1 += 1;
                    $totalA1 += $count['a'];
                }
              }

            if($countQ1 != 0){
                $averageQ1 = number_format($totalQ1/$countQ1, 2);
            } else {
                $averageQ1 = '-';
            }
            if($countE1 != 0){
                $averageE1 = number_format($totalE1/$countE1, 2);
            } else {
                $averageE1 = '-';
            }
            if($countT1 != 0){
                $averageT1 = number_format($totalT1/$countT1, 2);
            } else {
                $averageT1 = '-';
            }
            if($countA1 != 0){
                $averageA1 = number_format($totalA1/$countA1, 2);
            } else {
                $averageA1 = '-';
            }

            $ipcrQuery2->execute(array($row['empno']));
            $ipcrQueryResult2 = $ipcrQuery2->fetchAll(PDO::FETCH_ASSOC);
            foreach ($ipcrQueryResult2 as $count){
                $outputCount += 1;

                if($count['q'] != 0){
                    $countQ2 += 1;
                    $totalQ2 += $count['q'];
                }
                if($count['e'] != 0){
                    $countE2 += 1;
                    $totalE2 += $count['e'];
                }
                if($count['t'] != 0){
                    $countT2 += 1;
                    $totalT2 += $count['t'];
                }
                if($count['a'] != 0){
                    $countA2 += 1;
                    $totalA2 += $count['a'];
                }
              }

            if($countQ2 != 0){
                $averageQ2 = number_format($totalQ2/$countQ2, 2);
            } else {
                $averageQ2 = '-';
            }
            if($countE2 != 0){
                $averageE2 = number_format($totalE2/$countE2, 2);
            } else {
                $averageE2 = '-';
            }
            if($countT2 != 0){
                $averageT2 = number_format($totalT2/$countT2, 2);
            } else {
                $averageT2 = '-';
            }
            if($countA2 != 0){
                $averageA2 = number_format($totalA2/$countA2, 2);
            } else {
                $averageA2 = '-';
            }

            echo '<tr>
            <td style="vertical-align: middle; width: min-content;">'. $row['empno'] .'</td>
            <td style="vertical-align: middle; width: min-content;">'.$row['sname']. ", " . $row['fname'] . " " . $row['mname'] . " " . $row['ext'] .'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageQ1.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageE1.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageT1.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageA1.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageQ2.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageE2.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageT2.'</td>' .
            '<td style="vertical-align: middle; text-align: center;">'.$averageA2.'</td>' .
            '</tr>';

            echo '<script>' .
            
        
              '</script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
        }   
    }
    else{
        echo '<tr><td colspan="10" class="text-center"><h1>No Data Found</h1></td></tr>';
    }

}

?>