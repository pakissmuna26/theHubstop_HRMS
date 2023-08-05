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
$application_contract_start_date = add_escape_character($obj->application_contract_start_date);
$past_tense_status = add_escape_character($obj->past_tense_status);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

if($past_tense_status == "Activated"){
	$sql = "UPDATE tbl_applicant_application 
	SET application_contract_start_date = '$application_contract_start_date', 
	application_contract_status = '$past_tense_status'
	WHERE applicant_application_id = $applicant_application_id";
	if(mysqli_query($connection, $sql)){
		echo true;
	}else{
		echo "Updating Job Application Contract Status Error: ".$connection->error." || ".$sql;
	}
}else if($past_tense_status == "Deactivated"){
	$sql = "UPDATE tbl_applicant_application 
	SET application_contract_end_date = '$application_contract_start_date', 
	application_contract_status = '$past_tense_status'
	WHERE applicant_application_id = $applicant_application_id";
	if(mysqli_query($connection, $sql)){
		echo true;
	}else{
		echo "Updating Job Application Contract Status Error: ".$connection->error." || ".$sql;
	}
}
?>