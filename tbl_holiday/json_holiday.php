<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_holiday ORDER BY holiday_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['holiday_id']="{$User['holiday_id']}";
	$jsonArrayItem['holiday_code']="{$User['holiday_code']}";
	$jsonArrayItem['holiday_title']=$User['holiday_title'];
	$jsonArrayItem['holiday_description']=$User['holiday_description'];	
	$jsonArrayItem['holiday_date_from']=$User['holiday_date_from'];
	$jsonArrayItem['holiday_date_from_description']=GetMonthDescription($User['holiday_date_from']);
	$jsonArrayItem['holiday_date_to']=$User['holiday_date_to'];
	$jsonArrayItem['holiday_date_to_description']=GetMonthDescription($User['holiday_date_to']);
	$jsonArrayItem['holiday_is_paid']=$User['holiday_is_paid'];

	$jsonArrayItem['holiday_created_at']=$User['holiday_created_at'];
	$jsonArrayItem['holiday_status']=$User['holiday_status'];
	$jsonArrayItem['holiday_status_description']=statusColor($User['holiday_status']);
	$jsonArrayItem['holiday_added_by']=$User['holiday_added_by'];
	$jsonArrayItem['holiday_added_by_name']=PersonName("{$User['holiday_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>