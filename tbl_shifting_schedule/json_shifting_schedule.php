<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_shifting_schedule ORDER BY shifting_schedule_time_from ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();		
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['shifting_schedule_id']="{$User['shifting_schedule_id']}";
	$jsonArrayItem['shifting_schedule_code']="{$User['shifting_schedule_code']}";
	$jsonArrayItem['shifting_schedule_time_from']=$User['shifting_schedule_time_from'];
	$jsonArrayItem['shifting_schedule_time_to']=$User['shifting_schedule_time_to'];
	$jsonArrayItem['shifting_schedule_break_time_from']=$User['shifting_schedule_break_time_from'];
	$jsonArrayItem['shifting_schedule_break_time_to']=$User['shifting_schedule_break_time_to'];

	$working_hours = 0;
	$working_hours = $User['shifting_schedule_time_to'] - $User['shifting_schedule_time_from'];

	$jsonArrayItem['shifting_schedule_details']="<b>{$User['shifting_schedule_time_from']} TO {$User['shifting_schedule_time_to']} </b><br>
		Working Hours: $working_hours HRS<br>
		Shift Break: {$User['shifting_schedule_break_time_from']} TO {$User['shifting_schedule_break_time_to']}";	

	$jsonArrayItem['shifting_schedule_details2']="Shift Schedule: {$User['shifting_schedule_time_from']} TO {$User['shifting_schedule_time_to']} | 
		Shift Break: {$User['shifting_schedule_break_time_from']} TO {$User['shifting_schedule_break_time_to']}";	
	
	$jsonArrayItem['shifting_schedule_monday']=$User['shifting_schedule_monday'];	
	$jsonArrayItem['shifting_schedule_tuesday']=$User['shifting_schedule_tuesday'];	
	$jsonArrayItem['shifting_schedule_wednesday']=$User['shifting_schedule_wednesday'];	
	$jsonArrayItem['shifting_schedule_thursday']=$User['shifting_schedule_thursday'];	
	$jsonArrayItem['shifting_schedule_friday']=$User['shifting_schedule_friday'];	
	$jsonArrayItem['shifting_schedule_saturday']=$User['shifting_schedule_saturday'];	
	$jsonArrayItem['shifting_schedule_sunday']=$User['shifting_schedule_sunday'];

	$shifting_schedule_added_by_name = PersonName("{$User['shifting_schedule_added_by']}");
	$jsonArrayItem['shifting_schedule_created_at']=$User['shifting_schedule_created_at'];
	$jsonArrayItem['shifting_schedule_created_at_by']="{$User['shifting_schedule_created_at']}<br><span style='color:gray;'>By: $shifting_schedule_added_by_name</span>";

	$days_of_week = "";
	if($User['shifting_schedule_monday'] == "Yes")
		$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Monday, ";
	else 
		$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Monday, ";
	if($User['shifting_schedule_tuesday'] == "Yes")
		$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Tuesday, ";
	else 
		$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Tuesday, ";
	if($User['shifting_schedule_wednesday'] == "Yes")
		$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Wednesday<br>";
	else 
		$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Wednesday<br>";
	if($User['shifting_schedule_thursday'] == "Yes")
		$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Thursday, ";
	else 
		$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Thursday, ";
	if($User['shifting_schedule_friday'] == "Yes")
		$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Friday, ";
	else 
		$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Friday, ";
	if($User['shifting_schedule_saturday'] == "Yes")
		$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Saturday, ";
	else 
		$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Saturday, ";
	if($User['shifting_schedule_sunday'] == "Yes")
		$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Sunday";
	else 
		$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Sunday";

	$jsonArrayItem['shifting_schedule_days_of_week']="$days_of_week";

	
	$jsonArrayItem['shifting_schedule_status']=$User['shifting_schedule_status'];
	$jsonArrayItem['shifting_schedule_status_description']=statusColor($User['shifting_schedule_status']);
	$jsonArrayItem['shifting_schedule_added_by']=$User['shifting_schedule_added_by'];
	$jsonArrayItem['shifting_schedule_added_by_name']=PersonName("{$User['shifting_schedule_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>