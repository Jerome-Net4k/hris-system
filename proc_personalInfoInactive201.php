<?php
include 'table_personalInfoTable.php';
$personalInfo = new personalInfo();
if(!isset($_POST['searchBar']) && !isset($_GET['id']) && !isset($_POST['regionFil']) && !isset($_POST['viewVacant'])){
    loadPersonalInfo($personalInfo);
}
if(isset($_POST['searchBar']) || isset($_POST['regionFil']) || isset($_POST['regionFil'])){
    searchPersonalInfo($personalInfo);
}
if(isset($_POST['viewVacant'])){ 
    loadPersonalInfoVacant($personalInfo);
}

function loadPersonalInfo($personalInfo){
    $result = $personalInfo->get_inactiveTblank();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['modeofinput'] == 'transfer'){
                $editable = 'hidden';
            } else {
                $editable = '';
            }
            $withRemarks = "none";
            if($row['remarks'] != ''){
                $withRemarks = "inline";
            }
            echo '<tr id="inactiveRow' . $row['rowno'] . '">
            <td><button class="btn btn-outline-warning p-1" id="remarksBtn' . $row['rowno'] . '" style="display: ' . $withRemarks . ';"><i class="fa fa-sticky-note-o" aria-hidden="true" style="font-size: 25px;"></i></button></td>
            <td>'.$row['idno'].'</td>
            <td>'.$row['surname'].'</td>
            <td>'.$row['firstname'].'</td>
            <td>'.$row['middlename'].'</td>
            <td>'.$row['ext'].'</td>
            <td>'.$row['region'].'</td>
            <td>' . 
            '<form method="post" id="viewFormInactive' . $row['rowno'] . '" action="views_201FilesActive.php">' .
            '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            '<input type="hidden" name="folderName" value="' . $row['rowno'] . ' ' . $row['surname'] . '">' .
            '</form>' . 
            '<button class="btn btn-outline-secondary p-1" type="submit" form="viewFormInactive' . $row['rowno'] . '" value="Submit"><i class="fa fa-folder-open-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>' .
            // '<td>' .
            // '<form method="post" id="uploadFile' . $row['rowno'] . '"enctype="multipart/form-data" action="fileUpload.php" onsubmit="return confirm(\'Are you sure you want to upload this file??\');">' .
            // '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            // '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            // '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            // '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            // // '<input type="hidden" name="folderName" value="' . $row['idno'] . ' ' . $row['surname'] . '">' .
            // '<input type ="file" name="inactiveDocs" accept=".pdf" required>
            // <button type="submit" form="uploadFile' . $row['rowno'] . '" value="Submit">Upload</button>
            // </form>' .
            // '</td>' .
            '<td>' .
            '<form method="post" id="editForm' . $row['rowno'] . '" action="personalInfoInactiveEdit.php">' .
            '<input type="hidden" name="remarks" value="' . $row['remarks'] .'">' .
            '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="oldidNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="oldsname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="fname" value="' . $row['firstname'] . '">' .
            '<input type="hidden" name="mname" value="' . $row['middlename'] . '">' .
            '<input type="hidden" name="ext" value="' . $row['ext'] . '">' .
            '<input type="hidden" name="region" value="' . $row['region'] . '">' .
            '<input type="hidden" name="folderName" value="' . $row['idno'] . ' ' . $row['surname'] . '">' .
            '</form>' . 
            '<button class="btn btn-outline-success p-1" type="submit" form="editForm' . $row['rowno'] . '" value="Submit"><i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>' .
            // '<td>' .
            // '<form method="post" id="deleteForm' . $row['rowno'] . '" action="uploadPDInactive.php" onsubmit="return confirm(\'['. $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] .'] is selected. \n this action CANNOT be RECOVERED upon DELETION!! \n CONFIRM??\');">' .
            // '<input type="hidden" name="delRow" value= true>' .
            // '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            // '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            // '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            // '<button type="submit" form="deleteForm' . $row['rowno'] . '" value="Submit" '. $editable .'>DELETE</button>' .
            // '</td>' .
            '<td>' .
            '<button class="btn btn-outline-danger p-1" id="deleteBtn' . $row['rowno'] . '" style="font-weight: 700;" '. $editable .'><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 25px;"></i>
            </button>' .
            '</td>' .
            '</tr>';

            echo '<script>' . 

            '$("#deleteBtn' . $row['rowno'] . '").on("click",function (e){
                iziToast.error({
                    timeout: 15000,
                    close: false,
                    overlay: true,
                    displayMode: \'once\',
                    id: \'question\',
                    zindex: 999,
                    title: \'' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '\',
                    message: \'Confirm Delete??\',
                    position: \'center\',
                    buttons: [
                        [\'<button><b>YES</b></button>\', function (instance, toast) {
                 
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');                                    

                            $.ajax({
                                data: {
                                    delRow: true,
                                    rowno: \''. $row['rowno'] .'\',
                                    sname: \''. $row['surname'] .'\'
            
                                },
                                    type: "POST",
                                    url: "uploadPDInactive.php",
                                    success: function(data){
                                      if (data == "success"){
                                        iziToast.error({
                                            position: "center",
                                            title: "Record Deleted!",
                                            messageSize: "30",
                                            titleSize: "25",
                                            message: ""
                                        });
                                        document.getElementById("inactiveRow' . $row['rowno'] . '").style.display = "none";                                        
                                        // window.location.href="views_201Files.php";
                                      } else {

                                      }
                                    }
                                  })

                            
                 
                        }, true],
                        [\'<button>NO</button>\', function (instance, toast) {
                 
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');
                 
                        }],
                    ]
                });
              })
        
              $("#remarksBtn' . $row['rowno'] . '").on("click",function (e){
                iziToast.info({
                    title: \'' . $row['idno'] .' Remarks: \',
                    titleSize: \'20\',
                    message: \'' . $row['remarks'] . '\',
                    messageSize: \'25\',
                    position: \'center\'
                });
              })
        
              </script>
              <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
        }   
    }
    else{
        // echo '<tr><td colspan="5" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
    $result = $personalInfo->get_inactiveTbl();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['modeofinput'] == 'transfer'){
                $editable = 'hidden';
            } else {
                $editable = '';
            }
            $withRemarks = "none";
            if($row['remarks'] != ''){
                $withRemarks = "inline";
            }

            if($row['filecheck'] == '0'){
                $fileCheck = "beige";
            } else {
                $fileCheck = "white";
            }

            echo '<tr id="inactiveRow' . $row['rowno'] . '" style="background-color: ' . $fileCheck .';">
            <td><button class="btn btn-outline-warning p-1" id="remarksBtn' . $row['rowno'] . '" style="display: ' . $withRemarks . ';"><i class="fa fa-sticky-note-o" aria-hidden="true" style="font-size: 25px;"></i></button></td>
            <td>'.$row['idno'].'</td>
            <td>'.$row['surname'].'</td>
            <td>'.$row['firstname'].'</td>
            <td>'.$row['middlename'].'</td>
            <td>'.$row['ext'].'</td>
            <td>'.$row['region'].'</td>
            <td>' . 
            '<form method="post" id="viewFormInactive' . $row['rowno'] . '" action="views_201FilesActive.php">' .
            '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            '<input type="hidden" name="folderName" value="' . $row['rowno'] . ' ' . $row['surname'] . '">' .
            '</form>' . 
            '<button class="btn btn-outline-secondary p-1" type="submit" form="viewFormInactive' . $row['rowno'] . '" value="Submit"><i class="fa fa-folder-open-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            // '<button id="viewBtn' . $row['rowno'] . '" class="btn btn-outline-secondary p-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"><i class="fa fa-folder-open-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>' .            
            // '<td>' .
            // '<form method="post" id="uploadFile' . $row['rowno'] . '"enctype="multipart/form-data" action="fileUpload.php" onsubmit="return confirm(\'Are you sure you want to upload this file??\');">' .
            // '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            // '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            // '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            // '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            // // '<input type="hidden" name="folderName" value="' . $row['idno'] . ' ' . $row['surname'] . '">' .
            // '<input type ="file" name="inactiveDocs" accept=".pdf" required>
            // <button type="submit" form="uploadFile' . $row['rowno'] . '" value="Submit">Upload</button>
            // </form>' .
            // '</td>' .
            '<td>' .
            '<form method="post" id="editForm' . $row['rowno'] . '" action="personalInfoInactiveEdit.php">' .
            '<input type="hidden" name="remarks" value="' . $row['remarks'] .'">' .
            '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="oldidNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="oldsname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="fname" value="' . $row['firstname'] . '">' .
            '<input type="hidden" name="mname" value="' . $row['middlename'] . '">' .
            '<input type="hidden" name="ext" value="' . $row['ext'] . '">' .
            '<input type="hidden" name="region" value="' . $row['region'] . '">' .
            '<input type="hidden" name="folderName" value="' . $row['idno'] . ' ' . $row['surname'] . '">' .
            '</form>' . 
            '<button class="btn btn-outline-success p-1" type="submit" form="editForm' . $row['rowno'] . '" value="Submit"><i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>' .
            // '<td>' .
            // '<form method="post" id="deleteForm' . $row['rowno'] . '" action="uploadPDInactive.php" onsubmit="return confirm(\'['. $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] .'] is selected. \n this action CANNOT be RECOVERED upon DELETION!! \n CONFIRM??\');">' .
            // '<input type="hidden" name="delRow" value= true>' .
            // '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            // '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            // '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            // '<button type="submit" form="deleteForm' . $row['rowno'] . '" value="Submit" '. $editable .'>DELETE</button>' .
            // '</td>' .
            '<td>' .
            '<button class="btn btn-outline-danger p-1" id="deleteBtn' . $row['rowno'] . '" style="font-weight: 700;" '. $editable .'><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>' .
            '</tr>';

            echo '<script>

            $("#deleteBtn' . $row['rowno'] . '").on("click",function (e){
                iziToast.error({
                    timeout: 15000,
                    close: false,
                    overlay: true,
                    displayMode: \'once\',
                    id: \'question\',
                    zindex: 999,
                    title: \'' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '\',
                    message: \'Confirm Delete??\',
                    position: \'center\',
                    buttons: [
                        [\'<button><b>YES</b></button>\', function (instance, toast) {
                 
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');                                    

                            $.ajax({
                                data: {
                                    delRow: true,
                                    rowno: \''. $row['rowno'] .'\',
                                    sname: \''. $row['surname'] .'\'
            
                                },
                                    type: "POST",
                                    url: "uploadPDInactive.php",
                                    success: function(data){
                                      if (data == "success"){
                                        iziToast.error({
                                            position: "center",
                                            title: "Record Deleted!",
                                            messageSize: "30",
                                            titleSize: "25",
                                            message: ""
                                        });
                                        document.getElementById("inactiveRow' . $row['rowno'] . '").style.display = "none";                                        
                                        // window.location.href="views_201Files.php";
                                      } else {

                                      }
                                    }
                                  })

                            
                 
                        }, true],
                        [\'<button>NO</button>\', function (instance, toast) {
                 
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');
                 
                        }],
                    ]
                });
              })
        
              $("#viewBtn' . $row['rowno'] . '").on("click",function (e){
                document.getElementById("inactiveRow' . $row['rowno'] . '").style.backgroundColor=\'white\';
                document.getElementById("staticBackdropLabel1").innerHTML = "' . $row['idno'] . ' - ' . $row['surname'] . '";
              })

              $("#remarksBtn' . $row['rowno'] . '").on("click",function (e){
                iziToast.info({
                    title: \'' . $row['idno'] .' Remarks: \',
                    titleSize: \'20\',
                    message: \'' . $row['remarks'] . '\',
                    messageSize: \'25\',
                    position: \'center\'
                });
              })
        
              </script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
        }   
    }
    else{
        echo '<tr><td colspan="5" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}

function loadPersonalInfoVacant($personalInfo){
    $result = $personalInfo->get_inactiveTblank();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['modeofinput'] == 'transfer'){
                $editable = 'hidden';
            } else {
                $editable = '';
            }
            $withRemarks = "none";
            if($row['remarks'] != ''){
                $withRemarks = "inline";
            }
            echo '<tr id="inactiveRow' . $row['rowno'] . '">
            <td><button class="btn btn-outline-warning p-1" id="remarksBtn' . $row['rowno'] . '" style="display: ' . $withRemarks . ';"><i class="fa fa-sticky-note-o" aria-hidden="true" style="font-size: 25px;"></i></button></td>
            <td>'.$row['idno'].'</td>
            <td>'.$row['surname'].'</td>
            <td>'.$row['firstname'].'</td>
            <td>'.$row['middlename'].'</td>
            <td>'.$row['ext'].'</td>
            <td>'.$row['region'].'</td>
            <td>' . 
            '<form method="post" id="viewFormInactive' . $row['rowno'] . '" action="views_201FilesActive.php">' .
            '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            '<input type="hidden" name="folderName" value="' . $row['rowno'] . ' ' . $row['surname'] . '">' .
            '</form>' . 
            '<button class="btn btn-outline-secondary p-1" type="submit" form="viewFormInactive' . $row['rowno'] . '" value="Submit"><i class="fa fa-folder-open-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>' .
            // '<td>' .
            // '<form method="post" id="uploadFile' . $row['rowno'] . '"enctype="multipart/form-data" action="fileUpload.php" onsubmit="return confirm(\'Are you sure you want to upload this file??\');">' .
            // '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            // '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            // '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            // '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            // // '<input type="hidden" name="folderName" value="' . $row['idno'] . ' ' . $row['surname'] . '">' .
            // '<input type ="file" name="inactiveDocs" accept=".pdf" required>
            // <button type="submit" form="uploadFile' . $row['rowno'] . '" value="Submit">Upload</button>
            // </form>' .
            // '</td>' .
            '<td>' .
            '<form method="post" id="editForm' . $row['rowno'] . '" action="personalInfoInactiveEdit.php">' .
            '<input type="hidden" name="remarks" value="' . $row['remarks'] .'">' .
            '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="oldidNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="oldsname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="fname" value="' . $row['firstname'] . '">' .
            '<input type="hidden" name="mname" value="' . $row['middlename'] . '">' .
            '<input type="hidden" name="ext" value="' . $row['ext'] . '">' .
            '<input type="hidden" name="region" value="' . $row['region'] . '">' .
            '<input type="hidden" name="folderName" value="' . $row['idno'] . ' ' . $row['surname'] . '">' .
            '</form>' . 
            '<button class="btn btn-outline-success p-1" type="submit" form="editForm' . $row['rowno'] . '" value="Submit"><i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>' .
            // '<td>' .
            // '<form method="post" id="deleteForm' . $row['rowno'] . '" action="uploadPDInactive.php" onsubmit="return confirm(\'['. $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] .'] is selected. \n this action CANNOT be RECOVERED upon DELETION!! \n CONFIRM??\');">' .
            // '<input type="hidden" name="delRow" value= true>' .
            // '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            // '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            // '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            // '<button type="submit" form="deleteForm' . $row['rowno'] . '" value="Submit" '. $editable .'>DELETE</button>' .
            // '</td>' .
            '<td>' .
            '<button class="btn btn-outline-danger p-1" id="deleteBtn' . $row['rowno'] . '" style="font-weight: 700;" '. $editable .'><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>' .
            '</tr>';

            echo '<script>

            $("#deleteBtn' . $row['rowno'] . '").on("click",function (e){
                iziToast.error({
                    timeout: 15000,
                    close: false,
                    overlay: true,
                    displayMode: \'once\',
                    id: \'question\',
                    zindex: 999,
                    title: \'' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '\',
                    message: \'Confirm Delete??\',
                    position: \'center\',
                    buttons: [
                        [\'<button><b>YES</b></button>\', function (instance, toast) {
                 
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');                                    

                            $.ajax({
                                data: {
                                    delRow: true,
                                    rowno: \''. $row['rowno'] .'\',
                                    sname: \''. $row['surname'] .'\'
            
                                },
                                    type: "POST",
                                    url: "uploadPDInactive.php",
                                    success: function(data){
                                      if (data == "success"){
                                        iziToast.error({
                                            position: "center",
                                            title: "Record Deleted!",
                                            messageSize: "30",
                                            titleSize: "25",
                                            message: ""
                                        });
                                        document.getElementById("inactiveRow' . $row['rowno'] . '").style.display = "none";                                        
                                        // window.location.href="views_201Files.php";
                                      } else {

                                      }
                                    }
                                  })

                            
                 
                        }, true],
                        [\'<button>NO</button>\', function (instance, toast) {
                 
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');
                 
                        }],
                    ]
                });
              })
        
              $("#viewFiles").on("click",function (e){

              })

              $("#remarksBtn' . $row['rowno'] . '").on("click",function (e){
                iziToast.info({
                    title: \'' . $row['idno'] .' Remarks: \',
                    titleSize: \'20\',
                    message: \'' . $row['remarks'] . '\',
                    messageSize: \'25\',
                    position: \'center\'
                });
              })
        
              </script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
        }   
    }
    else{
        echo '<tr><td colspan="5" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}

function searchPersonalInfo($personalInfo){
    $name = $_POST['searchBar']."%";
    $fil = $_POST['fil'];
    $regionFil = $_POST['regionFil'];
    $result = $personalInfo->get_wldcrdInactiveTblTest($fil,$regionFil,$name);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['modeofinput'] == 'transfer'){
                $editable = 'hidden';
            } else {
                $editable = '';
            }
            $withRemarks = "none";
            if($row['remarks'] != ''){
                $withRemarks = "inline";
            }
            echo '<tr id="inactiveRow' . $row['rowno'] . '">
            <td><button class="btn btn-outline-warning p-1" id="remarksBtn' . $row['rowno'] . '" style="display: ' . $withRemarks . ';"><i class="fa fa-sticky-note-o" aria-hidden="true" style="font-size: 25px;"></i></button></td>
            <td>'.$row['idno'].'</td>
            <td>'.$row['surname'].'</td>
            <td>'.$row['firstname'].'</td>
            <td>'.$row['middlename'].'</td>
            <td>'.$row['ext'].'</td>
            <td>'.$row['region'].'</td>
            <td>' . 
            '<form method="post" id="viewFormInactive' . $row['rowno'] . '" action="views_201FilesActive.php">' .
            '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            '<input type="hidden" name="folderName" value="' . $row['rowno'] . ' ' . $row['surname'] . '">' .
            '</form>' . 
            '<button class="btn btn-outline-secondary p-1" type="submit" form="viewFormInactive' . $row['rowno'] . '" value="Submit"><i class="fa fa-folder-open-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>' .
            // '<td>' .
            // '<form method="post" id="uploadFile' . $row['rowno'] . '"enctype="multipart/form-data" action="fileUpload.php" onsubmit="return confirm(\'Are you sure you want to upload this file??\');">' .
            // '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            // '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            // '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            // '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            // // '<input type="hidden" name="folderName" value="' . $row['idno'] . ' ' . $row['surname'] . '">' .
            // '<input type ="file" name="inactiveDocs" accept=".pdf" required>
            // <button type="submit" form="uploadFile' . $row['rowno'] . '" value="Submit">Upload</button>
            // </form>' .
            // '</td>' .
            '<td>' .
            '<form method="post" id="editForm' . $row['rowno'] . '" action="personalInfoInactiveEdit.php">' .
            '<input type="hidden" name="remarks" value="' . $row['remarks'] .'">' .
            '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="oldidNo" value="' . $row['idno'] .'">' .
            '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="oldsname" value="' . $row['surname'] . '">' .
            '<input type="hidden" name="fname" value="' . $row['firstname'] . '">' .
            '<input type="hidden" name="mname" value="' . $row['middlename'] . '">' .
            '<input type="hidden" name="ext" value="' . $row['ext'] . '">' .
            '<input type="hidden" name="region" value="' . $row['region'] . '">' .
            '<input type="hidden" name="folderName" value="' . $row['idno'] . ' ' . $row['surname'] . '">' .
            '</form>' . 
            '<button class="btn btn-outline-success p-1" type="submit" form="editForm' . $row['rowno'] . '" value="Submit"><i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</td>
            // <td>' .
            // '<form method="post" id="deleteForm' . $row['rowno'] . '" action="uploadPDInactive.php" onsubmit="return confirm(\'['. $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] .'] is selected. \n this action CANNOT be RECOVERED upon DELETION!! \n CONFIRM??\');">' .
            // '<input type="hidden" name="delRow" value= true>' .
            // '<input type="hidden" name="rowno" value="' . $row['rowno'] .'">' .
            // '<input type="hidden" name="empName" value="' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '">' .
            // '<input type="hidden" name="sname" value="' . $row['surname'] . '">' .
            // '<button type="submit" form="deleteForm' . $row['rowno'] . '" value="Submit" '. $editable .'>DELETE</button>' .
            // '</td>' .
            '<button class="btn btn-outline-danger p-1" id="deleteBtn' . $row['rowno'] . '" style="font-weight: 700;" '. $editable .'><i class="fa fa-trash-o" aria-hidden="true" style="font-size: 25px;"></i></button>' .
            '</tr>';

            echo '<script>

            $("#deleteBtn' . $row['rowno'] . '").on("click",function (e){
                iziToast.error({
                    timeout: 15000,
                    close: false,
                    overlay: true,
                    displayMode: \'once\',
                    id: \'question\',
                    zindex: 999,
                    title: \'' . $row['surname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['ext'] . '\',
                    message: \'Confirm Delete??\',
                    position: \'center\',
                    buttons: [
                        [\'<button><b>YES</b></button>\', function (instance, toast) {
                 
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');                                    

                            $.ajax({
                                data: {
                                    delRow: true,
                                    rowno: \''. $row['rowno'] .'\',
                                    sname: \''. $row['surname'] .'\'
            
                                },
                                    type: "POST",
                                    url: "uploadPDInactive.php",
                                    success: function(data){
                                      if (data == "success"){
                                        iziToast.error({
                                            position: "center",
                                            title: "Record Deleted!",
                                            messageSize: "30",
                                            titleSize: "25",
                                            message: ""
                                        });
                                        document.getElementById("inactiveRow' . $row['rowno'] . '").style.display = "none";                                        
                                        // window.location.href="views_201Files.php";
                                      } else {

                                      }
                                    }
                                  })

                            
                 
                        }, true],
                        [\'<button>NO</button>\', function (instance, toast) {
                 
                            instance.hide({ transitionOut: \'fadeOut\' }, toast, \'button\');
                 
                        }],
                    ]
                });
              })
        
              $("#viewFiles").on("click",function (e){

              })
        
              $("#remarksBtn' . $row['rowno'] . '").on("click",function (e){
                iziToast.info({
                    title: \'' . $row['idno'] .' Remarks: \',
                    titleSize: \'20\',
                    message: \'' . $row['remarks'] . '\',
                    messageSize: \'25\',
                    position: \'center\'
                });
              })

              </script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
        }   
    }
    else{
        echo '<tr><td colspan="5" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}

?>