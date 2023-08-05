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
	}
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