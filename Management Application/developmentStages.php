<?php require "templates/header.php"; ?>


<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Choose Stage To Display</h1><br>

<div class="row">
<div class="col-3">
<a href="project.php" style="margin: 0 auto;"><button type="button" class="btn btn-info">Back</button></a>
</div>
<form method="post">
<div class="form-row" style="margin: 0 auto;">
<select class="form-control col-md-10" name="selected">
  <option value="production_management">Production Management</option>
  <option value="mission_management">Mission Management</option>
  <option value="design_review">Design Review</option>
  <option value="requirements_management">Requirments Management</option>
  <option value="planning">Planning</option>
  <option value="software_checks">Software Checks</option>
  <option value="unit_checks">Unit Checks</option>
</select>
<div class="form-group col-md-2">
<center><input type="submit" name="submit" value="Show" class="btn btn-primary"> </center>
</div>
</form>
</div>
</div>

  <div class="col-sm"> </div>
</div>


<?php
if (isset($_POST['submit']))
{
	require "config.php";
	require "common.php";

	$db = new PDO($dsn, $username, $password, $options);

	$temp_selected = $_POST['selected'];	
	$statement = $db->query("SELECT *
							 FROM development_stages");

	$result = $statement->fetchAll();
	
	if(strcmp($temp_selected,"production_management") == 0){
		$temp_selected2 = "Production Management";
	}
	if(strcmp($temp_selected,"mission_management") == 0){
		$temp_selected2 = "Mission Management";
	}
	if(strcmp($temp_selected,"design_review") == 0){
		$temp_selected2 = "Design Review";
	}
	if(strcmp($temp_selected,"requirements_management") == 0){
		$temp_selected2 = "Requirments Management";
	}
	if(strcmp($temp_selected,"planning") == 0){
		$temp_selected2 = "Planning";
	}
	if(strcmp($temp_selected,"software_checks") == 0){
		$temp_selected2 = "Software Checks";
	}
	if(strcmp($temp_selected,"unit_checks") == 0){
		$temp_selected2 = "Unit Checks";
	}


  if ($result && $statement->rowCount() > 0)
	{ ?>
		<table class="table">
			<thead class="thead-light">
				<tr>
					<th scope="col">Project Number</th>
                    <th scope="col">Development Stage</th>
					<th scope="col">Development Tool</th>
				</tr>
			</thead>
			<tbody>
		<?php
		foreach ($result as $row)
		{?>
			<tr>
				<td scope="row"><?php echo escape($row["project_number"]); ?></td>
                <td scope="row"><?php echo escape($temp_selected2); ?></td>
				<td scope="row"><?php echo escape($row[$temp_selected]); ?> </td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>
	<?php
	}
	}
	?>


<?php require "templates/footer.php"; ?>
