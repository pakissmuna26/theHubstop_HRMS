<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_leave_category ORDER BY leave_category_title ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['leave_category_id']="{$User['leave_category_id']}";
	$jsonArrayItem['leave_category_code']="{$User['leave_category_code']}";
	$jsonArrayItem['leave_category_title']=$User['leave_category_title'];
	$jsonArrayItem['leave_category_description']=$User['leave_category_description'];
	$jsonArrayItem['leave_category_quantity']=$User['leave_category_quantity'];	
	$jsonArrayItem['leave_category_paid_quantity']=$User['leave_category_paid_quantity'];	

	$jsonArrayItem['leave_category_created_at']=$User['leave_category_created_at'];
	$jsonArrayItem['leave_category_status']=$User['leave_category_status'];
	$jsonArrayItem['leave_category_status_description']=statusColor($User['leave_category_status']);
	$jsonArrayItem['leave_category_added_by']=$User['leave_category_added_by'];
	$jsonArrayItem['leave_category_added_by_name']=PersonName("{$User['leave_category_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>