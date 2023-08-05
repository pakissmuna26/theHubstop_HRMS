<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$payroll_person_id = add_escape_character($obj->payroll_person_id);
$payroll_month = add_escape_character($obj->payroll_month);
$payroll_year = add_escape_character($obj->payroll_year);
$payroll_period_id = add_escape_character($obj->payroll_period_id);
$payroll_salary = add_escape_character($obj->payroll_salary);
$payroll_absent_adjustment = add_escape_character($obj->payroll_absent_adjustment);
$payroll_overtime = add_escape_character($obj->payroll_overtime);
$payroll_non_taxable_earnings = add_escape_character($obj->payroll_non_taxable_earnings);
$payroll_deductions = add_escape_character($obj->payroll_deductions);
$payroll_withholding_tax = add_escape_character($obj->payroll_withholding_tax);
$payroll_net_pay = add_escape_character($obj->payroll_net_pay);

$obj_attendance_id = json_decode($_GET["attendance_id"], false);

$obj_benefits_id = json_decode($_GET["benefits_id"], false);
$obj_benefits_amount = json_decode($_GET["benefits_amount"], false);
$obj_deduction_id = json_decode($_GET["deduction_id"], false);
$obj_deduction_amount = json_decode($_GET["deduction_amount"], false);
$obj_deduction_amount_company_share=json_decode($_GET["deduction_amount_company_share"],false);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$payroll_id = 0;
$query = "SELECT * FROM tbl_payroll
ORDER BY payroll_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$payroll_id = $User['payroll_id'];
}
$payroll_id++;

$generated_code = GenerateDisplayId("PAYROLL", $payroll_id);
$sql = "INSERT INTO tbl_payroll VALUES ($payroll_id,'$generated_code', $payroll_person_id,$payroll_month, $payroll_year, $payroll_period_id, $payroll_salary, $payroll_absent_adjustment, $payroll_overtime, $payroll_non_taxable_earnings,$payroll_deductions,$payroll_withholding_tax,$payroll_net_pay,'$dateEncoded @ $timeEncoded','Saved',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	$name = PersonName($payroll_person_id);
	Create_Logs("NEW PAYROLL",$payroll_id, "CREATE","New payroll successfully saved<br>New Information<br>Name: $name<br>Salary: $payroll_salary<br>Absent Adjustment: $payroll_absent_adjustment<br>Overtime: $payroll_overtime<br>Non-Taxable Earnings: $payroll_non_taxable_earnings<br>Deductions: $payroll_deductions<br>Withholding Tax: $payroll_withholding_tax<br>Net Pay: $payroll_net_pay<br>Status: Saved",$signedin_person_id);

	$total_counter=0;
	$error = "";
	for($index=0; $index < COUNT($obj_attendance_id); $index++){
		$attendance_id=$obj_attendance_id[$index];
		
		$sqlAttendance = "UPDATE tbl_attendance 
		SET payroll_id = $payroll_id, 
		attendance_status = \"Payroll\"
		WHERE attendance_id = $attendance_id";
		if(mysqli_query($connection, $sqlAttendance)){
			$total_counter++;
		}else{
			$error.="Updating Contract Leave Credit Status Error: ".$connection->error." || ".$sqlAttendance." ";
		}

	}

	for($index=0; $index < COUNT($obj_benefits_id); $index++){
		$benefits_id=$obj_benefits_id[$index];
		$benefits_amount=$obj_benefits_amount[$index];
		
		date_default_timezone_set("Asia/Manila");
		$dateEncoded = date("Y-m-d");
		$timeEncoded = date("h:i:s A");

		$payroll_benefits_deduction_id = 0;
		$query = "SELECT * FROM tbl_payroll_benefits_deduction
		ORDER BY payroll_benefits_deduction_id ASC";
		$Users = mysqli_query($connection, $query);
		while ($User = mysqli_fetch_array($Users)) {
			$payroll_benefits_deduction_id = $User['payroll_benefits_deduction_id'];
		}
		$payroll_benefits_deduction_id++;
		$generated_code = GenerateDisplayId("PAYROLL-BENEFITS", $payroll_benefits_deduction_id);
		$sqlBenefits = "INSERT INTO tbl_payroll_benefits_deduction VALUES ($payroll_benefits_deduction_id,'$generated_code',$payroll_id,$benefits_id,$benefits_amount,0,'Benefits' ,'$dateEncoded @ $timeEncoded','Saved',$signedin_person_id)";
		if(mysqli_query($connection, $sqlBenefits)){	
			$total_counter++;
		}else{
			$error.="<br>Benefits Error: ".$connection->error." || ".$sqlBenefits." ";	
		}
	}

	for($index=0; $index < COUNT($obj_deduction_id); $index++){
		$deduction_id=$obj_deduction_id[$index];
		$deduction_amount=$obj_deduction_amount[$index];
		$deduction_amount_company_share=$obj_deduction_amount_company_share[$index];
		
		date_default_timezone_set("Asia/Manila");
		$dateEncoded = date("Y-m-d");
		$timeEncoded = date("h:i:s A");

		$payroll_benefits_deduction_id = 0;
		$query = "SELECT * FROM tbl_payroll_benefits_deduction
		ORDER BY payroll_benefits_deduction_id ASC";
		$Users = mysqli_query($connection, $query);
		while ($User = mysqli_fetch_array($Users)) {
			$payroll_benefits_deduction_id = $User['payroll_benefits_deduction_id'];
		}
		$payroll_benefits_deduction_id++;
		$generated_code = GenerateDisplayId("PAYROLL-DEDUCTION", $payroll_benefits_deduction_id);
		$sqlDeduction = "INSERT INTO tbl_payroll_benefits_deduction VALUES ($payroll_benefits_deduction_id,'$generated_code',$payroll_id,$deduction_id,$deduction_amount,$deduction_amount_company_share,'Deduction' ,'$dateEncoded @ $timeEncoded','Saved',$signedin_person_id)";
		if(mysqli_query($connection, $sqlDeduction)){	
			$total_counter++;
		}else{	
			$error.="<br>DEduction Error: ".$connection->error." || ".$sqlDeduction." ";	
		}
	}

	$total_entry = COUNT($obj_attendance_id) + COUNT($obj_benefits_id) + COUNT($obj_deduction_id);
	if($total_entry == $total_counter){
		echo true;
	}else{
		echo $error;
	}
}else{
	echo "Payroll Error: ".$connection->error." || ".$sql;
}
?>