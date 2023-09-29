<?php //include ("partials_header2.php");?>

<!-- <form id="upmyform" method="POST" enctype="multipart/form-data"> -->

<?php
	include("connection.php");


// LOAD THE SIDEBAR 
	if(isset($_POST['sidecontent'])){
		$sidecontent=$_POST['sidecontent'];
		// $sidecontent="aasdf";
		
		$sql = "SELECT * FROM orgchart WHERE position='$sidecontent'";
		$result = $con->query($sql);
		if ($result->num_rows > 0) {

// load the search of in the combo box
		while($row = $result->fetch_assoc()) {
			$delid= $row['id'];
			$name= $row['name'];
		?>
		<!-- <form action="orgchart_search_update.php" method="POST" enctype="multipart/form-data"> -->
		
			<div id="<?php echo $row['id'];?>">
				<input type="hidden" value="<?php echo $row['id'];?>" id="upid" name="upid">

				<div class="col">
					<img src="images/<?php  echo $row['image'];?>" alt="personnel image" style="width: 100px; height: 80px;"> <!-- display image -->
					<!-- <p>Update image? <input type="checkbox" id="check-to-update" class="form-check-input"></p> -->
				</div>
				<div class="col">
					<div class="form-floating mb-2" id="image-to-update">
						<input type="file" id="newimg" name="newimg" class="form-control required">
						<label for="sname">Personnel image</label>
					
					</div>
				</div>

				<!-- <input type="text" id="fiximg" name="fiximg" value="<?php  //echo $row['image'];?>"> -->

				<div class="col">
					<div class="form-floating mb-2">
						<input type="text" value="<?php  echo $row['name'];?>" id="upname" name="upname" class="form-control required" required>
						<label for="sname">Name on the position</label>
					</div>
				</div>

				<div class="col">
					<div class="form-floating mb-2">
						<input type="text" id="upsg" name="upsg" value="<?php  echo $row['sg'];?>" class="form-control required" required>
						<label for="sname">Salary Grade</label>
					</div>
				</div>

				<div class="col">
					<div class="form-floating mb-2">
						<input type="text" id="upposition" name="upposition" value="<?php echo $row['position'];?>" class="form-control required" required>
						<label for="sname">POSITION</label>
					</div>
				</div>
				<div class="col">
					<div class="form-floating mb-2">
						<select name="upother-call" id="upother-call" class="form-select" required>
							<option><?php  echo $row['head_office'];?></option>
							<option value=""></option>
							<option value="YES">YES</option>
							<option value="NO">NO</option>
						</select>
						<!-- <input type="text" id="position" name="position"  placeholder=" " class="form-control required" required> -->
						<label for="sname">HEAD OFFICE</label>
					</div>
				</div>

				<div class="col">
					<div class="form-floating mb-2">
						<input type="text" id="upunderpos" name="upunderpos" value="<?php  echo $row['under'];?>" class="form-control required" required>
						<label for="sname">REPORTED TO</label>
						<!-- <select id="upunderpos" name="upunderpos" class="form-select required">
							<option><?php  //echo $row['under'];?></option>
						</select> -->
					</div>
				</div>
				
				<div class="col">
					<div class="form-floating mb-2">
						<select name="upsubline" id="upsubline" class="form-select" required>
							<option><?php  echo $row['subline'];?></option>
							<option value=""></option>
							<option value="YES">YES</option>
							<option value="NO">NO</option>
						</select>
						<!-- <input type="text" id="position" name="position"  placeholder=" " class="form-control required" required> -->
						<label for="sname">HEAD OFFICE</label>
					</div>
				</div>

				<div class="modal-footer">
					<!-- <a href="" data-bs-toggle="modal" data-bs-target="#RemovemyModal" class="btn btn-danger mb-2">DELETE</a> -->
                    <!-- <button type="button" class="btn btn-danger mb-2" id="movetowhere" name="movetowhere" data-bs-toggle="modal" data-bs-target="#RemovemyModal">DELETE</button> -->
                    <!-- <a href="" class="btn btn-danger mb-2">DELETE</a> -->
					<button type="button" class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">DELETE</button>
					<a href="orgchart_list.php?select=<?php echo $row['position'];?>" class="btn btn-info mb-2">SHOW LIST</a>
					<!-- <a href="" class="btn btn-primary" id="update-info" name="update-info" value="<?php //echo $row['id'];?>">UPDATE</a> -->
					<button type="submit" class="btn btn-primary mb-2" id="submit" name="submit" value="<?php echo $row['id'];?>">UPDATE</button>
					<!-- <input type="submit" class="btn btn-primary mb-2" id="submit" name="submit" value="UPDATE"> -->
				</div>
			</div>
		<?php
		}
	}
	}
?>
<!-- </form> -->

<script>
	var checkbox = document.getElementById('check-to-update');
	var form = document.getElementById('image-to-update');

		checkbox.addEventListener('change', function() {
		if (this.checked) {
			form.style.display = 'block';
		} else {
			form.style.display = 'none';
		}
	});
</script>


		