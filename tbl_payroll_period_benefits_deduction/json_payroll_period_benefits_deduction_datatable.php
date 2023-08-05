<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php
	$obj = json_decode($_GET["data"], false);
	$contract_payroll_period_id = add_escape_character($obj->contract_payroll_period_id);

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_payroll_period_benefits_deduction WHERE contract_payroll_period_id=$contract_payroll_period_id ORDER BY payroll_period_benefits_deduction_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['payroll_period_benefits_deduction_id']="{$User['payroll_period_benefits_deduction_id']}";
		$jsonArrayItem['payroll_period_benefits_deduction_code']="{$User['payroll_period_benefits_deduction_code']}";
		$jsonArrayItem['contract_payroll_period_id']=$User['contract_payroll_period_id'];
		$jsonArrayItem['benefits_deduction_id']=$User['benefits_deduction_id'];
		$jsonArrayItem['benefits_deduction_category']=$User['benefits_deduction_category'];

		$benefits_deduction_description = "";
		if($User['benefits_deduction_category']=="Benefits"){
			$benefits_details = "";
			$query = "SELECT * FROM tbl_benefits_category WHERE benefits_category_id = {$User['benefits_deduction_id']}";
			$Benefits = mysqli_query($connection, $query);
			while ($Benefit = mysqli_fetch_array($Benefits)) {
				$benefits_details="<b>{$Benefit['benefits_category_title']}</b><br>
				Amount: "."PHP ".addComma($Benefit['benefits_category_amount']);
				break;
			}
			$benefits_deduction_description=$benefits_details;	
		}else{		
			$deduction_details="";
			$query = "SELECT * FROM tbl_deduction_category WHERE deduction_category_id = {$User['benefits_deduction_id']}";
			$Deductions = mysqli_query($connection, $query);
			while ($Deduction = mysqli_fetch_array($Deductions)) {
				if($Deduction['deduction_category_is_percentage'] == "Yes")
					$deduction_details="<b>{$Deduction['deduction_category_title']}</b><br>Company Share: {$Deduction['deduction_category_company_share']}% | Personnel Share: {$Deduction['deduction_category_personnel_share']}%";
				else if($Deduction['deduction_category_is_percentage'] == "No")
					$deduction_details="<b>{$Deduction['deduction_category_title']}</b><br>Company Share: PHP ".addComma($Deduction['deduction_category_company_share'])." | Personnel Share: PHP ".addComma($Deduction['deduction_category_personnel_share']);
				break;
			}
			$benefits_deduction_description=$deduction_details;
		}
		$jsonArrayItem['benefits_deduction_description']=$benefits_deduction_description;


		$payroll_period_benefits_deduction_added_by_name = PersonName("{$User['payroll_period_benefits_deduction_added_by']}");
		$jsonArrayItem['payroll_period_benefits_deduction_created_at']=$User['payroll_period_benefits_deduction_created_at'];
		$jsonArrayItem['payroll_period_benefits_deduction_created_at_by']="{$User['payroll_period_benefits_deduction_created_at']}<br><span style='color:gray;'>By: $payroll_period_benefits_deduction_added_by_name</span>";
		
		$jsonArrayItem['payroll_period_benefits_deduction_status']=$User['payroll_period_benefits_deduction_status'];
		$jsonArrayItem['payroll_period_benefits_deduction_status_description']=statusColor($User['payroll_period_benefits_deduction_status']);
		$jsonArrayItem['payroll_period_benefits_deduction_added_by']=$User['payroll_period_benefits_deduction_added_by'];
		$jsonArrayItem['payroll_period_benefits_deduction_added_by_name']=PersonName("{$User['payroll_period_benefits_deduction_added_by']}");

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>