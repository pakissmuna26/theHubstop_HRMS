<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
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

$branch_id = 0;
$query = "SELECT * FROM tbl_branch
ORDER BY branch_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$branch_id = $User['branch_id'];
}
$branch_id++;

$generated_code = GenerateDisplayId("BRANCH", $branch_id);

$sql = "INSERT INTO tbl_branch VALUES ($branch_id,'$generated_code','$branch_name', '$branch_description', '$branch_address', '$branch_barangay', '$branch_city', '$branch_province', '$branch_region', '$branch_contact_number','$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW BRANCH",$branch_id, "CREATE","New branch successfully saved<br>New Information<bBranch Name: $branch_name<br>Branch Description: branch_description<br>Branch Address: $branch_address, $branch_barangay, $branch_city, $branch_province, $branch_region<br>Contact Number: $branch_contact_number<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Branch Error: ".$connection->error." || ".$sql;
}
?>