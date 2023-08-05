<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$branch_id = add_escape_character($obj->branch_id);
$branch_name = add_escape_character($obj->branch_name);
$branch_description = add_escape_character($obj->branch_description);
$branch_address = add_escape_character($obj->branch_address);
$branch_barangay = add_escape_character($obj->branch_barangay);
$branch_city = add_escape_character($obj->branch_city);
$branch_province = add_escape_character($obj->branch_province);
$branch_region = add_escape_character($obj->branch_region);
$branch_contact_number = add_escape_character($obj->branch_contact_number);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$sql = "UPDATE tbl_branch 
SET branch_name = '$branch_name',
branch_description = '$branch_description',
branch_address = '$branch_address',
branch_barangay = '$branch_barangay',
branch_city = '$branch_city',
branch_province = '$branch_province',
branch_region = '$branch_region',
branch_contact_number = '$branch_contact_number'
WHERE branch_id = $branch_id";
if(mysqli_query($connection, $sql)){
	
	Create_Logs("UPDATE BRANCH",$branch_id, "UPDATE","Updating branch successfully saved<br>New Information<bBranch Name: $branch_name<br>Branch Description: branch_description<br>Branch Address: $branch_address, $branch_barangay, $branch_city, $branch_province, $branch_region<br>Contact Number: $branch_contact_number",$signedin_person_id);
	
	echo true;
}else{
	echo "Updating Branch Error: ".$connection->error." || ".$sql;
}
?>