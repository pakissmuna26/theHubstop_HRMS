<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$attendance_id = add_escape_character($obj->attendance_id);
$past_tense_status = add_escape_character($obj->past_tense_status);
$present_tense_status = add_escape_character($obj->present_tense_status);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_attendance 
SET attendance_status = '$past_tense_status',
attendance_approved_by = $signedin_person_id
WHERE attendance_id = $attendance_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE ATTENDANCE STATUS",$attendance_id, "UPDATE","Updating of attendance status successfully saved<br>Status: $past_tense_status",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Attendance Status Error: ".$connection->error." || ".$sql;
}
?>