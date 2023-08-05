<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_applicant_application INNER JOIN tbl_contract 
ON tbl_applicant_application.contract_id = tbl_contract.contract_id
ORDER BY tbl_applicant_application.applicant_application_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['applicant_application_id']="{$User['applicant_application_id']}";
	$jsonArrayItem['applicant_application_code']="{$User['applicant_application_code']}";
	$jsonArrayItem['contract_code']="{$User['contract_code']}";
	$jsonArrayItem['applicant_id']=$User['applicant_id'];
	$jsonArrayItem['contract_id']=$User['contract_id'];	
	$jsonArrayItem['application_category']=$User['application_category'];	
	$jsonArrayItem['application_remarks']=$User['application_remarks'];	
	$jsonArrayItem['application_contract_status']=$User['application_contract_status'];	
	$jsonArrayItem['application_contract_status_color']=statusColor($User['application_contract_status']);	
	$jsonArrayItem['application_contract_start_date']=$User['application_contract_start_date'];	
	$jsonArrayItem['application_contract_start_date_description']=GetMonthDescription($User['application_contract_start_date']);	
	$jsonArrayItem['application_contract_end_date']=$User['application_contract_end_date'];	
	$jsonArrayItem['application_contract_end_date_description']=GetMonthDescription($User['application_contract_end_date']);	

	$jsonArrayItem['application_created_at']=$User['application_created_at'];
	$jsonArrayItem['application_status']=$User['application_status'];
	$jsonArrayItem['application_status_description']=statusColor($User['application_status']);
	$jsonArrayItem['application_added_by']=$User['application_added_by'];
	$jsonArrayItem['application_added_by_name']=PersonName("{$User['application_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>