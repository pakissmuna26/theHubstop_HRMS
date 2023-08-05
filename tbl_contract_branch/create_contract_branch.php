<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_id = add_escape_character($obj->contract_id);

$obj_branch = json_decode($_GET["data_branch"], false);

$branch_counter=0;
$branch_error="";
for($index=0; $index < COUNT($obj_branch); $index++){
	$branch_id=$obj_branch[$index];

	date_default_timezone_set("Asia/Manila");
	$dateEncoded = date("Y-m-d");
	$timeEncoded = date("h:i:s A");

	$contract_branch_id = 0;
	$query = "SELECT * FROM tbl_contract_branch
	ORDER BY contract_branch_id ASC";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$contract_branch_id = $User['contract_branch_id'];
	}
	$contract_branch_id++;

	$generated_code = GenerateDisplayId("CONTRACT-BRANCH", $contract_branch_id);

	$sql = "INSERT INTO tbl_contract_branch VALUES ($contract_branch_id,'$generated_code',$contract_id,$branch_id,'$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
	if(mysqli_query($connection, $sql)){	

		Create_Logs("NEW CONTRACT BRANCH",$contract_branch_id, "CREATE","New contract branch successfully saved<br>New Information<br>Status: Activated",$signedin_person_id);

		$branch_counter++;
	}else{
		$branch_error.= "Contract Branch Error: ".$connection->error." || ".$sql;
	}
}

if(COUNT($obj_branch) == $branch_counter){
	echo true;
}else{
	echo $branch_error;
}
?>