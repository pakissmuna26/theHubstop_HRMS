<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$payroll_period_title = add_escape_character($obj->payroll_period_title);
$payroll_period_from = add_escape_character($obj->payroll_period_from);
$payroll_period_to = add_escape_character($obj->payroll_period_to);
$payroll_period_cutoff_from = add_escape_character($obj->payroll_period_cutoff_from);
$payroll_period_cutoff_to = add_escape_character($obj->payroll_period_cutoff_to);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$payroll_period_id = 0;
$query = "SELECT * FROM tbl_payroll_period
ORDER BY payroll_period_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$payroll_period_id = $User['payroll_period_id'];
}
$payroll_period_id++;

$generated_code = GenerateDisplayId("PAYROLL-PERIOD", $payroll_period_id);

$sql = "INSERT INTO tbl_payroll_period VALUES ($payroll_period_id,'$generated_code','$payroll_period_title', $payroll_period_from, $payroll_period_to, '$payroll_period_cutoff_from', '$payroll_period_cutoff_to','$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW PAYROLL PERIOD",$payroll_period_id, "CREATE","New payroll period successfully saved<br>New Information<br>Payroll Period Title: $payroll_period_title<br>Payroll Day: $payroll_period_from TO $payroll_period_to<br>Payrol Period: $payroll_period_cutoff_from TO $payroll_period_cutoff_to<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Payroll Period Error: ".$connection->error." || ".$sql;
}
?>