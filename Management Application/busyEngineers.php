<!--
STUDENTS: RONI POLISANOV - 397835884
		  HAIM ELBAZ - 203085196
-->
<!DOCTYPE html lang="en">

<?php require "install.php" ?>
<?php require "templates/header.php"; ?>
<?php require "common.php"; ?>


		<title>Software Company Database Management - Engineers - Employed Engineers</title>
	</head>
	
	<body style="max-width: 1200px; margin: 0 auto;">

	<br><h1 style="text-align: center;">Employed Engineers</h1><br>

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
							INNER JOIN takespart
							ON engineer.engineer_id = takespart.engineer_id
                            ORDER BY takespart.project_number");

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
                    <th scope="col">Project Number</th>
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
                <td scope="row"><?php echo escape($row["project_number"]); ?></td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>
	<?php
	}
	?>
    
	<center>
	<a href="engineer.php" style="text-align: center;"><button type="button" class="btn btn-success">Back</button></a>
	</center>
<br>

<?php require "templates/footer.php"; ?>
