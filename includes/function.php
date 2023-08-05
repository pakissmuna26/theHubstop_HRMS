<?php 
function add_escape_character($value) {
// $magic_quotes_active = get_magic_quotes_gpc();
// $compatible_version = function_exists("mysql_real_escape_string");
 
// if($compatible_version) { // PHP v4.3.0 or higher
//   if($magic_quotes_active) {$value=stripslashes($value);}
//      // $value = mysql_real_escape_string($value);
// } else {
//   if(!$magic_quotes_active) {$value=addslashes($value,"'");}
// }
$value = addcslashes($value, "'");

return $value;
}

function GetMonthDescription($date){

	$months = array("", "January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December");
	$dateYear = substr($date, 0,4);
	$monthDescription = $months[(int)(substr($date, 5,2))];
	$dateDays = substr($date, 8,2);
	$fullDate = $monthDescription." ".$dateDays.", ".$dateYear;

	return $fullDate;
}

function PersonName($personId){
	global $connection;
	$personCreated="";
	$query = "SELECT * FROM tbl_person 
	WHERE person_id={$personId}";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$personCreated="{$User['last_name']} {$User['affiliation_name']}, {$User['first_name']} {$User['middle_name']}";
	}
	return $personCreated;
}

function LeaveCategory($leave_category_id){
	global $connection;
	$leave="";
	$query = "SELECT * FROM tbl_leave_category 
	WHERE leave_category_id={$leave_category_id}";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$leave="{$User['leave_category_title']}";
	}
	return $leave;
}

function BranchName($branchId){
	global $connection;
	$branch_name="";
	$query = "SELECT * FROM tbl_branch 
	WHERE branch_id={$branchId}";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		$branch_name="{$User['branch_name']}";
	}
	return $branch_name;
}


function Get_Type_Description($type_id){
	global $connection;
	$type_description="";

	if($type_id == 1) $type_description = "Administrator";
	else if($type_id == 2) $type_description = "HR Staff";
	else if($type_id == 3) $type_description = "Employee";
	return $type_description;
}


function Create_Logs($category,$id,$status,$description,$added_by){
global $connection;

date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");

$transaction_logs_id = 0;
$query = "SELECT * FROM tbl_transaction_logs
ORDER BY transaction_logs_id ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {
	$transaction_logs_id = $User['transaction_logs_id'];
}
$transaction_logs_id++;
$logs_code=date("d")."".date("Y")."".date("m")."".date("i")."".date("s")."".date("h").$transaction_logs_id;

$sql = "INSERT INTO tbl_transaction_logs VALUES ($transaction_logs_id,'$logs_code','$category',$id,'$status','$description','$dateEncoded @ $timeEncoded',$added_by)";
mysqli_query($connection, $sql);

}

