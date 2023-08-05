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
$leave_category_title = add_escape_character($obj->leave_category_title);
$leave_category_description = add_escape_character($obj->leave_category_description);
$leave_category_quantity = add_escape_character($obj->leave_category_quantity);
$leave_category_paid_quantity = add_escape_character($obj->leave_category_paid_quantity);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_leave_category 
SET leave_category_title = '$leave_category_title',
leave_category_description = '$leave_category_description',
leave_category_quantity = $leave_category_quantity,
leave_category_paid_quantity = $leave_category_paid_quantity
WHERE leave_category_id = $leave_category_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE LEAVE CATEGORY",$leave_category_id, "UPDATE","Updating leave category successfully saved<br>New Information<br>:Leave Title: $leave_category_title<br>:Leave Description: leave_category_description<br>Quantity: $leave_category_quantity<br>Paid Leave Quantity: $leave_category_paid_quantity",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Leave Category Error: ".$connection->error." || ".$sql;
}
?>