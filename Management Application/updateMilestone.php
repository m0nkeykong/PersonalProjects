<?php

if (isset($_POST['submit']))
{

	try
	{
		require "config.php";
		require "common.php";

		$db = new PDO($dsn, $username, $password, $options);

		$tempday = $_POST['day'];
		$tempmonth = ("/" . $_POST['month']);
		$tempyear =  ("/" . $_POST['year']);

    	$temp_projnum = $_POST['project_number'];
		$temp_submission = $_POST['submission'];
		$temp_payment = $_POST['receive_payment'];
		$temp_date = $tempday . $tempmonth . $tempyear;
		$temp_month = $_POST['month'];

		$result = $db->query("SELECT project_number 
							  FROM milestones 
							  WHERE project_number = '$temp_projnum'");

		$result = $result->fetchAll();
		if(!$result){
			?>
			<blockquote>Project Number: <?php echo escape($_POST['project_number']); ?> Was Not Found In The System.</blockquote>
			<?php
		}
		else{

   		 if(!empty($temp_submission)){
   		 $db->query("UPDATE milestones SET submission='$temp_submission' WHERE project_number=$temp_projnum");
  		  }

		if(!empty($temp_payment)){
			$db->query("UPDATE milestones SET receive_payment='$temp_payment' WHERE project_number=$temp_projnum");
		}
		
		$db->query("UPDATE milestones SET date='$temp_date' WHERE project_number=$temp_projnum");
		$db->query("UPDATE milestones SET cur_month='$temp_month' WHERE project_number=$temp_projnum");

		
		$sql = "SELECT *
				FROM milestones
				WHERE project_number = $temp_projnum";

		$statement = $db->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll();
		
		?>
		<blockquote>Milestone Was Updated Successfully.</blockquote>
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

<?php
if (isset($_POST['submit']))
{
	if ($result && $statement->rowCount() > 0)
	{ ?>

		<h2>Results</h2>
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
}?>

<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Update A Milestone</h1><br>

<div class="row">
<div class="col-3">
<a href="milestones.php" style="margin: 0 auto;"><button type="button" class="btn btn-info">Back</button></a>
</div>

<div class="col-6">
<form method="post">
<div class="form-group">
<label for="project_number">Project Number</label>
<input type="text"  name="project_number" class="form-control" id="project_number" placeholder="Project Number" required>
</div>
<div class="form-group">
  <label for="submission">Submission</label>
  <input type="text" name="submission" class="form-control" id="submission" placeholder="Submission">
</div>
<div class="form-group">
  <label for="receive_payment">Future Payment</label>
  <input type="number" name="receive_payment" class="form-control" id="receive_payment" placeholder="Future Payment">
</div>
<h6 style="text-align: center;" for="date">Deadline Date</h6>
<div class="form-row">
<div class="form-group col-md-4">
<label for="day">Day</label>
<input type="number" name="day" class="form-control" id="day" placeholder="Day" required>
</div>
<div class="form-group col-md-4">
<label for="month">Month</label>
<input type="number" name="month" class="form-control" id="month" placeholder="Month" required>
</div>
<div class="form-group col-md-4">
<label for="year">Year</label>
<input type="number" name="year" class="form-control" id="year" placeholder="Year" required>
</div>
</div>
<div class="form-group">
<center> <input type="submit" name="submit" value="Update" class="btn btn-primary"> </center>
</div>
</form>
</div>


  <div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>
