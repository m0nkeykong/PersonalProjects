<?php
session_start();
include "data/init.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="includes/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Bitter|Quicksand" rel="stylesheet">
    <title>User Control Panel</title>
	<script type="text/javascript">
	function on() {
		document.getElementById("overlay").style.display = "block";
	}

	function off() {
		document.getElementById("overlay").style.display = "none";
	}
	</script>
</head>

	<body style="margin:0 auto; width: 1000px;">
	
		<br><h1 style="text-align: center; color: rgba(0,0,0,0.6);
                        text-shadow: 2px 8px 6px rgba(0,0,0,0.2),
                        0px -5px 35px rgba(255,255,255,0.3); font-family: 'Quicksand', sans-serif;"> 
                        Wellcome <?php echo $_SESSION["username"];?> 
            </h1><br><br><br>
	<div id="overlay" onclick="off()">
		<div id="text">
			<img src="includes/pic1.png" id="overlay_pic">
			<p>In order to preform a Search in files, simply click on the search button.<br>
			At the search bar, insert you'r query to search at the database.<br>
			The search is filtered from stop-list words.</p>
			<h4>Search Features:</h4>
			<p>You can search using Boolean operands:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;1. OR - search for several words that may appear in one or more files.<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Example: all OR how - will result a search of the word 'all' OR the word 'how' and will present the files containing atleast one of them).<br><br>
				&nbsp;&nbsp;&nbsp;&nbsp;2. AND - search for several words that appear in the same file.<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Example: all AND how - will result a search of the 'all' AND the word 'how' and will present the files containing them both).<br><br>
				&nbsp;&nbsp;&nbsp;&nbsp;3. !(NOT) - search for a word that does not contains the word you have assign the NOT to.<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Example: !all - will result a search of all the files and present the files that does not contain the word 'all').<br><br>
				&nbsp;&nbsp;&nbsp;&nbsp;4. "(Apostrophes) - search word/words that are included in the stop-list words<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Example: "the" - will result a search in all the files for and presents the files that contains the word "the" disregarding the revelance to the stop-list words.</p>
			<br>
			<h4>Admin Features:</h4>
			&nbsp;&nbsp;&nbsp;&nbsp;1. Adding a file:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In order to add a file to the search database, simply click the Add button, there you will be presented with the Exisiting files that are parsed into the database,
				<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;and a list of files that exist in the Storage section but are not parsed.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Simply insert into the text-box the name of the required file you wish to add, and the system will automaticly parse it(while referencing the words, stop words etc..).<br>
			<br>&nbsp;&nbsp;&nbsp;&nbsp;2. Delete a file:<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In order to delete a file from the search database, simply click the Remove button, there you will be presented with the Exisiting files that are parsed into the database.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Simply insert into the text-box the name of the file you wish to remove, the system will automaticly delete it and all is content from the database(while keeping it in the Storage section).<br>
		</div>
	</div>
	<div class="container" style="text-align: center;">
	<div class="row">
		<div class="col">
			<h5 style="font-family: 'Quicksand', sans-serif;">Search Word\Phrase</h5>
			<a href="search.php"><button style="width: 200px; height: 200px;" type="button" class="btn btn-light"><i class="fa fa-search" aria-hidden="true" style="font-size:80px" ></i></button></a>
		</div>
		<div class="col">
			<h5 style="font-family: 'Quicksand', sans-serif;">Help & Instructions</h5>
			<button onclick="on()" style="width: 200px; height: 200px;" type="button" class="btn btn-light"><i class="fa fa-question-circle" aria-hidden="true" style="font-size:80px"></i></button>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col">
			<h5 style="font-family: 'Quicksand', sans-serif;">Disconnect</h5>
			<a href="login.php"><button style="width: 70px; height: 70px;" type="button" class="btn btn-light"><i class="	fa fa-user-times" aria-hidden="true" style="font-size:40px"></i></button></a>
		</div>
	</div>
	</div>
</body>
</html>