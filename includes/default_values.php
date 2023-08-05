<?php 
	date_default_timezone_set("Asia/Manila");
	$dateEncoded = date("Y-m-d");
	$timeEncoded = date("h:i:s A");
?>

<?php 
	
	global $connection;
	$noData = 0;
	$query = "SELECT * FROM tbl_person";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$noData++;
	}
	if($noData == 0){
		date_default_timezone_set("Asia/Manila");
		$Date = date("Y-m-d");
		$Time = date("h:i:sa");
		global $connection;
		$generated_code = GenerateDisplayId("PERSON", 1);
		$password=password_hash(add_escape_character("default123"), PASSWORD_DEFAULT);
		$sql = "INSERT INTO tbl_person 
		VALUES (1,'$generated_code','Christian','Alvarez','Jaramillo','','0000-00-00','Male','Single','','','','','','christian@gmail.com','','','$password',0,0,'','','','','','','','','','','','$Date @ $Time', 'Activated',1,1, '')";
		if(mysqli_query($connection, $sql)){
		}else{
			echo "Person Error: ".$connection->error." || ".$sql;
		}
	}
	else{
	}
?>