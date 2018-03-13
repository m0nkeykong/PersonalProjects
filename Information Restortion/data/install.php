<?php
session_start();
include "init.php";

//stoplist words from files
$stopList=['a', '"', ';', '.', 'the', 'an', '!', '*', 'it', 'at', 'i', 'in', 'that', 'as', 'on','and', 'to'];

//$tempSTOP = file_get_content("stoplist.txt");
//$stopList = explode("\n", $tempSTOP);

//start the db with inserting all the file's data
$files = scandir("files/");	//get all files
$files = array_diff($files, array('.', '..'));	//exclude the . and .. - which are the current dir and parent dir
$ctr = 0;
foreach($files as $file){						//first we copy all the files
	$fileptr = fopen("files/" . $file, "r") or die("Unable to open " . $file . "!");
	$newfile = fopen("db/" . $file, "w") or die("Unable to open " . $file . "!");
	$ctr++;	
	while(($line = fgets($fileptr)) !== false){
		fwrite($newfile, $line . "\n");	
	}
	fclose($fileptr);				//here we finished with the origin files, now we start dealing with the proccessed files
	fclose($newfile);				//here we finished proccessing the files
	if($ctr == 5) { break; }		//get only 5 files, the rest is up to the admin - later implement the addition from the GUI.
}

$files = scandir("db/");	//get all files
$files = array_diff($files, array('.', '..'));	//exclude the . and ..
$ctr = 0;
foreach($files as $file){			//now we need to insert the files into our data base, and parse the words
	$fileptr = fopen("db/" . $file, "r") or die("Unable to open " . $file . "!");
	$ctr++;
	$line = fgets($fileptr);				//first we store the file information in the our database
	$dtls = explode(";", $line);
	$dtls[0] = substr($dtls[0], strrpos($dtls[0],':') + 1);
	$dtls[1] = substr($dtls[1], strrpos($dtls[1],':') + 1);
	$dtls[2] = substr($dtls[2], strrpos($dtls[2],':') + 1);
	
	$query = "INSERT INTO file_list(file_number, file_name, file_author, file_type, file_created) VALUES('$ctr', '$file', '$dtls[0]', '$dtls[1]', '$dtls[2]')";
	mysqli_query($connection, $query);
	//at this point, we inserted the file's details into the the database
	
	//now we start mapping the words from the file
	$linesarray = file("db/" . $file);									//get all content
	array_shift($linesarray);						//remove first row from file - file information
	$lines = implode("" ,$linesarray);				//get array to string
	$words = preg_split('/[\s,.";:!*()?]+/', strtolower($lines), -1); 		//split it into words
	foreach($words as $word){
		//if word is a stoplist, keep track by storing it at the stoplist table
		$word = str_replace("'", "\'", $word);					//replace the ' to \' - ' wont be accepted			
		if(!(in_array($word, $stopList))){
			//now, for each word that is not part of the stoplist, store it in the database table
									//and to the inverted_file list		
			$query = "SELECT * FROM word_list WHERE word = '$word' AND file_number = '$ctr'";
			$result = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($result);
			if(!$row && $word){	//if the word we( got from file does not exist in db, create it
				$times = substr_count($lines, " $word ");
				$times++;
				$query = "INSERT INTO word_list(word, occurrences, file_number) VALUES ('$word', $times, '$ctr')";
				mysqli_query($connection, $query);
				echo "*creating word: '" . $word . "'" . " from file: '" . $file . "'<br>";
			} else {				//if the word we got from file exist in db, add file number to file_number 
				echo "*word: '" . $word . "'" . " already exist at word_list table<br>.";
			}
									
		} else { 			//if word is in stop-list
			$query = "SELECT * FROM stop_list WHERE word = '$word' AND file_number = '$ctr'";
			$result = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			
			if(!$row){	//if the word we got from file does not exist in db, create it
				$times = substr_count($lines, " $word ");
				$times++;
				$query = "INSERT INTO stop_list(word, occurrences, file_number) VALUES ('$word', $times, '$ctr')";
				mysqli_query($connection, $query);
				echo "*creating stop-word: '" . $word . "'" . " from file: '" . $file . "'<br>";
			} else {				//if the word we got from file exist in db, add file number to file_number 
				echo "*stop-word: '" . $word . "'" . " already exist at stop_list table<br>.";
			}
		
		} 
	}
}
$_SESSION['ctr'] = $ctr;
?>
