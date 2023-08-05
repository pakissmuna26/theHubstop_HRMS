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
$query = "SELECT * FROM tbl_branch ORDER BY branch_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$branch_assigned=false;
	if($signedin_user_type_id == 2){
		$query = "SELECT * FROM tbl_branch_person
		WHERE person_id = $signedin_person_id AND 
		branch_id = {$User['branch_id']} AND 
		branch_person_status = \"Added\"";
		$branch_persons = mysqli_query($connection, $query);
		while ($branch_person = mysqli_fetch_array($branch_persons)) {
			$branch_assigned=true;
		}
	}else{
		$branch_assigned=true;	
	}

	if($branch_assigned){
		$filterCounter++;
		$jsonArrayItem=array();
		$jsonArrayItem['branch_name']=$User['branch_name'];
		$jsonArrayItem['branch_id']=$User['branch_id'];	
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
	

}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>