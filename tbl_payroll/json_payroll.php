<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_payroll ORDER BY payroll_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$payroll_period_from = $payroll_period_to = 0;
	$payroll_cutoff_from = $payroll_cutoff_to = 0;
	$query = "SELECT * FROM tbl_payroll_period 
	WHERE payroll_period_id = {$User['payroll_period_id']}";
	$payroll_periods = mysqli_query($connection, $query);
	while ($payroll_period_ = mysqli_fetch_array($payroll_periods)) {
		$payroll_period_from = $payroll_period_['payroll_period_from'];
		$payroll_period_to = $payroll_period_['payroll_period_to'];
		$payroll_cutoff_from = $payroll_period_['payroll_period_cutoff_from'];
		$payroll_cutoff_to = $payroll_period_['payroll_period_cutoff_to'];
		break;
	}
	$months = array("", "January", "February", "March", "April", "May", "June",
	"July", "August", "September", "October", "November", "December");

	$year = $User['payroll_year'];
	$month = (int)$User['payroll_month'];
	
	$from_year = $year;
	$to_year = $year;
	$payroll_date_from = $payroll_date_to = "";

	$month_description_from = $months[$month];
	if($payroll_period_from > $payroll_period_to ){
		$payroll_month = $month - 1;
		$month_description_to = $months[$payroll_month];
		if($payroll_month == 0){
			$month_description_to = $months[12];
			$from_year = $year - 1;
		}
		$payroll_date_from = "$month_description_to $payroll_period_from, $from_year"; 
		$payroll_date_to = "$month_description_from $payroll_period_to, $to_year";
	}else{
		$payroll_date_from = "$month_description_from $payroll_period_from, $year";
		$payroll_date_to = "$month_description_from $payroll_period_to, $year";
	}

	$from_year = $year;
	$to_year = $year;
	$cutoff_date_from = $cutoff_date_to = "";
	$month_description_from = $months[$month];
	if($payroll_cutoff_from > $payroll_cutoff_to ){
		$cutoff_month = $month - 1;
		$month_description_to = $months[$cutoff_month];
		if($cutoff_month == 0){
			$month_description_to = $months[12];
			$from_year = $year - 1;
		}
		$cutoff_date_from = "$month_description_to $payroll_cutoff_from, $from_year"; 
		$cutoff_date_to = "$month_description_from $payroll_cutoff_to, $to_year";
	}else{
		$cutoff_date_from="$month_description_from $payroll_cutoff_from, $year";
		$cutoff_date_to="$month_description_from $payroll_cutoff_to, $year";
	}

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['payroll_id']="{$User['payroll_id']}";
	$jsonArrayItem['payroll_code']="{$User['payroll_code']}";
	$jsonArrayItem['payroll_person_id']=$User['payroll_person_id'];
	$jsonArrayItem['payroll_person_name']=PersonName($User['payroll_person_id']);
	$jsonArrayItem['payroll_month']=$User['payroll_month'];	
	$jsonArrayItem['payroll_year']=$User['payroll_year'];	
	$jsonArrayItem['payroll_period_id']=$User['payroll_period_id'];	
	$jsonArrayItem['payroll_period_description']="Cutoff Period: $cutoff_date_from TO $cutoff_date_to<br>Payroll Period: $payroll_date_from TO $payroll_date_to";
	
	$jsonArrayItem['payroll_salary']=$User['payroll_salary'];	
	$jsonArrayItem['payroll_salary_description']=addComma($User['payroll_salary']);	
	$jsonArrayItem['payroll_absent_adjustment']=$User['payroll_absent_adjustment'];	
	$jsonArrayItem['payroll_absent_adjustment_description']=addComma($User['payroll_absent_adjustment']);	
	$jsonArrayItem['payroll_overtime']=$User['payroll_overtime'];	
	$jsonArrayItem['payroll_overtime_description']=addComma($User['payroll_overtime']);	


	$jsonArrayItem['payroll_non_taxable_earnings']=$User['payroll_non_taxable_earnings'];
	$jsonArrayItem['payroll_non_taxable_earnings_description']=addComma($User['payroll_non_taxable_earnings']);
	$jsonArrayItem['payroll_deductions']=$User['payroll_deductions'];	
	$jsonArrayItem['payroll_deductions_description']=addComma($User['payroll_deductions']);	
	$jsonArrayItem['payroll_withholding_tax']=$User['payroll_withholding_tax'];	
	$jsonArrayItem['payroll_withholding_tax_description']=addComma($User['payroll_withholding_tax']);	
	$jsonArrayItem['payroll_net_pay']=$User['payroll_net_pay'];	
	$jsonArrayItem['payroll_net_pay_description']=addComma($User['payroll_net_pay']);	

	$jsonArrayItem['payroll_created_at']=$User['payroll_created_at'];
	$jsonArrayItem['payroll_status']=$User['payroll_status'];
	$jsonArrayItem['payroll_status_description']=statusColor($User['payroll_status']);
	$jsonArrayItem['payroll_added_by']=$User['payroll_added_by'];
	$jsonArrayItem['payroll_added_by_name']=PersonName("{$User['payroll_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>