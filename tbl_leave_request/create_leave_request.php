<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$leave_request_by = add_escape_character($obj->leave_request_by);
$leave_request_category_id = add_escape_character($obj->leave_request_category_id);
$leave_request_date_from = add_escape_character($obj->leave_request_date_from);
$leave_request_date_to = add_escape_character($obj->leave_request_date_to);
$leave_request_remarks = add_escape_character($obj->leave_request_remarks);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$leave_request_id = 0;
$query = "SELECT * FROM tbl_leave_request
ORDER BY leave_request_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$leave_request_id = $User['leave_request_id'];
}
$leave_request_id++;

$generated_code = GenerateDisplayId("LEAVE-REQUEST", $leave_request_id);

$sql = "INSERT INTO tbl_leave_request VALUES ($leave_request_id,'$generated_code',$leave_request_by,$leave_request_category_id,'$leave_request_date_from','$leave_request_date_to','$leave_request_remarks',0,'','$dateEncoded @ $timeEncoded','Pending',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	$leave_request_by_name = PersonName($leave_request_by);
	$leave_request_category = LeaveCategory($leave_request_category_id);

	Create_Logs("NEW LEAVE REQUEST",$leave_request_id, "CREATE","New leave request successfully saved<br>New Information<br>Requested By: $leave_request_by_name<br>Leave: $leave_request_category<br>Date: $leave_request_date_from TO $leave_request_date_to<br>Remarks: $leave_request_remarks<br>Status: Pending",$signedin_person_id);

	echo true;
}else{
	echo "Leave Request Error: ".$connection->error." || ".$sql;
}
?>