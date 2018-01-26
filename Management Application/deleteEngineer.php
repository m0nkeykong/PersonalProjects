<?php
if (isset($_POST['submit']))
{
	
	try
	{
		require "config.php";
		require "common.php";
		
		$db = new PDO($dsn, $username, $password, $options);
		
		$engineer_id = $_POST['engineer_id'];
		
		$result = $db->query("SELECT engineer_id 
							  FROM engineer 
							  WHERE engineer_id = '$engineer_id'");

		$result = $result->fetchAll();
		if(!$result) {
		?>
        <blockquote>ID Number <?php echo escape($_POST['engineer_id']); ?> Was Not Found In The System.</blockquote>
		<?php
		}
		else {
			$sql = "DELETE FROM engineer
                    WHERE engineer_id = :engineer_id";
					
		$statement = $db->prepare($sql);
		$statement->bindParam(':engineer_id', $engineer_id, PDO::PARAM_STR);
		$statement->execute();
		
        if (isset($_POST['submit']))
        ?>
        <?php{ ?>
        <blockquote>ID Number <?php echo escape($_POST['engineer_id']); ?> Was Deleted Successfully.</blockquote>
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
<br><h1 style="text-align: center;">Delete Engineer</h1><br>



<div class="row">
<div class="col-3">
<a href="engineer.php" style="margin: 0 auto;"><button type="button" class="btn btn-info">Back</button></a>
</div>

<div class="col-6">
<form method="post">
<div class="form-group">
<label for="engineer_id">ID Number</label>
<input type="text"  name="engineer_id" class="form-control" id="engineer_id" placeholder="ID Number" required>
</div>

<div class="form-group">
	<center> <input type="submit" name="submit" value="Delete" class="btn btn-primary"> </center>
	</div>
</form>

</div>
  
  <div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>