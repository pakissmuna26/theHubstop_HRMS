<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>

<?php
date_default_timezone_set("Asia/Manila");
$dateToday = date("Y-m-d");

// WHERE tbl_person_shifting_schedule.effective_date >= \"$dateToday\" AND \"$dateToday\" <= tbl_person_shifting_schedule.end_effective_date
$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_person_shifting_schedule INNER JOIN tbl_shifting_schedule
ON tbl_person_shifting_schedule.shifting_schedule_id = tbl_shifting_schedule.shifting_schedule_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	if($dateToday >= $User['effective_date'] && 
		$dateToday <=  $User['end_effective_date']){

		$personnel_assigned = false;
		if($signedin_user_type_id == 2){
			$query = "SELECT * FROM tbl_applicant_application 
			WHERE applicant_id={$User['person_id']}";
			$applicant_applications = mysqli_query($connection, $query);
			while ($applicant_application = mysqli_fetch_array($applicant_applications)) {
				
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
			$jsonArrayItem['person_shifting_schedule_id']="{$User['person_shifting_schedule_id']}";
			$jsonArrayItem['person_shifting_schedule_code']="{$User['person_shifting_schedule_code']}";
			$jsonArrayItem['person_id']=$User['person_id'];
			$jsonArrayItem['person_name']=PersonName($User['person_id']);
			$jsonArrayItem['shifting_schedule_id']=$User['shifting_schedule_id'];	
			$jsonArrayItem['branch_id']=$User['branch_id'];	
			$jsonArrayItem['branch_name']=BranchName($User['branch_id']);	
			$jsonArrayItem['effective_date']=$User['effective_date'];	
			$jsonArrayItem['end_effective_date']=$User['end_effective_date'];	

			$jsonArrayItem['person_shifting_schedule_created_at']=$User['person_shifting_schedule_created_at'];
			$jsonArrayItem['person_shifting_schedule_status']=$User['person_shifting_schedule_status'];
			$jsonArrayItem['person_shifting_schedule_status_description']=statusColor($User['person_shifting_schedule_status']);
			$jsonArrayItem['person_shifting_schedule_added_by']=$User['person_shifting_schedule_added_by'];
			$jsonArrayItem['person_shifting_schedule_added_by_name']=PersonName("{$User['person_shifting_schedule_added_by']}");

			$jsonArrayItem['shifting_schedule_time_from']=$User['shifting_schedule_time_from'];
			$jsonArrayItem['shifting_schedule_time_to']=$User['shifting_schedule_time_to'];
			$jsonArrayItem['shifting_schedule_break_time_from']=$User['shifting_schedule_break_time_from'];
			$jsonArrayItem['shifting_schedule_break_time_to']=$User['shifting_schedule_break_time_to'];
			
			array_push($jsonArray, $jsonArrayItem);
		}
	}
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>