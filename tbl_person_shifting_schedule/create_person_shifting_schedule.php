<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$person_id = add_escape_character($obj->person_id);
$shifting_schedule_id = add_escape_character($obj->shifting_schedule_id);
$contract_branch_id = add_escape_character($obj->contract_branch_id);
$effective_date = add_escape_character($obj->effective_date);
$end_effective_date = add_escape_character($obj->end_effective_date);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$person_shifting_schedule_id = 0;
$query = "SELECT * FROM tbl_person_shifting_schedule
ORDER BY person_shifting_schedule_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$person_shifting_schedule_id = $User['person_shifting_schedule_id'];
}
$person_shifting_schedule_id++;

$generated_code = GenerateDisplayId("SHIFT-SCHEDULE", $person_shifting_schedule_id);

$sqlShiftSchedule = "INSERT INTO tbl_person_shifting_schedule VALUES ($person_shifting_schedule_id,'$generated_code',$person_id,$shifting_schedule_id,$contract_branch_id,'$effective_date','$end_effective_date','$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sqlShiftSchedule)){	

	$name = PersonName($person_id);
	Create_Logs("NEW SHIFT SCHEDULE",$person_shifting_schedule_id, "CREATE","New shift schedule successfully saved<br>New Information<br>Name: $name<br>Effective Date: $effective_date<br>End of Effective Date: end_effective_date",$signedin_person_id);
	
	echo true;
}else{
	echo "Shift Schedule Error: ".$connection->error." || ".$sqlShiftSchedule;
}
?>