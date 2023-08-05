<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_contract_payroll_period ORDER BY contract_payroll_period_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['contract_payroll_period_id']="{$User['contract_payroll_period_id']}";
	$jsonArrayItem['contract_payroll_period_code']="{$User['contract_payroll_period_code']}";
	$jsonArrayItem['contract_id']=$User['contract_id'];
	$jsonArrayItem['payroll_period_id']=$User['payroll_period_id'];

	$jsonArrayItem['contract_payroll_period_created_at']=$User['contract_payroll_period_created_at'];
	$jsonArrayItem['contract_payroll_period_status']=$User['contract_payroll_period_status'];
	$jsonArrayItem['contract_payroll_period_status_description']=statusColor($User['contract_payroll_period_status']);
	$jsonArrayItem['contract_payroll_period_added_by']=$User['contract_payroll_period_added_by'];
	$jsonArrayItem['contract_payroll_period_added_by_name']=PersonName("{$User['contract_payroll_period_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>