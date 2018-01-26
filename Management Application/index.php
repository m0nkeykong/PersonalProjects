<!--
STUDENTS: RONI POLISANOV - 397835884
		  HAIM ELBAZ - 203085196
-->
<!DOCTYPE html lang="en">

<?php require "install.php" ?>
<?php require "templates/header.php"; ?>

<?php
require "config.php";
require "common.php";
$db = new PDO($dsn, $username, $password, $options);
$blat = $db->query("DROP TRIGGER IF EXISTS verify_delete;");
$statment = $db->query("CREATE TRIGGER verify_delete BEFORE DELETE ON engineer FOR EACH ROW 
						BEGIN
						DELETE FROM speciality WHERE OLD.engineer_id = speciality.engineer_id; 
						DELETE FROM takespart WHERE OLD.engineer_id = takespart.engineer_id; 
						END");
?>







	<title>Software Company Database Management</title>
</head>
	<body style="margin:0 auto; width: 1000px;">
	
		<br><h1 style="text-align: center; color: rgba(0,0,0,0.6);
text-shadow: 2px 8px 6px rgba(0,0,0,0.2),
                 0px -5px 35px rgba(255,255,255,0.3); font-family: 'Quicksand', sans-serif;
">Haim & Roni DATABASE Project</h1><br><br><br>

	<div class="container" style="text-align: center;">
	<div class="row">
		<div class="col">
		<h5 style="font-family: 'Quicksand', sans-serif;">Engineers</h5>
		<a href="engineer.php"><button style="width: 200px; height: 200px;" type="button" class="btn btn-light"><i class="fa fa-users" aria-hidden="true" style="font-size:80px" ></i></button></a>
		</div>

		<div class="col">
		<h5 style="font-family: 'Quicksand', sans-serif;">Projects</h5>
		<a href="project.php"><button style="width: 200px; height: 200px;" type="button" class="btn btn-light"><i class="fa fa-newspaper-o" aria-hidden="true" style="font-size:80px"></i>
</button></a>
		</div>

		<div class="col">
		<h5 style="font-family: 'Quicksand', sans-serif;">Software Fields</h5>
		<a href="software.php"><button style="width: 200px; height: 200px;" type="button" class="btn btn-light"><i class="fa fa-windows" aria-hidden="true" style="font-size:80px"></i>
</button></a>
		</div>
	</div>
	</div>

<?php require "templates/footer.php"; ?>
