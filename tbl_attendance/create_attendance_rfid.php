<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php //include("../includes/session.php");?>

<?php 
$obj = json_decode($_GET["data"], false);
$person_id = add_escape_character($obj->person_id);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("H:i");
$timeEncodedData = date("h:i:s A");

$is_time_in = true;
$attendance_id = 0;

$valid_time_in=true;
$time_out_gap_minutes = 0;

$valid_time_out=true;
$time_in_gap_minutes = 0;

$get_time_in = $get_time_out = "";
$get_time_in_display = $get_time_out_display = "";
$query = "SELECT * FROM tbl_attendance
WHERE attendance_requested_by = $person_id AND 
attendance_category = \"RFID\"
ORDER BY attendance_id DESC LIMIT 1";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($User['attendance_date_in'] != "" && $User['attendance_time_out'] == ""){
		$is_time_in = false;
		$attendance_id = $User['attendance_id'];
		$get_time_in = "{$User['attendance_date_in']} {$User['attendance_time_in']}";
		$get_time_in_display = "Date: ".GetMonthDescription($User['attendance_date_in'])." | Time: {$User['attendance_time_in']}";
		$time_in = new DateTime($get_time_in);
		$get_time_out_now = "$dateEncoded $timeEncoded";
		$time_out_now = new DateTime($get_time_out_now);
		$time_in_gap = $time_in->diff($time_out_now);
		$time_in_gap_hours = $time_in_gap->h;
		$time_in_gap_minutes = $time_in_gap->i;
		$time_in_gap_total_minutes=($time_in_gap_hours*60)+$time_in_gap_minutes;
		if($time_in_gap_total_minutes <= 60){
			$valid_time_out=false;
		}
	}else{
		$is_time_in = true;
		$attendance_id = 0;
		$get_time_out = "{$User['attendance_date_out']} {$User['attendance_time_out']}";
		$get_time_out_display = "Date: ".GetMonthDescription($User['attendance_date_out'])." | Time: {$User['attendance_time_out']}";
		$time_out = new DateTime($get_time_out);
		$get_time_in_now = "$dateEncoded $timeEncoded";
		$time_in_now = new DateTime($get_time_in_now);
		$time_out_gap = $time_out->diff($time_in_now);
		$time_out_gap_hours = $time_out_gap->h;
		$time_out_gap_minutes = $time_out_gap->i;
		$time_out_gap_total_minutes=($time_out_gap_hours*60)+$time_out_gap_minutes;	
		if($time_out_gap_total_minutes <= 60){
			$valid_time_in=false;
		}

	}
}

