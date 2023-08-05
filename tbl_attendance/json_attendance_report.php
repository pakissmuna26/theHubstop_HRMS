<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];

	$obj = json_decode($_GET["data"], false);
	$date_from = add_escape_character($obj->date_from);
	$date_to = add_escape_character($obj->date_to);
	$personnel = add_escape_character($obj->personnel);

?>
<?php
$table_list = "";
$total_working_hours = $total_working_minutes = 0;
$filterCounter=0;
$array_type = [0, 0, 0];
$array_category = [0, 0];
$array_status = [0, 0, 0, 0];
// $time_in_out_status = [0, 0, 0, 0, 0];
$query = "SELECT * FROM tbl_attendance 
WHERE attendance_requested_by = $personnel AND 
attendance_date_in >= \"$date_from\" AND 
attendance_date_in <= \"$date_to\" 
ORDER BY attendance_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	
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

	$shift_type = "";
	if((int)$shift_time_from_hours > (int)$shift_time_to_hours) {
		$shift_type = "Night Shift";

		if($attendance_from_hours >= ($shift_time_from_hours-1) ||   
			$attendance_from_hours >= $shift_time_from_hours &&  
			$attendance_from_hours <= 23 && 
			$attendance_from_minutes <= 59){
			// $date_attendance_from = "{$User['attendance_date_in']}";
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
	if($User['attendance_type'] == "Daily"){
		$array_type[0] = $array_type[0] + 1;
	}else if($User['attendance_type'] == "Overtime"){
		$array_type[1] = $array_type[1] + 1;
	}else if($User['attendance_type'] == "Leave Request"){
		$array_type[2] = $array_type[2] + 1;
	}

	if($User['attendance_category'] == "Manual"){
		$array_category[0] = $array_category[0] + 1;
	}else if($User['attendance_category'] == "RFID"){
		$array_category[1] = $array_category[1] + 1;
	}

	if($User['attendance_status'] == "Pending"){
		$array_status[0] = $array_status[0] + 1;
	}else if($User['attendance_status'] == "Approved"){
		$array_status[1] = $array_status[1] + 1;
	}else if($User['attendance_status'] == "Denied"){
		$array_status[2] = $array_status[2] + 1;
	}else if($User['attendance_status'] == "Payroll"){
		$array_status[3] = $array_status[3] + 1;
	}

	$status = "Approved/Denied";
	if($User['attendance_status'] != "Pending")
		$status = $User['attendance_status'];
	$attendance_approved_by = PersonName($User['attendance_approved_by']);

	$working_details = "No Schedule on this day";
	if($has_schedule){
		$working_details="$work_status<br><span style='color:gray;'>$status By: $attendance_approved_by</span>";
	}

	$total_working_hours += $working_time_hours;
	$total_working_minutes += $working_time_minutes;
	$table_list.="<tr>
		<td>$filterCounter</td>
		<td>Time In: ".GetMonthDescription($User['attendance_date_in'])." @ {$User['attendance_time_in']} | Time Out: ".GetMonthDescription($User['attendance_date_out'])." @ {$User['attendance_time_out']}<br>
			$working_details
		</td>
		<td>$day</td>
		<td>$working_time_hours HR/S $working_time_minutes MIN/S</td>
		<td>".statusColor($User['attendance_category'])."</td>
		<td>".statusColor($User['attendance_type'])."</td>
		<td>".statusColor($User['attendance_status'])."</td>
	</tr>";
}
	$get_hours_in_total_working_minutes = floor($total_working_minutes/60);
	$total_working_hours+=$get_hours_in_total_working_minutes;

	$get_remaining_minutes = $total_working_minutes - ($get_hours_in_total_working_minutes*60);
	$total_working_minutes+=$get_remaining_minutes;

?>

<div class='row'>
	<div class='col-lg-12'>
		<div class='card'>
			<div class='card-body'>
				<div class='row'>
					<div class='col-lg-12'>
<?php 
$query = "SELECT * FROM tbl_person 
WHERE person_id = $personnel
ORDER BY person_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	echo "<h6>{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} {$User['middle_name']}</h6>
	<span>
		Address: {$User['house_number']}, {$User['barangay']}, {$User['city']}, {$User['province']}, {$User['region']}<br>
		Contact #: +639 {$User['contact_number']}<br>
	</span>";
	break;
}
?>
					</div>
				</div>
			</div>
		</div>
	</div>  

	<div class='col-lg-12'>
		<div class='card'>
			<div class='card-body'>
				<div class='row'>
					<div class='col-lg-12'>

