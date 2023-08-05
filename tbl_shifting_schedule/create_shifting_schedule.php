<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
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

$shifting_schedule_id = 0;
$query = "SELECT * FROM tbl_shifting_schedule
ORDER BY shifting_schedule_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$shifting_schedule_id = $User['shifting_schedule_id'];
}
$shifting_schedule_id++;

$generated_code = GenerateDisplayId("SHIFTING-SCHEDULE", $shifting_schedule_id);

$sql = "INSERT INTO tbl_shifting_schedule VALUES ($shifting_schedule_id,'$generated_code','$shifting_schedule_time_from', '$shifting_schedule_time_to','$shifting_schedule_break_time_from', '$shifting_schedule_break_time_to','$shifting_schedule_monday','$shifting_schedule_tuesday','$shifting_schedule_wednesday','$shifting_schedule_thursday','$shifting_schedule_friday','$shifting_schedule_saturday','$shifting_schedule_sunday','$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW SHIFTING SCHEDULE",$shifting_schedule_id, "CREATE","New shifting schedule successfully saved<br>New Information<br>Shifting Time: $shifting_schedule_time_from TO $shifting_schedule_time_to<br>Shift Break: $shifting_schedule_break_time_from TO $shifting_schedule_break_time_to<br>Monday: $shifting_schedule_monday <br>Tuesday: $shifting_schedule_tuesday <br>Wednesday: $shifting_schedule_wednesday <br>Thursday: $shifting_schedule_thursday <br>Friday: $shifting_schedule_friday <br>Saturday: $shifting_schedule_saturday <br>Sunday $shifting_schedule_sunday <br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Shifting Schedule Error: ".$connection->error." || ".$sql;
}
?>