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
$past_tense_status = add_escape_character($obj->past_tense_status);
$present_tense_status = add_escape_character($obj->present_tense_status);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_applicant_application 
SET application_status = '$past_tense_status'
WHERE applicant_application_id = $applicant_application_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE JOB APPLICATION STATUS",$applicant_application_id, "UPDATE","Updating of job application status successfully saved<br>Status: $past_tense_status",$signedin_person_id);
	
	$sql_history = "UPDATE tbl_application_history 
	SET application_history_status = '$past_tense_status'
	WHERE applicant_application_id = $applicant_application_id AND  
	history_category=\"Application Submitted\"";
	if(mysqli_query($connection, $sql_history)){
		echo true;
	}else{
		echo "Updating Job Application History Status Error: ".$connection->error." || ".$sql_history;
	}
}else{
	echo "Updating Job Application Status Error: ".$connection->error." || ".$sql;
}
?>