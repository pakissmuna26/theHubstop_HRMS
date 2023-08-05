<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$payroll_period_id = add_escape_character($obj->payroll_period_id);
$past_tense_status = add_escape_character($obj->past_tense_status);
$present_tense_status = add_escape_character($obj->present_tense_status);


date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_payroll_period 
SET payroll_period_status = '$past_tense_status'
WHERE payroll_period_id = $payroll_period_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE PAYROLL PERIOD STATUS",$payroll_period_id, "UPDATE","Updating of payroll period status successfully saved<br>Status: $past_tense_status",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Payroll Period Status Error: ".$connection->error." || ".$sql;
}
?>