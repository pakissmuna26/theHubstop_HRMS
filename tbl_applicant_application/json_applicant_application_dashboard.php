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
$query = "SELECT * FROM tbl_applicant_application";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$personnel_assigned=false;
	if($signedin_user_type_id == 2){
		$query = "SELECT * FROM tbl_contract_branch
		WHERE contract_id = {$User['contract_id']} 
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
	}else{
		$personnel_assigned=true;		
	}

	if($personnel_assigned){
		$filterCounter++;
		$jsonArrayItem=array();
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['applicant_application_id']="{$User['applicant_application_id']}";
		$jsonArrayItem['applicant_application_code']="{$User['applicant_application_code']}";
		$jsonArrayItem['applicant_id']=$User['applicant_id'];
		$jsonArrayItem['contract_id']=$User['contract_id'];	
		$jsonArrayItem['application_category']=$User['application_category'];	
		$jsonArrayItem['application_remarks']=$User['application_remarks'];	
		$jsonArrayItem['application_contract_status']=$User['application_contract_status'];	
		$jsonArrayItem['application_contract_status_color']=statusColor($User['application_contract_status']);	
		$jsonArrayItem['application_contract_start_date']=$User['application_contract_start_date'];	
		$jsonArrayItem['application_contract_start_date_description']=GetMonthDescription($User['application_contract_start_date']);	
		$jsonArrayItem['application_contract_end_date']=$User['application_contract_end_date'];	
		$jsonArrayItem['application_contract_end_date_description']=GetMonthDescription($User['application_contract_end_date']);	

		$jsonArrayItem['application_created_at']=$User['application_created_at'];
		$jsonArrayItem['application_status']=$User['application_status'];
		$jsonArrayItem['application_status_description']=statusColor($User['application_status']);
		$jsonArrayItem['application_added_by']=$User['application_added_by'];
		$jsonArrayItem['application_added_by_name']=PersonName("{$User['application_added_by']}");

		array_push($jsonArray, $jsonArrayItem);
	}
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>