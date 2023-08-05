<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

$results["data"] = array();

$result=$db->prepare("SELECT * FROM tbl_shifting_schedule ORDER BY shifting_schedule_time_from ASC");
$result->execute();

$filterCounter=0;
for($i=0; $User = $result->fetch(); $i++){
	
	$filterCounter++;
	$jsonArrayItem=array();		
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['shifting_schedule_id']="{$User['shifting_schedule_id']}";
	$jsonArrayItem['shifting_schedule_code']="{$User['shifting_schedule_code']}";
	$jsonArrayItem['shifting_schedule_time_from']=$User['shifting_schedule_time_from'];
	$jsonArrayItem['shifting_schedule_time_to']=$User['shifting_schedule_time_to'];
	$jsonArrayItem['shifting_schedule_break_time_from']=$User['shifting_schedule_break_time_from'];
	$jsonArrayItem['shifting_schedule_break_time_to']=$User['shifting_schedule_break_time_to'];

	$shift_time_from=$User['shifting_schedule_time_from'];
	$shift_time_to=$User['shifting_schedule_time_to'];
	$shift_break_time_from=$User['shifting_schedule_break_time_from'];
	$shift_break_time_to=$User['shifting_schedule_break_time_to'];
	
	// CHECK SHIFT SCHEDULE
	$shift_time_from_hours = (int)substr($shift_time_from, 0, 2);
	$shift_time_from_minutes = (int)substr($shift_time_from, 3, 2);
	$shift_time_to_hours = (int)substr($shift_time_to, 0, 2);
	$shift_time_to_minutes = (int)substr($shift_time_to, 3, 2);
	// END OF CHECK SHIFT SCHEDULE

	// CHECK BREAK TIME
	$break_time_from_hours = (int)substr($shift_break_time_from, 0, 2);
	$break_time_from_minutes = (int)substr($shift_break_time_from, 3, 2);
	$break_time_to_hours = (int)substr($shift_break_time_to, 0, 2);
	$break_time_to_minutes = (int)substr($shift_break_time_to, 3, 2);
	// END OF CHECK BREAK TIME

	date_default_timezone_set("Asia/Manila");
	$dateToday = date("Y-m-d");
	
	$date_attendance_from = "$dateToday";
	$date_attendance_to = "$dateToday"; 

	$shift_type = "";

	// SHIFT SCHEDULE EXAMPLE
	if((int)$shift_time_from_hours > (int)$shift_time_to_hours) {
		$shift_type = "Night Shift";
		$date_attendance_to = date("Y-m-d", strtotime($date_attendance_from."+ 1 day"));
	}else{
		$shift_type = "Day Shift";
	}
	$shift_time_from_with_date="$date_attendance_from $shift_time_from";
	$shift_time_to_with_date="$date_attendance_to $shift_time_to";
	$expected_shift_schedule = GetMonthDescription("$date_attendance_from")." @  $shift_time_from TO ".GetMonthDescription("$date_attendance_to")." @ $shift_time_to";
	$shift_from = new DateTime($shift_time_from_with_date);
	$shift_to = new DateTime($shift_time_to_with_date);
	$working_time = $shift_from->diff($shift_to);
	$working_time_hours = $working_time->h;
	$working_time_minutes = $working_time->i;
	// END OF SHIFT SCHEDULE EXAMPLE

	// SHIFT BREAK EXAMPLE
	if($shift_time_from_hours > $break_time_from_hours)
		$date_attendance_from=date("Y-m-d", strtotime($date_attendance_from."+ 1 day"));
	
	$date_attendance_to = "$date_attendance_from";
	if($break_time_to_hours < $break_time_from_hours){
		$date_attendance_to = date("Y-m-d", strtotime($date_attendance_from."+ 1 day"));
	}
	$shift_break_time_from_with_date="$date_attendance_from $shift_break_time_from";
	$shift_break_time_to_with_date="$date_attendance_to $shift_break_time_to";
	$expected_shift_break = GetMonthDescription("$date_attendance_from")." @ $shift_break_time_from TO ".GetMonthDescription("$date_attendance_to")." @ $shift_break_time_to";
	$break_from = new DateTime($shift_break_time_from_with_date);
	$break_to = new DateTime($shift_break_time_to_with_date);
	$break_time = $break_to->diff($break_from);
	$break_time_hours = $break_time->h;
	$break_time_minutes = $break_time->i;
	// END OF SHIFT BREAK EXAMPLE

	$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;
	$deduction_work_and_break=($break_time_hours*60)+$break_time_minutes;
	$rem = $get_minutes_work_time - $deduction_work_and_break;
	$rem_in_hours = floor($rem/60);
	$rem_in_minutes = $rem - ($rem_in_hours*60);

	$jsonArrayItem['shifting_schedule_details']="<span style='color:gray;'>{$User['shifting_schedule_code']}</span><br>
		<b>$shift_time_from TO $shift_time_to 
			($working_time_hours HR/S $working_time_minutes MIN/S)</b><br>
		E.g.: $expected_shift_schedule<br>
		<b>Break: $shift_break_time_from TO $shift_break_time_to 
			($break_time_hours HR/S $break_time_minutes MIN/S)</b><br>
		E.g.: $expected_shift_break
		<b>Working Hours: $rem_in_hours HR/S $rem_in_minutes MIN/S</b>";
	
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

	array_push($results["data"], $jsonArrayItem);

}

$data[] =$results["data"];
$results["sEcho"]=1;
$results["iTotalRecords"]=count($data);
$results["iTotalDisplayRecords"]=count($data);
echo json_encode($results);
?>