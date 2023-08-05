<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$branch_id = add_escape_character($obj->branch_id);
$person_id = add_escape_character($obj->person_id);
$branch_person_remarks = add_escape_character($obj->branch_person_remarks);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$branch_person_id = 0;
$query = "SELECT * FROM tbl_branch_person
ORDER BY branch_person_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$branch_person_id = $User['branch_person_id'];
}
$branch_person_id++;

$generated_code = GenerateDisplayId("BRANCH-PERSON", $branch_person_id);

$sql = "INSERT INTO tbl_branch_person VALUES ($branch_person_id,'$generated_code',$branch_id, $person_id, '$branch_person_remarks' ,'$dateEncoded @ $timeEncoded','Added',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	$name = PersonName($person_id);
	$branch_name = BranchName($branch_id);
	Create_Logs("NEW BRANCH PERSONNEL",$branch_person_id, "CREATE","New branch personnel successfully saved<br>New Information<br>Branch Name: $branch_name<br>Personnel: $name<br>Status: Added",$signedin_person_id);

	echo true;
}else{
	echo "Branch Personnel Error: ".$connection->error." || ".$sql;
}
?>