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

$obj_leave = json_decode($_GET["data_leave"], false);

$leave_counter=0;
$leave_error="";
for($index=0; $index < COUNT($obj_leave); $index++){
	$leave_id=$obj_leave[$index];

	date_default_timezone_set("Asia/Manila");
	$dateEncoded = date("Y-m-d");
	$timeEncoded = date("h:i:s A");

	$contract_category_credit_id = 0;
	$query = "SELECT * FROM tbl_contract_leave_category
	ORDER BY contract_category_credit_id ASC";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$contract_category_credit_id = $User['contract_category_credit_id'];
	}
	$contract_category_credit_id++;

	$generated_code = GenerateDisplayId("CONTRACT-LEAVE-CREDIT", $contract_category_credit_id);

	$sql = "INSERT INTO tbl_contract_leave_category VALUES ($contract_category_credit_id,'$generated_code',$contract_id,$leave_id,'$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
	if(mysqli_query($connection, $sql)){	

		Create_Logs("NEW CONTRACT LEAVE CREDIT",$contract_category_credit_id, "CREATE","New contract leave credit successfully saved<br>New Information<br>Status: Activated",$signedin_person_id);

		$leave_counter++;
	}else{
		$leave_error.= "Leave Credit Error: ".$connection->error." || ".$sql;
	}
}

if(COUNT($obj_leave) == $leave_counter){
	echo true;
}else{
	echo $leave_error;
}
?>