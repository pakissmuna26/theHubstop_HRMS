<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_id = add_escape_character($obj->contract_id);
$payroll_period_id = add_escape_character($obj->payroll_period_id);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$existed=false;
$query = "SELECT * FROM tbl_contract_payroll_period WHERE contract_id=$contract_id AND payroll_period_id=$payroll_period_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$existed=true;
}

if($existed){
	echo "Payroll period is already existed.";
}else{
	$contract_payroll_period_id = 0;
	$query = "SELECT * FROM tbl_contract_payroll_period
	ORDER BY contract_payroll_period_id ASC";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$contract_payroll_period_id = $User['contract_payroll_period_id'];
	}
	$contract_payroll_period_id++;

	$generated_code = GenerateDisplayId("CONTRACT-PAYROLL", $contract_payroll_period_id);

	$sql = "INSERT INTO tbl_contract_payroll_period VALUES ($contract_payroll_period_id,'$generated_code',$contract_id,$payroll_period_id,'$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
	if(mysqli_query($connection, $sql)){	

		Create_Logs("NEW CONTRACT PAYROLL",$contract_payroll_period_id, "CREATE","New contract payroll successfully saved<br>New Information<br>Status: Activated",$signedin_person_id);

		echo true;
	}else{
		echo "Registration was failed, Please try again.";
	}
}

?>