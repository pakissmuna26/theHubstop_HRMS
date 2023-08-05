<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_person INNER JOIN tbl_branch_person 
ON tbl_person.person_id = tbl_branch_person.person_id 
INNER JOIN tbl_branch 
ON tbl_branch_person.branch_id = tbl_branch.branch_id
ORDER BY tbl_branch.branch_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$filterCounter++;
	$jsonArrayItem=array();
	$jsonArrayItem['number']=$filterCounter;
	$jsonArrayItem['person_id']="{$User['person_id']}";
	$jsonArrayItem['person_code']="{$User['person_code']}";
	$jsonArrayItem['first_name']=$User['first_name'];
	$jsonArrayItem['middle_name']=$User['middle_name'];	
	$jsonArrayItem['last_name']=$User['last_name'];
	$jsonArrayItem['affiliation_name']=$User['affiliation_name'];
	$jsonArrayItem['full_name']="{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} {$User['middle_name']} (".Get_Type_Description($User['user_type']).")";
	$jsonArrayItem['user_type']="{$User['user_type']}";	

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
		array_push($jsonArray, $jsonArrayItem);
	

}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>