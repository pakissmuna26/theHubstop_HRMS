<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_contract ORDER BY contract_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['contract_id']="{$User['contract_id']}";
	$jsonArrayItem['contract_code']="{$User['contract_code']}";
	$jsonArrayItem['contract_title']=$User['contract_title'];
	$jsonArrayItem['contract_description']=$User['contract_description'];
	$jsonArrayItem['contract_application_date_from']=$User['contract_application_date_from'];
	$jsonArrayItem['contract_application_date_from_description']=GetMonthDescription($User['contract_application_date_from']);
	$jsonArrayItem['contract_application_date_to']=$User['contract_application_date_to'];
	$jsonArrayItem['contract_application_date_to_description']=GetMonthDescription($User['contract_application_date_to']);
	$jsonArrayItem['contract_starting_date']=$User['contract_starting_date'];
	$jsonArrayItem['contract_starting_date_description']=GetMonthDescription($User['contract_starting_date']);
	$jsonArrayItem['contract_job_position_id']=$User['contract_job_position_id'];
	$jsonArrayItem['contract_rate']=$User['contract_rate'];
	$jsonArrayItem['contract_rate_peso']="PHP ".addComma($User['contract_rate']);
	$jsonArrayItem['contract_shifting_schedule_id']=$User['contract_shifting_schedule_id'];

	$job_position_title="";
	$job_position_description="";
	$query = "SELECT * FROM tbl_job_position WHERE job_position_id={$User['contract_job_position_id']}";
	$job_positions = mysqli_query($connection, $query);
	while ($job_position = mysqli_fetch_array($job_positions)) {
		$job_position_title="{$job_position['job_position_title']}";
		$job_position_description="{$job_position['job_position_description']}";
	}

	$shifting_schedule="";
	$break_schedule="";
	$query = "SELECT * FROM tbl_shifting_schedule WHERE shifting_schedule_id={$User['contract_shifting_schedule_id']}";
	$schedules = mysqli_query($connection, $query);
	while ($schedule = mysqli_fetch_array($schedules)) {
		$shifting_schedule="{$schedule['shifting_schedule_time_from']} TO {$schedule['shifting_schedule_time_to']}";
		$break_schedule="{$schedule['shifting_schedule_break_time_from']} TO {$schedule['shifting_schedule_break_time_to']}";
	}

	$jsonArrayItem['job_position_title']=$job_position_title;
	$jsonArrayItem['job_position_description']=$job_position_description;
	$jsonArrayItem['shifting_schedule']=$shifting_schedule;
	$jsonArrayItem['break_schedule']=$break_schedule;

	$jsonArrayItem['contract_created_at']=$User['contract_created_at'];
	$jsonArrayItem['contract_status']=$User['contract_status'];
	$jsonArrayItem['contract_status_description']=statusColor($User['contract_status']);
	$jsonArrayItem['contract_added_by']=$User['contract_added_by'];
	$jsonArrayItem['contract_added_by_name']=PersonName("{$User['contract_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>