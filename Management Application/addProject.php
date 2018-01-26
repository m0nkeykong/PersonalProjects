<?php
if (isset($_POST['submit']))
{
	require "config.php";
	require "common.php";

	try
	{
		$db = new PDO($dsn, $username, $password, $options);

		$new_user = array(
			"project_name" => $_POST['project_name'],
			"customer_name" => $_POST['customer_name'],
			"start_date"  => $_POST['start_date'],
			"description" => $_POST['description']);

		$sql = sprintf(
			"INSERT INTO %s (%s) values (%s)",
			"projects",
			implode(", ", array_keys($new_user)),
			":" . implode(", :", array_keys($new_user))
		);
		
		$statement = $db->prepare($sql);
		$statement->execute($new_user);
		
		$proj_name = $_POST['project_name'];
		$check_numb = $db->query("SELECT project_number
								  FROM projects
								  WHERE project_name = '$proj_name'");

		$check_numb = $check_numb->fetch();

		$new_stage = array(
			"project_number" => intval($check_numb[0]),
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
	
		$statement = $db->prepare($sql);
		$statement->execute($new_stage);
	}

	catch(PDOException $error)
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>

<?php require "templates/header.php" ?>
<title>Software Company Database Management - Add Project</title>
</head>
<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Add A Project</h1><br>

<?php
if (isset($_POST['submit']) && $statement)
{ ?>
	<blockquote><?php echo escape($_POST['project_name']); ?> was successfully added.</blockquote>
<?php
} ?>


<div class="row">
<div class="col-3">
<a href="project.php" style="margin: 0 auto;"><button type="button" class="btn btn-info">Back</button></a>
</div>
  
<div class="col-6">
<form method="post">
<div class="form-group">
<label for="project_name">Project Name</label>
<input type="text"  name="project_name" class="form-control" id="project_name" placeholder="Project Name" required>
</div>
<div class="form-group">
  <label for="customer_name">Customer Name</label>
  <input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Customer Name" required>
</div>
<div class="form-group">
  <label for="start_date">Start Date</label>
  <input type="text" name="start_date" class="form-control" id="start_date" placeholder="dd/mm/yyyy" required>
</div>
<div class="form-group">
<label for="description">Description</label>
<textarea class="form-control" name="description" id="description" rows="3" placeholder="Description" required></textarea>
</div>
<br><h4 style="text-align: center;">Development Stages Tools</h4><br>
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
<center> <input type="submit" name="submit" value="Add" class="btn btn-primary"> </center>
</div>
</form>
</div>

<div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>
