<?php require "templates/header.php"; ?>


<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Employed Engineers</h1><br>

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
<center> <input type="submit" name="submit" value="View" class="btn btn-primary"> </center>
</div>
</form>
</div>
</div>

  <div class="col-sm"> </div></div>

<?php

if (isset($_POST['submit']))
{

	try
	{
		require "config.php";
		require "common.php";

		$db = new PDO($dsn, $username, $password, $options);


    	$temp_id = $_POST['project_number'];


		$result = $db->query("SELECT *
								FROM takespart NATURAL JOIN speciality 
								WHERE project_number = '$temp_id'
								ORDER BY field_id ASC");
								
		$result = $result->fetchAll();

		if(!$result){
			?>
			<blockquote>Project Number: <?php echo escape($_POST['project_number']); ?> Was Not Found In The System.</blockquote>
			<?php
		}
		else
	{ ?>
		<h2>Results</h2>
		<table class="table">
			<thead class="thead-light">
				<tr>
					<th scope="col">Software Field ID</th>
					<th scope="col">Project Number</th>
					<th scope="col">Engineer ID</th>
				</tr>
			</thead>
			<tbody>
	<?php
		foreach ($result as $row)
		{ ?>
			<tr>
				<td scope="row"><?php echo escape($row["field_id"]); ?></td>
				<td scope="row"><?php echo escape($row["project_number"]); ?></td>
				<td scope="row"><?php echo escape($row["engineer_id"]); ?></td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>
	<?php
	}

	
	}
	catch(PDOException $error)
	{
		echo $result . "<br>" . $error->getMessage();
	}
}
?>


<?php require "templates/footer.php"; ?>
