<?php
	$server="localhost";
	$user="root";
	$pass="";
	$name="hubstop_hrms";
	$connection = mysqli_connect($server,$user,$pass,$name);
	if(!$connection){
		die("");
	}

	$db = new PDO('mysql:host='.$server.';dbname='.$name, $user, $pass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>