<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$leave_category_title = add_escape_character($obj->leave_category_title);
$leave_category_description = add_escape_character($obj->leave_category_description);
$leave_category_quantity = add_escape_character($obj->leave_category_quantity);
$leave_category_paid_quantity = add_escape_character($obj->leave_category_paid_quantity);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$leave_category_id = 0;
$query = "SELECT * FROM tbl_leave_category
ORDER BY leave_category_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$leave_category_id = $User['leave_category_id'];
}
$leave_category_id++;

$generated_code = GenerateDisplayId("LEAVE-CATEGORY", $leave_category_id);

$sql = "INSERT INTO tbl_leave_category VALUES ($leave_category_id,'$generated_code','$leave_category_title', '$leave_category_description',$leave_category_quantity,$leave_category_paid_quantity,'$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW LEAVE CATEGORY",$leave_category_id, "CREATE","New leave category successfully saved<br>New Information<br>:Leave Title: $leave_category_title<br>:Leave Description: leave_category_description<br>Quantity: $leave_category_quantity<br>Paid Leave Quantity: $leave_category_paid_quantity<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo ":Leave Category Error: ".$connection->error." || ".$sql;
}
?>