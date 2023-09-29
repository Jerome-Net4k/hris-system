<?php

if(isset($_POST['action'])){
    if($_POST['action'] == 'upload'){
        session_start();
        include 'connection.php';
        $file = $_FILES['file'];
        for($a = 0; $a < count($file['name']);$a++){
            $fileName = $file['name'][$a];
            $fileTemp = $file['tmp_name'][$a];
            $fileError = $file['error'][$a];
            if($fileError === 0){
                $select = "SELECT * FROM `archive_table` WHERE `filename` = ?";
                $slq = $con->prepare($select);
                $slq->bind_param('s',$fileName);
                $slq->execute();
                $slqRes = $slq->get_result();
                if($slqRes->num_rows > 0){
                    echo 'Duplicate';
                }
                else{
                    $dest = 'uploads/archive/'.$fileName;
                    move_uploaded_file($fileTemp,$dest);
                    $query = "INSERT INTO `archive_table`(`filename`, `uploadedBy`,`date`, `time`) VALUES (?,?,?,?)";
                    $stmt = $con->prepare($query);
                    date_default_timezone_set('Singapore');
                    $dateTime = date('Y/m/d H:i:s');
                    $date = $_POST['date'];
                    $stmt->bind_param('ssss',$fileName,$_SESSION['uname'],$date,$dateTime);
                    $stmt->execute();
                }         
            }   
        }
    }

    if($_POST['action'] == 'search'){
        include 'connection.php';
        $sbar = '%'.$_POST['sbar'].'%';
        $query = "SELECT * FROM `archive_table` WHERE `filename` LIKE ? ORDER BY `filename` ASC";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$sbar);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '<tr>
                <td class="text-center">'.$row['id'].'</td>
                <td id="clickme"><i class="fa-regular fa-file fs-5"></i><a href="uploads/archive/'.$row['filename'].'" target="_blank" class="fs-5"> '.$row['filename'].'</a></td>
                <td>'.$row['date'].'</td>
                <td class="text-center"><button class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i> | Delete</button></td>
                </tr>';
            }
        }
        else{
            echo '<tr><td class="text-center" colspan="4"><h1>No Data Found</h1></td></tr>';
        }
    }
}

if(isset($_GET['action'])){
        include 'connection.php';
        $query = "SELECT * FROM `archive_table` ORDER BY `filename` ASC";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '<tr>
                <td class="text-center">'.$row['id'].'</td>
                <td id="clickme"><i class="fa-regular fa-file fs-5"></i><a href="uploads/archive/'.$row['filename'].'" target="_blank" class="fs-5"> '.$row['filename'].'</a></td>
                <td class="text-center">'.substr($row['date'],5,2).'/'.substr($row['date'],strlen($row['date'])-2).'/'.substr($row['date'],0,4).'</td>
                <td class="text-center">
                <button class="btn btn-outline-primary" value="'.$row['filename'].'" id="update" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-regular fa-pen-to-square"></i> | Update</button>
                <button class="btn btn-outline-danger" value="'.$row['filename'].'" id="delete"><i class="fa-solid fa-trash"></i> | Delete</button></td>
                </tr>';
            }
        }
        else{
            echo '<tr><td class="text-center" colspan="4"><h1>No Data Found</h1></td></tr>';
        }

        echo '<script>
        
        $("button#update").on("click",function(){
            $("form").hide();
            $("#upload").hide();
            $("#upDate").show();
            $("#labelDate").show();
            $("#confirm").show();
            var updateId = $(this).val();
            $("#confirm").val(updateId);
            $.ajax({
                data: {updateId:updateId},
                type: "POST",
                url: "proc_archive.php",
                success: function(data){
                    var conv = jQuery.parseJSON(data);
                    $("#upDate").val(conv.date)
                }

            })
        })
        
        $("button#delete").on("click",function(){
            var id = $(this).val();    
            
            iziToast.error({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: "once",
                id: "question",
                zindex: 999,
                title: "Hey",
                message: "Are you sure about that?",
                position: "center",
                buttons: [
                    ["<button><b>YES</b></button>", function (instance, toast) {
                        $.ajax({
                            data: {id: id},
                            type: "POST",
                            url: "proc_archive.php",
                            success: function(){
                                window.location.href="views_archive.php";
                            }
                        })
             
                        instance.hide({ transitionOut: "fadeOut" }, toast, "button");
             
                    }, true],
                    ["<button>NO</button>", function (instance, toast) {
             
                        instance.hide({ transitionOut: "fadeOut" }, toast, "button");
             
                    }],
                ],
                onClosing: function(instance, toast, closedBy){
                    console.info("Closing | closedBy: " + closedBy);
                },
                onClosed: function(instance, toast, closedBy){
                    console.info("Closed | closedBy: " + closedBy);
                }
            });
        })
        </script>';
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
    include 'connection.php';
    $query = "DELETE FROM `archive_table` WHERE `filename` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$id);
    $stmt->execute();
}

if(isset($_POST['updateId'])){
    $id = $_POST['updateId'];
    include 'connection.php';
    $query = "SELECT * FROM `archive_table` WHERE `filename` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo json_encode($row);
}

if(isset($_POST['upID'])){
    include 'connection.php';
    $id = $_POST['upID'];
    $newDate = $_POST['newDate'];
    $query = "UPDATE `archive_table` SET `date`= ? WHERE `filename` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ss',$newDate,$id);
    $stmt->execute();
}


/*$dir = "uploads/archive/";

if(isset($_GET['text'])){
  $text = $_GET['text'];
  $dir = "uploads/".$text;

}

$files = scandir($dir);

if(count($files) > 0){
  $a = 2;
  while($a < count($files)){
    echo '<tr>';
    if(pathinfo($files[$a], PATHINFO_EXTENSION)){
      echo '<td id="clickme"><i class="fa-solid fa-file pe-1"></i><a href="'.$dir.'/'.$files[$a].'" target="_blank">'.$files[$a].'</a></td>';
      echo '<td class="text-center"><button class="btn btn-outline-danger" value="'.$files[$a].'" id="delete"><i class="fa-solid fa-trash"></i> | Delete</button></td>';
      if($a+2 <= count($files)){
        echo '<td id="clickme"><i class="fa-solid fa-file pe-1"></i><a href="'.$dir.'/'.$files[$a + 1].'" target="_blank">'.$files[$a].'</a></td>';
        echo '<td class="text-center"><button class="btn btn-outline-danger" value="'.$files[$a + 1].'" id="delete"><i class="fa-solid fa-trash"></i> | Delete</button></td>';
      }
      //echo '<td id="clickme"><i class="fa-regular fa-folder pe-1"></i>'.$files[$b].'</td>';
      //echo '<td class="text-center"><button class="btn btn-outline-danger" value="'.$files[$b].'" id="delete"><i class="fa-solid fa-trash"></i> Delete</button></td>';
      
       //echo '<a href="uploads/'.$files[$a].'"><i class="fa-regular fa-folder"></i>'.$files[$a].'</a><br>';
     }
    echo '</tr>'; 
    if($a+2 < count($files)){
      $a+=2;
    }
    else{
      $a+=1;
    }
  }
}
else{
  echo '<tr><td><h1>No File Found</h1></td></tr>';
}*/
?>
