<?php

if (isset($_POST['submit']))
{

	try
	{
		require "config.php";
		require "common.php";

		$db = new PDO($dsn, $username, $password, $options);
		$db->beginTransaction();
		$field_id = $_POST['field_id'];
		
		$result = $db->query("SELECT field_id 
							  FROM software_field 
							  WHERE field_id = '$field_id'");

		$result = $result->fetchAll();
		if(!$result) {
		?>
        <blockquote>ID Number <?php echo escape($_POST['field_id']); ?> Was Not Found In The System.</blockquote>
		<?php
		}
		else {
			$sql = "DELETE FROM software_field
                           WHERE field_id = :field_id";
        
		$statement = $db->prepare($sql);
		$statement->bindParam(':field_id', $field_id, PDO::PARAM_STR);
		
		$check_if_possible = $db->query("SELECT engineer_id
										 FROM speciality
										 WHERE field_id = '$field_id'");

		$check_if_possible = $check_if_possible->fetchAll();
		if (isset($check_if_possible)){
			$db->rollBack();
			echo "There are working engineers in this field, cannot delete it";
		} else {
			$statement->execute();
			$db->commit();
			?><blockquote>Field ID <?php echo escape($_POST['field_id']); ?> Was Deleted Successfully.</blockquote><?php
		}

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
<br><h1 style="text-align: center;">Delete Software Field</h1><br>


<div class="row">
<div class="col-3">
<a href="software.php" style="margin: 0 auto;"><button type="button" class="btn btn-info">Back</button></a>
</div>

<div class="col-6">
<form method="post">
<div class="form-group">
<label for="field_id">Field ID</label>
<input type="text"  name="field_id" class="form-control" id="field_id" placeholder="Field ID" required>
</div>

<div class="form-group">
	<center> <input type="submit" name="submit" value="Delete" class="btn btn-primary"> </center>
	</div>
</form>

</div>
  
  <div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>