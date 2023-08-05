<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$applicant_id = add_escape_character($obj->applicant_id);
$contract_id = add_escape_character($obj->contract_id);
$application_category = add_escape_character($obj->application_category);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$applicant_application_id = 0;
$query = "SELECT * FROM tbl_applicant_application
ORDER BY applicant_application_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$applicant_application_id = $User['applicant_application_id'];
}
$applicant_application_id++;

$application_history_id = 0;
$query = "SELECT * FROM tbl_application_history
ORDER BY application_history_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$application_history_id = $User['application_history_id'];
}
$application_history_id++;


$generated_code = GenerateDisplayId("JOB-APPLICATION", $applicant_application_id);
$generated_code_history = GenerateDisplayId("JOB-APPLICATION-HISTORY", $application_history_id);

$sql = "INSERT INTO tbl_applicant_application VALUES ($applicant_application_id,'$generated_code',$applicant_id, $contract_id, '$application_category','','Pending','','','$dateEncoded @ $timeEncoded','Pending',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	$name = PersonName($applicant_id);
	Create_Logs("NEW JOB APPLICATION",$applicant_application_id, "CREATE","New job application successfully saved<br>New Information<br>Applicant Name: $name<br>Category: $application_category<br>Status: Pending",$signedin_person_id);

	$sql_history = "INSERT INTO tbl_application_history VALUES ($application_history_id,'$generated_code_history',$applicant_application_id, '$application_category','For Confirmation','','','','','$dateEncoded @ $timeEncoded','Pending',$signedin_person_id)";
	if(mysqli_query($connection, $sql_history)){	

		$name = PersonName($applicant_id);
		Create_Logs("NEW JOB APPLICATION HISTORY",$applicant_application_id, "CREATE","New job history application successfully saved<br>New Information<br>Applicant Name: $name<br>Category: $application_category<br>Status: Pending",$signedin_person_id);

		echo true;
	}else{
		echo "Job Application History Error: ".$connection->error." || ".$sql_history;
	}

}else{
	echo "Job Application Error: ".$connection->error." || ".$sql;
}
?>