function statusColor($status){
	$arrayStatus = array("none","Saved","Activated","Deactivated","Registration", "Added", "Removed", "Accepted", "Denied", "Pending", "Cancelled", "Retrieved", "Done", "Scheduled", "Passed", "Failed", "Re-scheduled", "For Checking", "Approved", "Deleted", "Manual", "RFID", "On Time", "Early In", "Early Out", "No Attendance", "Late", "Overtime", "Not Valid", "Break Time", "Half Day", "Day Shift", "Night Shift", "Daily", "Payroll", "Leave Request");
	$arrayBadge = array("None",
		"<span class=\"badge bg-label-success rounded-pill\">Saved</span>", 
		"<span class=\"badge bg-label-success rounded-pill\">Activated</span>", 
		"<span class=\"badge bg-label-danger rounded-pill\">Deactivated</span>", 
		"<span class=\"badge bg-label-warning rounded-pill\">Registration</span>", 
		"<span class=\"badge bg-label-success rounded-pill\">Added</span>", 
		"<span class=\"badge bg-label-danger rounded-pill\">Removed</span>",
		"<span class=\"badge bg-label-success rounded-pill\">Accepted</span>", 
		"<span class=\"badge bg-label-danger rounded-pill\">Denied</span>", 
		"<span class=\"badge bg-label-warning rounded-pill\">Pending</span>", 
		"<span class=\"badge bg-label-danger rounded-pill\">Cancelled</span>",
		"<span class=\"badge bg-label-warning rounded-pill\">Retrieved</span>",
		"<span class=\"badge bg-label-success rounded-pill\">Done</span>",
		"<span class=\"badge bg-label-info rounded-pill\">Scheduled</span>",
		"<span class=\"badge bg-label-success rounded-pill\">Passed</span>",
		"<span class=\"badge bg-label-danger rounded-pill\">Failed</span>",
		"<span class=\"badge bg-label-warning rounded-pill\">Re-scheduled</span>",
		"<span class=\"badge bg-label-warning rounded-pill\">For Checking</span>",
		"<span class=\"badge bg-label-success rounded-pill\">Approved</span>",
		"<span class=\"badge bg-label-danger rounded-pill\">Deleted</span>",
		"<span class=\"badge bg-label-success rounded-pill\">Manual</span>",
		"<span class=\"badge bg-label-info rounded-pill\">RFID</span>",
		"<span class=\"badge bg-label-success rounded-pill\">On Time</span>",
		"<span class=\"badge bg-label-info rounded-pill\">Early In</span>",
		"<span class=\"badge bg-label-warning rounded-pill\">Early Out</span>",
		"<span class=\"badge bg-label-danger rounded-pill\">No Attendance</span>",
		"<span class=\"badge bg-label-danger rounded-pill\">Late</span>",
		"<span class=\"badge bg-label-danger rounded-pill\">Overtime</span>",
		"<span class=\"badge bg-label-danger rounded-pill\">Not Valid</span>",
		"<span class=\"badge bg-label-danger rounded-pill\">Break Time</span>",
		"<span class=\"badge bg-label-warning rounded-pill\">Half Day</span>",
		"<span class=\"badge bg-label-info rounded-pill\">Day Shift</span>",
		"<span class=\"badge bg-label-success rounded-pill\">Night Shift</span>",
		"<span class=\"badge bg-label-info rounded-pill\">Daily</span>",
		"<span class=\"badge bg-label-info rounded-pill\">Payroll</span>",
		"<span class=\"badge bg-label-warning rounded-pill\">Leave Request</span>");

	$id = 0;
	for($index = 0; $index < COUNT($arrayStatus); $index++){
		if($status == $arrayStatus[$index]){
			$id = $index; break;
		}else{

		}
	}
	return "<span style=\"text-transform:uppercase;font-size:14px;\">".$arrayBadge[$id]."</span>";
}

function GenerateDisplayId($desc, $id){
	$newId = "";
	$zeroes = 6;
	$getZeroes = 0;
	$getZeroes = $zeroes-strlen($id);
	$generate = "";
	
	for($index = 0; $index < $getZeroes; $index++)
		$generate .= "0";

	$newId = $desc."-".$generate.$id;
	return $newId;
}

function addComma($number){
$counter = 0;
$whole = "";
$flipWhole = "";
$decimal = "";
$num_text = (string)$number; // convert into a string
$array = str_split($num_text);

//get whole numbers
foreach ($array as $char) {
	if($char != "."){
		$counter++; 
		$whole .= $char;
	}
	else
		break;
}

//get decimal numbers
for($index = $counter; $index <strlen($num_text); $index++){
	if($array[$index] != ".")
		$decimal .= $array[$index];
}

//flip whole numbers
$array2 = str_split($whole);
for($index2 = strlen($whole) - 1; $index2 >= 0; $index2--){
	$flipWhole .= $array2[$index2];
}

//add comma per 3 digits
$array3 = str_split($flipWhole, "3"); // break string in 3 character sets
$num_new_text = implode(",", $array3);  // implode array with comma
$array4 = str_split($num_new_text);
$whole = "";

//flip to the original 
for($index3 = strlen($num_new_text) - 1; $index3 >= 0; $index3--){
	$whole .= $array4[$index3];
}

if($decimal != "")
	return $whole . "." . $decimal;
else
	return $whole;
}
?>