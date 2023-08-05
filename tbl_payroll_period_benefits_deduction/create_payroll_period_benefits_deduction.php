<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_payroll_period_id = add_escape_character($obj->contract_payroll_period_id);

$obj_benefits = json_decode($_GET["data_benefits"], false);
$obj_deduction = json_decode($_GET["data_deduction"], false);

$benefits_counter=0;
$benefits_error="";
for($index=0; $index < COUNT($obj_benefits); $index++){
	$benefits_id=$obj_benefits[$index];

	date_default_timezone_set("Asia/Manila");
	$dateEncoded = date("Y-m-d");
	$timeEncoded = date("h:i:s A");

	$payroll_period_benefits_deduction_id = 0;
	$query = "SELECT * FROM tbl_payroll_period_benefits_deduction
	ORDER BY payroll_period_benefits_deduction_id ASC";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$payroll_period_benefits_deduction_id = $User['payroll_period_benefits_deduction_id'];
	}
	$payroll_period_benefits_deduction_id++;

	$generated_code = GenerateDisplayId("CONTRACT-BENEFITS", $payroll_period_benefits_deduction_id);

	$sql = "INSERT INTO tbl_payroll_period_benefits_deduction VALUES ($payroll_period_benefits_deduction_id,'$generated_code',$contract_payroll_period_id,$benefits_id, 'Benefits','$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
	if(mysqli_query($connection, $sql)){	

		Create_Logs("NEW CONTRACT BENEFITS",$payroll_period_benefits_deduction_id, "CREATE","New contract benefits successfully saved<br>New Information<br>Status: Activated",$signedin_person_id);

		$benefits_counter++;
	}else{
		$benefits_error.= "Benefits Error: ".$connection->error." || ".$sql;
	}
}

$deduction_counter=0;
$deduction_error="";
for($index=0; $index < COUNT($obj_deduction); $index++){
	$benefits_id=$obj_deduction[$index];

	date_default_timezone_set("Asia/Manila");
	$dateEncoded = date("Y-m-d");
	$timeEncoded = date("h:i:s A");

	$payroll_period_benefits_deduction_id = 0;
	$query = "SELECT * FROM tbl_payroll_period_benefits_deduction
	ORDER BY payroll_period_benefits_deduction_id ASC";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$payroll_period_benefits_deduction_id = $User['payroll_period_benefits_deduction_id'];
	}
	$payroll_period_benefits_deduction_id++;

	$generated_code = GenerateDisplayId("CONTRACT-DEDUCTION", $payroll_period_benefits_deduction_id);

	$sql = "INSERT INTO tbl_payroll_period_benefits_deduction VALUES ($payroll_period_benefits_deduction_id,'$generated_code',$contract_payroll_period_id,$benefits_id, 'Deduction','$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
	if(mysqli_query($connection, $sql)){	

		Create_Logs("NEW CONTRACT DEDUCTION",$payroll_period_benefits_deduction_id, "CREATE","New contract deduction successfully saved<br>New Information<br>Status: Activated",$signedin_person_id);

		$deduction_counter++;
	}else{
		$deduction_error.= "deduction Error: ".$connection->error." || ".$sql;
	}
}

if(COUNT($obj_benefits) == $benefits_counter && COUNT($obj_deduction) == $deduction_counter){
	echo true;
}else{
	echo $benefits_error." || ".$deduction_error;
}
?>