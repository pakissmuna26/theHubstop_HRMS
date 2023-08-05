<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_payroll_period ORDER BY payroll_period_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['payroll_period_id']="{$User['payroll_period_id']}";
		$jsonArrayItem['payroll_period_code']="{$User['payroll_period_code']}";
		$jsonArrayItem['payroll_period_title']=$User['payroll_period_title'];
		$jsonArrayItem['payroll_period_from']=$User['payroll_period_from'];	
		$jsonArrayItem['payroll_period_to']=$User['payroll_period_to'];	
		$jsonArrayItem['payroll_period_cutoff_from']=$User['payroll_period_cutoff_from'];
		$jsonArrayItem['payroll_period_cutoff_to']=$User['payroll_period_cutoff_to'];	
		
		$payroll_period_added_by_name = PersonName("{$User['payroll_period_added_by']}");
		$jsonArrayItem['payroll_period_created_at']=$User['payroll_period_created_at'];
		$jsonArrayItem['payroll_period_created_at_by']="{$User['payroll_period_created_at']}<br><span style='color:gray;'>By: $payroll_period_added_by_name</span>";
		$jsonArrayItem['payroll_period_status']=$User['payroll_period_status'];
		$jsonArrayItem['payroll_period_status_description']=statusColor($User['payroll_period_status']);
		$jsonArrayItem['payroll_period_added_by']=$User['payroll_period_added_by'];
		$jsonArrayItem['payroll_period_added_by_name']=PersonName("{$User['payroll_period_added_by']}");

		$jsonArrayItem['payroll_period_details']="<span style='color:gray;'>{$User['payroll_period_code']}</span><br><b>{$User['payroll_period_title']}</b><br>
		Payroll Period: {$User['payroll_period_from']} TO {$User['payroll_period_to']} | 
		Cut-off Period: {$User['payroll_period_cutoff_from']} TO {$User['payroll_period_cutoff_to']}";

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>