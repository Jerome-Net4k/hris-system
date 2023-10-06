<?php
include 'table_personalInfoTable.php';
$personalInfo = new personalInfo();
if(!isset($_POST['searchBar']) && !isset($_GET['id'])){
    loadPersonalInfo($personalInfo);
}
if(isset($_POST['searchBar'])){
    searchPersonalInfo($personalInfo);
}
if(isset($_GET['id'])){ 
    echo getPdsInfo($personalInfo);
}




function loadPersonalInfo($personalInfo){

    $result = $personalInfo->get_all();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo '<tr>
            <td>'. $row['empno'] .'</td>
            <td>'.$row['sname'].'</td>
            <td>'.$row['fname'].'</td> 
            <td>'.$row['mname'].'</td>
            <td>ext</td>
            <td>region</td>' . 
            '<td>' .
            '<form method="post" id="viewForm' . $row['empno'] . '" action="views_201FilesActive.php">' .
            '<input type="hidden" name="empNo" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="rowno" value="' . $row['empno'] .'">' .
            '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            '<input type="hidden" name="empName" value="' . $row['sname'] . ', ' . $row['fname'] . ' ' . $row['mname'] . '">' .
            '<input type="hidden" name="folderName" value="' . $row['empno'] . ' ' . $row['sname'] . '">' .
            '</form>' . 
            '<button type="submit" form="viewForm' . $row['empno'] . '" value="Submit">View Files</button>' .
            '</td>' .
            // '<td>' .
            // '<form method="post" id="uploadFileActive' . $row['emp_id'] . '"enctype="multipart/form-data" action="fileUpload.php">' .
            // '<input type="hidden" name="idNo" value="' . $row['emp_id'] .'">' .
            // '<input type="hidden" name="empName" value="' . $row['sname'] . ', ' . $row['fname'] . ' ' . $row['mname'] . ' ' . 'ext' . '">' .
            // '<input type="hidden" name="sname" value="' . $row['sname'] . '">' .
            // '<input type="hidden" name="folderName" value="' . $row['emp_id'] . ' ' . $row['sname'] . '">' .
            // '<input type ="file" name="activeDocs" accept=".pdf">
            // <button type="submit" form="uploadFileActive' . $row['emp_id'] . '" value="Submit">Upload</button>
            // </form>
            // </td> 
            '</tr>';


            echo '<script type = "text/javascript">
            
            $("#uploadFilesInactive' . $row['empno'] . '").on("click",function (e){
                var fileDialog = $(\'<input type="file">\');
                fileDialog.click();
                fileDialog.on("change",onFileSelected);
                return false;
            })
        
            </script>';
        }   
    }
    else{
        echo '<tr><td colspan="5" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}

function getPdsInfo($personalInfo){
    $id = $_GET['id'];
    $result = $personalInfo->get_sglTbl('empNo',$id);
    $row = $result->fetch_assoc();
    return json_encode($row);
}

function searchPersonalInfo($personalInfo){
    $name = $_POST['searchBar']."%";
    $fil = $_POST['fil'];
    $result = $personalInfo->get_wldcrdTbl($fil,$name);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo '<tr>
            <td>'.$row['sname'].'</td>
            <td>'.$row['fname'].'</td> 
            <td>'.$row['mname'].'</td>
            <td>'.$row['ext'].'</td>
            <td class="header"><button class="btn btn-success p-1" id="view"><i class="fi fi-rr-eye p-1"></i>View</button>
            <button class="btn btn-primary p-1"><i class="fi fi-rr-edit p-1"></i>Update</button></td>
            </tr>';
        }
    }
    else{
        echo '<tr><td colspan="5" class="text-center"><h1>No Data Foundtest</h1></td></tr>';
    }

}

?>