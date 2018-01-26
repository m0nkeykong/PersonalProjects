<?php
require "config.php";
require "common.php";

$db = new PDO($dsn, $username, $password, $options);

if (isset($_POST['submit']))
{

	try
	{
    $temp_id = $_POST['engineer_id'];

    $tempday = $_POST['day'];
    $tempmonth = ("/" . $_POST['month']);
    $tempyear =  ("/" . $_POST['year']);
    $temp_first = $_POST['first_name'];
    $temp_last = $_POST['last_name'];
    $temp_city = $_POST['city'];
    $temp_strt = $_POST['street'];
    $temp_phone = $_POST['telephone'];
		$temp_phone2 = $_POST['telephone2'];
		$temp_spec = $_POST['field_id'];

		$result = $db->query("SELECT engineer_id 
							  FROM engineer 
							  WHERE engineer_id = '$temp_id'");

		$result = $result->fetchAll();
		if(!$result){
			?>
			<blockquote>Engineer ID: <?php echo escape($_POST['engineer_id']); ?> Was Not Found In The System.</blockquote>
			<?php
		}
		else{
    if(!empty($tempday) && !empty($tempyear) && !empty($tempmonth)){
      $temp_date = $tempday . $tempmonth . $tempyear;
      $db->query("UPDATE engineer SET date_of_birth='$temp_date' WHERE engineer_id=$temp_id");
    }

    if(!empty($_POST['year'])){
      $temp_age = (2018 - $_POST['year']);
      $db->query("UPDATE engineer SET age=$temp_age WHERE engineer_id=$temp_id");
    }

    if(!empty($temp_first)){
      $db->query("UPDATE engineer SET first_name='$temp_first' WHERE engineer_id=$temp_id");
    }

    if(!empty($temp_last)){
      $db->query("UPDATE engineer SET last_name='$temp_last' WHERE engineer_id=$temp_id");
    }

    if(!empty($temp_city)){
      $db->query("UPDATE engineer SET city='$temp_city' WHERE engineer_id=$temp_id");
    }

    if(!empty($temp_strt)){
      $db->query("UPDATE engineer SET street='$temp_strt' WHERE engineer_id=$temp_id");
    }

    if(!empty($temp_phone)){
    $db->query("UPDATE phone_number SET telephone='$temp_phone' WHERE engineer_id=$temp_id");
    }

		if(!empty($temp_phone2)){
			$db->query("UPDATE phone_number SET telephone2='$temp_phone2' WHERE engineer_id=$temp_id");
		}

		if(!empty($temp_spec)){
			$db->query("UPDATE speciality SET field_id='$temp_spec' WHERE engineer_id=$temp_id");
		}
		
		
		$related_projects = isset($_POST['projects']) ? $_POST["projects"] : [];
	
			$db->query("DELETE FROM takespart WHERE engineer_id = '$temp_id'");	
			foreach($related_projects as $tmp){
				$sql7 = "INSERT INTO takespart (engineer_id, project_number) VALUES ('$temp_id', '$tmp')";
				$statement = $db->prepare($sql7);
				$statement->execute();
			}

		echo "IM HERE4";
		$sql = "SELECT *
						FROM engineer 
						INNER JOIN phone_number
						ON engineer.engineer_id = $temp_id AND (phone_number.engineer_id = $temp_id)
						INNER JOIN speciality
						ON engineer.engineer_id = $temp_id AND (speciality.engineer_id = $temp_id)
						";


		$statement = $db->prepare($sql);
		$statement->execute();
		
		$result = $statement->fetchAll();
		?>
		<blockquote>Engineer "ID:<?php echo escape($_POST['engineer_id']); ?>" Was Updated Successfully.</blockquote>
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
	{ 
		?>

		<h2>Results</h2>
		<table class="table">
			<thead class="thead-light">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">First Name</th>
					<th scope="col">Last Name</th>
					<th scope="col">City</th>
					<th scope="col">Street</th>
					<th scope="col">Age</th>
					<th scope="col">Date Of Birth</th>
          <th scope="col">Phone Number</th>
					<th scope="col">Secondary Phone Number</th>
					<th scope="col">Speciality ID</th>
				</tr>
			</thead>
			<tbody>
	<?php
		foreach ($result as $row)
		{ ?>
			<tr>
				<td scope="row"><?php echo escape($row["engineer_id"]); ?></td>
				<td scope="row"><?php echo escape($row["first_name"]); ?></td>
				<td scope="row"><?php echo escape($row["last_name"]); ?></td>
				<td scope="row"><?php echo escape($row["city"]); ?></td>
				<td scope="row"><?php echo escape($row["street"]); ?></td>
				<td scope="row"><?php echo escape($row["age"]); ?></td>
				<td scope="row"><?php echo escape($row["date_of_birth"]); ?> </td>
        <td scope="row"><?php echo escape($row["telephone"]); ?> </td>
				<td scope="row"><?php echo escape($row["telephone2"]); ?> </td>
				<td scope="row"><?php echo escape($row["field_id"]); ?> </td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>
	<?php
	}
}?>

<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Update Engineer</h1><br>

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
  <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name">
</div>
<div class="form-group col-md-6">
  <label for="last_name">Last Name</label>
  <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
</div>
</div>
<div class="form-row">
<div class="form-group col-md-4">
<label for="day">Day</label>
<input type="number" name="day" class="form-control" id="day" placeholder="Day">
</div>
<div class="form-group col-md-4">
<label for="last_name">Month</label>
<input type="number" name="month" class="form-control" id="month" placeholder="Month">
</div>
<div class="form-group col-md-4">
<label for="last_name">Year</label>
<input type="number" name="year" class="form-control" id="year" placeholder="Year">
</div>
</div>
<div class="form-group">
<label for="city">City</label>
<input type="text" name="city" class="form-control" id="city" placeholder="City">
</div>
<div class="form-group">
<label for="street">Street</label>
<input type="text" name="street" class="form-control" id="street" placeholder="Street">
</div>
<div class="form-group">
<label for="telephone">Phone Number</label>
<input type="text" name="telephone" class="form-control" id="telephone" placeholder="Phone Number">
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
<small id="notice" class="form-text text-muted">*If you will leave this empty, all realted projects will be cleared.</small><br>
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
	<div class="form-group">
	<center> <input type="submit" name="submit" value="Update" class="btn btn-primary"> </center>
	</div>
</form>
  </div>

  <div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>
