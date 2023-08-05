<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_id = add_escape_character($obj->contract_id);

$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_contract_leave_category WHERE contract_id=$contract_id ORDER BY contract_category_credit_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['contract_category_credit_id']="{$User['contract_category_credit_id']}";
	$jsonArrayItem['contract_category_credit_code']="{$User['contract_category_credit_code']}";
	$jsonArrayItem['contract_id']=$User['contract_id'];
	$jsonArrayItem['leave_category_id']=$User['leave_category_id'];

	$jsonArrayItem['contract_category_credit_created_at']=$User['contract_category_credit_created_at'];
	$jsonArrayItem['contract_category_credit_status']=$User['contract_category_credit_status'];
	$jsonArrayItem['contract_category_credit_status_description']=statusColor($User['contract_category_credit_status']);
	$jsonArrayItem['contract_category_credit_added_by']=$User['contract_category_credit_added_by'];
	$jsonArrayItem['contract_category_credit_added_by_name']=PersonName("{$User['contract_category_credit_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>