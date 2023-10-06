
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>New Account</title>
   
    <script>
      $(document).ready(function(){

        $("button#prev").on("click",function(){
                window.location.href = "views_201Files.php"
            })
      })
    </script>
</head>
<body>
<?php 

session_start();

include 'navbar.php'; 

$empName = "";

if(isset($_POST['empNo']) && isset($_POST['empName'])){
    $empNo = $_POST['empNo'];
    $empName = $_POST['empName'];
    $rowno = $_POST['rowno'];
    $sname = $_POST['sname'];
    $folderSelect = 'activeDocs';
    $folderName = $_POST['folderName'];
    $filePath = "docs/Active/" . $folderName . ".pdf";

} else if(isset($_POST['idNo'])){
    $empNo = $_POST['idNo'];
    $empName = $_POST['empName'];
    $rowno = $_POST['rowno'];
    $sname = $_POST['sname'];
    $folderSelect = 'inactiveDocs';
    $folderName = $_POST['folderName'];
    $filePath = "docs/Inactive/" . $folderName . ".pdf";

} else if(isset($_SESSION['empNo'])){
  $empNo = $_SESSION['empNo'];
  $empName = $_SESSION['empName'];
  $filePath = $_SESSION['filePath'];
  $rowno = $_SESSION['rowno'];
  $sname = $_SESSION['sname'];
  $folderSelect = $_SESSION['folderSelect'];
}



?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container bg-white rounded mt-4 mb-4">
    <button class="btn btn-primary m-2 p-1" id="prev"><< Back</button>
    <h1 class="fw-bolder text-center mb-2 pt-2"><?php echo $empNo . ' - ' . $empName ?></h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">201 Documents</div>
<div class="row row-cols-2 ">

<div class = "column">
    <!-- <img src="docs/sampledocs.png"> -->
<div style="margin-bottom: 10px">
    <!-- <input type ="file" name="inactiveDocs" accept=".pdf" required>
    <button type="submit" form="uploadFile" value="Submit">Upload</button> -->

    <?php 
    echo
    '<form method="post" id="uploadFile' . $rowno . '"enctype="multipart/form-data" action="fileUpload.php" onsubmit="return confirm(\'Are you sure you want to upload this file??\');">' .
    '<input type="hidden" name="idNo" value="' . $empNo .'">' .
    '<input type="hidden" name="rowno" value="' . $rowno .'">' .
    '<input type="hidden" name="empName" value="' . $empName . '">' .
    '<input type="hidden" name="sname" value="' . $sname . '">' .
    '<input type ="file" name="' . $folderSelect . '" accept=".pdf" required>
    <button type="submit" form="uploadFile' . $rowno . '" value="Submit">Upload</button>
    </form>';

    ?>
</div>
    <?php 
    
        // $filePath = "docs/" . $folderName . "/*.{[jJ][pP][gG],[pP][nN][gG]}";
        // $filePath = "docs/" . "/*.{[jJ][pP][gG],[pP][nN][gG]}";
        // $filePath = "docs/" . $folderName . "/*.{[pP][dD][fF]}";
        foreach (glob($filePath, GLOB_BRACE) as $filename) {
        // echo '<img src="' . $filename . '">';
        // echo "<iframe src=\"docs/39 Alcabaza/sampledocs.pdf\" width=\"100%\" style=\"height:100vh\"></iframe>";
        echo '<iframe src="' . $filename . '" width="100%" style="height:100vh"></iframe>';
        }
    ?>
</div>

</div>
<div class="d-flex justify-content-end">
          <!-- <button class="btn btn-primary mb-2" id="next">Next</button> -->
        </div>
</div>

<style>
.row {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}

/* Create two equal columns that sits next to each other */
.column {
  flex: 50%;
  padding: 0 4px;
  text-align: center;
}

.column img {
  margin-top: 8px;
  vertical-align: middle;
  width: 90%;
  max-width: 100%;
}

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>