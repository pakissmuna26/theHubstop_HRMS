<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$applicant_application_id = add_escape_character($obj->applicant_application_id);
$application_history_id = add_escape_character($obj->application_history_id);
$history_category = add_escape_character($obj->history_category);
$history_title = add_escape_character($obj->history_title);
$history_description = add_escape_character($obj->history_description);
$history_date = add_escape_character($obj->history_date);
$history_time = add_escape_character($obj->history_time);
$history_remarks = add_escape_character($obj->history_remarks);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_application_history 
SET history_category = '$history_category',
history_title = '$history_title',
history_description = '$history_description',
history_date = '$history_date',
history_time = '$history_time',
history_remarks = '$history_remarks'
WHERE application_history_id = $application_history_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE JOB APPLICATION HISTORY",$application_history_id, "UPDATE","Updating job application history successfully saved<br>New Information<br>Category: $history_category<br>Title: $history_title<br>Description: $history_description<br>Date: $history_date<br>Time: $history_time<br>Remarks: $history_remarks",$signedin_person_id);
	
	// $sql_applicant = "UPDATE tbl_applicant_application 
	// SET application_category = '$history_category'
	// WHERE applicant_application_id = $applicant_application_id";
	// if(mysqli_query($connection, $sql_applicant)){
	// 	echo true;
	// }else{
	// 	echo "Job Application History Error: ".$connection->error." || ".$sql_applicant;	
	// }
	echo true;
	
}else{
	echo "Updating Job Application Error: ".$connection->error." || ".$sql;
}
?>