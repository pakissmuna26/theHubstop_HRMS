<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$deduction_category_id = add_escape_character($obj->deduction_category_id);
$deduction_category_title = add_escape_character($obj->deduction_category_title);
$deduction_category_description = add_escape_character($obj->deduction_category_description);
$deduction_category_is_percentage = add_escape_character($obj->deduction_category_is_percentage);
$deduction_category_company_share = add_escape_character($obj->deduction_category_company_share);
$deduction_category_personnel_share = add_escape_character($obj->deduction_category_personnel_share);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_deduction_category 
SET deduction_category_title = '$deduction_category_title',
deduction_category_description = '$deduction_category_description',
deduction_category_is_percentage = '$deduction_category_is_percentage',
deduction_category_company_share = $deduction_category_company_share,
deduction_category_personnel_share = $deduction_category_personnel_share
WHERE deduction_category_id = $deduction_category_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE DEDUCTIONS CATEGORY",$deduction_category_id, "UPDATE","Updating deduction category successfully saved<br>Deduction Title: $deduction_category_title<br>Deduction Description: deduction_category_description<br>Is Percentage: $deduction_category_is_percentage<br>Company Share: $deduction_category_company_share<br>Personnel Share: $deduction_category_personnel_share",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Deduction Category Error: ".$connection->error." || ".$sql;
}
?>