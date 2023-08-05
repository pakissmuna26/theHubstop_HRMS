<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$leave_request_id = add_escape_character($obj->leave_request_id);
$leave_request_category_id = add_escape_character($obj->leave_request_category_id);
$leave_request_date_from = add_escape_character($obj->leave_request_date_from);
$leave_request_date_to = add_escape_character($obj->leave_request_date_to);
$leave_request_remarks = add_escape_character($obj->leave_request_remarks);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_leave_request 
SET leave_request_category_id = $leave_request_category_id,
leave_request_date_from = '$leave_request_date_from',
leave_request_date_to = '$leave_request_date_to',
leave_request_remarks = '$leave_request_remarks'
WHERE leave_request_id = $leave_request_id";
if(mysqli_query($connection, $sql)){
	
	$leave_request_category = LeaveCategory($leave_request_category_id);
	Create_Logs("UPDATE LEAVE REQUEST",$leave_request_id, "UPDATE","Updating leave request successfully saved<br>New Information<br>Leave: $leave_request_category<br>Date: $leave_request_date_from TO $leave_request_date_to<br>Remarks: $leave_request_remarks",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Leave Request Error: ".$connection->error." || ".$sql;
}
?>