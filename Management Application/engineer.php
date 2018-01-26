<!--
STUDENTS: RONI POLISANOV - 397835884
		  HAIM ELBAZ - 203085196
-->
<!DOCTYPE html lang="en">

<?php require "install.php" ?>
<?php require "templates/header.php"; ?>
<?php require "common.php"; ?>


		<title>Software Company Database Management - Engineers</title>
	</head>
	
	<body style="max-width: 1200px; margin: 0 auto;">

	<br><h1 style="text-align: center;">Engineer Menu</h1><br>

		<div class="container" style="text-align: center;">
			<div class="row">
				<div class="col">
				<a href="engineer.php"><button type="button" class="btn btn-primary">Engineers</button></a>
				</div>
				<div class="col">
				<a href="project.php"><button type="button" class="btn btn-primary">Projects</button></a>
				</div>
				<div class="col">
				<a href="software.php"><button type="button" class="btn btn-primary">Software Fields</button></a>
				</div>
			</div>
		</div>
	<br>
  <?php

  $statement = $db->query("SELECT * 
							 FROM engineer 
							 INNER JOIN phone_number
							 ON engineer.engineer_id = phone_number.engineer_id
							 INNER JOIN speciality
							 ON engineer.engineer_id = speciality.engineer_id
							 ");

  $result = $statement->fetchAll();
  ?>
  <?php
  if ($result && $statement->rowCount() > 0)
	{ ?>
		<table class="table">
			<thead class="thead-light">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">First Name</th>
					<th scope="col">Last Name</th>
					<th scope="col">Date Of Birth</th>
					<th scope="col">Age</th>
					<th scope="col">City</th>
					<th scope="col">Street</th>
					<th scope="col">Phone Number</th>
					<th scope="col">Secondary Phone Number</th>
					<th scope="col">Speciality ID</th>
				</tr>
			</thead>
			<tbody>

	<?php
		foreach ($result as $row)
		{ ?>

			<tr>
				<td scope="row"><?php echo escape($row["engineer_id"]); ?></td>
				<td scope="row"><?php echo escape($row["first_name"]); ?></td>
				<td scope="row"><?php echo escape($row["last_name"]); ?></td>
				<td scope="row"><?php echo escape($row["date_of_birth"]); ?> </td>
				<td scope="row"><?php echo escape($row["age"]); ?></td>
				<td scope="row"><?php echo escape($row["city"]); ?></td>
				<td scope="row"><?php echo escape($row["street"]); ?></td>
				<td scope="row"><?php echo escape($row["telephone"]); ?> </td>
				<td scope="row"><?php echo escape($row["telephone2"]); ?> </td>
				<td scope="row"><?php echo escape($row["field_id"]); ?> </td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>
	<?php
	}
	?>

  <br>
	<div class="container" style="text-align: center;">
	<div class="row">
		<div class="col">
		<a href="addEngineer.php"><button type="button" class="btn btn-info">Add Engineer</button></a>
		</div>

		<div class="col">
		<a href="deleteEngineer.php"><button type="button" class="btn btn-info">Delete Engineer</button></a>
		</div>

		<div class="col">
		<a href="updateEngineer.php"><button type="button" class="btn btn-info">Update Engineer</button></a>
		</div>

		<div class="col">
		<a href="addGrade.php"><button type="button" class="btn btn-info">Add Grade</button></a>
		</div>

		<div class="col">
		<a href="busyEngineers.php"><button type="button" class="btn btn-info">Busy Engineers</button></a>
		</div>

	</div>
	</div><br>
	<center>
	<a href="index.php" style="text-align: center;"><button type="button" class="btn btn-success">HOME</button></a>
	</center>
<br>

<?php require "templates/footer.php"; ?>
