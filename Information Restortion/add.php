<?php
session_start();
//here, the program checks all the implemented files and all the existing files
//the files that exist in the databank and not in the database are loaded 
//to give the admin the option to add them to the system
include "data/init.php";
$stopList=['a', '"', ';', '.', 'the', 'an', '!', '*', 'it', 'at', 'i', 'in', 'that', 'as', 'on','and', 'to'];
if (!empty($_POST)){
    $toADD = $_POST['addIT'];
    if(!file_exists("data/db/$toADD")){
    if(file_exists("data/files/$toADD")){
        $fileptr = fopen("data/files/" . $toADD, "r") or die("Unable to open " . $toADD . "!");
        $newfile = fopen("data/db/" . $toADD, "w") or die("Unable to open " . $toADD . "!");
        while(($line = fgets($fileptr)) !== false){
            fwrite($newfile, $line . "\n");	
        }
        fclose($fileptr);				//here we finished with the origin files, now we start dealing with the proccessed files
        fclose($newfile);				//here we finished proccessing the files
        $ctr = $_SESSION['ctr'];
        //here we start parsing the new file's data into the different tables
        $fileptr = fopen("data/db/" . $toADD, "r") or die("Unable to open " . $toADD . "!");
        $line = fgets($fileptr);				//first we store the file information in the our database
        $dtls = explode(";", $line);
        $ctr++;
        $_SESSION['ctr'] = $ctr;
        $dtls[0] = substr($dtls[0], strrpos($dtls[0],':') + 1);
        $dtls[1] = substr($dtls[1], strrpos($dtls[1],':') + 1);
        $dtls[2] = substr($dtls[2], strrpos($dtls[2],':') + 1);
        
        $query = "INSERT INTO file_list(file_number, file_name, file_author, file_type, file_created) VALUES('$ctr', '$toADD', '$dtls[0]', '$dtls[1]', '$dtls[2]')";
        mysqli_query($connection, $query);
        //at this point, we inserted the file's details into the the database
        
        //now we start mapping the words from the file
        $linesarray = file("data/db/" . $toADD);									//get all content
        array_shift($linesarray);
        $lines = implode("" ,$linesarray);
        $words = preg_split('/[\s,.";:!*()?]+/', strtolower($lines), -1); 		//split it into words
        foreach($words as $word){
            //if word is a stoplist, keep track by storing it at the stoplist table
            if(in_array($word, $stopList)){
                $query = "SELECT * FROM stop_list WHERE word = '$word' AND file_number = '$ctr'";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($result);
                mysqli_free_result($result);
                
                if(!$row){	//if the word we got from file does not exist in db, create it
                    $times = substr_count($lines, " $word ");
                    $times++;
                    $query = "INSERT INTO stop_list(word, occurrences, file_number) VALUES ('$word', $times, '$ctr')";
                    mysqli_query($connection, $query);
                }
            } else { 	//now, for each word that is not part of the stoplist, store it in the database table
                                        //and to the inverted_file list		
                $word = str_replace("'", "\'", $word);					//replace the ' to \' - ' wont be accepted			
                $query = "SELECT * FROM word_list WHERE word = '$word' AND file_number = '$ctr'";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($result);
                if(!$row && $word){	//if the word we got from file does not exist in db, create it
                    $times = substr_count($lines, " $word ");
                    $times++;
                    $query = "INSERT INTO word_list(word, occurrences, file_number) VALUES ('$word', $times, '$ctr')";
                    mysqli_query($connection, $query);
                }
            } 
        }
        echo "<script type='text/javascript'>alert('$toADD has been succesfuly added to the active database')</script>";
    } else {
        echo "<script type='text/javascript'>alert('file $toADD was not found in the system')</script>";
    }
} else{
    echo "<script type='text/javascript'>alert('file $toADD already exists in the database')</script>";
}
}
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
    <title>Admin Control Panel - Add File</title>
</head>

	<body style="margin:0 auto; width: 1000px;">
		<br><h1 style="text-align: center; color: rgba(0,0,0,0.6);
                        text-shadow: 2px 8px 6px rgba(0,0,0,0.2),
                        0px -5px 35px rgba(255,255,255,0.3); font-family: 'Quicksand', sans-serif;"> 
                        Add A File
        </h1>
        <div class="row">
            <div class="col">
                <a href="adminindex.php"><button style="width: 50px; height: 50px;" type="button" class="btn btn-light"><i class="fa fa-reply" aria-hidden="true" style="font-size:20px" ></i></button></a>
            </div>
        </div>
        <br>
        <nav class="navbar navbar-light bg-light">
        <form class="form-inline" method="post">
            <input class="form-control mr-sm-2" type="search" placeholder="Add" aria-label="Add" name="addIT" id="addIT" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit">Add</button>
        </form>
        </nav>
        <div class="container" style="text-align: center;">
        <div class="row">
            <h2>Existing Files</h2>
            <table class="table">
			<thead class="thead-light">
				<tr>
                    <th scope="col">File Number</th>
					<th scope="col">File Name</th>
                    <th scope="col">File Author</th>
                    <th scope="col">File Type</th>
					<th scope="col">File Creation Date</th>
				</tr>
			</thead>
			<tbody>
            <?php
                $query = ("SELECT * FROM file_list");
                $result = mysqli_query($connection, $query);
                foreach($result as $row){?>
                <tr>
                    <td scope="row"><?php echo $row["file_number"]; ?> </td>
                    <td scope="row"><a href="data/db/<?php echo $row["file_name"]; ?>" target="_blank"><?php echo $row["file_name"]; ?></a></td>
                    <td scope="row"><?php echo $row["file_author"]; ?> </td>
                    <td scope="row"><?php echo $row["file_type"]; ?> </td>
                    <td scope="row"><?php echo $row["file_created"]; ?> </td>
			    </tr>
               <?php }
            ?>
            </tbody>    
            </table>
            <h2>Storage Files</h2>
            <table class="table">
			<thead class="thead-light">
				<tr>
					<th scope="col">File Name</th>
				</tr>
			</thead>
			<tbody>
            <?php //deal with storage files and give the admin the abillity to add them to the database
            $files = scandir("data/files/");	//get all files
            $files = array_diff($files, array('.', '..'));	//exclude the . and .. - which are the current dir and parent dir
            $ctr = 0;
            foreach($files as $file){						//print all existing file's names
                if(!file_exists("data/db/$file")){?>
                    <tr>
                        <td scope="row"><a href="data/files/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a></td>
                    </tr>
                <?php
                }
            }?>
            </tbody>    
            </table>
        </div>
        </div>
    </body>
</html>
