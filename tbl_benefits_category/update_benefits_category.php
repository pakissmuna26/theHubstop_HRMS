<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$benefits_category_id = add_escape_character($obj->benefits_category_id);
$benefits_category_title = add_escape_character($obj->benefits_category_title);
$benefits_category_description = add_escape_character($obj->benefits_category_description);
$benefits_category_amount = add_escape_character($obj->benefits_category_amount);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_benefits_category 
SET benefits_category_title = '$benefits_category_title',
benefits_category_description = '$benefits_category_description',
benefits_category_amount = $benefits_category_amount
WHERE benefits_category_id = $benefits_category_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE BENEFITS CATEGORY",$benefits_category_id, "UPDATE","Updating benefits category successfully saved<br>New Information<br>Benefits Title: $benefits_category_title<br>Benefits Description: benefits_category_description<br>Amount: $benefits_category_amount",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Benefits Category Error: ".$connection->error." || ".$sql;
}
?>