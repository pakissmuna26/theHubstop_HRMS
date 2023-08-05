<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$person_id = add_escape_character($obj->person_id);
$old_password = add_escape_character($obj->old_password);

$jsonArray = array();
$query = "SELECT * FROM tbl_person WHERE person_id = $person_id ORDER BY person_id DESC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$jsonArrayItem=array();
	if(password_verify($old_password,$User['password'])){
		$jsonArrayItem['match']="Yes";
	}else{
		$jsonArrayItem['match']="No";

	}

	array_push($jsonArray, $jsonArrayItem);
}
	$connection->close();
    header('Content-type: application/json');
	echo json_encode($jsonArray);
?>