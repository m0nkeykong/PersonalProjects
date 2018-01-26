<?php

if (isset($_POST['submit']))
{

	try
	{
		require "config.php";
		require "common.php";

		$db = new PDO($dsn, $username, $password, $options);


    $temp_id = $_POST['project_number'];

		$tempprojname = $_POST['project_name'];
		$tempcustomername = $_POST['customer_name'];
		$tempstartdate = $_POST['start_date'];
		$tempdescription = $_POST['description'];

		$result = $db->query("SELECT project_number 
							 	FROM projects 
							  	WHERE project_number = '$temp_id'");

		$result = $result->fetchAll();
		if(!$result){
			?>
			<blockquote>Project Number: <?php echo escape($_POST['project_number']); ?> Was Not Found In The System.</blockquote>
			<?php
		}
		else{

    if(!empty($tempprojname)){
    $db->query("UPDATE projects SET project_name='$tempprojname' WHERE project_number=$temp_id");
    }

		if(!empty($tempcustomername)){
			$db->query("UPDATE projects SET customer_name='$tempcustomername' WHERE project_number=$temp_id");
		}
		
		if(!empty($tempstartdate)){
			$db->query("UPDATE projects SET start_date='$tempstartdate' WHERE project_number=$temp_id");
		}
		
		if(!empty($tempdescription)){
			$db->query("UPDATE projects SET description='$tempdescription' WHERE project_number=$temp_id");
		}
		$sql = "SELECT *
						FROM projects
						WHERE project_number = $temp_id";

		$statement = $db->prepare($sql);
		$statement->execute();

		$new_stage = array(
			"project_number" => $temp_id,
			"production_management" => $_POST['production_management'],
			"mission_management" => $_POST['mission_management'],
			"design_review" => $_POST['design_review'],
			"requirements_management" => $_POST['requirements_management'],
			"planning" => $_POST['planning'],
			"software_checks" => $_POST['software_checks'],
			"unit_checks" => $_POST['unit_checks']
		);

		$sql = sprintf(
			"INSERT INTO %s (%s) values (%s)",
			"development_stages",
			implode(", ", array_keys($new_stage)),
			":" . implode(", :", array_keys($new_stage))
		);
	
		$db->query("DELETE FROM development_stages
					WHERE project_number = $temp_id");
		$statement2 = $db->prepare($sql);
		$statement2->execute($new_stage);



		$result = $statement->fetchAll();
		?>
		<blockquote>Project Number: <?php echo escape($_POST['project_number']); ?> Was Updated Successfully.</blockquote>
		<?php
	}
	}
	catch(PDOException $error)
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit']))
{
	if ($result && $statement->rowCount() > 0)
	{ ?>

		<h2>Results</h2>
		<table class="table">
			<thead class="thead-light">
				<tr>
					<th scope="col">Project Number</th>
					<th scope="col">Project Name</th>
					<th scope="col">Customer Name</th>
					<th scope="col">Start Date</th>
					<th scope="col">Description</th>
				</tr>
			</thead>
			<tbody>
	<?php
		foreach ($result as $row)
		{ ?>
			<tr>
				<td scope="row"><?php echo escape($row["project_number"]); ?></td>
				<td scope="row"><?php echo escape($row["project_name"]); ?></td>
				<td scope="row"><?php echo escape($row["customer_name"]); ?></td>
				<td scope="row"><?php echo escape($row["start_date"]); ?></td>
				<td scope="row"><?php echo escape($row["description"]); ?></td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>
	<?php
	}
}?>

<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Update A Project</h1><br>

<div class="row">
<div class="col-3">
<a href="project.php" style="margin: 0 auto;"><button type="button" class="btn btn-info">Back</button></a>
</div>

<div class="col-6">
<form method="post">
<div class="form-group">
<label for="project_number">Project Number</label>
<input type="text"  name="project_number" class="form-control" id="project_number" placeholder="Project Number" required>
</div>
<div class="form-group">
<label for="project_name">Project Name</label>
<input type="text"  name="project_name" class="form-control" id="project_name" placeholder="Project Name">
</div>
<div class="form-group">
  <label for="customer_name">Customer Name</label>
  <input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Customer Name">
</div>
<div class="form-group">
  <label for="start_date">Start Date</label>
  <input type="text" name="start_date" class="form-control" id="start_date" placeholder="dd/mm/yyyy">
</div>
<div class="form-group">
<label for="description">Description</label>
<textarea class="form-control" name="description" id="description" rows="3" placeholder="Description"></textarea>
</div>
<br><h4 style="text-align: center;">Development Stages Tools</h4>
<small id="notice" class="form-text text-muted">*If you will leave this empty, all tools will be cleared.</small><br>
<div class="form-row">
<div class="form-group col-md-6">
<label for="production_management">Production Management</label>
<input type="text" class="form-control" name="production_management" id="production_management" placeholder="Tool"></textarea>
</div>
<div class="form-group col-md-6">
<label for="mission_management">Mission Management</label>
<input type="text" class="form-control" name="mission_management" id="mission_management" placeholder="Tool"></textarea>
</div>
</div>
<div class="form-row">
<div class="form-group col-md-6">
<label for="design_review">Design Review</label>
<input type="text" class="form-control" name="design_review" id="design_review" placeholder="Tool"></textarea>
</div>
<div class="form-group col-md-6">
<label for="requirements_management">Requirements Management</label>
<input type="text" class="form-control" name="requirements_management" id="requirements_management" placeholder="Tool"></textarea>
</div>
</div>
<div class="form-row">
<div class="form-group col-md-6">
<label for="planning">Planning</label>
<input type="text" class="form-control" name="planning" id="planning" placeholder="Tool"></textarea>
</div>
<div class="form-group col-md-6">
<label for="software_checks">Software Checks</label>
<input type="text" class="form-control" name="software_checks" id="software_checks" placeholder="Tool"></textarea>
</div>
</div>
<div class="form-row">
<div class="form-group col-md-6">
<label for="unit_checks">Unit Checks</label>
<input type="text" class="form-control" name="unit_checks" id="unit_checks" placeholder="Tool"></textarea>
</div>
</div>
<div class="form-group">
<center> <input type="submit" name="submit" value="Update" class="btn btn-primary"> </center>
</div>
</form>
</div>
  </div>

  <div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>
