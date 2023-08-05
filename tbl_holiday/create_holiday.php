<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$holiday_title = add_escape_character($obj->holiday_title);
$holiday_description = add_escape_character($obj->holiday_description);
$holiday_date_from = add_escape_character($obj->holiday_date_from);
$holiday_date_to = add_escape_character($obj->holiday_date_to);
$holiday_is_paid = add_escape_character($obj->holiday_is_paid);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$holiday_id = 0;
$query = "SELECT * FROM tbl_holiday
ORDER BY holiday_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$holiday_id = $User['holiday_id'];
}
$holiday_id++;

$generated_code = GenerateDisplayId("HOLIDAY", $holiday_id);

$sql = "INSERT INTO tbl_holiday VALUES ($holiday_id,'$generated_code','$holiday_title', '$holiday_description', '$holiday_date_from', '$holiday_date_to', '$holiday_is_paid','$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW HOLIDAY",$holiday_id, "CREATE","New holiday successfully saved<br>New Information<br>Title: $holiday_title<br>Description: $holiday_description<br>Date: $holiday_date_from TO $holiday_date_to<br>Paid?: $holiday_is_paid<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Holiday Error: ".$connection->error." || ".$sql;
}
?>