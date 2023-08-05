<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_contract_branch ORDER BY contract_branch_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['contract_branch_id']="{$User['contract_branch_id']}";
	$jsonArrayItem['contract_branch_code']="{$User['contract_branch_code']}";
	$jsonArrayItem['contract_id']=$User['contract_id'];
	$jsonArrayItem['branch_id']=$User['branch_id'];

	$jsonArrayItem['contract_branch_created_at']=$User['contract_branch_created_at'];
	$jsonArrayItem['contract_branch_status']=$User['contract_branch_status'];
	$jsonArrayItem['contract_branch_status_description']=statusColor($User['contract_branch_status']);
	$jsonArrayItem['contract_branch_added_by']=$User['contract_branch_added_by'];
	$jsonArrayItem['contract_branch_added_by_name']=PersonName("{$User['contract_branch_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>