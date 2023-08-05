<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_payroll_period ORDER BY payroll_period_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['payroll_period_id']="{$User['payroll_period_id']}";
	$jsonArrayItem['payroll_period_code']="{$User['payroll_period_code']}";
	$jsonArrayItem['payroll_period_title']=$User['payroll_period_title'];
	$jsonArrayItem['payroll_period_from']=$User['payroll_period_from'];	
	$jsonArrayItem['payroll_period_to']=$User['payroll_period_to'];	
	$jsonArrayItem['payroll_period_cutoff_from']=$User['payroll_period_cutoff_from'];	
	$jsonArrayItem['payroll_period_cutoff_to']=$User['payroll_period_cutoff_to'];	

	$jsonArrayItem['payroll_period_created_at']=$User['payroll_period_created_at'];
	$jsonArrayItem['payroll_period_status']=$User['payroll_period_status'];
	$jsonArrayItem['payroll_period_status_description']=statusColor($User['payroll_period_status']);
	$jsonArrayItem['payroll_period_added_by']=$User['payroll_period_added_by'];
	$jsonArrayItem['payroll_period_added_by_name']=PersonName("{$User['payroll_period_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>