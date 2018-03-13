<?php
function doOper($termA,$termB,$oper){       //check the operator
  if (strcmp($oper, '&&') === 0 ) return intersect($termA,$termB);    //if its && - do AND
  if (strcmp($oper, '||') === 0 ) return union($termA,$termB);   //if its || - do OR
}

//findWord - this function is the second stop of the search - gets a term to search in the word_table
function findWord($term){
  array_push($_SESSION['lookup'], $term);   //store term to show in file later
  $DBHOST       = "localhost";
  $DBUSER       = "root";
  $DBPASS       = "1234";
  $DBNAME       = "ir"; 
  $connection = mysqli_connect($DBHOST, $DBUSER , $DBPASS , $DBNAME);
  
  
  //connection established - now do query
   if (strpos($term, '!') !== false){        //if word contains the NOT
    $term = str_replace('!', '', $term);    //clear term from !
    $query = "SELECT * FROM word_list NATURAL JOIN file_list WHERE file_list.file_number not in 
              (SELECT file_list.file_number FROM word_list NATURAL JOIN file_list WHERE word = '$term') 
              GROUP BY file_name ORDER BY occurrences DESC";   //prepare query  
    } else {
      $query = "SELECT * FROM word_list NATURAL JOIN file_list WHERE word = '$term' ORDER BY occurrences DESC";   //prepare query
    }
  
  $result = mysqli_query($connection, $query);    //execute it
  $result = mysqli_fetch_all($result, MYSQLI_ASSOC);    //fetch all answers Assoc - all field names
  if ($result) return $result;    //if exist, return it
  return [];        //if doesnt exist, return empty array
}

//findWord - this function is the second stop of the search - gets a term to search in the stop_word_table
function findStopWord($term){
  $term = str_replace('"', '', $term);    //clear term from "
  array_push($_SESSION['lookup'], $term);   //store term to show in file later
  $DBHOST       = "localhost";
  $DBUSER       = "root";
  $DBPASS       = "1234";
  $DBNAME       = "ir"; 
  $connection = mysqli_connect($DBHOST, $DBUSER , $DBPASS , $DBNAME);
  
  //connection established - now do query
  if (strpos($term, '!') !== false){        //if word contains the NOT
    $term = str_replace('!', '', $term);    //clear term from !
    $query = "SELECT * FROM stop_list NATURAL JOIN file_list WHERE file_list.file_number not in 
              (SELECT file_list.file_number FROM word_list NATURAL JOIN file_list WHERE word = '$term') 
              GROUP BY file_name ORDER BY occurrences DESC";   //prepare query  
  } else {
    $query = "SELECT * FROM stop_list NATURAL JOIN file_list WHERE word = '$term' ORDER BY occurrences DESC";   //prepare query
  }
  $result = mysqli_query($connection, $query);    //execute it
  $result = mysqli_fetch_all($result, MYSQLI_ASSOC);        //fetch all answers Assoc - all field names
  if ($result) return $result;      //if exist, return it
  return [];        //if doesnt exist, return empty array
}




//here is the first step of the search - gets a term  - called from processTerms
function search($term){
  if (strpos($term, '"') === false) return findWord($term);   //if the term contains " which indicates a stop-list word
  else return findStopWord($term);                  //search the term in the stop-list table and return it
}


function filterFileName($v1,$v2)  {                   //this function returns 0 if they are similar
  return strcmp($v1['file_name'], $v2['file_name']);
}

function intersect($arrA,$arrB){                      //do AND
	$output = array_uintersect($arrA, $arrB, "filterFileName"); //take both arrays and leave only the similar parts - calls filterFileName function
	return $output;                                             
}

function union($arrA,$arrB){                          //do OR
	$merged = array_merge($arrA,$arrB);                 //merge the answer's array - all the result's fields
	$output = array_intersect_key($merged, array_unique(array_column($merged, 'file_name')));     //after mergin the array's, remove duplicates while considering file_name
	return $output;                                     //return the merged array after duplicate elimination
}

function getRand(){                                 //creates a random key to replace the () - temporarly - hash code
  $seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
  shuffle($seed);
  $rand = '';
  foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
  return $rand;
}

//translate function - gets the input query and handle the () - if exist
  function translate(&$string){
    $translate = [];          //create an empty array
    while(strpos($string, "(") !== false) {      //check if there is ()
      preg_match('/\(([^)]+)\)/', $string, $match);         //search them
      $repl = getRand();                                     //create a random characters to replace them - hash code
      $string = str_replace($match[0],$repl,$string);       //replace the () with random character
      $translate[$repl] = makeArray($match[1]);               //call makeArray
    }
    return $translate;                                         //return the 'translated' array
  }

//makeArray - function that takes all the string and fix the syntax to compile with our format
function makeArray($string){        
  $string = preg_replace('{\s+(?!([^"]*"[^"]*")*[^"]*$)}',"~~",$string);  //replace non terminals or operands with ~~
  $string = str_replace("||"," || ",$string);                             //replace operand || with " || " - insert spaces                          
  $string = str_replace("&&"," && ",$string);                             //replace operand && with " && " - insert spaces
  $output = preg_replace('!\s+!', ' ', $string);                          //replace spaces/non spaces with only one space
  $output  = explode(" ",trim($output));                                  //split the the string into an array of terms and conditions - using the spaces
  foreach($output as &$value) $value = $string = str_replace("~~"," ",$value);  //now for each array var that we conducted from the string, replace ~~ back to spaces
  return $output;                                                                 //return the output
}

//this function gets all the terms dismanteled (arrString - all noraml terms, translate - all () terms, searchArr - empty array - will contains words to search)
function processTerms($arrString,&$translate,&$searchArr){
  $operators =["||","&&", "!"];       //this is the operands that the system can handle
  foreach ($arrString as $val)        //for each term in arrString - query terms
    if(!in_array($val,$operators))    //if it is not an operand
      if (isset($translate[$val])) processTerms($translate[$val],$translate,$searchArr);  //if there is () - start handling them by calling this function recursivly
      else $searchArr[$val] = search($val);      //if there are no (), handle the terms - or if the recursion ended - store all query returns in searchArr array    
}

function finalSearch($arrString,&$translate,&$searchArr){
  $first = array_shift($arrString);                           //Get first term
  if (!isset($searchArr[$first])) $searchArr[$first] = finalSearch($translate[$first],$translate,$searchArr); //If it is a generated term inside() and we dont have it searched, search it
  if(!$arrString) return $searchArr[$first];    //If itś a single term with out conditions or with () - nothing to do\already did - return it
  while ($arrString){     //if not a single term - while there are terms - terms are in groups of 3 - term, operand, term
    $oper = array_shift($arrString);    //get the operand - after a term comes the opernad
    $second = array_shift($arrString);  //get the second term - 3 variable in array
    if (!isset($searchArr[$second]))    //if the second is XXXX which means inside ()
      $searchArr[$second] = finalSearch($translate[$second],$translate,$searchArr);   //If it is a generated term inside() and we dont have it searched, search it
    if (isset($response)) $response = doOper($response,$searchArr[$second],$oper);    //else we do OR/AND with what we already have - or finished the recursion
    else $response = doOper($searchArr[$first],$searchArr[$second],$oper);            //If it is the first round - start computing it
  }
  return $response;                                             //return the response - total answer from the function
}
