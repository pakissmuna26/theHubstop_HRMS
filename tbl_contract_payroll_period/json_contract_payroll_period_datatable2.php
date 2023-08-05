<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php
	$obj = json_decode($_GET["data"], false);
	$contract_id = add_escape_character($obj->contract_id);

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_contract_payroll_period WHERE contract_id=$contract_id ORDER BY contract_payroll_period_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['contract_payroll_period_id']="{$User['contract_payroll_period_id']}";
		$jsonArrayItem['contract_payroll_period_code']="{$User['contract_payroll_period_code']}";
		$jsonArrayItem['contract_id']=$User['contract_id'];
		$jsonArrayItem['payroll_period_id']=$User['payroll_period_id'];
		
		$query = "SELECT * FROM tbl_payroll_period WHERE payroll_period_id = {$User['payroll_period_id']}";
		$payroll_periods = mysqli_query($connection, $query);
		while ($payroll_period = mysqli_fetch_array($payroll_periods)) {
			$jsonArrayItem['payroll_period_details'] = "<b>{$payroll_period['payroll_period_title']}</b><br>
			Payroll Period: {$payroll_period['payroll_period_from']} TO {$payroll_period['payroll_period_to']}<br>
			Cut-off Period: {$payroll_period['payroll_period_cutoff_from']} TO {$payroll_period['payroll_period_cutoff_to']}";
		}

		$benefits = "";
		$deduction = "";
		$query = "SELECT * FROM tbl_payroll_period_benefits_deduction WHERE contract_payroll_period_id = {$User['contract_payroll_period_id']}";
		$payroll_period_benefits_deductions = mysqli_query($connection, $query);
		while ($payroll_period_benefits_deduction = mysqli_fetch_array($payroll_period_benefits_deductions)) {
			
			if($payroll_period_benefits_deduction['benefits_deduction_category']=="Benefits"){
				
				$chkorclose="<i class='bx bx-window-close' style='color:red;' data-bs-toggle='modal' data-bs-target='#modalChangeStatusBenefitsAndDeduction' onclick='btnChangeStatusBenefitsAndDeduction({$payroll_period_benefits_deduction['payroll_period_benefits_deduction_id']}, \"Activated\", \"Activate\")'></i> ";
				if($payroll_period_benefits_deduction['payroll_period_benefits_deduction_status'] == "Activated")
					$chkorclose="<i class='bx bx-check-square' style='color:green;' data-bs-toggle='modal' data-bs-target='#modalChangeStatusBenefitsAndDeduction' onclick='btnChangeStatusBenefitsAndDeduction({$payroll_period_benefits_deduction['payroll_period_benefits_deduction_id']}, \"Deactivated\", \"Deactivate\")'></i> ";

				$benefits_details = "";
				$query = "SELECT * FROM tbl_benefits_category WHERE benefits_category_id = {$payroll_period_benefits_deduction['benefits_deduction_id']}";
				$Benefits = mysqli_query($connection, $query);
				while ($Benefit = mysqli_fetch_array($Benefits)) {
					$benefits_details = "<b>{$Benefit['benefits_category_title']}</b><br>
					Amount: "."PHP ".addComma($Benefit['benefits_category_amount']);
					break;
				}
				$benefits.="$chkorclose ".$benefits_details."<br>";				
			}else{
				$chkorclose="<i class='bx bx-window-close' style='color:red;' data-bs-toggle='modal' data-bs-target='#modalChangeStatusBenefitsAndDeduction' onclick='btnChangeStatusBenefitsAndDeduction({$payroll_period_benefits_deduction['payroll_period_benefits_deduction_id']}, \"Activated\", \"Activate\")'></i> ";
				if($payroll_period_benefits_deduction['payroll_period_benefits_deduction_status'] == "Activated")
					$chkorclose="<i class='bx bx-check-square' style='color:green;' data-bs-toggle='modal' data-bs-target='#modalChangeStatusBenefitsAndDeduction' onclick='btnChangeStatusBenefitsAndDeduction({$payroll_period_benefits_deduction['payroll_period_benefits_deduction_id']}, \"Deactivated\", \"Deactivate\")'></i> ";

				$deduction_details="";
				$query = "SELECT * FROM tbl_deduction_category WHERE deduction_category_id = {$payroll_period_benefits_deduction['benefits_deduction_id']}";
				$Deductions = mysqli_query($connection, $query);
				while ($Deduction = mysqli_fetch_array($Deductions)) {
					if($Deduction['deduction_category_is_percentage'] == "Yes")
						$deduction_details="<b>{$Deduction['deduction_category_title']}</b><br>Company Share: {$Deduction['deduction_category_company_share']}% | Personnel Share: {$Deduction['deduction_category_personnel_share']}%";
					else if($Deduction['deduction_category_is_percentage'] == "No")
						$deduction_details="<b>{$Deduction['deduction_category_title']}</b><br>Company Share: PHP ".addComma($Deduction['deduction_category_company_share'])." | Personnel Share: PHP ".addComma($Deduction['deduction_category_personnel_share']);
					break;
				}
				$deduction.="$chkorclose ".$deduction_details."<br>";
			}
		}
		$jsonArrayItem['list_of_benefits']="$benefits";
		$jsonArrayItem['list_of_deduction']="$deduction";


		$contract_payroll_period_added_by_name = PersonName("{$User['contract_payroll_period_added_by']}");
		$jsonArrayItem['contract_payroll_period_created_at']=$User['contract_payroll_period_created_at'];
		$jsonArrayItem['contract_payroll_period_created_at_by']="{$User['contract_payroll_period_created_at']}<br><span style='color:gray;'>By: $contract_payroll_period_added_by_name</span>";
		
		$jsonArrayItem['contract_payroll_period_status']=$User['contract_payroll_period_status'];
		$jsonArrayItem['contract_payroll_period_status_description']=statusColor($User['contract_payroll_period_status']);
		$jsonArrayItem['contract_payroll_period_added_by']=$User['contract_payroll_period_added_by'];
		$jsonArrayItem['contract_payroll_period_added_by_name']=PersonName("{$User['contract_payroll_period_added_by']}");

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>