<?php
if (isset($_POST['submit']))
{
	require "config.php";
	require "common.php";

	try
	{
		$db = new PDO($dsn, $username, $password, $options);

		$new_user = array(
			"name" => $_POST['name'],
			"specialization" => $_POST['specialization']);

		$sql = sprintf(
			"INSERT INTO %s (%s) values (%s)",
			"software_field",
			implode(", ", array_keys($new_user)),
			":" . implode(", :", array_keys($new_user))
        );
        
		$statement = $db->prepare($sql);
		$statement->execute($new_user);
	}

	catch(PDOException $error)
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>

<?php require "templates/header.php" ?>
<title>Software Company Database Management - Add Software</title>
</head>
<body style="max-width: 1000px; margin: 0 auto;">
<br><h1 style="text-align: center;">Add Software</h1><br>

<?php
if (isset($_POST['submit']) && $statement)
{ ?>
	<blockquote><?php echo escape($_POST['name']); ?> was successfully added.</blockquote>
<?php
} ?>


<div class="row">
<div class="col-3">
<a href="software.php" style="margin: 0 auto;"><button type="button" class="btn btn-info">Back</button></a>
</div>
<div class="col-6">

<form method="post">
<div class="form-group">
<label for="specialization">Specialization</label>
<input type="text"  name="specialization" class="form-control" id="specialization" placeholder="specialization" required>
</div>
<div class="form-group">
<label for="name">Name</label>
<input type="text"  name="name" class="form-control" id="name" placeholder="name" required>
</div>
<div class="form-group">
<center> <input type="submit" name="submit" value="Add" class="btn btn-primary"> </center>
</div>
</form>

</div>
<div class="col-sm"> </div>
</div>

<?php require "templates/footer.php"; ?>
