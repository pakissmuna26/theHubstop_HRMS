<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$attendance_category = add_escape_character($obj->attendance_category);
$attendance_type = add_escape_character($obj->attendance_type);
$attendance_date_in = add_escape_character($obj->attendance_date_in);
$attendance_time_in = add_escape_character($obj->attendance_time_in);
$attendance_date_out = add_escape_character($obj->attendance_date_out);
$attendance_time_out = add_escape_character($obj->attendance_time_out);
$attendance_requested_by = add_escape_character($obj->attendance_requested_by);
$attendance_approved_by = add_escape_character($obj->attendance_approved_by);
$status = add_escape_character($obj->status);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$attendance_id = 0;
$query = "SELECT * FROM tbl_attendance
ORDER BY attendance_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$attendance_id = $User['attendance_id'];
}
$attendance_id++;

$generated_code = GenerateDisplayId("ATTENDANCE", $attendance_id);

$sql = "INSERT INTO tbl_attendance VALUES ($attendance_id,'$generated_code','$attendance_category','$attendance_type','$attendance_date_in', '$attendance_time_in','$attendance_date_out', '$attendance_time_out', $attendance_requested_by,$attendance_approved_by,'$dateEncoded @ $timeEncoded','$status',$signedin_person_id, 0)";
if(mysqli_query($connection, $sql)){	

	$attendance_requested_by_name = PersonName($attendance_requested_by);
	$attendance_approved_by_name = PersonName($attendance_approved_by);
	Create_Logs("NEW ATTENDANCE",$attendance_id, "CREATE","New attendance successfully saved<br>New Information<br>Category: $attendance_category<br>Type: $attendance_type<br>Time-In: $attendance_date_in @ $attendance_time_in<br>Time-Out: $attendance_date_out @ $attendance_time_out<br>Requested By: $attendance_requested_by_name<br>Approved By: $attendance_approved_by_name<br>Status: $status",$signedin_person_id);

	echo true;
}else{
	echo "Attendance Error: ".$connection->error." || ".$sql;
}
?>