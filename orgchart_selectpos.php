<!-- Loop the all data frin the position -->
<?php
	// $sql = "SELECT position FROM orgchart";
	// $result = $con->query($sql);
	// if ($result->num_rows > 0) {
	// 	while($row = $result->fetch_assoc()){
	// echo '
	//  <option>' .$row['position'].'</option>';

	// }	}
?>


<?php
	$sql = "SELECT position FROM orgchart";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()){
		echo '<div class="select-item">' . $row['position'].'</div>';
		}	
	}
?>