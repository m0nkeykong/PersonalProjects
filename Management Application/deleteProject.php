<?php

if (isset($_POST['submit']))
{
	try
	{
		require "config.php";
		require "common.php";

		$db = new PDO($dsn, $username, $password, $options);
		
		$project_number = $_POST['project_number'];
		
		$result = $db->query("SELECT project_number 
							  FROM projects 
							  WHERE project_number = '$project_number'");

		$result = $result->fetchAll();
		if(!$result) {
		?>
        <blockquote>Project Number <?php echo escape($_POST['project_number']); ?> Was Not Found In The System.</blockquote>
		<?php
		}
		else {
			$sql = "DELETE FROM projects
                        WHERE project_number = :project_number";
        

		$statement = $db->prepare($sql);
		$statement->bindParam(':project_number', $project_number, PDO::PARAM_STR);
		$statement->execute();
		
        if (isset($_POST['submit']))
        ?>
        <?php{ ?>
        <blockquote>ID Number <?php echo escape($_POST['project_number']); ?> Was Deleted Successfully.</blockquote>
        <?php}
        ?>
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

<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Delete A Project</h1><br>

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
	<center> <input type="submit" name="submit" value="Delete" class="btn btn-primary"> </center>
	</div>
</form>

</div>
  
  <div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>