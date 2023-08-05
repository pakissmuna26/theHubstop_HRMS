<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
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

$tax_id = 0;
$query = "SELECT * FROM tbl_tax
ORDER BY tax_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$tax_id = $User['tax_id'];
}
$tax_id++;

$generated_code = GenerateDisplayId("TAX", $tax_id);

$sql = "INSERT INTO tbl_tax VALUES ($tax_id,'$generated_code','$tax_title', '$tax_description', '$tax_date_from', '$tax_date_to', $tax_amount_from, $tax_amount_to, $tax_additional, $tax_percentage,'$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW TAX",$tax_id, "CREATE","New branch successfully saved<br>New Information<br>Tax Title: $tax_title<br>Tax Description: tax_description<br>Tax Date Range: $tax_date_from TO $tax_date_to<br>Tax Amount Range: $tax_amount_from TO $tax_amount_to<br>Additioanl: $tax_additional<br>Percentage: $tax_percentage<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Tax Error: ".$connection->error." || ".$sql;
}
?>