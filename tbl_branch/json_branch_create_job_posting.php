<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_id = add_escape_character($obj->contract_id);

$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_branch ORDER BY branch_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$existed=false;
	$query = "SELECT * FROM tbl_contract_branch 
	WHERE contract_id=$contract_id AND 
	branch_id={$User['branch_id']}";
	$contract_branches = mysqli_query($connection, $query);
	while ($contract_branch=mysqli_fetch_array($contract_branches)) {
		$existed=true;
	}

	if(!$existed){
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

		$hr_staff = "";
		$query = "SELECT * FROM tbl_branch_person INNER JOIN tbl_person 
		ON tbl_branch_person.person_id = tbl_person.person_id
		WHERE tbl_branch_person.branch_id = {$User['branch_id']} AND 
		tbl_branch_person.branch_person_status=\"Added\" AND 
		tbl_person.user_type=2";
		$branch_persons = mysqli_query($connection, $query);
		while ($branch_person = mysqli_fetch_array($branch_persons)) {
			$hr_staff.= "<li>{$branch_person['last_name']} {$branch_person['affiliation_name']}, {$branch_person['first_name']} {$branch_person['middle_name']}</li>";
		}

		$jsonArrayItem['branch_hr_staff']="<ul>$hr_staff</ul>";

		$jsonArrayItem['branch_created_at']=$User['branch_created_at'];
		$jsonArrayItem['branch_status']=$User['branch_status'];
		$jsonArrayItem['branch_status_description']=statusColor($User['branch_status']);
		$jsonArrayItem['branch_added_by']=$User['branch_added_by'];
		$jsonArrayItem['branch_added_by_name']=PersonName("{$User['branch_added_by']}");

		array_push($jsonArray, $jsonArrayItem);
	}
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>