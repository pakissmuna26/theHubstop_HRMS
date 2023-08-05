<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>

<?php 
$obj = json_decode($_GET["data"], false);
$payroll_period_id = add_escape_character($obj->payroll_period_id);

$jsonArray = array();
$filterCounter = 0;
$query = "SELECT DISTINCT(tbl_person.person_id) AS personId
FROM tbl_contract_payroll_period INNER JOIN tbl_contract 
ON tbl_contract_payroll_period.contract_id = tbl_contract.contract_id 
INNER JOIN tbl_applicant_application 
ON tbl_contract.contract_id = tbl_applicant_application.contract_id 
INNER JOIN tbl_person 
ON tbl_applicant_application.applicant_id = tbl_person.person_id
WHERE tbl_contract_payroll_period.payroll_period_id
ORDER BY tbl_person.last_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$personnel_assigned = false;
	if($signedin_user_type_id == 2){
		$query = "SELECT * FROM tbl_applicant_application 
		WHERE applicant_id={$User['personId']}";
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
		$jsonArrayItem['person_id']="{$User['personId']}";
		$jsonArrayItem['person_name']=PersonName($User['personId']);

		array_push($jsonArray, $jsonArrayItem);
	}
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>