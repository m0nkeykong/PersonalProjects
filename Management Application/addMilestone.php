<?php
if (isset($_POST['submit']))
{
	require "config.php";
	require "common.php";

	try
	{
		$db = new PDO($dsn, $username, $password, $options);

		$tempday = $_POST['day'];
		$tempmonth = ("/" . $_POST['month']);
		$tempyear =  ("/" . $_POST['year']);
		$new_milestone = array(
			"project_number" => $_POST['project_number'],
			"submission" => $_POST['submission'],
			"receive_payment"  => $_POST['receive_payment'],
			"date" => $tempday . $tempmonth . $tempyear,
			"cur_month" => $_POST['month']);

		$sql = sprintf(
			"INSERT INTO %s (%s) values (%s)",
			"milestones",
			implode(", ", array_keys($new_milestone)),
			":" . implode(", :", array_keys($new_milestone))
		);
		
		$statement = $db->prepare($sql);
		$statement->execute($new_milestone);
	}

	catch(PDOException $error)
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>

<?php require "templates/header.php" ?>
<title>Software Company Database Management - Add Milestone</title>
</head>
<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Add A Milestone</h1><br>

<?php
if (isset($_POST['submit']) && $statement)
{ ?>
	<blockquote>Milestone was successfully added.</blockquote>
<?php
} ?>


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
  <input type="text" name="submission" class="form-control" id="submission" placeholder="Submission" required>
</div>
<div class="form-group">
  <label for="receive_payment">Future Payment</label>
  <input type="number" name="receive_payment" class="form-control" id="receive_payment" placeholder="Future Payment" required>
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
<center> <input type="submit" name="submit" value="Add" class="btn btn-primary"> </center>
</div>
</form>
</div>

<div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>
