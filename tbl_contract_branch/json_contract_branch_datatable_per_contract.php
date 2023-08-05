<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php
	$obj = json_decode($_GET["data"], false);
	$contract_id = add_escape_character($obj->contract_id);

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_job_position INNER JOIN tbl_contract ON tbl_job_position.job_position_id = tbl_contract.contract_job_position_id INNER JOIN tbl_contract_branch ON tbl_contract.contract_id = tbl_contract_branch.contract_id INNER JOIN tbl_branch ON tbl_contract_branch.branch_id = tbl_branch.branch_id WHERE tbl_contract_branch.contract_id=$contract_id ORDER BY tbl_contract_branch.contract_branch_id DESC");
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

		$jsonArrayItem['contract_details']="<b>{$User['job_position_title']}</b><br>
		Contract: {$User['contract_title']}<br>
		Application Date: ".GetMonthDescription($User['contract_application_date_from'])." TO ".GetMonthDescription($User['contract_application_date_to'])."<br>Starting Date: ".GetMonthDescription($User['contract_starting_date']);

		$jsonArrayItem['branch_details']="<span style='color:gray;'>{$User['branch_code']}</span><br><b>{$User['branch_name']}</b><br>Address: {$User['branch_address']}, {$User['branch_barangay']}, {$User['branch_city']}, {$User['branch_province']}, {$User['branch_region']}<br>Contact #: +639 {$User['branch_contact_number']}";

		$contract_branch_added_by_name = PersonName("{$User['contract_branch_added_by']}");
		$jsonArrayItem['contract_branch_created_at']=$User['contract_branch_created_at'];
		$jsonArrayItem['contract_branch_created_at_by']="{$User['contract_branch_created_at']}<br><span style='color:gray;'>By: $contract_branch_added_by_name</span>";
	
		$jsonArrayItem['contract_branch_status']=$User['contract_branch_status'];
		$jsonArrayItem['contract_branch_status_description']=statusColor($User['contract_branch_status']);
		$jsonArrayItem['contract_branch_added_by']=$User['contract_branch_added_by'];
		$jsonArrayItem['contract_branch_added_by_name']=PersonName("{$User['contract_branch_added_by']}");

		$hr_staff = "";
		$query = "SELECT * FROM tbl_branch_person INNER JOIN tbl_person 
		ON tbl_branch_person.person_id = tbl_person.person_id
		WHERE tbl_branch_person.branch_id = {$User['branch_id']} AND 
		tbl_branch_person.branch_person_status=\"Added\" AND 
		tbl_person.user_type=2";
		$branch_persons = mysqli_query($connection, $query);
		while ($branch_person = mysqli_fetch_array($branch_persons)) {
			$hr_staff.= "<li>{$branch_person['last_name']} {$branch_person['affiliation_name']}, {$branch_person['first_name']} {$branch_person['middle_name']}</li>";
		}

		$jsonArrayItem['branch_hr_staff']="<ul>$hr_staff</ul>";
		
		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>