<?php
session_start();				
include "data/init.php";
include "functions.php";
$_SESSION['lookup'] = [];
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
	<title>Search</title>
	
</head>

	<body style="margin:0 auto; width: 1000px;">
	
		<br><h1 style="text-align: center; color: rgba(0,0,0,0.6);
                        text-shadow: 2px 8px 6px rgba(0,0,0,0.2),
                        0px -5px 35px rgba(255,255,255,0.3); font-family: 'Quicksand', sans-serif;"> 
                        Wellcome <?php echo $_SESSION["username"];?> 
			</h1
		<div class="row">
            <div class="col">
                <a href="<?php echo $_SESSION['username'];?>index.php"><button style="width: 50px; height: 50px;" type="button" class="btn btn-light"><i class="fa fa-reply" aria-hidden="true" style="font-size:20px" ></i></button></a>
            </div>
        </div>
	<br>
	<nav class="navbar navbar-light bg-light">
		<form class="form-inline" method="post">
			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query" id="query" required>
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit">Search</button>
		</form>
    </nav>
	<?php
	if (!empty($_POST)){
		$lookup = $_POST['query'];          //this is the full query inserted
		$search = strtolower($lookup);		//get all chars to lower
        $searchArr = [];						//create a empty array
		$translate = translate($search);        //deal with () and insert them into the translate
		$arrString = makeArray($search);        //dissmantle it to array - now if we had (), here we have a hash code instead
		processTerms($arrString,$translate,$searchArr);     			//for each expression in array - if not operand, add it to search - term
		//at this point, we commited all the word searches in the database - now we have all the data to begin and conduct the operator conditions
		$response = finalSearch($arrString,$translate,$searchArr);     //combine all term searches and return a complete answer
		?>
		<div class="container" style="text-align: center;">
        <div class="row">
            <h2>Search Results for: "<?php echo $lookup; ?>"</h2>
            <table class="table">
			<thead class="thead-light">
				<tr>
                    <th scope="col">File Number</th>
					<th scope="col">File Name</th>
					<th scope="col">Hits</th>
					<th scope="col">Summary</th>
				</tr>
			</thead>
			<tbody>
		<?php
		if($response){
			foreach($response as $print){
				$filename = $print['file_name'];
				?>
				<tr>
					<td scope="row"><?php echo $print['file_number']; ?> </td>
					<td scope="row"><a href="filecontent.php?name=<?php echo $filename; ?>" target="_blank"><?php echo $filename; ?></a></td>
					<td scope="row"><?php echo $print['occurrences']; ?> </td>
					<td scope="row" id="summary">
					<?php
						$fileptr = fopen("data/db/$filename", "r") or die("Unable to open $filename");
						$line = fgets($fileptr);
						for($rows = 0; $rows < 20; $rows++){
							$line = strtolower(fgets($fileptr));
							if(strcmp($line, "\n") != 0){
								echo $line;	//Bold & Underline searced word		
							}
						}
						?>
					</td>
				</tr>
			<?php
			}
		} else {							//if the searched term does not exist in the db, print this
				echo "<script type='text/javascript'>alert('No Result Were Found In Database for $lookup')</script>";
		}?>
		</div>
	</div>
<?php 
	}
?>
</body>
</html>