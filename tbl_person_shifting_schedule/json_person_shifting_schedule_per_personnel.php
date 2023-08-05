<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>

<?php 
$obj = json_decode($_GET["data"], false);
$date_from = add_escape_character($obj->date_from);
$date_to = add_escape_character($obj->date_to);

$date_from_date = new DateTime($date_from);
$date_to_date = new DateTime($date_to);

$diff = $date_from_date->diff($date_to_date);
$days = $diff->d;

echo "<table class='table'>";
$more_date = $date_from;
echo "<tr>";
for($index = 0; $index <= $days; $index++){
	$more_date_description = GetMonthDescription($more_date);
	$day = date("l", strtotime($more_date));
	echo "<td class='text-center'>$more_date_description<br><i>$day</i></td>";
	$more_date = date("Y-m-d", strtotime($more_date."+ 1 day"));
}
echo "</tr>";

$query = "SELECT * FROM tbl_person INNER JOIN tbl_person_shifting_schedule 
ON tbl_person.person_id = tbl_person_shifting_schedule.person_id 
WHERE tbl_person_shifting_schedule.person_id = $signedin_person_id
ORDER BY tbl_person.last_name ASC";
$PersonSchedules = mysqli_query($connection, $query);
while ($PersonSchedule = mysqli_fetch_array($PersonSchedules)) {
	echo "<tr>";
	$more_date = $date_from;
	for($index = 0; $index <= $days; $index++){			
		$day = date("l", strtotime($more_date));
		
		$scheduled = "No";
		$scheduled_data = "<i class='bx bx-window-close' style='color:red;'></i><br>Day Off";
		$query = "SELECT * FROM tbl_person INNER JOIN tbl_person_shifting_schedule 
		ON tbl_person.person_id = tbl_person_shifting_schedule.person_id
		INNER JOIN tbl_shifting_schedule
		ON tbl_person_shifting_schedule.shifting_schedule_id = tbl_shifting_schedule.shifting_schedule_id
		WHERE tbl_person_shifting_schedule.person_id = {$PersonSchedule['person_id']}
		ORDER BY tbl_person.last_name ASC";
		$Schedules = mysqli_query($connection, $query);
		while ($Schedule = mysqli_fetch_array($Schedules)) {
			if($more_date >= $Schedule['effective_date'] && 
				$more_date <=  $Schedule['end_effective_date']){
				$scheduled = "Yes";

				$flag = "Yes";						
				if($day == "Monday")$flag=$Schedule['shifting_schedule_monday'];
				else if($day=="Tuesday")$flag=$Schedule['shifting_schedule_tuesday'];
				else if($day=="Wednesday")$flag=$Schedule['shifting_schedule_wednesday'];
				else if($day=="Thursday")$flag=$Schedule['shifting_schedule_thursday'];
				else if($day=="Friday")$flag=$Schedule['shifting_schedule_friday'];
				else if($day=="Saturday")$flag=$Schedule['shifting_schedule_saturday'];
				else if($day=="Sunday")$flag=$Schedule['shifting_schedule_sunday'];
				
				if($flag == "Yes"){
					$scheduled_data = "<i class='bx bx-calendar-check' style='color:green;'></i><br>{$Schedule['shifting_schedule_time_from']} TO {$Schedule['shifting_schedule_time_to']}<br>({$Schedule['shifting_schedule_break_time_from']} TO {$Schedule['shifting_schedule_break_time_to']})";
				}else{
					$scheduled_data = "<i class='bx bx-window-close' style='color:red;'></i><br>Day Off";
				}
			}//end of if
		}//end of while

		
		if($scheduled == "No"){
			echo "<td class='text-center'><i class='bx bx-time text-primary'></i><br>No Schedule</td>";
		}else{
			echo "<td class='text-center'>$scheduled_data</td>";
		}
		$more_date = date("Y-m-d", strtotime($more_date."+ 1 day"));

	}//end of for
	echo "</tr>";	
}//end of while $PersonSchedule
echo "</table>";

?>