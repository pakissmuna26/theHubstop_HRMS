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
$attendance_type = add_escape_character($obj->attendance_type);
$attendance_date_in = add_escape_character($obj->attendance_date_in);
$attendance_time_in = add_escape_character($obj->attendance_time_in);
$attendance_date_out = add_escape_character($obj->attendance_date_out);
$attendance_time_out = add_escape_character($obj->attendance_time_out);
$attendance_requested_by = add_escape_character($obj->attendance_requested_by);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_attendance 
SET attendance_date_in = '$attendance_date_in',
attendance_time_in = '$attendance_time_in',
attendance_date_out = '$attendance_date_out',
attendance_time_out = '$attendance_time_out',
attendance_requested_by = $attendance_requested_by,
attendance_type = '$attendance_type'
WHERE attendance_id = $attendance_id";
if(mysqli_query($connection, $sql)){
	
	$attendance_requested_by_name = PersonName($attendance_requested_by);
	Create_Logs("UPDATE ATTENDANCE",$attendance_id, "UPDATE","Updating attendance successfully saved<br>New Information<br>Type: $attendance_type<br>Time-In: $attendance_date_in @ $attendance_time_in<br>Time-Out: $attendance_date_out @ $attendance_time_out<br>Requested By: $attendance_requested_by_name",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Attendance Error: ".$connection->error." || ".$sql;
}
?>