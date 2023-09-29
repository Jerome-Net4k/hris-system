<!DOCTYPE html>
<html>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<link rel="stylesheet" href="css/printstyle2.css">
</head>

<style>
	.layout-form{
		padding: 50px;
		border: 2px solid black;
		width: 300px
	}
	.org-title{
		position: fixed;
		padding: 10px 15px;
		border: 1px solid #000;
		text-align: center;
		width: 100%;
	}
	#div-to-print{
		margin-top: 70px;
	}
	@media print {
	/* Sets print view with media query */
		/* body * {
		display: none;
		} */
		/* @page {
				size: A4;
				margin: 0;
			} */
		.layout-form *:not(#my-section):not(#my-section *){
			visibility: hidden;
		}
		/* Sets body and elements in it to not display */
		/* .layout-form {
			display: block;
		} */
	/* Sets print area element and all its content to display */
	}

</style>
<body>
	<!-- <button onclick="printAndSaveAsPDF()">Print and Save as PDF</button> -->
	<div class="layout-form">
		<div class="layout-title">
			<h3>LAYOUT FORMAT</h3>
			<select name="layoutdesign" id="layoutdesign" >
				<option value="layout1">print</option>
				<option value="layout2">LAYOUT TWO</option>
				<option value="layout3">LAYOUT THREE</option>
			</select>
			<input type="text" placeholder="Font Size" class="form-control">
			<p>Display image: <input type="checkbox"></p>
			<button>APPLY</button>
		</div>
	</div>
	
	<div class="org-title">
		<h4>ORGANIZATIONAL CHART</h4>
		<p>kung kanino silang under</p>
	</div>

	<div id="div-to-print">
		<!-- <div class="container"> -->
		<div class="tree" id="tree">
			<?php
			// include("connection.php");
			$con= new mysqli('localhost', 'root','','hr_management');
			if ($con->connect_error) {
				die("Connection failed: " . $con->connect_error);
			}

			// }
			?>

			<ul>
				<?php
				// load what selected
				if(isset($_GET['under'])){
					$under=$_GET['under'];

					$sql = "SELECT * FROM orgchart WHERE position='$under'";
					$result = $con->query($sql);
				
					if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
					?>
						<li>
							<span><img src="images/<?php echo $row['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $row['name'];?><small> (<?php echo $row['sg'];?>) </small></span>
								<span><?php echo $row['position'];?></span>
							</span>
	<?php
		// if(isset($_POST['under'])){
			global $additional;
			global $subline;
			$subline= "1";
			$under=$_GET['under'];
			$nextunder=$_GET['under'];
			
			$sql = "SELECT * FROM orgchart WHERE under='$under' and subline = '$subline'";
			$resulta = $con->query($sql);
			$resultb = $con->query($sql);
			if ($resulta->num_rows > 0) {
				sublineload($resulta,$resultb); ?>
				<?php
					$sql = "SELECT * FROM orgchart WHERE under='$nextunder' and subline <> '$subline'";
					$result = $con->query($sql);

					if ($result->num_rows > 0) {?>
					<ul>
						<?php while ($row = $result->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $row['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $row['name']; ?><small> (<?php echo $row['sg']; ?>) </small></span>
								<span><?php echo $underposition = $row['position']; ?></span>
							</span>
							
			<?php
			$under=$underposition;
			$nextunder=$underposition;
			
			$sql = "SELECT * FROM orgchart WHERE under='$under' and subline = '$subline'";
			$resulta = $con->query($sql);
			$resultb = $con->query($sql);
			if ($resulta->num_rows > 0) {
				sublineload($resulta,$resultb); ?>
				<ul>
				<?php
					$sql = "SELECT * FROM orgchart WHERE under='$nextunder' and subline <> '$subline'";
					$result = $con->query($sql);

					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $row['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $row['name']; ?><small> (<?php echo $row['sg']; ?>) </small></span>
								<span><?php echo $underposition3 = $row['position']; ?></span>
							</span>
							
							<?php
			$under3=$underposition3;
			$nextunder3=$underposition3;
			
			$sql = "SELECT * FROM orgchart WHERE under='$under3' and subline = '$subline'";
			$resultc2 = $con->query($sql);
			$resultd2 = $con->query($sql);
			if ($resultc2->num_rows > 0) {
				sublineload($resultc2,$resultd2); ?>
				<ul>
				<?php
					$sql = "SELECT * FROM orgchart WHERE under='$nextunder3' and subline <> '$subline'";
					$resultq2 = $con->query($sql);

					if ($resultq2->num_rows > 0) {
						while ($rowq2 = $resultq2->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $rowq2['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $rowq2['name']; ?><small> (<?php echo $rowq2['sg']; ?>) </small></span>
								<span><?php echo $underposition5= $rowq2['position']; ?></span>
							</span>


							<?php
			$under5=$underposition5;
			$nextunder5=$underposition5;
			
			$sql = "SELECT * FROM orgchart WHERE under='$under5' and subline = '$subline'";
			$resultc5 = $con->query($sql);
			$resultd5 = $con->query($sql);
			if ($resultc5->num_rows > 0) {
				sublineload($resultc5,$resultd5); ?>
				<ul>
				<?php
					$sql = "SELECT * FROM orgchart WHERE under='$nextunder5' and subline <> '$subline'";
					$resultq5 = $con->query($sql);

					if ($resultq5->num_rows > 0) {
						while ($rowq5 = $resultq5->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $rowq5['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $rowq5['name']; ?><small> (<?php echo $rowq5['sg']; ?>) </small></span>
								<span><?php echo $underposition5 = $rowq5['position']; ?></span>
							</span>
							
						</li>
						<?php
						}
					} ?>
				</ul>
				<?php
			}else{
				$sql = "SELECT * FROM orgchart WHERE under='$under5' and subline <> '$subline'";
				$resultw5 = $con->query($sql);
				if ($resultw5->num_rows > 0) { ?>
					<ul>
					<?php
					while ($roww5 = $resultw5->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $roww5['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $roww5['name']; ?><small> (<?php echo $roww5['sg']; ?>) </small></span>
								<span><?php echo $underposition4 = $roww5['position']; ?></span>
							</span>
							
						</li>
					<?php
					}
					?>
				</ul>
				<?php
				} ?>
			<?php
			}
		?>



							
						</li>
						<?php
						}
					} ?>
				</ul>
				<?php
			}else{
				$sql = "SELECT * FROM orgchart WHERE under='$under3' and subline <> '$subline'";
				$resultw2 = $con->query($sql);
				if ($resultw2->num_rows > 0) { ?>
					<ul>
					<?php
					while ($roww2 = $resultw2->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $roww2['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $roww2['name']; ?><small> (<?php echo $roww2['sg']; ?>) </small></span>
								<span><?php echo $underposition7 = $roww2['position']; ?></span>
							</span>
							
							
							<?php
			$under7=$underposition7;
			$nextunder7=$underposition7;
			
			$sql = "SELECT * FROM orgchart WHERE under='$under7' and subline = '$subline'";
			$resultc7 = $con->query($sql);
			$resultd7 = $con->query($sql);
			if ($resultc7->num_rows > 0) {
				sublineload($resultc7,$resultd7); ?>
				<ul>
				<?php
					$sql = "SELECT * FROM orgchart WHERE under='$nextunder7' and subline <> '$subline'";
					$resultq7 = $con->query($sql);

					if ($resultq7->num_rows > 0) {
						while ($rowq7 = $resultq7->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $rowq7['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $rowq7['name']; ?><small> (<?php echo $rowq7['sg']; ?>) </small></span>
								<span><?php echo $underposition7 = $rowq7['position']; ?></span>
							</span>
							
						</li>
						<?php
						}
					} ?>
				</ul>
				<?php
			}else{
				$sql = "SELECT * FROM orgchart WHERE under='$under7' and subline <> '$subline'";
				$resultw7 = $con->query($sql);
				if ($resultw7->num_rows > 0) { ?>
					<ul>
					<?php
					while ($roww7 = $resultw7->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $roww7['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $roww7['name']; ?><small> (<?php echo $roww7['sg']; ?>) </small></span>
								<span><?php echo $underposition4 = $roww7['position']; ?></span>
							</span>
							
						</li>
					<?php
					}
					?>
				</ul>
				<?php
				} ?>
			<?php
			}
		?>




						</li>
					<?php
					}
					?>
					</ul>
				<?php
				} ?>
			<?php
			}
		?>





						</li>
						<?php
						}
					} ?>
				</ul>
				<?php
			}else{
				$sql = "SELECT * FROM orgchart WHERE under='$under' and subline <> '$subline'";
				$resultc = $con->query($sql);
				if ($resultc->num_rows > 0) { ?>
					<ul>
					<?php
					while ($rowc = $resultc->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $rowc['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $rowc['name']; ?><small> (<?php echo $rowc['sg']; ?>) </small></span>
								<span><?php echo $underposition = $rowc['position']; ?></span>
							</span>
							
						</li>
					<?php
					}
					?>
				</ul>
				<?php
				} ?>
			<?php
			}
			?>
						</li>
						<?php
						}
					} ?>
				</ul>
				<?php
			}else{
				$sql = "SELECT * FROM orgchart WHERE under='$under' and subline <> '$subline'";
				$resultc = $con->query($sql);
				if ($resultc->num_rows > 0) { ?>
					<ul>
					<?php
					while ($rowc = $resultc->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $rowc['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $rowc['name']; ?><small> (<?php echo $rowc['sg']; ?>) </small></span>
								<span><?php echo $underposition3 = $rowc['position']; ?></span>
							</span>
							
						</li>
					<?php
					}
					?>
				</ul>
				<?php
				} ?>
			<?php
			}
		// }
		?>





				</li>
						<?php
					} } 
				}
			?>

			</ul>

			<!-- </li> -->
		</div>
	</div>
	</div>

	<?php
function sublineload($resulta,$resultb){
	include "connection.php";
	$subline = "1";
	if ($resulta->num_rows > 0) {
		?>
		
		<ul>
			<?php
		while ($rowa = $resulta->fetch_assoc()) {
			?>
			<li style="visibility: hidden;">
				<span>
					<img src="images/<?php echo $rowa['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
					<span style="display: flex;"><?php echo $rowa['name']; ?><small> (<?php echo $rowa['sg']; ?>) </small></span>
					<span><?php echo $underposition1 = $rowa['position']; ?></span>
				</span>

		<?php
			$under2=$underposition1;
			$nextunder2=$underposition1;
			
			$sql = "SELECT * FROM orgchart WHERE under='$under2' and subline = '$subline'";
			$resultc = $con->query($sql);
			$resultd = $con->query($sql);
			if ($resultc->num_rows > 0) {
				sublineload($resultc,$resultd); ?>
				<ul>
				<?php
					$sql = "SELECT * FROM orgchart WHERE under='$nextunder2' and subline <> '$subline'";
					$resultq = $con->query($sql);

					if ($resultq->num_rows > 0) {
						while ($rowq = $resultq->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $rowq['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $rowq['name']; ?><small> (<?php echo $rowq['sg']; ?>) </small></span>
								<span><?php echo $underposition6 = $rowq['position']; ?></span>
							</span>
							<?php
			$under6=$underposition6;
			$nextunder6=$underposition6;
			
			$sql = "SELECT * FROM orgchart WHERE under='$under6' and subline = '$subline'";
			$resultc6 = $con->query($sql);
			$resultd6 = $con->query($sql);
			if ($resultc6->num_rows > 0) {
				sublineload($resultc6,$resultd6); ?>
				<ul>
				<?php
					$sql = "SELECT * FROM orgchart WHERE under='$nextunder6' and subline <> '$subline'";
					$resultq6 = $con->query($sql);

					if ($resultq6->num_rows > 0) {
						while ($rowq6 = $resultq6->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $rowq5['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $rowq6['name']; ?><small> (<?php echo $rowq6['sg']; ?>) </small></span>
								<span><?php echo $underposition6 = $rowq6['position']; ?></span>
							</span>

							<ul></ul>
						</li>
						<?php
						}
					} ?>
				</ul>
				<?php
			}else{
				$sql = "SELECT * FROM orgchart WHERE under='$under6' and subline <> '$subline'";
				$resultw6 = $con->query($sql);
				if ($resultw6->num_rows > 0) { ?>
					<ul>
					<?php
					while ($roww6 = $resultw6->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $roww6['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $roww6['name']; ?><small> (<?php echo $roww6['sg']; ?>) </small></span>
								<span><?php echo $underposition4 = $roww6['position']; ?></span>
							</span>
							
						</li>
					<?php
					}
					?>
				</ul>
				<?php
				} ?>
			<?php
			}
		?>


							<ul></ul>
						</li>
						<?php
						}
					} ?>
				</ul>
				<?php
			}else{
				$sql = "SELECT * FROM orgchart WHERE under='$under2' and subline <> '$subline'";
				$resultw = $con->query($sql);
				if ($resultw->num_rows > 0) { ?>
					<ul>
					<?php
					while ($roww = $resultw->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $roww['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $roww['name']; ?><small> (<?php echo $roww['sg']; ?>) </small></span>
								<span><?php echo $underposition4 = $roww['position']; ?></span>
							</span>
							
						</li>
					<?php
					}
					?>
				</ul>
				<?php
				} ?>
			<?php
			}
		?>

			</li>
			<?php
		}
	}

	$additional = 0;
	// $resultb = $con->query($sql);
	if ($resultb->num_rows > 0) {
		while($rowb = $resultb->fetch_assoc()) {
			?>
			<li>
				<span><img src="images/<?php echo $rowb['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
					<span style="display: flex;"><?php echo $rowb['name'];?><small> (<?php echo $rowb['sg'];?>) </small></span>
					<span><?php echo $underposition2 = $rowb['position'];?></span>
				</span>
				
		<?php
			$under2=$underposition2;
			$nextunder2=$underposition2;
			
			$sql = "SELECT * FROM orgchart WHERE under='$under2' and subline = '$subline'";
			$resultc = $con->query($sql);
			$resultd = $con->query($sql);
			if ($resultc->num_rows > 0) {
				sublineload($resultc,$resultd); ?>
				<ul>
				<?php
					$sql = "SELECT * FROM orgchart WHERE under='$nextunder2' and subline <> '$subline'";
					$resultq = $con->query($sql);

					if ($resultq->num_rows > 0) {
						while ($rowq = $resultq->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $rowq['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $rowq['name']; ?><small> (<?php echo $rowq['sg']; ?>) </small></span>
								<span><?php echo $underposition6 = $rowq['position']; ?></span>
							</span>



							<?php
			$under6=$underposition6;
			$nextunder6=$underposition6;
			
			$sql = "SELECT * FROM orgchart WHERE under='$under6' and subline = '$subline'";
			$resultc6 = $con->query($sql);
			$resultd6 = $con->query($sql);
			if ($resultc6->num_rows > 0) {
				sublineload($resultc6,$resultd6); ?>
				<ul>
				<?php
					$sql = "SELECT * FROM orgchart WHERE under='$nextunder6' and subline <> '$subline'";
					$resultq6 = $con->query($sql);

					if ($resultq6->num_rows > 0) {
						while ($rowq6 = $resultq6->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $rowq5['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $rowq6['name']; ?><small> (<?php echo $rowq6['sg']; ?>) </small></span>
								<span><?php echo $underposition6 = $rowq6['position']; ?></span>
							</span>

							<ul></ul>
						</li>
						<?php
						}
					} ?>
				</ul>
				<?php
			}else{
				$sql = "SELECT * FROM orgchart WHERE under='$under6' and subline <> '$subline'";
				$resultw6 = $con->query($sql);
				if ($resultw6->num_rows > 0) { ?>
					<ul>
					<?php
					while ($roww6 = $resultw6->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $roww6['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $roww6['name']; ?><small> (<?php echo $roww6['sg']; ?>) </small></span>
								<span><?php echo $underposition4 = $roww6['position']; ?></span>
							</span>
							
						</li>
					<?php
					}
					?>
				</ul>
				<?php
				} ?>
			<?php
			}
		?>









						</li>
						<?php
						}
					} ?>
				</ul>
				<?php
			}else{
				$sql = "SELECT * FROM orgchart WHERE under='$under2' and subline <> '$subline'";
				$resultw = $con->query($sql);
				if ($resultw->num_rows > 0) { ?>
					<ul>
					<?php
					while ($roww = $resultw->fetch_assoc()) { ?>
						<li>
							<span><img src="images/<?php echo $roww['image']; ?>" alt="My Image" style="width: 100px; height: 80px;">
								<span style="display: flex;"><?php echo $roww['name']; ?><small> (<?php echo $roww['sg']; ?>) </small></span>
								<span><?php echo $underposition = $roww['position']; ?></span>
							</span>
						</li>
					<?php
					}
					?>
				</ul>
				<?php
				} ?>
			<?php
			}
		?>


			</li>
		<?php
		} 
	}
	?>
</ul>
<?php
}

?>






</body>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			load();

			function load(){
				var selectedLayout = $("#layoutdesign").val();
				layoutload(selectedLayout);
			}

			$("#layoutdesign").on("change", function() {
				var selectedLayout = $(this).val();
				layoutload(selectedLayout);
			});

			function layoutload(selectedLayout){
				if (selectedLayout === "layout1") {
					// alert(selectedLayout);
					$("<link>", {
						href: "css/printstyle.css",
						rel: "stylesheet",
						type: "text/css"
					}).appendTo("head");
				}
				else if (selectedLayout === "layout2") {
					// alert(selectedLayout);
					$("<link>", {
						href: "",
						rel: "stylesheet",
						type: "text/css"
					}).appendTo("head");
				} else {
					$("link[href='css/printstyle.css']").remove();
					$("link[href='css/printstyle2.css']").remove();
				}
			}
		});

	</script> -->
</html>