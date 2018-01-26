<?php
require "config.php";
require "common.php";
$db = new PDO($dsn, $username, $password, $options);
if (isset($_POST['submit']))
{
	try
	{
		$tempday = $_POST['day'];
		$tempmonth = ("/" . $_POST['month']);
		$tempyear =  ("/" . $_POST['year']);
		$new_user = array(
			"engineer_id" => $_POST['engineer_id'],
			"first_name" => $_POST['first_name'],
			"last_name"  => $_POST['last_name'],
			"date_of_birth" => $tempday . $tempmonth . $tempyear,
			"age" => (2018 - $_POST['year']),
			"city" => $_POST['city'],
			"street"  => $_POST['street']);

		$sql = sprintf(
			"INSERT INTO %s (%s) values (%s)",
			"engineer",
			implode(", ", array_keys($new_user)),
			":" . implode(", :", array_keys($new_user))
		);
		
		$statement = $db->prepare($sql);
		$statement->execute($new_user);

		$phone_number = array(
			"engineer_id" => $_POST['engineer_id'],
			"telephone" => $_POST['telephone'],
			"telephone2" => $_POST['telephone2']
		);

		$sql2 = sprintf(
			"INSERT INTO %s (%s) values (%s)",
			"phone_number",
			implode(", ", array_keys($phone_number)),
			":" . implode(", :", array_keys($phone_number)),
			":" . implode(", :", array_keys($phone_number))
		);
		
		$statement = $db->prepare($sql2);
		$statement->execute($phone_number);
		
		$tempid = $_POST['engineer_id'];
		$field_id = $_POST['field_id'];

		$sql3 = "INSERT INTO speciality
				 (engineer_id, field_id)
				 VALUES ('$tempid', '$field_id')";

		$statement = $db->prepare($sql3);
		$statement->execute();
			
		$related_projects = isset($_POST['projects']) ? $_POST["projects"] : [];
		
		foreach($related_projects as $tmp){
		$sql7 = "INSERT INTO takespart (engineer_id, project_number) VALUES ('$tempid', '$tmp')";
		$statement = $db->prepare($sql7);
		$statement->execute();
		
		}
	}

	catch(PDOException $error)
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>

<?php require "templates/header.php" ?>
<title>Software Company Database Management - Add Engineer</title>
</head>
<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Add Engineer</h1><br>

<?php
if (isset($_POST['submit']) && $statement)
{ ?>
	<blockquote><?php echo escape($_POST['first_name']); ?> was successfully added.</blockquote>
<?php
} ?>


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
<div class="form-row">
<div class="form-group col-md-6">
<label for="first_name">First Name</label>
<input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" required>
</div>
<div class="form-group col-md-6">
<label for="last_name">Last Name</label>
<input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" required>
</div>
</div>
<div class="form-row">
<div class="form-group col-md-4">
<label for="day">Day</label>
<input type="number" name="day" class="form-control" id="day" placeholder="Day" required>
</div>
<div class="form-group col-md-4">
<label for="last_name">Month</label>
<input type="number" name="month" class="form-control" id="month" placeholder="Month" required>
</div>
<div class="form-group col-md-4">
<label for="last_name">Year</label>
<input type="number" name="year" class="form-control" id="year" placeholder="Year" required>
</div>
</div>
<div class="form-group">
<label for="city">City</label>
<input type="text" name="city" class="form-control" id="city" placeholder="City" required>
</div>
<div class="form-group">
<label for="street">Street</label>
<input type="text" name="street" class="form-control" id="street" placeholder="Street" required>
</div>
<div class="form-group">
<label for="telephone">Phone Number</label>
<input type="text" name="telephone" class="form-control" id="telephone" placeholder="Phone Number" required>
</div>
<div class="form-group">
<label for="telephone2">Secondary Phone Number</label>
<input type="text" name="telephone2" class="form-control" id="telephone2" placeholder="Phone Number">
</div>
<label for="field_id">Specialization ID</label>
<select class="form-control" id="field_id" name="field_id">
<?php
$sql4 = $db->query("SELECT *
					FROM software_field");
$sql4 = $sql4->fetchAll();

foreach ($sql4 as $row)
{?>
  <option value="<?php echo escape($row["field_id"]); ?>"> <?php echo escape($row["name"]); ?> </option>
<?php
}
?>
</select><br>
<br><h4 style="text-align: center;">Related Projects</h4>
<div class="custom-control custom-checkbox">
<?php
$sql5 = $db->query("SELECT *
					   FROM projects");
$sql5 = $sql5->fetchAll();
foreach ($sql5 as $row){ ?>
  <input type="checkbox" class="form-check-input" name="projects[]"  id="Projects" value="<?php echo escape($row['project_number']); ?>">
	<label  for="Projects" ></label><?php echo escape($row["project_name"]); ?><br>
<?php
}
?>
</div><br>


	<div class="form-group">
	<center> <input type="submit" name="submit" value="Submit" class="btn btn-primary"> </center>
	</div>
</form>
  </div>

  <div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>
