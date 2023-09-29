<?php
 	include("connection.php");
	// echo "update successfully";
	// UPDATE THE SIDEBAR FORM
// 	if(!empty($_POST)) 
// 	 {
		// if (isset($_POST['upid'])){
			// echo "update successfully";
			
			// $image_tmp = $_FILES["newimg"]["tmp_name"];

			// if image is not empty display this
			// if (!empty($_FILES['newimg']['tmp_name'])) {
			// 	// $image_tmp = $_FILES['newimg']['tmp_name'];
			// 	// perform update operation
			// 	echo "update successfully";
			// } else {
			// }
			$personnel_id = $_POST['upid'];
			$personnel_name = $_POST['upname'];
			$personnel_sg = $_POST['upsg'];
			$personnel_position = $_POST['upposition'];
			$personnel_under = $_POST['upunderpos'];
			$personnel_upother_call = $_POST['upother-call'];
			$personnel_upsubline = $_POST['upsubline'];

			$upimage = $personnel_name . '.png'; // Change the extension to PNG
			$upimage_tmp = $_FILES["newimg"]["tmp_name"];
			move_uploaded_file($upimage_tmp, "images/" . $upimage);

			$sql = "UPDATE orgchart SET name=?, sg=?, position=?, under=?, head_office=?, image=?, subline=? WHERE id=?";
			
			$stmt = mysqli_prepare($con, $sql);
			mysqli_stmt_bind_param($stmt, 'sssssssi', $personnel_name, $personnel_sg, $personnel_position, $personnel_under, $personnel_upother_call, $upimage, $personnel_upsubline, $personnel_id);
			
			if (mysqli_stmt_execute($stmt)) {
				echo "update successfully";
			} else {
				echo "Error updating data: " . mysqli_error($con);
			}
			mysqli_stmt_close($stmt);
			mysqli_close($con);

			// $personnel_id = $_POST['upid'];
			// $personnel_name = $_POST['upname'];
			// $personnel_sg = $_POST['upsg'];
			// $personnel_position = $_POST['upposition'];
			// $personnel_under = $_POST['upunderpos'];
			// $personnel_upother_call = $_POST['upother-call'];

			// $upimage = $personnel_name . '.png'; // Change the extension to PNG
			// $upimage_tmp = $_FILES["newimg"]["tmp_name"];
			// // echo " . $upimage_tmp . ";
			
			  
			// move_uploaded_file($upimage_tmp, "images/" . $upimage);
			
			// $sqll = "UPDATE orgchart SET name = '$personnel_name', sg = '$personnel_sg', position = '$personnel_position', under = '$personnel_under', head_office ='$personnel_upother_call' image = '$upimage' WHERE id='$personnel_id'";
			
			// if (mysqli_query($con, $sqll)) {
			// 	echo "update successfully";
			// }
		// }
?>