<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_deduction_category ORDER BY deduction_category_title ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['deduction_category_id']="{$User['deduction_category_id']}";
	$jsonArrayItem['deduction_category_code']="{$User['deduction_category_code']}";
	$jsonArrayItem['deduction_category_title']=$User['deduction_category_title'];
	$jsonArrayItem['deduction_category_description']=$User['deduction_category_description'];
	$jsonArrayItem['deduction_category_is_percentage']=$User['deduction_category_is_percentage'];
	$jsonArrayItem['deduction_category_company_share']=$User['deduction_category_company_share'];
	$jsonArrayItem['deduction_category_personnel_share']=$User['deduction_category_personnel_share'];	


	$share = "";
	if($User['deduction_category_is_percentage'] == "Yes")
		$share="Company Share: {$User['deduction_category_company_share']}% | Personnel Share: {$User['deduction_category_personnel_share']}%";
	else if($User['deduction_category_is_percentage'] == "No")
		$share="Company Share: PHP ".addComma($User['deduction_category_company_share'])." | Personnel Share: PHP ".addComma($User['deduction_category_personnel_share'])."";
	$jsonArrayItem['share']=$share;	

	$jsonArrayItem['deduction_category_created_at']=$User['deduction_category_created_at'];
	$jsonArrayItem['deduction_category_status']=$User['deduction_category_status'];
	$jsonArrayItem['deduction_category_status_description']=statusColor($User['deduction_category_status']);
	$jsonArrayItem['deduction_category_added_by']=$User['deduction_category_added_by'];
	$jsonArrayItem['deduction_category_added_by_name']=PersonName("{$User['deduction_category_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>