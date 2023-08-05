<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_benefits_category ORDER BY benefits_category_title ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['benefits_category_id']="{$User['benefits_category_id']}";
	$jsonArrayItem['benefits_category_code']="{$User['benefits_category_code']}";
	$jsonArrayItem['benefits_category_title']=$User['benefits_category_title'];
	$jsonArrayItem['benefits_category_description']=$User['benefits_category_description'];
	$jsonArrayItem['benefits_category_amount']=$User['benefits_category_amount'];	
	$jsonArrayItem['benefits_category_amount_display']="PHP ".addComma($User['benefits_category_amount']);

	$jsonArrayItem['benefits_category_created_at']=$User['benefits_category_created_at'];
	$jsonArrayItem['benefits_category_status']=$User['benefits_category_status'];
	$jsonArrayItem['benefits_category_status_description']=statusColor($User['benefits_category_status']);
	$jsonArrayItem['benefits_category_added_by']=$User['benefits_category_added_by'];
	$jsonArrayItem['benefits_category_added_by_name']=PersonName("{$User['benefits_category_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>