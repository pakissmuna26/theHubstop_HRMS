<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$tax_id = add_escape_character($obj->tax_id);
$tax_title = add_escape_character($obj->tax_title);
$tax_description = add_escape_character($obj->tax_description);
$tax_date_from = add_escape_character($obj->tax_date_from);
$tax_date_to = add_escape_character($obj->tax_date_to);
$tax_amount_from = add_escape_character($obj->tax_amount_from);
$tax_amount_to = add_escape_character($obj->tax_amount_to);
$tax_additional = add_escape_character($obj->tax_additional);
$tax_percentage = add_escape_character($obj->tax_percentage);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_tax 
SET tax_title = '$tax_title',
tax_description = '$tax_description',
tax_date_from = '$tax_date_from',
tax_date_to = '$tax_date_to',
tax_amount_from = $tax_amount_from,
tax_amount_to = $tax_amount_to,
tax_additional = $tax_additional,
tax_percentage = $tax_percentage
WHERE tax_id = $tax_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE TAX",$tax_id, "UPDATE","Updating tax successfully saved<br>New Information<br>Tax Title: $tax_title<br>Tax Description: tax_description<br>Tax Date Range: $tax_date_from TO $tax_date_to<br>Tax Amount Range: $tax_amount_from TO $tax_amount_to<br>Additioanl: $tax_additional<br>Percentage: $tax_percentage",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Tax Error: ".$connection->error." || ".$sql;
}
?>