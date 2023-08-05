<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_leave_request ORDER BY leave_request_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();		
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['leave_request_id']="{$User['leave_request_id']}";
	$jsonArrayItem['leave_request_code']="{$User['leave_request_code']}";
	$jsonArrayItem['leave_request_by']=$User['leave_request_by'];
	$jsonArrayItem['leave_request_by_name']=PersonName($User['leave_request_by']);
	$jsonArrayItem['leave_request_category_id']=$User['leave_request_category_id'];
	$jsonArrayItem['leave_request_category']=LeaveCategory($User['leave_request_category_id']);
	$jsonArrayItem['leave_request_date_from']=$User['leave_request_date_from'];
	$jsonArrayItem['leave_request_date_from_description']=GetMonthDescription($User['leave_request_date_from']);
	$jsonArrayItem['leave_request_date_to']=$User['leave_request_date_to'];
	$jsonArrayItem['leave_request_date_to_description']=GetMonthDescription($User['leave_request_date_to']);
	$jsonArrayItem['leave_request_remarks']=$User['leave_request_remarks'];
	$jsonArrayItem['leave_request_approved_by']=$User['leave_request_approved_by'];
	$jsonArrayItem['leave_request_approved_by_name']=PersonName($User['leave_request_approved_by']);
	$jsonArrayItem['leave_request_approved_by_date_time']=$User['leave_request_approved_by_date_time'];

	$leave_request_added_by_name = PersonName("{$User['leave_request_added_by']}");
	$jsonArrayItem['leave_request_created_at']=$User['leave_request_created_at'];
	$jsonArrayItem['leave_request_created_at_by']="{$User['leave_request_created_at']}<br><span style='color:gray;'>By: $leave_request_added_by_name</span>";
	
	$jsonArrayItem['leave_request_status']=$User['leave_request_status'];
	$jsonArrayItem['leave_request_status_description']=statusColor($User['leave_request_status']);
	$jsonArrayItem['leave_request_added_by']=$User['leave_request_added_by'];
	$jsonArrayItem['leave_request_added_by_name']=PersonName("{$User['leave_request_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>