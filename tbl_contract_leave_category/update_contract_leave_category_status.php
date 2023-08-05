<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_category_credit_id = add_escape_character($obj->contract_category_credit_id);
$past_tense_status = add_escape_character($obj->past_tense_status);
$present_tense_status = add_escape_character($obj->present_tense_status);


date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_contract_leave_category 
SET contract_category_credit_status = '$past_tense_status'
WHERE contract_category_credit_id = $contract_category_credit_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE CONTRACT LEAVE CREDIT STATUS",$contract_category_credit_id, "UPDATE","Updating of contract leave credit status successfully saved<br>Status: $past_tense_status",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Contract Leave Credit Status Error: ".$connection->error." || ".$sql;
}
?>