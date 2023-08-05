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
	$result=$db->prepare("SELECT * FROM tbl_leave_request INNER JOIN tbl_leave_category ON tbl_leave_request.leave_request_category_id = tbl_leave_category.leave_category_id  ORDER BY tbl_leave_request.leave_request_id DESC");
}else{
	$result=$db->prepare("SELECT * FROM tbl_leave_request INNER JOIN tbl_leave_category ON tbl_leave_request.leave_request_category_id = tbl_leave_category.leave_category_id WHERE tbl_leave_request.leave_request_by = $person_id ORDER BY tbl_leave_request.leave_request_id DESC");
}
$result->execute();

$filterCounter=0;
for($i=0; $User = $result->fetch(); $i++){
	

	$personnel_assigned = false;
	if($signedin_user_type_id == 2){
		$query = "SELECT * FROM tbl_applicant_application 
		WHERE applicant_id={$User['leave_request_by']}";
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
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['leave_request_id']="{$User['leave_request_id']}";
		$jsonArrayItem['leave_request_code']="{$User['leave_request_code']}";
		$jsonArrayItem['leave_request_by']=$User['leave_request_by'];
		$jsonArrayItem['leave_request_category_id']=$User['leave_request_category_id'];
		$jsonArrayItem['leave_request_date_from']=$User['leave_request_date_from'];
		$jsonArrayItem['leave_request_date_to']=$User['leave_request_date_to'];
		$jsonArrayItem['leave_request_remarks']=$User['leave_request_remarks'];
		$jsonArrayItem['leave_request_approved_by']=$User['leave_request_approved_by'];
		$jsonArrayItem['leave_request_approved_by_date_time']=$User['leave_request_approved_by_date_time'];
		
		$date_from = date_create("{$User['leave_request_date_from']}");
		$date_to = date_create("{$User['leave_request_date_to']}");
		$get_days = date_diff($date_to,$date_from);
		$days = $get_days->d;

		$status = "Approved/Denied";
		if($User['leave_request_status'] == "Approved" || $User['leave_request_status'] == "Denied") $status = "{$User['leave_request_status']}";

		$label = "Day";
		if($days > 1) $label = "Days";
		$leave_request_date_from = GetMonthDescription($User['leave_request_date_from']);
		$leave_request_date_to = GetMonthDescription($User['leave_request_date_to']);
		$leave_request_by = PersonName($User['leave_request_by']);
		$leave_request_approved_by = PersonName($User['leave_request_approved_by']);
		$jsonArrayItem['leave_request_details']="<b>{$User['leave_category_title']}</b><br>
		Date: $leave_request_date_from TO $leave_request_date_to<br>
		No. of $label: $days $label<br>
		Remarks: {$User['leave_request_remarks']}<br>
		<span style='color:gray;'>$status By: $leave_request_approved_by, {$User['leave_request_approved_by_date_time']}</span>";

		$leave_request_added_by_name = PersonName("{$User['leave_request_added_by']}");
		$jsonArrayItem['leave_request_created_at']=$User['leave_request_created_at'];
		$jsonArrayItem['leave_request_created_at_by']="{$User['leave_request_created_at']}<br><span style='color:gray;'>By: $leave_request_added_by_name</span>";
		
		$jsonArrayItem['leave_request_status']=$User['leave_request_status'];
		$jsonArrayItem['leave_request_status_description']=statusColor($User['leave_request_status']);
		$jsonArrayItem['leave_request_added_by']=$User['leave_request_added_by'];
		$jsonArrayItem['leave_request_added_by_name']=PersonName("{$User['leave_request_added_by']}");

		array_push($results["data"], $jsonArrayItem);
	}

}

$data[] =$results["data"];
$results["sEcho"]=1;
$results["iTotalRecords"]=count($data);
$results["iTotalDisplayRecords"]=count($data);
echo json_encode($results);
?>