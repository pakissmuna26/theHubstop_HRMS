<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php
	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_job_position INNER JOIN tbl_contract ON tbl_job_position.job_position_id = tbl_contract.contract_job_position_id INNER JOIN tbl_contract_branch ON tbl_contract.contract_id = tbl_contract_branch.contract_id INNER JOIN tbl_branch ON tbl_contract_branch.branch_id = tbl_branch.branch_id ORDER BY tbl_contract_branch.contract_branch_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['contract_branch_id']="{$User['contract_branch_id']}";
		$jsonArrayItem['contract_branch_code']="{$User['contract_branch_code']}";
		$jsonArrayItem['contract_id']=$User['contract_id'];
		$jsonArrayItem['branch_id']=$User['branch_id'];

		$jsonArrayItem['contract_details']="<span style='color:gray;'>{$User['contract_branch_code']}</span><br><b>{$User['job_position_title']}</b><br>
		Contract Code: {$User['contract_code']}<br>
		Contract: {$User['contract_title']}";

		$jsonArrayItem['branch_details']="<b>{$User['branch_name']}</b><br>Branch Code: {$User['branch_code']}<br>Address: {$User['branch_address']}, {$User['branch_barangay']}, {$User['branch_city']}, {$User['branch_province']}, {$User['branch_region']}<br>Contact #: +639 {$User['branch_contact_number']}";

		$contract_branch_added_by_name = PersonName("{$User['contract_branch_added_by']}");
		$jsonArrayItem['contract_branch_created_at']=$User['contract_branch_created_at'];
		$jsonArrayItem['contract_branch_created_at_by']="{$User['contract_branch_created_at']}<br><span style='color:gray;'>By: $contract_branch_added_by_name</span>";
	
		$jsonArrayItem['contract_branch_status']=$User['contract_branch_status'];
		$jsonArrayItem['contract_branch_status_description']=statusColor($User['contract_branch_status']);
		$jsonArrayItem['contract_branch_added_by']=$User['contract_branch_added_by'];
		$jsonArrayItem['contract_branch_added_by_name']=PersonName("{$User['contract_branch_added_by']}");

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>