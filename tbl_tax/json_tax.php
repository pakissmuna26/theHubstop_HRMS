<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_tax ORDER BY tax_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['tax_id']="{$User['tax_id']}";
	$jsonArrayItem['tax_code']="{$User['tax_code']}";
	$jsonArrayItem['tax_title']=$User['tax_title'];
	$jsonArrayItem['tax_description']=$User['tax_description'];	
	$jsonArrayItem['tax_date_from']=$User['tax_date_from'];	
	$jsonArrayItem['tax_date_from_description']=GetMonthDescription($User['tax_date_from']);
	$jsonArrayItem['tax_date_to']=$User['tax_date_to'];	
	$jsonArrayItem['tax_date_to_description']=GetMonthDescription($User['tax_date_to']);
	$jsonArrayItem['tax_amount_from']=$User['tax_amount_from'];	
	$jsonArrayItem['tax_amount_from_description']=addComma($User['tax_amount_from']);	
	$jsonArrayItem['tax_amount_to']=$User['tax_amount_to'];	
	$jsonArrayItem['tax_amount_to_description']=addComma($User['tax_amount_to']);
	$jsonArrayItem['tax_additional']=$User['tax_additional'];	
	$jsonArrayItem['tax_additional_description']=addComma($User['tax_additional']);	
	$jsonArrayItem['tax_percentage']=$User['tax_percentage'];	

	$jsonArrayItem['tax_created_at']=$User['tax_created_at'];
	$jsonArrayItem['tax_status']=$User['tax_status'];
	$jsonArrayItem['tax_status_description']=statusColor($User['tax_status']);
	$jsonArrayItem['tax_added_by']=$User['tax_added_by'];
	$jsonArrayItem['tax_added_by_name']=PersonName("{$User['tax_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>