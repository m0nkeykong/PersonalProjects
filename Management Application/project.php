<!--
STUDENTS: RONI POLISANOV - 397835884
		  HAIM ELBAZ - 203085196
-->
<!DOCTYPE html lang="en">

<?php require "install.php" ?>
<?php require "templates/header.php"; ?>
<?php require "common.php"; ?>

		<title>Software Company Database Management - Projects</title>
	</head>
		<body style="margin:0 auto; width: 1000px;">
		<br><h1 style="text-align: center;">Projects Menu</h1><br>

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
							FROM projects");
  $result = $statement->fetchAll();
  ?>
  <?php
  if ($result && $statement->rowCount() > 0)
	{ ?>
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
		$db->beginTransaction();
		$allprojects = $db->query("SELECT project_number
									FROM monthly_grade");

		$allprojects = $allprojects->fetchAll();		
		$gradeslist;

		foreach($allprojects as $curproject){
			$i = 0;
			$tempcalc = 0;
			$usethis = $curproject['project_number'];
			$projgrades = $db->query("SELECT grade
										FROM monthly_grade
										WHERE project_number = $usethis");
			$projgrades = $projgrades->fetchAll();
			
			foreach($projgrades as $curgrade){
				$tempcalc += $curgrade['grade'];
				$i++;
			}
			$gradeslist[$usethis] = $tempcalc / $i;			
		}
		sort($gradeslist);
		?>
		<h6 style="text-decoration: under-line">Most Interesting Projects: 
		<b><?php for($i = 1; $i < 4; $i++){ 
		echo escape($gradeslist[sizeof($gradeslist) - $i] . " ");
		}?> 
		</h6>
		<h6 style="text-decoration: under-line">Less Interesting Projects: <b><?php for($i = 0; $i < 3; $i++){ 
		echo escape($gradeslist[$i] . " ");
		}
		$db->rollBack();
		?> 
		</h6>
	<?php	
	}
	?>
		

  <br>
  <div class="container" style="text-align: center;">
  <div class="row">
	  <div class="col">
	  <a href="addProject.php"><button type="button" class="btn btn-info">Add Project</button></a>
	  </div>

	  <div class="col">
	  <a href="deleteProject.php"><button type="button" class="btn btn-info">Delete Project</button></a>
	  </div>

	  <div class="col">
	  <a href="updateProject.php"><button type="button" class="btn btn-info">Update Project</button></a>
	  </div>

	  <div class="col">
	  <a href="milestones.php"><button type="button" class="btn btn-info">Milestones</button></a>
	  </div>

		<div class="col">
	  <a href="developmentStages.php"><button type="button" class="btn btn-info">Development Stages</button></a>
	  </div>

	  <div class="col">
	  <a href="employedEngineers.php"><button type="button" class="btn btn-info">Employed Engineers</button></a>
	  </div>
  </div>
  </div><br>
  <center>
  <a href="index.php" style="text-align: center;"><button type="button" class="btn btn-success">HOME</button></a>
  </center>
<br>
<?php require "templates/footer.php"; ?>
<?php require "templates/footer.php"; ?>
