<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_branch ORDER BY branch_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['branch_id']="{$User['branch_id']}";
	$jsonArrayItem['branch_code']="{$User['branch_code']}";
	$jsonArrayItem['branch_name']=$User['branch_name'];
	$jsonArrayItem['branch_description']=$User['branch_description'];	
	$jsonArrayItem['branch_address']=$User['branch_address'];	
	$jsonArrayItem['branch_barangay']=$User['branch_barangay'];	
	$jsonArrayItem['branch_city']=$User['branch_city'];	
	$jsonArrayItem['branch_province']=$User['branch_province'];	
	$jsonArrayItem['branch_region']=$User['branch_region'];	
	$jsonArrayItem['address']="{$User['branch_address']}, {$User['branch_barangay']}, {$User['branch_city']}, {$User['branch_province']}, {$User['branch_region']}";
	$jsonArrayItem['branch_contact_number']=$User['branch_contact_number'];	
	$jsonArrayItem['branch_contact_number_full']="+639 {$User['branch_contact_number']}";	

	$jsonArrayItem['branch_created_at']=$User['branch_created_at'];
	$jsonArrayItem['branch_status']=$User['branch_status'];
	$jsonArrayItem['branch_status_description']=statusColor($User['branch_status']);
	$jsonArrayItem['branch_added_by']=$User['branch_added_by'];
	$jsonArrayItem['branch_added_by_name']=PersonName("{$User['branch_added_by']}");

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>