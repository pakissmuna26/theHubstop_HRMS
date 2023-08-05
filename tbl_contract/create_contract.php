<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_title = add_escape_character($obj->contract_title);
$contract_description = add_escape_character($obj->contract_description);
$contract_application_date_from = add_escape_character($obj->contract_application_date_from);
$contract_application_date_to = add_escape_character($obj->contract_application_date_to);
$contract_starting_date = add_escape_character($obj->contract_starting_date);
$contract_job_position_id = add_escape_character($obj->contract_job_position_id);
$contract_rate = add_escape_character($obj->contract_rate);
$contract_shifting_schedule_id = add_escape_character($obj->contract_shifting_schedule_id);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$contract_id = 0;
$query = "SELECT * FROM tbl_contract
ORDER BY contract_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$contract_id = $User['contract_id'];
}
$contract_id++;

$generated_code = GenerateDisplayId("JOB-CONTRACT", $contract_id);

$sql = "INSERT INTO tbl_contract VALUES ($contract_id,'$generated_code','$contract_title', '$contract_description', '$contract_application_date_from','$contract_application_date_to','$contract_starting_date',$contract_job_position_id,$contract_rate,$contract_shifting_schedule_id,'$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW JOB CONTRACT",$contract_id, "CREATE","New job contract successfully saved<br>New Information<br>Contract Title: $contract_title<br>Contract Description: contract_description<br>Application Date: $contract_application_date_from TO $contract_application_date_to,$contract_starting_date<br>Starting Date: $contract_starting_date<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Job Contract Error: ".$connection->error." || ".$sql;
}
?>