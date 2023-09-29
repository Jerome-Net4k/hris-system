<?php
if(isset($_POST['uploadedgsis'])){
    $uploadeyear = $_POST['uploadeyear'];
    $uploadedgsis = $_POST['uploadedgsis'];
    $uploadesurname = $_POST['uploadesurname'];

    $fileuploaded = $uploadedgsis . " " . $uploadesurname . ".pdf";
    
    $titletabname = "NOSI " . $uploadeyear . " - " . $uploadesurname;

    $pdspath = "pmupload/" . $uploadeyear . "/PDS/" . $fileuploaded;
    $ipcrpath = "pmupload/" . $uploadeyear . "/IPCR/" . $fileuploaded;
    $nosipath = "pmupload/" . $uploadeyear . "/NOSI/" . $fileuploaded;
    $nosapath = "pmupload/" . $uploadeyear . "/NOSA/" . $fileuploaded;
    $salnpath = "pmupload/" . $uploadeyear . "/SALN/" . $fileuploaded;
    $coepath = "pmupload/" . $uploadeyear . "/COE/" . $fileuploaded;

    if(file_exists($pdspath)) {
        echo '<tr>
            <td>PDS PATH</td>
            <td><a href="'.$pdspath.'" target="_blank" onclick="changeTabTitle(this, \''.$titletabname.'\')">'.$uploadeyear.' PDS</a></td>
            </tr>';
    } else {
        echo '<tr>
            <td>PDS PATH</td>
            <td>No file found</td><tr>';
    }

    if(file_exists($ipcrpath)) {
        echo '<tr>
            <td>IPCR PATH</td>
            <td><a href="'.$ipcrpath.'" target="_blank" onclick="changeTabTitle(this, \''.$titletabname.'\')">'.$uploadeyear.' IPCR</a></td>
            </tr>';
    } else {
        echo '<tr>
            <td>IPCR PATH</td>
            <td>No file found</td><tr>';
    }

    if(file_exists($nosipath)) {
        echo '<tr>
            <td>NOSI PATH</td>
            <td><a href="'.$nosipath.'" target="_blank" onclick="changeTabTitle(this, \''.$titletabname.'\')">'.$uploadeyear.' NOSI</a></td>
            </tr>';
    } else {
        echo '<tr>
            <td>NOSI PATH</td>
            <td>No file found</td><tr>';
    }
    
    if(file_exists($nosapath)) {
        echo '<tr>
            <td>NOSA PATH</td>
            <td><a href="'.$nosapath.'" target="_blank" onclick="changeTabTitle(this, \''.$titletabname.'\')">'.$uploadeyear.' NOSA</a></td>
            </tr>';
    } else {
        echo '<tr>
            <td>NOSA PATH</td>
            <td>No file found</td><tr>';
    }

    if(file_exists($salnpath)) {
        echo '<tr>
            <td>SALN PATH</td>
            <td><a href="'.$salnpath.'" target="_blank" onclick="changeTabTitle(this, \''.$titletabname.'\')">'.$uploadeyear.' SALN</a></td>
            </tr>';
    } else {
        echo '<tr>
            <td>SALN PATH</td>
            <td>No file found</td><tr>';
    }
    
    if(file_exists($coepath)) {
        echo '<tr>
            <td>COE PATH</td>
            <td><a href="'.$coepath.'" target="_blank" onclick="changeTabTitle(this, \''.$titletabname.'\')">'.$uploadeyear.' COE</a></td>
            </tr>';
    } else {
        echo '<tr>
            <td>COE PATH</td>
            <td>No file found</td><tr>';
    }
}
?>
<script>
    function changeTabTitle(link, customTitle) {
        var newTab = window.open(link.href, '_blank');
        setTimeout(function() {
            newTab.document.title = customTitle;
        }, 100);
        return false;
    }
</script>
