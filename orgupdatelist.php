<?php 
include "connection.php";
    $alert= "";
        if(isset($_POST['but_update'])){
            if(isset($_POST['update'])){
                foreach($_POST['update'] as $updateid){
 
                    $name = $_POST['name_'.$updateid];
                    $sg = $_POST['sg_'.$updateid];
                    $position = $_POST['position_'.$updateid];
                    $under = $_POST['under_'.$updateid];
                    $image = $_POST['image_'.$updateid];
 
                    if($name !='' && $position != '' ){
                        $updateUser = "UPDATE orgchart SET 
                            name='".$name."',position='".$position."'
                        WHERE id=".$updateid;
                        mysqli_query($con,$updateUser);
                    }
                     
                }
                $alert = '<div class="alert alert-success alert-dismissible">
						    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
						    <strong>Success!</strong> This alert box could indicate a successful or positive action.
						  </div>';
            }
        }
 ?>