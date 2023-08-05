<?php 
// COMPUTE WORKING HOURS
$break_time = $break_from->diff($break_to);
$break_time_hours = $break_time->h;
$break_time_minutes = $break_time->i;
$deduction_work_and_break=($break_time_hours*60)+$break_time_minutes;
			
if($time_in < $shift_from && $time_out <= $break_to){ // checked
	$work_status = "Before Break: ".statusColor("Early In")." & ".statusColor("Early Out")." | After Break: ".statusColor("No Attendance");
	if($time_out > $shift_from && $time_out < $break_from){
		$working_time = $shift_from->diff($time_out);
		$working_time_hours = $working_time->h;
		$working_time_minutes = $working_time->i;
	}else if($time_out > $shift_from && $time_out >= $break_from && $time_out <= $break_to){
		$working_time = $shift_from->diff($break_from);
		$working_time_hours = $working_time->h;
		$working_time_minutes = $working_time->i;
	}else{
		$work_status = "a Before Break: ".statusColor("Not Valid")." | After Break: ".statusColor("Not Valid");
		$working_time_hours = 0;
		$working_time_minutes = 0;
	}
}


if($time_in >= $shift_from && $time_out <= $break_to){ // checked
	if($time_in == $shift_from)
		$work_status = "Before Break: ".statusColor("On Time")." & ".statusColor("Half Day")." | After Break: ".statusColor("No Attendance");
	if($time_in > $shift_from)
		$work_status = "Before Break: ".statusColor("Late")." & ".statusColor("Half Day")." | After Break: ".statusColor("No Attendance");
	$working_time = $time_in->diff($time_out);	
	$working_time_hours = $working_time->h;
	$working_time_minutes = $working_time->i;
	$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;

	if($time_out < $break_from){
		$deduction_work_and_break=0;			
	}else if($time_out >= $break_from && $time_out <= $break_to){
		$break_time = $break_from->diff($time_out);
		$break_time_hours = $break_time->h;
		$break_time_minutes = $break_time->i;
		$deduction_work_and_break=($break_time_hours*60)+$break_time_minutes;	
	}

	if($time_out >= $break_from && $time_out <= $break_to){
		$rem = $get_minutes_work_time - $deduction_work_and_break;
		$rem_in_hours = floor($rem/60);
		$rem_in_minutes = $rem - ($rem_in_hours*60);
		$working_time_hours = $rem_in_hours;
		$working_time_minutes = $rem_in_minutes;
	}
}

if($time_in >= $shift_from && $time_in < $break_to && $time_out > $break_to && $time_out < $shift_to){ // checked
	if($time_in == $shift_from)
		$work_status = "Before Break: ".statusColor("On Time")." | After Break: ".statusColor("Early Out");
	if($time_in > $shift_from)
		$work_status = "Before Break: ".statusColor("Late")." | After Break: ".statusColor("Early Out");

	if($time_in > $break_from){
		$working_time = $break_to->diff($time_out);	
		$working_time_hours = $working_time->h;
		$working_time_minutes = $working_time->i;
		$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;
	}else{
		$working_time = $time_in->diff($time_out);	
		$working_time_hours = $working_time->h;
		$working_time_minutes = $working_time->i;
		$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;

	}

	if($time_in > $break_from && $time_in < $break_to){
		$deduction_work_and_break=0;
	}
	$rem = $get_minutes_work_time - $deduction_work_and_break;
	$rem_in_hours = floor($rem/60);
	$rem_in_minutes = $rem - ($rem_in_hours*60);
	$working_time_hours = $rem_in_hours;
	$working_time_minutes = $rem_in_minutes;
}

if($time_in >= $shift_from && $time_out > $break_to && $time_out == $shift_to){ // checked
	if($time_in == $shift_from)
		$work_status = "Before Break: ".statusColor("On Time")." | After Break: ".statusColor("On Time");
	if($time_in > $shift_from)
		$work_status = "Before Break: ".statusColor("Late")." | After Break: ".statusColor("On Time");
	$working_time = $time_in->diff($time_out);	
	$working_time_hours = $working_time->h;
	$working_time_minutes = $working_time->i;
	$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;

	if($time_in < $break_to){
		$rem = $get_minutes_work_time - $deduction_work_and_break;
		$rem_in_hours = floor($rem/60);
		$rem_in_minutes = $rem - ($rem_in_hours*60);
		$working_time_hours = $rem_in_hours;
		$working_time_minutes = $rem_in_minutes;
	}

}

