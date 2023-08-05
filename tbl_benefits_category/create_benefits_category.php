<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$benefits_category_title = add_escape_character($obj->benefits_category_title);
$benefits_category_description = add_escape_character($obj->benefits_category_description);
$benefits_category_amount = add_escape_character($obj->benefits_category_amount);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$benefits_category_id = 0;
$query = "SELECT * FROM tbl_benefits_category
ORDER BY benefits_category_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$benefits_category_id = $User['benefits_category_id'];
}
$benefits_category_id++;

$generated_code = GenerateDisplayId("BENEFITS-CATEGORY", $benefits_category_id);

$sql = "INSERT INTO tbl_benefits_category VALUES ($benefits_category_id,'$generated_code','$benefits_category_title', '$benefits_category_description', $benefits_category_amount,'$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW BENEFITS CATEGORY",$benefits_category_id, "CREATE","New benefits category successfully saved<br>New Information<br>Benefits Title: $benefits_category_title<br>Benefits Description: benefits_category_description<br>Amount: $benefits_category_amount<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Benefits Category Error: ".$connection->error." || ".$sql;
}
?>