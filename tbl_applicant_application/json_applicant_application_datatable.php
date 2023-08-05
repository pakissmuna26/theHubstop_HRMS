<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php
	$obj = json_decode($_GET["data"], false);
	$applicant_id = add_escape_character($obj->applicant_id);

	$results["data"] = array();

	if($applicant_id == 0){
		$result=$db->prepare("SELECT * FROM tbl_person INNER JOIN tbl_applicant_application ON tbl_person.person_id = tbl_applicant_application.applicant_id INNER JOIN tbl_contract ON tbl_applicant_application.contract_id = tbl_contract.contract_id INNER JOIN tbl_job_position ON tbl_contract.contract_job_position_id = tbl_job_position.job_position_id ORDER BY tbl_applicant_application.applicant_application_id DESC");
	}else{
		$result=$db->prepare("SELECT * FROM tbl_person INNER JOIN tbl_applicant_application ON tbl_person.person_id = tbl_applicant_application.applicant_id INNER JOIN tbl_contract ON tbl_applicant_application.contract_id = tbl_contract.contract_id INNER JOIN tbl_job_position ON tbl_contract.contract_job_position_id = tbl_job_position.job_position_id WHERE tbl_applicant_application.applicant_id = $applicant_id ORDER BY tbl_applicant_application.applicant_application_id DESC");
	}
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){

		$history = "";
		$counter=0;
		$query = "SELECT * FROM tbl_application_history 
		WHERE applicant_application_id = {$User['applicant_application_id']} AND 
		application_history_status = \"Scheduled\"
		ORDER BY application_history_id ASC";
		$application_histories = mysqli_query($connection, $query);
		while ($application_history = mysqli_fetch_array($application_histories)) {
			$counter++;
			$history .= "<li>{$application_history['history_category']}</li>";
		}
		if($counter == 0)
			$history .= "<li>No Scheduled Process</li>";	

		$assigned = false;
		if($signedin_user_type_id == 2){
			$query = "SELECT * FROM tbl_contract_branch INNER JOIN tbl_branch 
			ON tbl_contract_branch.branch_id = tbl_branch.branch_id 
			INNER JOIN tbl_branch_person 
			ON tbl_branch.branch_id = tbl_branch_person.branch_id 
			WHERE tbl_contract_branch.contract_id = {$User['contract_id']} AND 
			tbl_branch_person.person_id = $signedin_person_id AND 
			tbl_branch_person.branch_person_status=\"Added\"";
			$assigned_to_branches = mysqli_query($connection, $query);
			while ($assigned_to_branch = mysqli_fetch_array($assigned_to_branches)) {
				$assigned = true;
				break;
			}
			if($assigned){
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
				$jsonArrayItem['application_history']="<ul>$history</ul>";	
				$jsonArrayItem['application_contract_status']=$User['application_contract_status'];	
				$jsonArrayItem['application_contract_status_color']=statusColor($User['application_contract_status']);	
				$jsonArrayItem['application_contract_start_date']=$User['application_contract_start_date'];	
				$jsonArrayItem['application_contract_start_date_description']=GetMonthDescription($User['application_contract_start_date']);	
				$jsonArrayItem['application_contract_end_date']=$User['application_contract_end_date'];	
				$jsonArrayItem['application_contract_end_date_description']=GetMonthDescription($User['application_contract_end_date']);
				
				$application_added_by_name = PersonName("{$User['application_added_by']}");
				$jsonArrayItem['application_created_at']=$User['application_created_at'];
				$jsonArrayItem['application_created_at_by']="{$User['application_created_at']}<br><span style='color:gray;'>By: $application_added_by_name</span>";

				$jsonArrayItem['application_status']=$User['application_status'];
				$jsonArrayItem['application_status_description']=statusColor($User['application_status']);
				$jsonArrayItem['application_added_by']=$User['application_added_by'];
				$jsonArrayItem['application_added_by_name']=$application_added_by_name;
				array_push($results["data"], $jsonArrayItem);
			}
		}else{
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
			$jsonArrayItem['application_history']="<ul>$history</ul>";
			$jsonArrayItem['application_contract_status']=$User['application_contract_status'];	
			$jsonArrayItem['application_contract_status_color']=statusColor($User['application_contract_status']);	
			$jsonArrayItem['application_contract_start_date']=$User['application_contract_start_date'];	
			$jsonArrayItem['application_contract_start_date_description']=GetMonthDescription($User['application_contract_start_date']);	
			$jsonArrayItem['application_contract_end_date']=$User['application_contract_end_date'];	
			$jsonArrayItem['application_contract_end_date_description']=GetMonthDescription($User['application_contract_end_date']);
			
			$application_added_by_name = PersonName("{$User['application_added_by']}");
			$jsonArrayItem['application_created_at']=$User['application_created_at'];
			$jsonArrayItem['application_created_at_by']="{$User['application_created_at']}<br><span style='color:gray;'>By: $application_added_by_name</span>";

			$jsonArrayItem['application_status']=$User['application_status'];
			$jsonArrayItem['application_status_description']=statusColor($User['application_status']);
			$jsonArrayItem['application_added_by']=$User['application_added_by'];
			$jsonArrayItem['application_added_by_name']=$application_added_by_name;
			array_push($results["data"], $jsonArrayItem);
		}

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>