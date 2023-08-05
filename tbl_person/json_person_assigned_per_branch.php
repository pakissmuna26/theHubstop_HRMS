<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>

<?php 
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_person ORDER BY person_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	
	$personnel_assigned = false;
	if($signedin_user_type_id == 2){
		$query = "SELECT * FROM tbl_applicant_application 
		WHERE applicant_id={$User['person_id']}";
		$applicant_applications = mysqli_query($connection, $query);
		while ($applicant_application = mysqli_fetch_array($applicant_applications)) {
			
			// contract_branch_status = \"Activated\"
			$query = "SELECT * FROM tbl_contract_branch
			WHERE contract_id = {$applicant_application['contract_id']} 
			ORDER BY contract_branch_id DESC";
			$contract_branches = mysqli_query($connection, $query);
			while ($contract_branch = mysqli_fetch_array($contract_branches)) {

				$query = "SELECT * FROM tbl_branch_person
				WHERE person_id = $signedin_person_id AND 
				branch_id = {$contract_branch['branch_id']} AND 
				branch_person_status = \"Added\"";
				$branch_persons = mysqli_query($connection, $query);
				while ($branch_person = mysqli_fetch_array($branch_persons)) {
					$personnel_assigned=true;
					break;
				}
			}
		}
	}else{
		$personnel_assigned=true;
	}

	if($personnel_assigned){
		$filterCounter++;
		$jsonArrayItem=array();
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['person_rfid']="{$User['person_rfid']}";
		$jsonArrayItem['person_id']="{$User['person_id']}";
		$jsonArrayItem['person_code']="{$User['person_code']}";

		$jsonArrayItem['first_name']=$User['first_name'];
		$jsonArrayItem['middle_name']=$User['middle_name'];	
		$jsonArrayItem['last_name']=$User['last_name'];
		$jsonArrayItem['affiliation_name']=$User['affiliation_name'];
		$jsonArrayItem['full_name']="{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} {$User['middle_name']}";

		$jsonArrayItem['date_of_birth']=$User['date_of_birth'];
		$jsonArrayItem['date_of_birth_description']=GetMonthDescription($User['date_of_birth']);
		$jsonArrayItem['sex']=$User['sex'];
		$jsonArrayItem['civil_status']=$User['civil_status'];	
		
		$jsonArrayItem['house_number']="{$User['house_number']}";	
		$jsonArrayItem['barangay']=$User['barangay'];	
		$jsonArrayItem['city']=$User['city'];
		$jsonArrayItem['province']=$User['province'];	
		$jsonArrayItem['region']=$User['region'];	
		$jsonArrayItem['address']="{$User['house_number']}, {$User['barangay']}, {$User['city']}, {$User['province']}, {$User['region']}";	
		
		$jsonArrayItem['email_address']="{$User['email_address']}";	
		$jsonArrayItem['contact_number']="{$User['contact_number']}";	
		$jsonArrayItem['contact_number_full']="+639 {$User['contact_number']}";	
		$jsonArrayItem['telephone_number']="{$User['telephone_number']}";
		$jsonArrayItem['password']="{$User['password']}";
		
		$jsonArrayItem['height']="{$User['height']}";
		$jsonArrayItem['weight']="{$User['weight']}";

		$jsonArrayItem['height_with_unit']="{$User['height']} cm";
		$jsonArrayItem['weight_with_unit']="{$User['weight']} kg";

		$jsonArrayItem['religion']="{$User['religion']}";
		$jsonArrayItem['nationality']="{$User['nationality']}";
		
		$jsonArrayItem['spouse_name']="{$User['spouse_name']}";
		$jsonArrayItem['spouse_occupation']="{$User['spouse_occupation']}";
		$jsonArrayItem['father_name']="{$User['father_name']}";
		$jsonArrayItem['father_occupation']="{$User['father_occupation']}";
		$jsonArrayItem['mother_name']="{$User['mother_name']}";
		$jsonArrayItem['mother_occupation']="{$User['mother_occupation']}";
		
		$jsonArrayItem['person_emergency_contact']="{$User['person_emergency_contact']}";
		$jsonArrayItem['relations_to_person_emergency_contact']="{$User['relations_to_person_emergency_contact']}";
		$jsonArrayItem['person_emergency_contact_number']="{$User['person_emergency_contact_number']}";
		$jsonArrayItem['person_emergency_contact_number_full']="+639 {$User['person_emergency_contact_number']}";
		
		$jsonArrayItem['person_created_at']="{$User['person_created_at']}";	
		$jsonArrayItem['person_status']="{$User['person_status']}";
		$jsonArrayItem['person_status_description']=statusColor("{$User['person_status']}");
		$jsonArrayItem['user_type']="{$User['user_type']}";	
		$jsonArrayItem['user_type_description']=Get_Type_Description("{$User['user_type']}");
		$jsonArrayItem['added_by']="{$User['added_by']}";
		$jsonArrayItem['added_by_name']=PersonName("{$User['added_by']}");

		array_push($jsonArray, $jsonArrayItem);
	}
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>