$early_in_status = false;
$shift_time_from = $shift_time_to = "";
$shift_break_time_from = $shift_break_time_to = "";
$has_schedule=false;
if($is_time_in){
	$query = "SELECT * FROM tbl_person_shifting_schedule 
	INNER JOIN tbl_shifting_schedule
	ON tbl_person_shifting_schedule.shifting_schedule_id = tbl_shifting_schedule.shifting_schedule_id
	WHERE tbl_person_shifting_schedule.person_id = $person_id AND tbl_person_shifting_schedule.person_shifting_schedule_status=\"Activated\"
	ORDER BY tbl_person_shifting_schedule.person_shifting_schedule_id DESC";
	$shifting_schedules = mysqli_query($connection, $query);
	while ($shifting_schedule = mysqli_fetch_array($shifting_schedules)) {
		// JULY 05, 2023 <= AUGUST 1, 2023 && AUGUST 15 >= AUGUST 1, 2023
		if($shifting_schedule['effective_date'] <= $dateEncoded &&
			  $shifting_schedule['end_effective_date'] >= $dateEncoded){

			$day = date("l", strtotime($dateEncoded));
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

	// CHECK ATTENDANCE
	$attendance_from_hours = substr("$dateEncoded", 0, 2);
	$attendance_from_minutes = substr("$dateEncoded", 3, 2);
	// END OF CHECK ATTENDANCE

	// CHECK SHIFT SCHEDULE
	$shift_time_from_hours = substr($shift_time_from, 0, 2);
	$shift_time_from_minutes = substr($shift_time_from, 3, 2);
	// END OF CHECK SHIFT SCHEDULE

	if($attendance_from_hours >= ($shift_time_from_hours-1) ||   
		$attendance_from_hours >= $shift_time_from_hours &&  
		$attendance_from_hours <= 23 && 
		$attendance_from_minutes <= 59){
		
		$early_in_status = true;
	}
}
// $valid_time_out=true;

if($is_time_in){
	if(!$valid_time_in){
	$jsonArray = array();
	$jsonArrayItem=array();
	$jsonArrayItem['type']="Time In is not valid";
	$jsonArrayItem['date_and_time']="<br>You already Time-Out $time_out_gap_minutes min/s ago<br>$get_time_out_display";
	$jsonArrayItem['name']=PersonName($person_id);
	array_push($jsonArray, $jsonArrayItem);
	$connection->close();
	header('Content-type: application/json');
	echo json_encode($jsonArray);
	}else{
		if($early_in_status){
			$jsonArray = array();
			$jsonArrayItem=array();
			$jsonArrayItem['type']="Time In is not valid";
			$jsonArrayItem['date_and_time']="<br>Time In should be at least <b>1 hr</b> before your shift starts @ $shift_time_from</b>";
			$jsonArrayItem['name']=PersonName($person_id);
			array_push($jsonArray, $jsonArrayItem);
			$connection->close();
			header('Content-type: application/json');
			echo json_encode($jsonArray);
		}else{
			$attendance_category = "RFID";
			$attendance_type = "Daily";
			$attendance_date_in = $dateEncoded;
			$attendance_time_in = $timeEncoded;
			$attendance_date_out = "";
			$attendance_time_out = "";
			$attendance_requested_by = $person_id;
			$attendance_approved_by = 0;
			$status = "Pending";

			$attendance_id = 0;
			$query = "SELECT * FROM tbl_attendance
			ORDER BY attendance_id ASC";
			$Users = mysqli_query($connection, $query);
			while ($User = mysqli_fetch_array($Users)) {
				$attendance_id = $User['attendance_id'];
			}
			$attendance_id++;

			$generated_code = GenerateDisplayId("ATTENDANCE", $attendance_id);

			$sql = "INSERT INTO tbl_attendance VALUES ($attendance_id,'$generated_code','$attendance_category','$attendance_type','$attendance_date_in', '$attendance_time_in','$attendance_date_out', '$attendance_time_out', $attendance_requested_by,$attendance_approved_by,'$dateEncoded @ $timeEncodedData','$status',$person_id, 0)";
			if(mysqli_query($connection, $sql)){	

				$attendance_requested_by_name = PersonName($attendance_requested_by);
				$attendance_approved_by_name = PersonName($attendance_approved_by);
				Create_Logs("NEW ATTENDANCE (TIME-IN RFID)",$attendance_id, "CREATE","New attendance successfully saved<br>Time-In: $attendance_date_in @ $attendance_time_in<br>Status: $status",$person_id);

				$jsonArray = array();
				$jsonArrayItem=array();
				$jsonArrayItem['type']="Time In !";
				$jsonArrayItem['date_and_time'] = "Date: ".GetMonthDescription($dateEncoded)." | Time: $timeEncoded";
				$jsonArrayItem['name']=PersonName($person_id);
				array_push($jsonArray, $jsonArrayItem);
				$connection->close();
				header('Content-type: application/json');
				echo json_encode($jsonArray);
			}else{
				$jsonArray = array();
				$jsonArrayItem=array();
				$jsonArrayItem['type']="Error";
				$jsonArrayItem['date_and_time'] = "Attendance Error: ".$connection->error." || ".$sql;
				$jsonArrayItem['name']="";
				array_push($jsonArray, $jsonArrayItem);
				$connection->close();
				header('Content-type: application/json');
				echo json_encode($jsonArray);
			}
		}//end of else $early_in_status
	}//end of else $valid_time_in
}else if(!$is_time_in){
	if(!$valid_time_out){
		$jsonArray = array();
		$jsonArrayItem=array();
		$jsonArrayItem['type']="Time Out is not valid";
		$jsonArrayItem['date_and_time']="<br>You already Time-In $time_in_gap_minutes min/s ago<br>$get_time_in_display";
		$jsonArrayItem['name']=PersonName($person_id);
		array_push($jsonArray, $jsonArrayItem);
		$connection->close();
		header('Content-type: application/json');
		echo json_encode($jsonArray);
	}else{
		$attendance_date_out = $dateEncoded;
		$attendance_time_out = $timeEncoded;
		$attendance_requested_by = $person_id;

		$sql = "UPDATE tbl_attendance 
		SET attendance_date_out = '$attendance_date_out',
		attendance_time_out = '$attendance_time_out'
		WHERE attendance_id = $attendance_id";
		if(mysqli_query($connection, $sql)){
			
			$attendance_requested_by_name = PersonName($attendance_requested_by);
			Create_Logs("NEW ATTENDANCE (TIME-OUT RFID)",$attendance_id, "UPDATE","New attendance successfully saved<br>New Information<br>Time-Out: $attendance_date_out @ $attendance_time_out",$person_id);
			
			$jsonArray = array();
			$jsonArrayItem=array();
			$jsonArrayItem['type']="Time Out !";
			$jsonArrayItem['date_and_time'] = "Date: ".GetMonthDescription($dateEncoded)." | Time: $timeEncoded";
			$jsonArrayItem['name']=PersonName($person_id);
			array_push($jsonArray, $jsonArrayItem);
			$connection->close();
			header('Content-type: application/json');
			echo json_encode($jsonArray);
		}else{
			$jsonArray = array();
			$jsonArrayItem=array();
			$jsonArrayItem['type']="Error";
			$jsonArrayItem['date_and_time'] = "Updating Attendance Error: ".$connection->error." || ".$sql;
			$jsonArrayItem['name']="";
			array_push($jsonArray, $jsonArrayItem);
			$connection->close();
			header('Content-type: application/json');
			echo json_encode($jsonArray);
		}
	}
}else{
	$jsonArray = array();
	$jsonArrayItem=array();
	$jsonArrayItem['type']="Error";
	$jsonArrayItem['date_and_time']="";
	$jsonArrayItem['name']="";
	array_push($jsonArray, $jsonArrayItem);
	$connection->close();
	header('Content-type: application/json');
	echo json_encode($jsonArray);
}



?>