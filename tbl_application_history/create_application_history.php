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
$history_category = add_escape_character($obj->history_category);
$history_title = add_escape_character($obj->history_title);
$history_description = add_escape_character($obj->history_description);
$history_date = add_escape_character($obj->history_date);
$history_time = add_escape_character($obj->history_time);
$history_remarks = add_escape_character($obj->history_remarks);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$application_history_id = 0;
$query = "SELECT * FROM tbl_application_history
ORDER BY application_history_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$application_history_id = $User['application_history_id'];
}
$application_history_id++;

$generated_code = GenerateDisplayId("JOB-APPLICATION-HISTORY", $application_history_id);

$sql = "INSERT INTO tbl_application_history VALUES ($application_history_id,'$generated_code',$applicant_application_id, '$history_category','$history_title','$history_description','$history_date','$history_time','$history_remarks','$dateEncoded @ $timeEncoded','Scheduled',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW JOB APPLICATION HISTORY",$application_history_id, "CREATE","New job history application successfully saved<br>New Information<br>Category: $history_category<br>Title: $history_title<br>Description: $history_description<br>Date: $history_date<br>Time: $history_time<br>Remarks: $history_remarks<br>Status: Scheduled",$signedin_person_id);
	
	echo true;
}else{
	echo "Job Application History Error: ".$connection->error." || ".$sql;
}
?>