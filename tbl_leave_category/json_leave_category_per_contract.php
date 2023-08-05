<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_id = add_escape_character($obj->contract_id);

$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_leave_category ORDER BY leave_category_title ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$existed=false;
	$query = "SELECT * FROM tbl_contract_leave_category 
	WHERE contract_id=$contract_id AND 
	leave_category_id={$User['leave_category_id']}";
	$contract_leave_categories = mysqli_query($connection, $query);
	while ($contract_leave_category=mysqli_fetch_array($contract_leave_categories)) {
		$existed=true;
	}

	if(!$existed){
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
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>