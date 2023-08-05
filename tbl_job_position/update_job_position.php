<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$job_position_id = add_escape_character($obj->job_position_id);
$job_position_title = add_escape_character($obj->job_position_title);
$job_position_description = add_escape_character($obj->job_position_description);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_job_position 
SET job_position_title = '$job_position_title',
job_position_description = '$job_position_description'
WHERE job_position_id = $job_position_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE JOB POSITION",$job_position_id, "UPDATE","Updating job position successfully saved<br>New Information<br>Job Position Title: $job_position_title<br>Job Position Description: job_position_description",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Job Position Error: ".$connection->error." || ".$sql;
}
?>