<?php 	
	echo "<h6>Working Hours: $total_working_hours HR/S $total_working_minutes MIN/S</h6>";
	$total_category = $array_category[0]+$array_category[1];
	
	$avg_cat1 = $avg_cat2 = 0;
	if($array_category[0] != 0)
		$avg_cat1 = number_format((($array_category[0]/$total_category)*100),2);
	if($array_category[1] != 0)
		$avg_cat2 = number_format((($array_category[1]/$total_category)*100),2);
	echo "<table class='table'>
		<tr>
			<td>Attendance Category:</td>
			<td>Manual: <b>".$array_category[0]." ($avg_cat1%)</b></td>
			<td>RFID: <b>".$array_category[1]." ($avg_cat2%)</b></td>
			<td></td>
			<td></td>
		</tr>";

	$total_type = $array_type[0] + $array_type[1] + $array_type[2];		
	$avg_type1 = $avg_type2 = $avg_type3 = 0;
	if($array_type[0] != 0)
		$avg_type1 = number_format((($array_type[0]/$total_type)*100),2);
	if($array_type[1] != 0)
		$avg_type2 = number_format((($array_type[1]/$total_type)*100),2);
	if($array_type[2] != 0)
		$avg_type3 = number_format((($array_type[2]/$total_type)*100),2);
		echo "<tr>
			<td>Attendance Type:</td>
			<td>Daily: <b>".$array_type[0]." ($avg_type1%)</b></td>
			<td>Overtime: <b>".$array_type[1]." ($avg_type2%)</b></td>
			<td>Leave Request: <b>".$array_type[2]." ($avg_type3%)</b></td>
			<td></td>
		</tr>";		

	$total_status = $array_status[0] + $array_status[1] + $array_status[2] + $array_status[3];
	$avg_status1 = $avg_status2 = $avg_status3 = $avg_status4 = 0;
	if($array_status[0] != 0)
		$avg_status1 = number_format((($array_status[0]/$total_status)*100),2);
	if($array_status[1] != 0)
		$avg_status2 = number_format((($array_status[1]/$total_status)*100),2);
	if($array_status[2] != 0)
		$avg_status3 = number_format((($array_status[2]/$total_status)*100),2);
	if($array_status[3] != 0)
		$avg_status4 = number_format((($array_status[3]/$total_status)*100),2);
		echo "<tr>
			<td>Attendance Status:</td>
			<td>Pending: <b>".$array_status[0]." ($avg_status1%)</b></td>
			<td>Approved: <b>".$array_status[1]." ($avg_status2%)</b></td>
			<td>Denied: <b>".$array_status[2]." ($avg_status3%)</b></td>
			<td>Payroll: <b>".$array_status[3]." ($avg_status4%)</b></td>
		</tr>";

		// echo "<tr>
		// 	<td>Early In</td>
		// 	<td>On Time</td>
		// 	<td>Late</td>
		// 	<td>Half Day</td>
		// 	<td>Overtime</td>
		// </tr>";
	echo "</table>";
?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class='row'><div class='col-lg-12'>
	<div class='card'><div class='card-body'>
		<div class='row'><div class='col-lg-12'>
			<h6>List of Attendance</h6>
			<table class='table'>
				<tr>
					<th style="width: 5%;">No.</th>
					<th style="width: 50%;">Time In & Out</th>
					<th style="width: 10%;">Day</th>
					<th style="width: 20%;">Working Hours</th>
					<th style="width: 5%;">Category</th>
					<th style="width: 5%;">Type</th>
					<th style="width: 5%;">Status</th>
				</tr>
				<?php 
				echo "$table_list";
				?>
			</table>
		</div></div>
    </div></div>
</div></div>