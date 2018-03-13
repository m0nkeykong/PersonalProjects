<?php 
$DBHOST       = "localhost";
$DBUSER       = "root";
$DBPASS       = "1234";
$DBNAME       = "ir"; 

$connection = mysqli_connect($DBHOST, $DBUSER , $DBPASS , $DBNAME);

mysqli_query($connection,"SET NAMES 'utf8'") or die(mysql_error());

if(mysqli_connect_errno()) {
	die("DB connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}
?>