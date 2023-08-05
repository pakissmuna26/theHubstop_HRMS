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

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_person INNER JOIN tbl_applicant_application ON tbl_person.person_id = tbl_applicant_application.applicant_id INNER JOIN tbl_contract ON tbl_applicant_application.contract_id = tbl_contract.contract_id INNER JOIN tbl_job_position ON tbl_contract.contract_job_position_id = tbl_job_position.job_position_id WHERE tbl_applicant_application.contract_id = $contract_id ORDER BY tbl_applicant_application.applicant_application_id DESC");

	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		$jsonArrayItem=array();	
		$filterCounter++;
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['applicant_application_id']="{$User['applicant_application_id']}";
		$jsonArrayItem['applicant_application_code']="{$User['applicant_application_code']}";
		
		$jsonArrayItem['applicant_id']=$User['applicant_id'];
		$jsonArrayItem['applicant_details']="<span style='color:gray;'>{$User['applicant_application_code']}</span><br><b>{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} {$User['middle_name']}</b>";
		
		$jsonArrayItem['contract_id']=$User['contract_id'];	
		$jsonArrayItem['contract_details']="<span style='color:gray;'>{$User['contract_code']}</span><br><b>{$User['job_position_title']}</b>";	
		$jsonArrayItem['contract_details_for_applicant']="<b>{$User['job_position_title']}</b>";	
		
		$jsonArrayItem['application_category']=$User['application_category'];	
		$jsonArrayItem['application_remarks']=$User['application_remarks'];	
		
		$application_added_by_name = PersonName("{$User['application_added_by']}");
		$jsonArrayItem['application_created_at']=$User['application_created_at'];
		$jsonArrayItem['application_created_at_by']="{$User['application_created_at']}<br><span style='color:gray;'>By: $application_added_by_name</span>";

		$jsonArrayItem['application_status']=$User['application_status'];
		$jsonArrayItem['application_status_description']=statusColor($User['application_status']);
		$jsonArrayItem['application_added_by']=$User['application_added_by'];
		$jsonArrayItem['application_added_by_name']=$application_added_by_name;
		array_push($results["data"], $jsonArrayItem);
	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>