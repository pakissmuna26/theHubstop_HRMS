<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$person_id = add_escape_character($obj->person_id);
$rfid = add_escape_character($obj->rfid);


date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_person 
SET person_rfid = '$rfid'
WHERE person_id = $person_id";
if(mysqli_query($connection, $sql)){
	
	$name = PersonName($person_id);
	Create_Logs("UPDATE RFID",$person_id, "UPDATE","Updating of RFID successfully saved<br>Name: $name<br>RFID: $rfid",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating RFID Error: ".$connection->error." || ".$sql;
}
?>