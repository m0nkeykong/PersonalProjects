<!--
STUDENTS: RONI POLISANOV - 397835884
		  HAIM ELBAZ - 203085196
-->
<!DOCTYPE html lang="en">

<?php require "install.php" ?>
<?php require "templates/header.php"; ?>
<?php require "common.php"; ?>

		<title>Software Company Database Management - Software Fields</title>
	</head>
		<body style="margin:0 auto; width: 1000px;">
		<br><h1 style="text-align: center;">Software Fields Menu</h1><br>

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
					    	FROM software_field");
  $result = $statement->fetchAll();
  ?>
  <?php
  if ($result && $statement->rowCount() > 0)
	{ ?>
		<table class="table">
			<thead class="thead-light">
				<tr>
					<th scope="col">Field ID</th>
					<th scope="col">Specialization</th>
					<th scope="col">Field Name</th>
			</thead>
			<tbody>
	<?php
		foreach ($result as $row)
		{ ?>
			<tr>
				<td scope="row"><?php echo escape($row["field_id"]); ?></td>
				<td scope="row"><?php echo escape($row["specialization"]); ?></td>
				<td scope="row"><?php echo escape($row["name"]); ?></td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>
	<?php
	}
	?>

  <!-- show general table -->
  <!-- add function buttons (add engineer, update engineer, delete engineer)-->
  <br>
	<div class="container" style="text-align: center;">
	<div class="row">
		<div class="col">
		<a href="addSoftware.php"><button type="button" class="btn btn-info">Add Software Field</button></a>
		</div>

		<div class="col">
		<a href="deleteSoftware.php"><button type="button" class="btn btn-info">Delete Software Field</button></a>
		</div>

		<div class="col">
		<a href="updateSoftware.php"><button type="button" class="btn btn-info">Update Software Field</button></a>
		</div>

	</div>
	</div><br>
	<center>
	<a href="index.php" style="text-align: center;"><button type="button" class="btn btn-success">HOME</button></a>
	</center>
<br>
<?php require "templates/footer.php"; ?>