<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_job_position ORDER BY job_position_title ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['job_position_id']="{$User['job_position_id']}";
	$jsonArrayItem['job_position_code']="{$User['job_position_code']}";
	$jsonArrayItem['job_position_title']=$User['job_position_title'];
	$jsonArrayItem['job_position_description']=$User['job_position_description'];	

	$jsonArrayItem['job_position_created_at']=$User['job_position_created_at'];
	$jsonArrayItem['job_position_status']=$User['job_position_status'];
	$jsonArrayItem['job_position_status_description']=statusColor($User['job_position_status']);
	$jsonArrayItem['job_position_added_by']=$User['job_position_added_by'];
	$jsonArrayItem['job_position_added_by_name']=PersonName("{$User['job_position_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>