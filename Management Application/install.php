<?php

require "config.php";
try
{
  $db = new PDO("mysql:host=$host", $username, $password, $options);
	$sql = file_get_contents("data/init.sql");
	$db->exec($sql);
}

catch(PDOException $error)
{
	echo $sql . "<br>" . $error->getMessage();
}

?>
