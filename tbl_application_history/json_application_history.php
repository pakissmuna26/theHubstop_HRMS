<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_application_history INNER JOIN tbl_applicant_application ON tbl_application_history.applicant_application_id = tbl_applicant_application.applicant_application_id ORDER BY tbl_application_history.application_history_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

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
	$jsonArrayItem['history_details']="{$User['history_title']}<br>
		Description: {$User['history_description']}<br>
		Date & Time: ".GetMonthDescription($User['history_date'])." @ {$User['history_time']}<br>
		Remarks: {$User['history_remarks']}";

	$application_history_added_by_name = PersonName("{$User['application_history_added_by']}");
	$jsonArrayItem['application_history_created_at']=$User['application_history_created_at'];
	$jsonArrayItem['application_history_created_at_by']="{$User['application_history_created_at']}<br>By: $application_history_added_by_name";

	$jsonArrayItem['application_history_status']=$User['application_history_status'];
	$jsonArrayItem['application_history_status_description']=statusColor($User['application_history_status']);
	$jsonArrayItem['application_history_added_by']=$User['application_history_added_by'];
	$jsonArrayItem['application_history_added_by_name']=PersonName("{$User['application_history_added_by']}");

	$jsonArrayItem['application_contract_status']=$User['application_contract_status'];	
	
	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>