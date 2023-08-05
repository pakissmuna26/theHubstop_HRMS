<?php 
$query = "SELECT * FROM tbl_person_shifting_schedule 
INNER JOIN tbl_shifting_schedule
ON tbl_person_shifting_schedule.shifting_schedule_id = tbl_shifting_schedule.shifting_schedule_id
WHERE tbl_person_shifting_schedule.person_id = {$User['attendance_requested_by']} AND tbl_person_shifting_schedule.person_shifting_schedule_status=\"Activated\"
ORDER BY tbl_person_shifting_schedule.person_shifting_schedule_id DESC";
$shifting_schedules = mysqli_query($connection, $query);
while ($shifting_schedule = mysqli_fetch_array($shifting_schedules)) {
	// JULY 05, 2023 <= AUGUST 1, 2023 && AUGUST 15 >= AUGUST 1, 2023
	if($shifting_schedule['effective_date'] <= $User['attendance_date_in'] &&
		  $shifting_schedule['end_effective_date'] >= $User['attendance_date_in']){

		$day = date("l", strtotime($User['attendance_date_in']));
		$flag = "Yes";						
		if($day == "Monday")$flag=$shifting_schedule['shifting_schedule_monday'];
		else if($day=="Tuesday")$flag=$shifting_schedule['shifting_schedule_tuesday'];
		else if($day=="Wednesday")$flag=$shifting_schedule['shifting_schedule_wednesday'];
		else if($day=="Thursday")$flag=$shifting_schedule['shifting_schedule_thursday'];
		else if($day=="Friday")$flag=$shifting_schedule['shifting_schedule_friday'];
		else if($day=="Saturday")$flag=$shifting_schedule['shifting_schedule_saturday'];
		else if($day=="Sunday")$flag=$shifting_schedule['shifting_schedule_sunday'];
		
		if($flag == "Yes"){
			$has_schedule = true;
			$shift_time_from=$shifting_schedule['shifting_schedule_time_from'];
			$shift_time_to=$shifting_schedule['shifting_schedule_time_to'];
			$shift_break_time_from=$shifting_schedule['shifting_schedule_break_time_from'];
			$shift_break_time_to=$shifting_schedule['shifting_schedule_break_time_to'];
		}

		
		break;
	}
}

?>