<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>

<?php
$obj = json_decode($_GET["data"], false);
$attendance_category = add_escape_character($obj->attendance_category);

$results["data"] = array();

if($attendance_category != ""){
	$result=$db->prepare("SELECT * FROM tbl_attendance WHERE attendance_category=\"$attendance_category\" ORDER BY attendance_id DESC");
}else{
	$result=$db->prepare("SELECT * FROM tbl_attendance WHERE attendance_requested_by=$signedin_person_id ORDER BY attendance_id DESC");
}
$result->execute();

$filterCounter=0;
for($i=0; $User = $result->fetch(); $i++){
	
	$personnel_assigned = false;
	if($signedin_user_type_id == 2){
		$query = "SELECT * FROM tbl_applicant_application 
		WHERE applicant_id={$User['attendance_requested_by']}";
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
	
		$attendance_requested_by = PersonName($User['attendance_requested_by']);
		$attendance_approved_by = PersonName($User['attendance_approved_by']);

		$shift_time_from = $shift_time_to = "";
		$shift_break_time_from = $shift_break_time_to = "";
		$has_schedule=false;
		include("shift_schedule_checker.php");

		// CHECK ATTENDANCE
		$attendance_from_hours = substr("{$User['attendance_time_in']}", 0, 2);
		$attendance_from_minutes = substr("{$User['attendance_time_in']}", 3, 2);
		$attendance_to_hours = substr("{$User['attendance_time_out']}", 0, 2);
		$attendance_to_minutes = substr("{$User['attendance_time_out']}", 3, 2);
		// END OF CHECK ATTENDANCE

		// CHECK SHIFT SCHEDULE
		$shift_time_from_hours = substr($shift_time_from, 0, 2);
		$shift_time_from_minutes = substr($shift_time_from, 3, 2);
		$shift_time_to_hours = substr($shift_time_to, 0, 2);
		$shift_time_to_minutes = substr($shift_time_to, 3, 2);
		// END OF CHECK SHIFT SCHEDULE

		// CHECK BREAK TIME
		$break_time_from_hours = substr($shift_break_time_from, 0, 2);
		$break_time_from_minutes = substr($shift_break_time_from, 3, 2);
		$break_time_to_hours = substr($shift_break_time_to, 0, 2);
		$break_time_to_minutes = substr($shift_break_time_to, 3, 2);
		// END OF CHECK BREAK TIME

		// ATTENDANCE
		$attendance_time_in="{$User['attendance_date_in']} {$User['attendance_time_in']}";
		$attendance_time_out="{$User['attendance_date_out']} {$User['attendance_time_out']}";
		$time_in = new DateTime($attendance_time_in);
		$time_out = new DateTime($attendance_time_out);
		// END OF ATTENDANCE

		// EXPECTED SHIFT SCHEDULE
		$date_attendance_from = "{$User['attendance_date_in']}";
		$date_attendance_to = "{$User['attendance_date_in']}"; 
	
		$time_in_valid = false;
		$shift_type = "";
		if((int)$shift_time_from_hours > (int)$shift_time_to_hours) {
			$shift_type = "Night Shift";

			if($attendance_from_hours >= ($shift_time_from_hours-1) ||   
				$attendance_from_hours >= $shift_time_from_hours &&  
				$attendance_from_hours <= 23 && 
				$attendance_from_minutes <= 59){
				$time_in_valid = true;
			}else{
				$date_attendance_from=date("Y-m-d", strtotime($date_attendance_from."- 1 day"));
			}

			$date_attendance_to = date("Y-m-d", strtotime($date_attendance_from."+ 1 day"));
		}
		else {
			$shift_type = "Day Shift";
			if($attendance_from_hours >= ($shift_time_from_hours-1) ||   
				$attendance_from_hours >= $shift_time_from_hours &&  
				$attendance_from_hours <= 23 && 
				$attendance_from_minutes <= 59){
				
				$date_attendance_from = "{$User['attendance_date_in']}";
				$date_attendance_to = "{$User['attendance_date_in']}";
				$time_in_valid = true;
			}else{
				$date_attendance_from = "";
				$date_attendance_to = "";
			}
		}
		

		$shift_time_from_with_date="$date_attendance_from $shift_time_from";
		$shift_time_to_with_date="$date_attendance_to $shift_time_to";
		$expected_shift_schedule = GetMonthDescription("$date_attendance_from")." @  $shift_time_from TO ".GetMonthDescription("$date_attendance_to")." @ $shift_time_to";
		$shift_from = new DateTime($shift_time_from_with_date);
		$shift_to = new DateTime($shift_time_to_with_date);
		// END OF EXPECTED SHIFT SCHEDULE

		// SHIFT BREAK
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
		// END OF SHIFT BREAK

		$time_in_only=false;
		if($User['attendance_time_out'] == "") $time_in_only = true;
		$work_status = $working_time_display = "";
		$working_time_hours = $working_time_minutes = 0;

		if($time_in_only){
			$working_time_display = "TIME OUT IS NEEDED TO COMPUTE THE WORKING HOURS";
		}else{
			$working_time = $time_out->diff($time_in);
			$working_time_days = $working_time->d;

			if($working_time_days >= 1){
				$work_status = "<span style='color:red;'>ASK THE HR STAFF REGARDING YOUR ATTENDANCE</span>";
				$working_time_hours = 0;
				$working_time_minutes = 0;
				$working_time_display = "$working_time_hours HR/S $working_time_minutes MIN/S";
			}else{
				if($User['attendance_type'] == "Daily" || $User['attendance_type'] == "Leave Request"){
					include("attendance_checker_daily.php");
				}else if($User['attendance_type'] == "Overtime"){
					if($attendance_from_hours >= $shift_time_to_hours && $attendance_from_minutes >= $shift_time_to_minutes){
						$working_time = $time_in->diff($time_out);
						$working_time_hours = $working_time->h;
						$working_time_minutes = $working_time->i;
						$working_time_display="$working_time_hours HR/S $working_time_minutes MIN/S";						
					}else{
						$work_status = "<span style='color:red;'>ASK THE HR STAFF REGARDING YOUR ATTENDANCE</span>";
						$working_time_hours = 0;
						$working_time_minutes = 0;
						$working_time_display = "$working_time_hours HR/S $working_time_minutes MIN/S";	
					}
				}
			}//end of else $working_time_days
		}//end of else $time_in_only

		if(!$time_in_valid) $work_status = "<span style='color:red;'>ASK THE HR STAFF REGARDING YOUR ATTENDANCE (Time In should be at least <b>1 hr</b> before the shift starts)</span>";

		$status = "Approved/Denied";
		if($User['attendance_status'] != "Pending")
			$status = $User['attendance_status'];

		$shift_details = "No shift schedule set.";
		$working_details = "No Schedule on this day";
		if($has_schedule){
			// $shift_type = statusColor($shift_type);
			$shift_details = "$shift_type<br>Shift Schedule: $shift_time_from TO $shift_time_to | Shift Break: $shift_break_time_from TO $shift_break_time_to<br>Expected Work: $expected_shift_schedule<br>Expected Break: $expected_shift_break";
			
			$working_details="$work_status<br>";
			$working_details.="<b>Working Hours: $working_time_display</b><br>
			<span style='color:gray;'>$status By: $attendance_approved_by</span>";
		}

		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['time_in_valid']=$time_in_valid;
		$jsonArrayItem['attendance_id']="{$User['attendance_id']}";
		$jsonArrayItem['attendance_code']="{$User['attendance_code']}";
		$jsonArrayItem['payroll_id']="{$User['payroll_id']}";	
		$jsonArrayItem['attendance_category']=$User['attendance_category'];
		$jsonArrayItem['attendance_type']=$User['attendance_type'];
		$jsonArrayItem['attendance_date_in']=$User['attendance_date_in'];
		$jsonArrayItem['attendance_date_in_description']=GetMonthDescription($User['attendance_date_in']);
		$jsonArrayItem['attendance_time_in']=$User['attendance_time_in'];
		$jsonArrayItem['attendance_requested_by']=$User['attendance_requested_by'];
		$jsonArrayItem['attendance_requested_by_name']=PersonName($User['attendance_requested_by']);
		$jsonArrayItem['attendance_date_out']=$User['attendance_date_out'];
		$jsonArrayItem['attendance_date_out_description']=GetMonthDescription($User['attendance_date_out']);
		$jsonArrayItem['attendance_time_out']=$User['attendance_time_out'];
		$jsonArrayItem['attendance_approved_by']=$User['attendance_approved_by'];
		$jsonArrayItem['attendance_approved_by_name']=PersonName($User['attendance_approved_by']);

		$attendance_category_color = statusColor($User['attendance_category']);
		$attendance_type_color = statusColor($User['attendance_type']);
		$day = date("l", strtotime($User['attendance_date_in']));
		$jsonArrayItem['attendance_details']="<b>$attendance_requested_by</b><br>
		<span data-bs-toggle='modal' data-bs-target='#modalViewShiftDetails' onclick='ViewShiftDetails(\"$shift_details\")'><i class='bx bx-info-circle'></i> </span> 
		Category: $attendance_category_color | 
		Type: $attendance_type_color | 
		Day: $day
		<br>
		Time-In: ".GetMonthDescription($User['attendance_date_in'])." @ {$User['attendance_time_in']} | 
		Time-Out: ".GetMonthDescription($User['attendance_date_out'])." @ {$User['attendance_time_out']}<br>$working_details";

		$attendance_added_by_name = PersonName("{$User['attendance_added_by']}");
		$jsonArrayItem['attendance_created_at']=$User['attendance_created_at'];
		$jsonArrayItem['attendance_created_at_by']="{$User['attendance_created_at']}<br><span style='color:gray;'>By: $attendance_added_by_name</span>";
		$jsonArrayItem['attendance_status']=$User['attendance_status'];
		$jsonArrayItem['attendance_status_description']=statusColor($User['attendance_status']);
		$jsonArrayItem['attendance_added_by']=$User['attendance_added_by'];
		$jsonArrayItem['attendance_added_by_name']=PersonName("{$User['attendance_added_by']}");
		array_push($results["data"], $jsonArrayItem);
	}

}

$data[] =$results["data"];
$results["sEcho"]=1;
$results["iTotalRecords"]=count($data);
$results["iTotalDisplayRecords"]=count($data);
echo json_encode($results);
?>