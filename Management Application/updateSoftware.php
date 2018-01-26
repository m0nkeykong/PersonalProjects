	<?php

	if (isset($_POST['submit']))
	{
		try
		{
			require "config.php";
			require "common.php";

			$db = new PDO($dsn, $username, $password, $options);


		$temp_id = $_POST['field_id'];
		$tempname = $_POST['name'];
		$tempspecialization = $_POST['specialization'];


		if(!empty($tempname)){
		$db->query("UPDATE software_field SET name='$tempname' WHERE field_id=$temp_id");
		}

		if(!empty($tempspecialization)){
			$db->query("UPDATE software_field SET specialization='$tempspecialization' WHERE field_id=$temp_id");
		}

		$sql = "SELECT *
				FROM software_field
				WHERE field_id = $temp_id";

			$statement = $db->prepare($sql);
			$statement->execute();

			$result = $statement->fetchAll();
		
		}
		catch(PDOException $error)
		{
			echo $sql . "<br>" . $error->getMessage();
		}
	}?>
	<?php require "templates/header.php"; ?>

	<?php
	if (isset($_POST['submit']))
	{
		if ($result && $statement->rowCount() > 0)
		{ ?>
	<blockquote>Software Field "ID: <?php echo escape($_POST['field_id']); ?>" Was Updated Successfully.</blockquote>
			<h2>Results</h2>
			<table class="table">
				<thead class="thead-light">
					<tr>
						<th scope="col">Field ID</th>
						<th scope="col">Name</th>
						<th scope="col">Specialization</th>
					</tr>
				</thead>
				<tbody>
		<?php
			foreach ($result as $row)
			{ ?>
				<tr>
					<td scope="row"><?php echo escape($row["field_id"]); ?></td>
					<td scope="row"><?php echo escape($row["name"]); ?></td>
					<td scope="row"><?php echo escape($row["specialization"]); ?></td>
				</tr>
			<?php
			} ?>
			</tbody>
		</table>
		<?php
		}
		else
		{ ?>
			<blockquote>Software Field ID: <?php echo escape($_POST['field_id']); ?> Was Not Found In The System.</blockquote>
		<?php
		}
	}?>

	<body style="max-width: 1000px; margin: 0 auto;">
	<br><h1 style="text-align: center;">Update Software Field</h1><br>

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
	<label for="name">Name</label>
	<input type="text" name="name" class="form-control" id="name" placeholder="Name" >
	</div>
	<div class="form-group">
	<label for="specialization">Specialization</label>
	<input type="text"  name="specialization" class="form-control" id="specialization" placeholder="Specialization" >
	</div>
	<div class="form-group">
	<center> <input type="submit" name="submit" value="Update" class="btn btn-primary"> </center>
	</div>
	</form>
	</div>

	<div class="col-sm"> </div>
	</div>

	<?php require "templates/footer.php"; ?>
