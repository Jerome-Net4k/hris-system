
	<div class="modal-dialog">
		<div class="modal-content">

		<!-- Modal Header -->
		<div class="modal-header">
			<h4 class="modal-title">ORGANIZATION CHART</h4>
			<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
		</div>

		<!-- Modal body -->
			<div class="modal-body">
				<h4 class="fw-bolder text-center">PERSONNEL INFORMATION</h4>
				<p class="text-center">*All fields are required</p>
				<!--  action="orgchart_savedata.php" method="POST"  -->
				<form  id="myform" method="POST" enctype="multipart/form-data"> <!--  action="orgchart_savedata.php" method="POST" -->
					<div class="col">
						<div class="form-floating mb-2">
							<!--  accept="image/*" this code accept image only display to dialogbox -->
							<input type="file" id="image" name="image" class="form-control required" required>
							<!-- accept="image/*" -->
							<label for="sname" style="margin-bottom: 20px;">Please attach the image</label>
						</div>
					</div>


					<div class="col">
						<div class="form-floating mb-2">
							<input type="text" id="name" name="name" placeholder=" " class="form-control required" required>
							<label for="sname">Name on the position</label>
						</div>
					</div>

					<div class="col">
						<div class="form-floating mb-2">
							<input type="text" id="sg" name="sg" value="SG-" class="form-control required" required>
							<label for="sname">Salary Grade</label>
						</div>
					</div>

					<div class="col">
						<div class="form-floating mb-2">
							<input type="text" id="position" name="position"  placeholder=" " class="form-control required" required>
							<label for="sname">POSITION</label>
						</div>
					</div>
					
					<div class="col">
						<div class="form-floating mb-2">
							<select name="other-call" id="other-call" class="form-select">
								<option value="YES">YES</option>
								<option value="NO">NO</option>
							</select>
							<!-- <input type="text" id="position" name="position"  placeholder=" " class="form-control required" required> -->
							<label for="sname">HEAD OFFICER</label>
						</div>
					</div>

					<div class="col">
						<div class="form-floating mb-2">
							<input type="text" id="underorg" name="underorg" placeholder=" " class="form-control required" required>
							<label for="sname">UNDER ON WHAT ORGANIZATION</label>
						</div>
					</div>

					<div class="col">
						<div class="form-floating mb-2">
							<select name="subline" id="subline" class="form-select">
								<option value="NO">NO</option>
								<option value="YES">YES</option>
							</select><label for="sname">SUBLINE?</label>
						</div>
					</div>

					<!-- <div class="form-check mb-4 mt-3">
						<input type="checkbox" class="form-check-input" id="subline" name="subline" value="1">
						<label class="form-check-label" for="check1">Subline?</label>
					</div> -->

					<!-- Modal footer -->
					<div class="modal-footer">
						<!-- <input type="text" id="typeof" name="typeof"  value="add"> -->
						<!-- <button type="button" class="btn btn-primary mb-2" id="addnewpersonnel" name="addnewpersonnel">Add</button> -->
						<button type="button" class="btn btn-success" data-bs-dismiss="modal">CLOSE</button>
						<!-- <a href="#" class="btn btn-secondary mb-2">Add multiply</a> -->
						<!-- <button type="button" name="submit" id="submit">Upload Image</button> -->
						<!-- <button type="button" class="btn btn-primary mb-2" id="addnewpersonnel" name="addnewpersonnel">Add</button> -->
						<!-- <button type="submit" name="submit" id="submit" class="btn btn-primary mb-2">Add</button> -->
						<input type="submit" name="submit" id="submit" class="btn btn-primary mb-2" value="ADD NEW">
						<!-- <type type="submit" class="btn btn-primary mb-2" value="add"> -->
					</div>
				</form>
			</div>

		</div>
	</div>