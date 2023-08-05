<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_work_history ORDER BY work_history_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['work_history_id']="{$User['work_history_id']}";
	$jsonArrayItem['work_history_code']="{$User['work_history_code']}";
	$jsonArrayItem['work_history_applicant_id']=$User['work_history_applicant_id'];
	$jsonArrayItem['work_history_job_title']=$User['work_history_job_title'];	
	$jsonArrayItem['work_history_job_responsibilities']=$User['work_history_job_responsibilities'];	
	$jsonArrayItem['work_history_date_from']=$User['work_history_date_from'];	
	$jsonArrayItem['work_history_date_from_description']=GetMonthDescription($User['work_history_date_from']);	
	$jsonArrayItem['work_history_date_to']=$User['work_history_date_to'];	
	$jsonArrayItem['work_history_date_to_description']=GetMonthDescription($User['work_history_date_to']);	
	$jsonArrayItem['work_history_company']=$User['work_history_company'];	

	$jsonArrayItem['work_history_created_at']=$User['work_history_created_at'];
	$jsonArrayItem['work_history_status']=$User['work_history_status'];
	$jsonArrayItem['work_history_status_description']=statusColor($User['work_history_status']);
	$jsonArrayItem['work_history_added_by']=$User['work_history_added_by'];
	$jsonArrayItem['work_history_added_by_name']=PersonName("{$User['work_history_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>