if($time_in >= $shift_from && $time_in < $break_to && $time_out > $break_to && $time_out > $shift_to){ // checked
	if($time_in == $shift_from)
		$work_status = "Before Break: ".statusColor("On Time")." | After Break: ".statusColor("Overtime");
	if($time_in > $shift_from)
		$work_status = "Before Break: ".statusColor("Late")." | After Break: ".statusColor("Overtime");

	if($time_in > $break_from){
		$working_time = $break_to->diff($time_out);	
		$working_time_hours = $working_time->h;
		$working_time_minutes = $working_time->i;
		$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;
	}else{
		$working_time = $time_in->diff($time_out);	
		$working_time_hours = $working_time->h;
		$working_time_minutes = $working_time->i;
		$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;
	}

	// GET OVERTIME
	$over_time = $time_out->diff($shift_to);	
	$over_time_hours = $over_time->h;
	$over_time_minutes = $over_time->i;
	$get_minutes_over_time=($over_time_hours*60)+$over_time_minutes;
	// END OF GET OVERTIME

	if($time_in > $break_from){
		$deduction_work_and_break=0;
	}
	$rem = $get_minutes_work_time - ($deduction_work_and_break+$get_minutes_over_time);
	$rem_in_hours = floor($rem/60);
	$rem_in_minutes = $rem - ($rem_in_hours*60);
	$working_time_hours = $rem_in_hours;
	$working_time_minutes = $rem_in_minutes;
}

if($time_in >= $break_from && $time_out <= $break_to){ 
	// checked
	$work_status = statusColor("Break Time");
	$working_time = $time_in->diff($time_out);	
	$working_time_hours = 0;
	$working_time_minutes = 0;
}

if($time_in >= $break_to && $time_out <= $shift_to){ 
	// checked
	if($time_out < $shift_to)
		$work_status = "Before Break: ".statusColor("No Attendance")." | After Break: ".statusColor("Early Out");
	if($time_out == $shift_to)
		$work_status = "Before Break: ".statusColor("No Attendance")." | After Break: ".statusColor("On Time");
	$working_time = $time_in->diff($time_out);	
	$working_time_hours = $working_time->h;
	$working_time_minutes = $working_time->i;
}

if($time_in >= $break_to && $time_in <= $shift_to && $time_out > $shift_to){ 
	// checked
	$work_status = "Before Break: ".statusColor("No Attendance")." | After Break: ".statusColor("Overtime");
	$working_time = $time_in->diff($time_out);	
	$working_time_hours = $working_time->h;
	$working_time_minutes = $working_time->i;
	$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;

	// GET OVERTIME
	$over_time = $time_out->diff($shift_to);	
	$over_time_hours = $over_time->h;
	$over_time_minutes = $over_time->i;
	$get_minutes_over_time=($over_time_hours*60)+$over_time_minutes;
	// END OF GET OVERTIME

	if($time_in > $break_from){
		$deduction_work_and_break=0;
	}
	$rem = $get_minutes_work_time - ($deduction_work_and_break+$get_minutes_over_time);
	$rem_in_hours = floor($rem/60);
	$rem_in_minutes = $rem - ($rem_in_hours*60);
	$working_time_hours = $rem_in_hours;
	$working_time_minutes = $rem_in_minutes;
}

if($time_in < $shift_from && $time_out > $shift_to){ //checked
	$work_status = "Before Break: ".statusColor("Early In")." | After Break: ".statusColor("Overtime");
	$working_time = $shift_from->diff($shift_to);
	$working_time_hours = $working_time->h;
	$working_time_minutes = $working_time->i;
	$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;

	$rem = $get_minutes_work_time - $deduction_work_and_break;
	$rem_in_hours = floor($rem/60);
	$rem_in_minutes = $rem - ($rem_in_hours*60);
	$working_time_hours = $rem_in_hours;
	$working_time_minutes = $rem_in_minutes;
}

if($time_in < $shift_from && $time_out < $shift_to && $time_out > $break_to){ // checked
	$work_status = "Before Break: ".statusColor("Early In")." | After Break: ".statusColor("Early Out");
	$working_time = $shift_from->diff($time_out);
	$working_time_hours = $working_time->h;
	$working_time_minutes = $working_time->i;
	$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;

	$rem = $get_minutes_work_time - $deduction_work_and_break;
	$rem_in_hours = floor($rem/60);
	$rem_in_minutes = $rem - ($rem_in_hours*60);
	$working_time_hours = $rem_in_hours;
	$working_time_minutes = $rem_in_minutes;
}

if($time_in < $shift_from && $time_out == $shift_to){ //checked
	$work_status = "Before Break: ".statusColor("Early In")." | After Break: ".statusColor("On Time");
	$working_time = $shift_from->diff($shift_to);
	$working_time_hours = $working_time->h;
	$working_time_minutes = $working_time->i;
	$get_minutes_work_time=($working_time_hours*60)+$working_time_minutes;

	$rem = $get_minutes_work_time - $deduction_work_and_break;
	$rem_in_hours = floor($rem/60);
	$rem_in_minutes = $rem - ($rem_in_hours*60);
	$working_time_hours = $rem_in_hours;
	$working_time_minutes = $rem_in_minutes;
}

if($time_in > $shift_to && $time_out > $shift_to){ //checked
	$work_status = "Before Break: ".statusColor("Not Valid")." | After Break: ".statusColor("Not Valid");
	$working_time_hours = 0;
	$working_time_minutes = 0;
}

$working_time_display="$working_time_hours HR/S $working_time_minutes MIN/S";
// COMPUTE WORKING HOURS
?>