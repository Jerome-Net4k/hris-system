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
        loadServiceRecord($serviceRec);
    }else if($proc == 'getrnrrecfile'){
        rnrfile($Rnrrec);
    }else if($proc == 'benefits'){
        loyaleligible($serviceRec);
    }
}

function loyaleligible($serviceRec) {
    $result = $serviceRec->load_allRecforloyalty();
    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            // Convert the oldestServeRecFrom date to a DateTime object
            $date = new DateTime($row['oldestServeRecFrom']);
            // Get the current date as a DateTime object
            $currentDate = new DateTime();
            // Calculate the difference between the two dates
            $diff = $currentDate->diff($date);
            // Get the number of years between the two dates
            $years = $diff->y;
            // Format the oldestServeRecFrom date to display the day, month, and year
            $formattedDate = $date->format('F j, Y');
            if ($years == 40 || $years == 35 || $years == 30 || $years == 25 || $years == 20 || $years == 15 || $years == 10) {
                $rows[] = '<tr>
                    <td>'.$row['name'].'</td>
                    <td>'.$formattedDate.'</td>
                    <td class="text-center">'.$years.' years</td>
                </tr>';
            }
        }
        // Sort the rows alphabetically by name
        sort($rows);

        if (count($rows) > 0) {
            foreach ($rows as $row) {
                echo $row;
            }
        } else {
            echo '<tr class="no-records">
                <td colspan="3" class="text-center"><h1>No Records Found</h1></td>
            </tr>';
        }
    } else {
        echo '<tr class="no-records">
            <td colspan="3" class="text-center"><h1>No Records Found</h1></td>
        </tr>';
    }
}

function loadServiceRecord($serviceRec) {
    $result = $serviceRec->load_allRecforloyalty();
    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            // Convert the oldestServeRecFrom date to a DateTime object
            $date = new DateTime($row['oldestServeRecFrom']);
            // Get the current date as a DateTime object
            $currentDate = new DateTime();
            // Calculate the difference between the two dates
            $diff = $currentDate->diff($date);
            // Get the number of years between the two dates
            $years = $diff->y;
            // Format the oldestServeRecFrom date to display the day, month, and year
            $formattedDate = $date->format('F j, Y');
            if ($years == 30 || $years == 35 || $years == 40) {
                $class = 'class="gold"';
                $color = 'gold';
            } elseif ($years == 20 || $years == 25) {
                $class = 'class="silver"';
                $color = 'silver';
            } elseif ($years == 10 || $years == 15) {
                $class = 'class="bronze"';
                $color = 'bronze';
            } else {
                $class = '';
                $color = '';
            }
            
            $rows[] = '<tr '.$class.' data-color="'.$color.'">
                <td>'.$row['name'].'</td>
                <td>'.$formattedDate.'</td>
                <td class="text-center">'.$years.' years</td>
            </tr>';
        }
        // Sort the rows alphabetically by name
        sort($rows);
        
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                echo $row;
            }
        } else {
            echo '<tr class="no-records">
                <td colspan="3" class="text-center"><h1>No Records Found</h1></td>
            </tr>';
        }
    } else {
        echo '<tr class="no-records">
            <td colspan="3" class="text-center"><h1>No Records Found</h1></td>
        </tr>';
    }
}

function rnrfile($Rnrrec) {
    $result = $Rnrrec->get_rnrrefrec();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            // generate the HTML for the table row, including the image tag
            $id = 'panelsStayOpen-' . $row['id']; // Unique ID for each accordion item
            echo '<div class="accordion-item">
                <h2 class="accordion-header" id="'.$id.'-heading">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#'.$id.'-collapse" aria-expanded="false" aria-controls="'.$id.'-collapse">
                    <strong>'.$row['name'].'</strong>
                  </button>
                </h2>
                <div id="'.$id.'-collapse" class="accordion-collapse collapse" aria-labelledby="'.$id.'-heading" data-bs-parent="#accordion">
                  <div class="accordion-body">
                    <iframe src="'.$row['file'].'" width="100%" height="600px"></iframe>
                  </div>
                </div>
              </div>';
        }
    } else {
        echo '<tr>
                    <td colspan="7" class="text-center"><h5 class="fw-bold">No Record Found</h1></td>
                </tr>';
    }
}



?>