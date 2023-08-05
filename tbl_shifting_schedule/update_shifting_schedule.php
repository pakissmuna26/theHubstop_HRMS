<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$shifting_schedule_id = add_escape_character($obj->shifting_schedule_id);
$shifting_schedule_time_from = add_escape_character($obj->shifting_schedule_time_from);
$shifting_schedule_time_to = add_escape_character($obj->shifting_schedule_time_to);
$shifting_schedule_break_time_from = add_escape_character($obj->shifting_schedule_break_time_from);
$shifting_schedule_break_time_to = add_escape_character($obj->shifting_schedule_break_time_to);

$shifting_schedule_monday = add_escape_character($obj->shifting_schedule_monday);
$shifting_schedule_tuesday = add_escape_character($obj->shifting_schedule_tuesday);
$shifting_schedule_wednesday = add_escape_character($obj->shifting_schedule_wednesday);
$shifting_schedule_thursday = add_escape_character($obj->shifting_schedule_thursday);
$shifting_schedule_friday = add_escape_character($obj->shifting_schedule_friday);
$shifting_schedule_saturday = add_escape_character($obj->shifting_schedule_saturday);
$shifting_schedule_sunday = add_escape_character($obj->shifting_schedule_sunday);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_shifting_schedule 
SET shifting_schedule_time_from = '$shifting_schedule_time_from',
shifting_schedule_time_to = '$shifting_schedule_time_to',
shifting_schedule_break_time_from = '$shifting_schedule_break_time_from',
shifting_schedule_break_time_to = '$shifting_schedule_break_time_to',
shifting_schedule_monday = '$shifting_schedule_monday',
shifting_schedule_tuesday = '$shifting_schedule_tuesday',
shifting_schedule_wednesday = '$shifting_schedule_wednesday',
shifting_schedule_thursday = '$shifting_schedule_thursday',
shifting_schedule_friday = '$shifting_schedule_friday',
shifting_schedule_saturday = '$shifting_schedule_saturday',
shifting_schedule_sunday = '$shifting_schedule_sunday'
WHERE shifting_schedule_id = $shifting_schedule_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE SHIFTING SCHEDULE",$shifting_schedule_id, "UPDATE","Updating shifting schedule successfully saved<br>New Information<br>Shifting Time: $shifting_schedule_time_from TO $shifting_schedule_time_to<br>Shift Break: $shifting_schedule_break_time_from TO $shifting_schedule_break_time_to<br>Monday: $shifting_schedule_monday <br>Tuesday: $shifting_schedule_tuesday <br>Wednesday: $shifting_schedule_wednesday <br>Thursday: $shifting_schedule_thursday <br>Friday: $shifting_schedule_friday <br>Saturday: $shifting_schedule_saturday <br>Sunday $shifting_schedule_sunday",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Shifting Schedule Error: ".$connection->error." || ".$sql;
}
?>