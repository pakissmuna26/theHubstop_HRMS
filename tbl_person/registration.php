<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$first_name = add_escape_character($obj->first_name);
$middle_name = add_escape_character($obj->middle_name);
$last_name = add_escape_character($obj->last_name);
$affiliation_name = add_escape_character($obj->affiliation_name);
$date_of_birth = add_escape_character($obj->date_of_birth);
$sex = add_escape_character($obj->sex);
$civil_status = add_escape_character($obj->civil_status);
$region_option = add_escape_character($obj->region_option);
$province_option = add_escape_character($obj->province_option);
$city_option = add_escape_character($obj->city_option);
$barangay_option = add_escape_character($obj->barangay_option);
$house_number = add_escape_character($obj->house_number);
$email_address = add_escape_character($obj->email_address);
$contact_number = add_escape_character($obj->contact_number);
$telephone_number = add_escape_character($obj->telephone_number);
$height = add_escape_character($obj->height);
$weight = add_escape_character($obj->weight);
$religion = add_escape_character($obj->religion);
$nationality = add_escape_character($obj->nationality);
$spouse_name = add_escape_character($obj->spouse_name);
$spouse_occupation = add_escape_character($obj->spouse_occupation);
$father_name = add_escape_character($obj->father_name);
$father_occupation = add_escape_character($obj->father_occupation);
$mother_name = add_escape_character($obj->mother_name);
$mother_occupation = add_escape_character($obj->mother_occupation);
$person_emergency_contact = add_escape_character($obj->person_emergency_contact);
$relations_to_person_emergency_contact = add_escape_character($obj->relations_to_person_emergency_contact);
$person_emergency_contact_number = add_escape_character($obj->person_emergency_contact_number);
$user_type_id = add_escape_character($obj->user_type_id);
$status = add_escape_character($obj->status);
$password = add_escape_character($obj->password);
$personAddedBy = add_escape_character($obj->personAddedBy);

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$person_id = 0;
$query = "SELECT * FROM tbl_person
ORDER BY person_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$person_id = $User['person_id'];
}
$person_id++;

$personAddedBy = $person_id;

$generated_code = GenerateDisplayId("PERSON", $person_id);
$generated_password=password_hash(add_escape_character($password), PASSWORD_DEFAULT);

$sql = "INSERT INTO tbl_person VALUES ($person_id,'$generated_code','$first_name','$middle_name','$last_name','$affiliation_name','$date_of_birth','$sex','$civil_status','$house_number','$barangay_option','$city_option','$province_option','$region_option','$email_address','$contact_number','$telephone_number', '$generated_password', $height, $weight, '$religion', '$nationality', '$spouse_name', '$spouse_occupation', '$father_name', '$father_occupation', '$mother_name', '$mother_occupation', '$person_emergency_contact', '$relations_to_person_emergency_contact','$person_emergency_contact_number','$dateEncoded @ $timeEncoded','$status',$user_type_id,$personAddedBy, '')";
if(mysqli_query($connection, $sql)){
	
	$type_description=Get_Type_Description($user_type_id);
	Create_Logs("NEW PERSON",$person_id, "CREATE","New $type_description successfully saved<br>New Information<br>Name: $last_name $affiliation_name, $first_name $middle_name<br>Date of Birth: $date_of_birth<br>Sex: $sex<br>Civil Status: $civil_status <br>Address: $house_number, $barangay_option, $city_option, $province_option, $region_option<br>Username: $email_address<br>Contact Number: $contact_number<br>Telephone Number: $telephone_number<br><br>Height: $height<br> Weight: $weight<br> Religion: $religion<br> Nationality: $nationality<br><br> Spouse Name: $spouse_name<br>Spouse Occupation: $spouse_occupation<br> <br><br>Father Name: $father_name<br>Father Occupation: $father_occupation<br><br><br>Mother Name: $mother_name<br>Mother Occupation: $mother_occupation<br><br><br>Emergency Contact:<br>Name: $person_emergency_contact<br>Relationship: $relations_to_person_emergency_contact<br> Contact Number: $person_emergency_contact_number<br>RFID: <br>Status: $status",$personAddedBy);
	
	echo true;
}else{
	echo "Person Error: ".$connection->error." || ".$sql;
}
?>