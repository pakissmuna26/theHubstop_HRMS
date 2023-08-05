<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$person_shifting_schedule_id = add_escape_character($obj->person_shifting_schedule_id);
$effective_date = add_escape_character($obj->effective_date);
$end_effective_date = add_escape_character($obj->end_effective_date);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_person_shifting_schedule 
SET effective_date = '$effective_date',
end_effective_date = '$end_effective_date'
WHERE person_shifting_schedule_id = $person_shifting_schedule_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE SHIFT SCHEDULE",$person_shifting_schedule_id, "UPDATE","Updating shift schedule successfully saved<br>New Information<br>Effective Date: $effective_date<br>End of Effective Date: end_effective_date",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Shift Schedule Error: ".$connection->error." || ".$sql;
}
?>