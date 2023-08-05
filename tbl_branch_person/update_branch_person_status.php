<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$branch_person_id = add_escape_character($obj->branch_person_id);
$past_tense_status = add_escape_character($obj->past_tense_status);
$present_tense_status = add_escape_character($obj->present_tense_status);

$already_assigned=false;
$person_id = $branch_id = "";
$query = "SELECT * FROM tbl_branch_person WHERE branch_person_id=$branch_person_id";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$already_assigned=true;
	$branch_id = $User['branch_id']; // 2
	$person_id = $User['person_id']; // 5
	break;
}

$flag=false;
if($already_assigned){
	$query = "SELECT * FROM tbl_branch_person";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		if($User['branch_id'] != $branch_id && $User['person_id'] == $person_id && $User['branch_person_status'] == "Added"){
			$flag=true;
			break;
		}
	}
}

if($past_tense_status == "Removed") $flag=false;

if($flag){
	echo "This personnel is already assigned to different branch. Branch Name: ".BranchName($branch_id);
}else{
	date_default_timezone_set("Asia/Manila");
	$dateEncoded = date("Y-m-d");
	$timeEncoded = date("h:i:s A");

	$sql = "UPDATE tbl_branch_person 
	SET branch_person_status = '$past_tense_status'
	WHERE branch_person_id = $branch_person_id";
	if(mysqli_query($connection, $sql)){
		
		Create_Logs("UPDATE BRANCH PERSONNEL STATUS",$branch_person_id, "UPDATE","Updating of branch personnel status successfully saved<br>Status: $past_tense_status",$signedin_person_id);
		
		echo true;
	}else{
		echo "Updating of branch personnel status was failed, Please try again.";
	}
}
?>