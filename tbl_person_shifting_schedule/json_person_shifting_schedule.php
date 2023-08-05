<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_person_shifting_schedule INNER JOIN tbl_shifting_schedule
ON tbl_person_shifting_schedule.shifting_schedule_id = tbl_shifting_schedule.shifting_schedule_id
ORDER BY tbl_person_shifting_schedule.person_shifting_schedule_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['person_shifting_schedule_id']="{$User['person_shifting_schedule_id']}";
	$jsonArrayItem['person_shifting_schedule_code']="{$User['person_shifting_schedule_code']}";
	$jsonArrayItem['person_id']=$User['person_id'];
	$jsonArrayItem['person_name']=PersonName($User['person_id']);
	$jsonArrayItem['shifting_schedule_id']=$User['shifting_schedule_id'];	
	$jsonArrayItem['branch_id']=$User['branch_id'];	
	$jsonArrayItem['effective_date']=$User['effective_date'];	
	$jsonArrayItem['end_effective_date']=$User['end_effective_date'];	

	$jsonArrayItem['person_shifting_schedule_created_at']=$User['person_shifting_schedule_created_at'];
	$jsonArrayItem['person_shifting_schedule_status']=$User['person_shifting_schedule_status'];
	$jsonArrayItem['person_shifting_schedule_status_description']=statusColor($User['person_shifting_schedule_status']);
	$jsonArrayItem['person_shifting_schedule_added_by']=$User['person_shifting_schedule_added_by'];
	$jsonArrayItem['person_shifting_schedule_added_by_name']=PersonName("{$User['person_shifting_schedule_added_by']}");

	$jsonArrayItem['shifting_schedule_time_from']=$User['shifting_schedule_time_from'];
	$jsonArrayItem['shifting_schedule_time_to']=$User['shifting_schedule_time_to'];
	$jsonArrayItem['shifting_schedule_break_time_from']=$User['shifting_schedule_break_time_from'];
	$jsonArrayItem['shifting_schedule_break_time_to']=$User['shifting_schedule_break_time_to'];
	
	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>