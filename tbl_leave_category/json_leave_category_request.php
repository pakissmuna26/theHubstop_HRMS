<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$person_id = add_escape_character($obj->person_id);

$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_leave_category ORDER BY leave_category_title ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$counter=0;
	$credit_leave_category_quantity = $credit_leave_category_paid_quantity = 0;
	$query = "SELECT * FROM tbl_applicant_application INNER JOIN tbl_contract 
	ON tbl_applicant_application.contract_id = tbl_contract.contract_id 
	INNER JOIN tbl_contract_leave_category 
	ON tbl_contract.contract_id = tbl_contract_leave_category.contract_id
	WHERE tbl_applicant_application.applicant_id = $person_id AND 
	tbl_contract_leave_category.contract_category_credit_status=\"Activated\" AND 
	tbl_contract_leave_category.leave_category_id = {$User['leave_category_id']} AND 
	tbl_applicant_application.application_contract_status<>\"Pending\"
	ORDER BY tbl_applicant_application.applicant_application_id DESC";
	$personnel_remaining_leaves = mysqli_query($connection, $query);
	while ($personnel_remaining_leave = mysqli_fetch_array($personnel_remaining_leaves)) {
		$credit_leave_category_quantity += $User['leave_category_quantity'];
		$credit_leave_category_paid_quantity += $User['leave_category_paid_quantity'];
		$counter++;
	}

	$remaining_leave_category_quantity = 0;
	$requested=0;
	$query = "SELECT * FROM tbl_leave_request 
	WHERE leave_request_category_id = {$User['leave_category_id']} AND 
	leave_request_status <> \"Denied\" AND 
	leave_request_by=$person_id
	ORDER BY leave_request_id DESC";
	$leave_requests = mysqli_query($connection, $query);
	while ($leave_request = mysqli_fetch_array($leave_requests)) {
		$date_from = date_create("{$leave_request['leave_request_date_from']}");
		$date_to = date_create("{$leave_request['leave_request_date_to']}");
		$days = date_diff($date_to,$date_from);
		$requested += ($days->d);
	}

	$remaining_leave_category_quantity = $credit_leave_category_quantity-$requested;

	if($counter != 0){
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

		$jsonArrayItem['credit_leave_category_quantity']=$credit_leave_category_quantity;
		$jsonArrayItem['credit_leave_category_paid_quantity']=$credit_leave_category_paid_quantity;

		$jsonArrayItem['requested_leave_category_quantity']=$requested;
		$jsonArrayItem['remaining_leave_category_quantity']=$remaining_leave_category_quantity;
		
		array_push($jsonArray, $jsonArrayItem);
	}

}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>