<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_contract ORDER BY contract_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['contract_id']="{$User['contract_id']}";
		$jsonArrayItem['contract_code']="{$User['contract_code']}";
		$jsonArrayItem['contract_title']=$User['contract_title'];
		$jsonArrayItem['contract_description']=$User['contract_description'];
		$jsonArrayItem['contract_application_date_from']=$User['contract_application_date_from'];
		$jsonArrayItem['contract_application_date_to']=$User['contract_application_date_to'];
		$jsonArrayItem['contract_starting_date']=$User['contract_starting_date'];
		$jsonArrayItem['contract_job_position_id']=$User['contract_job_position_id'];
		$jsonArrayItem['contract_rate']=$User['contract_rate'];
		$jsonArrayItem['contract_shifting_schedule_id']=$User['contract_shifting_schedule_id'];

		$job_position_title="";
		$query = "SELECT * FROM tbl_job_position WHERE job_position_id={$User['contract_job_position_id']}";
		$job_positions = mysqli_query($connection, $query);
		while ($job_position = mysqli_fetch_array($job_positions)) {
			$job_position_title="{$job_position['job_position_title']}";
		}

		$shifting_schedule="";
		$query = "SELECT * FROM tbl_shifting_schedule WHERE shifting_schedule_id={$User['contract_shifting_schedule_id']}";
		$schedules = mysqli_query($connection, $query);
		while ($schedule = mysqli_fetch_array($schedules)) {
			$shifting_schedule="{$schedule['shifting_schedule_time_from']} TO {$schedule['shifting_schedule_time_to']}";
		}

		$jsonArrayItem['contract_details']="<span style='color:gray;'>{$User['contract_code']}</span><br><b>{$User['contract_title']}</b><br>
		Application Date: ".GetMonthDescription($User['contract_application_date_from'])." TO ".GetMonthDescription($User['contract_application_date_to'])."<br>Starting Date: ".GetMonthDescription($User['contract_starting_date']);	

		$jsonArrayItem['contract_details_2']="Job Position: $job_position_title<br>
		Rate (Monthly): PHP ".addComma($User['contract_rate'])."<br>
		Shift Schedule: $shifting_schedule";	

		
		$contract_added_by_name = PersonName("{$User['contract_added_by']}");
		$jsonArrayItem['contract_created_at']=$User['contract_created_at'];
		$jsonArrayItem['contract_created_at_by']="{$User['contract_created_at']}<br><span style='color:gray;'>By: $contract_added_by_name</span>";
		
		$jsonArrayItem['contract_status']=$User['contract_status'];
		$jsonArrayItem['contract_status_description']=statusColor($User['contract_status']);
		$jsonArrayItem['contract_added_by']=$User['contract_added_by'];
		$jsonArrayItem['contract_added_by_name']=PersonName("{$User['contract_added_by']}");

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>