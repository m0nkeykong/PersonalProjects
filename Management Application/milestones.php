<!--
STUDENTS: RONI POLISANOV - 397835884
		  HAIM ELBAZ - 203085196
-->
<!DOCTYPE html lang="en">

<?php require "install.php" ?>
<?php require "templates/header.php"; ?>
<?php require "common.php"; ?>

		<title>Software Company Database Management - Projects - Milestones</title>
	</head>
		<body style="margin:0 auto; width: 1000px;">
		<br><h1 style="text-align: center;">Milestones Menu</h1><br>

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
				<div class="col">
				<a href="af.php"><button type="button" class="btn btn-primary">Additional Features</button></a>
				</div>
			</div>
		</div>
	<br>
  <?php
  $statement = $db->query("SELECT * 
							FROM milestones
							WHERE (SELECT COUNT(project_number) 
								   FROM milestones) 
							> 0");
  $result = $statement->fetchAll();


  ?>
  <?php
  if ($result && $statement->rowCount() > 0)
	{ ?>
		<table class="table">
			<thead class="thead-light">
				<tr>
                    <th scope="col">Project Number</th>
					<th scope="col">Date</th>
					<th scope="col">Submission</th>
					<th scope="col">Received Payment</th>
				</tr>
			</thead>
			<tbody>
	<?php
		foreach ($result as $row)
		{ ?>
			<tr>
                <td scope="row"><?php echo escape($row["project_number"]); ?> </td>
				<td scope="row"><?php echo escape($row["date"]); ?> </td>
				<td scope="row"><?php echo escape($row["submission"]); ?> </td>
				<td scope="row"><?php echo escape($row["receive_payment"]); ?> </td>
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
	  <a href="addMilestone.php"><button type="button" class="btn btn-info">Add Milestone</button></a>
	  </div>

	  <div class="col">
	  <a href="deleteMilestone.php"><button type="button" class="btn btn-info">Delete Milestone</button></a>
	  </div>

	  <div class="col">
	  <a href="updateMilestone.php"><button type="button" class="btn btn-info">Update Milestone</button></a>
	  </div>

      <div class="col">
	  <a href="milestonesThisMonth.php"><button type="button" class="btn btn-info">Monthly Milestones</button></a>
	  </div>

  </div>
  </div><br>
  <center>
  <a href="index.php" style="text-align: center;"><button type="button" class="btn btn-success">HOME</button></a>
  </center>
<br>
<?php require "templates/footer.php"; ?>
<?php require "templates/footer.php"; ?>
