<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$work_history_applicant_id = add_escape_character($obj->work_history_applicant_id);
$work_history_job_title = add_escape_character($obj->work_history_job_title);
$work_history_job_responsibilities = add_escape_character($obj->work_history_job_responsibilities);
$work_history_date_from = add_escape_character($obj->work_history_date_from);
$work_history_date_to = add_escape_character($obj->work_history_date_to);
$work_history_company = add_escape_character($obj->work_history_company);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$work_history_id = 0;
$query = "SELECT * FROM tbl_work_history
ORDER BY work_history_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$work_history_id = $User['work_history_id'];
}
$work_history_id++;

$generated_code = GenerateDisplayId("WORK-HISTORY", $work_history_id);

$sql = "INSERT INTO tbl_work_history VALUES ($work_history_id,'$generated_code',$work_history_applicant_id, '$work_history_job_title', '$work_history_job_responsibilities', '$work_history_date_from', '$work_history_date_to', '$work_history_company','$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	$name = PersonName($work_history_applicant_id);
	Create_Logs("NEW WORK HISTORY",$work_history_id, "CREATE","New work history successfully saved<br>New Information<br>Employee Name: $name<br>Job Title: $work_history_job_title<br>Job Responsobilities: $work_history_job_responsibilities<br>Work Date: $work_history_date_from TO $work_history_date_to<br>Company: $work_history_company<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Work History Error: ".$connection->error." || ".$sql;
}
?>