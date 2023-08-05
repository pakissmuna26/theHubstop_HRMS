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
$payroll_period_title = add_escape_character($obj->payroll_period_title);
$payroll_period_from = add_escape_character($obj->payroll_period_from);
$payroll_period_to = add_escape_character($obj->payroll_period_to);
$payroll_period_cutoff_from = add_escape_character($obj->payroll_period_cutoff_from);
$payroll_period_cutoff_to = add_escape_character($obj->payroll_period_cutoff_to);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_payroll_period 
SET payroll_period_title = '$payroll_period_title',
payroll_period_from = $payroll_period_from,
payroll_period_to = $payroll_period_to,
payroll_period_cutoff_from = '$payroll_period_cutoff_from',
payroll_period_cutoff_to = '$payroll_period_cutoff_to'
WHERE payroll_period_id = $payroll_period_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE PAYROLL PERIOD",$payroll_period_id, "UPDATE","Updating payroll period successfully saved<br>New Information<br>Payroll Period Title: $payroll_period_title<br>Payroll Day: $payroll_period_from TO $payroll_period_to<br>Payrol Period: $payroll_period_cutoff_from TO $payroll_period_cutoff_to",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Payroll Period Error: ".$connection->error." || ".$sql;
}
?>