<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>

<?php
$obj = json_decode($_GET["data"], false);
$person_id = add_escape_character($obj->person_id);

	$results["data"] = array();

if($person_id == ""){
	$result=$db->prepare("SELECT * FROM tbl_payroll ORDER BY payroll_id DESC");
}else{
	$result=$db->prepare("SELECT * FROM tbl_payroll WHERE payroll_person_id=$person_id ORDER BY payroll_id DESC");
}
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$personnel_assigned = false;
		if($signedin_user_type_id == 2){
			$query = "SELECT * FROM tbl_applicant_application 
			WHERE applicant_id={$User['payroll_person_id']}";
			$applicant_applications = mysqli_query($connection, $query);
			while ($applicant_application = mysqli_fetch_array($applicant_applications)) {
				
				// contract_branch_status = \"Activated\"
				$query = "SELECT * FROM tbl_contract_branch
				WHERE contract_id = {$applicant_application['contract_id']} 
				ORDER BY contract_branch_id DESC";
				$contract_branches = mysqli_query($connection, $query);
				while ($contract_branch = mysqli_fetch_array($contract_branches)) {

					$query = "SELECT * FROM tbl_branch_person
					WHERE person_id = $signedin_person_id AND 
					branch_id = {$contract_branch['branch_id']} AND 
					branch_person_status = \"Added\"";
					$branch_persons = mysqli_query($connection, $query);
					while ($branch_person = mysqli_fetch_array($branch_persons)) {
						$personnel_assigned=true;
						break;
					}
				}
			}
		}else{
			$personnel_assigned=true;
		}

		if($personnel_assigned){
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
			$jsonArrayItem['payroll_month']=$User['payroll_month'];	
			$jsonArrayItem['payroll_year']=$User['payroll_year'];	
			$jsonArrayItem['payroll_period_id']=$User['payroll_period_id'];	
			$jsonArrayItem['payroll_salary']=$User['payroll_salary'];
			$jsonArrayItem['payroll_absent_adjustment']=$User['payroll_absent_adjustment'];	
			$jsonArrayItem['payroll_overtime']=$User['payroll_overtime'];	
			$jsonArrayItem['payroll_non_taxable_earnings']=$User['payroll_non_taxable_earnings'];
			$jsonArrayItem['payroll_deductions']=$User['payroll_deductions'];	
			$jsonArrayItem['payroll_withholding_tax']=$User['payroll_withholding_tax'];	
			$jsonArrayItem['payroll_net_pay']=$User['payroll_net_pay'];	

			$name = PersonName($User['payroll_person_id']);
			$jsonArrayItem['payroll_details']="<b>$name</b><br>
			Cutoff Period: $cutoff_date_from TO $cutoff_date_to<br>
			Payroll Period: $payroll_date_from TO $payroll_date_to<br>
			Net Pay: PHP ".addComma($User['payroll_net_pay']);

			$jsonArrayItem['payroll_details2']="<b>$name</b><br>
			Cutoff Period: $cutoff_date_from TO $cutoff_date_to<br>
			Payroll Period: $payroll_date_from TO $payroll_date_to<br>
			Salary: PHP ".addComma($User['payroll_salary'])." | 
			Absent Adjustment: PHP ".addComma($User['payroll_absent_adjustment'])."<br>
			Overtime: PHP ".addComma($User['payroll_overtime'])." | 
			Non-Taxable Earnings: PHP ".addComma($User['payroll_non_taxable_earnings'])." <br>
			Deduction: PHP ".addComma($User['payroll_deductions'])." | 
			Withholding Tax: PHP ".addComma($User['payroll_withholding_tax'])."<br>
			<b>Net Pay: PHP ".addComma($User['payroll_net_pay'])."</b>";

			$payroll_added_by_name = PersonName("{$User['payroll_added_by']}");
			$jsonArrayItem['payroll_created_at']=$User['payroll_created_at'];
			$jsonArrayItem['payroll_created_at_by']="{$User['payroll_created_at']}<br><span style='color:gray;'>By: $payroll_added_by_name</span>";

			$jsonArrayItem['payroll_status']=$User['payroll_status'];
			$jsonArrayItem['payroll_status_description']=statusColor($User['payroll_status']);
			$jsonArrayItem['payroll_added_by']=$User['payroll_added_by'];
			$jsonArrayItem['payroll_added_by_name']=$payroll_added_by_name;

			array_push($results["data"], $jsonArrayItem);
		}

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>