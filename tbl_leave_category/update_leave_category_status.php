<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$leave_category_id = add_escape_character($obj->leave_category_id);
$past_tense_status = add_escape_character($obj->past_tense_status);
$present_tense_status = add_escape_character($obj->present_tense_status);


date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_leave_category 
SET leave_category_status = '$past_tense_status'
WHERE leave_category_id = $leave_category_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE LEAVE CATEGORY STATUS",$leave_category_id, "UPDATE","Updating of leave category status successfully saved<br>Status: $past_tense_status",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Leave Category Status Error: ".$connection->error." || ".$sql;
}
?>