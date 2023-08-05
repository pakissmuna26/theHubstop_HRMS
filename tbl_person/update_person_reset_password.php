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
$password = add_escape_character($obj->password);
$generated_password=password_hash(add_escape_character($password), PASSWORD_DEFAULT);


date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_person 
SET password = '$generated_password'
WHERE person_id = $person_id";
if(mysqli_query($connection, $sql)){
	
	$name = PersonName($person_id);
	Create_Logs("UPDATE PERSON PASSWORD",$person_id, "UPDATE","Updating of person password successfully saved<br>Name: $name",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Person Password Error: ".$connection->error." || ".$sql;
}
?>