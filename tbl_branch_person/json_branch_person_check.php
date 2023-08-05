<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$branch_id = add_escape_character($obj->branch_id);

$jsonArray = array();
$filterCounter = 0;
$query = "SELECT * FROM tbl_person 
WHERE user_type <> 3
ORDER BY last_name ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$flag=false;
	$query = "SELECT * FROM tbl_branch_person";
	$Validations = mysqli_query($connection, $query);
	while ($Validation = mysqli_fetch_array($Validations)) {	
		if($Validation['person_id'] == $User['person_id'] && $Validation['branch_person_status'] == "Added" && $Validation['branch_id'] == $branch_id){
			$flag=true;
			break;
		}else if($Validation['person_id'] == $User['person_id'] && $Validation['branch_person_status'] == "Removed" && $Validation['branch_id'] == $branch_id){
			$flag=true;
			break;
		}else if($Validation['person_id'] == $User['person_id'] && $Validation['branch_person_status'] == "Added" && $Validation['branch_id'] != $branch_id){
			$flag=true;
			break;
		}
	}

	if(!$flag){
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
		array_push($jsonArray, $jsonArrayItem);
	}

}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>