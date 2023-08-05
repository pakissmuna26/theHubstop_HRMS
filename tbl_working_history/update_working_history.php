<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$work_history_id = add_escape_character($obj->work_history_id);
$work_history_job_title = add_escape_character($obj->work_history_job_title);
$work_history_job_responsibilities = add_escape_character($obj->work_history_job_responsibilities);
$work_history_date_from = add_escape_character($obj->work_history_date_from);
$work_history_date_to = add_escape_character($obj->work_history_date_to);
$work_history_company = add_escape_character($obj->work_history_company);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_work_history 
SET work_history_job_title = '$work_history_job_title',
work_history_job_responsibilities = '$work_history_job_responsibilities',
work_history_date_from = '$work_history_date_from',
work_history_date_to = '$work_history_date_to',
work_history_company = '$work_history_company' 
WHERE work_history_id = $work_history_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE WORK HISTORY",$work_history_id, "UPDATE","Updating work history successfully saved<br>New Information<br>Job Title: $work_history_job_title<br>Job Responsobilities: $work_history_job_responsibilities<br>Work Date: $work_history_date_from TO $work_history_date_to<br>Company: $work_history_company",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Work History Error: ".$connection->error." || ".$sql;
}
?>