<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_attendance ORDER BY attendance_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();		
	$jsonArrayItem['number']=$filterCounter;
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

	$attendance_added_by_name = PersonName("{$User['attendance_added_by']}");
	$jsonArrayItem['attendance_created_at']=$User['attendance_created_at'];
	$jsonArrayItem['attendance_created_at_by']="{$User['attendance_created_at']}<br><span style='color:gray;'>By: $attendance_added_by_name</span>";
	$jsonArrayItem['attendance_status']=$User['attendance_status'];
	$jsonArrayItem['attendance_status_description']=statusColor($User['attendance_status']);
	$jsonArrayItem['attendance_added_by']=$User['attendance_added_by'];
	$jsonArrayItem['attendance_added_by_name']=PersonName("{$User['attendance_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>