<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
$obj = json_decode($_GET["data"], false);
$job_position_title = add_escape_character($obj->job_position_title);
$job_position_description = add_escape_character($obj->job_position_description);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$job_position_id = 0;
$query = "SELECT * FROM tbl_job_position
ORDER BY job_position_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$job_position_id = $User['job_position_id'];
}
$job_position_id++;

$generated_code = GenerateDisplayId("JOB-POSITION", $job_position_id);

$sql = "INSERT INTO tbl_job_position VALUES ($job_position_id,'$generated_code','$job_position_title', '$job_position_description','$dateEncoded @ $timeEncoded','Activated',$signedin_person_id)";
if(mysqli_query($connection, $sql)){	

	Create_Logs("NEW JOB POSITION",$job_position_id, "CREATE","New job position successfully saved<br>New Information<br>Job Position Title: $job_position_title<br>Job Position Description: job_position_description<br>Status: Activated",$signedin_person_id);

	echo true;
}else{
	echo "Job Position Error: ".$connection->error." || ".$sql;
}
?>