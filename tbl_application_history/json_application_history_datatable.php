<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php
	$obj = json_decode($_GET["data"], false);
	$applicant_application_id = add_escape_character($obj->applicant_application_id);

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_application_history INNER JOIN tbl_applicant_application ON tbl_application_history.applicant_application_id = tbl_applicant_application.applicant_application_id WHERE tbl_application_history.applicant_application_id = $applicant_application_id ORDER BY tbl_application_history.application_history_id ASC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['application_history_id']="{$User['application_history_id']}";
		$jsonArrayItem['application_history_code']="{$User['application_history_code']}";
		$jsonArrayItem['applicant_application_id']=$User['applicant_application_id'];
		$jsonArrayItem['history_category']=$User['history_category'];	
		$jsonArrayItem['history_title']=$User['history_title'];	
		$jsonArrayItem['history_description']=$User['history_description'];	
		$jsonArrayItem['history_date']=$User['history_date'];	
		$jsonArrayItem['history_time']=$User['history_time'];	
		$jsonArrayItem['history_remarks']=$User['history_remarks'];	
		
		$jsonArrayItem['application_contract_status']=$User['application_contract_status'];

		$jsonArrayItem['history_details']="<b>{$User['history_title']}</b><br>
		<span style='color:gray;'>Description: {$User['history_description']}</span><br>
		Date & Time: ".GetMonthDescription($User['history_date'])." @ {$User['history_time']}<br>
		Remarks: {$User['history_remarks']}";
		
		$application_history_added_by_name = PersonName("{$User['application_history_added_by']}");
		$jsonArrayItem['application_history_created_at']=$User['application_history_created_at'];
		$jsonArrayItem['application_history_created_at_by']="{$User['application_history_created_at']}<br><span style='color:gray;'>By: $application_history_added_by_name</span>";

		$jsonArrayItem['application_history_status']=$User['application_history_status'];
		$jsonArrayItem['application_history_status_description']=statusColor($User['application_history_status']);
		$jsonArrayItem['application_history_added_by']=$User['application_history_added_by'];
		$jsonArrayItem['application_history_added_by_name']=$application_history_added_by_name;

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>