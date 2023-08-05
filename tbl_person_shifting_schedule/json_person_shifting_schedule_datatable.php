<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php
	$obj = json_decode($_GET["data"], false);
	$person_id = add_escape_character($obj->person_id);

	$results["data"] = array();

	if($person_id == 0){
		$result=$db->prepare("SELECT * FROM tbl_branch INNER JOIN  tbl_person_shifting_schedule ON tbl_branch.branch_id = tbl_person_shifting_schedule.branch_id INNER JOIN tbl_shifting_schedule ON tbl_person_shifting_schedule.shifting_schedule_id = tbl_shifting_schedule.shifting_schedule_id ORDER BY tbl_person_shifting_schedule.person_shifting_schedule_id DESC");
	}else{
		$result=$db->prepare("SELECT * FROM tbl_branch INNER JOIN  tbl_person_shifting_schedule ON tbl_branch.branch_id = tbl_person_shifting_schedule.branch_id INNER JOIN tbl_shifting_schedule ON tbl_person_shifting_schedule.shifting_schedule_id = tbl_shifting_schedule.shifting_schedule_id WHERE tbl_person_shifting_schedule.person_id=$person_id ORDER BY tbl_person_shifting_schedule.person_shifting_schedule_id DESC");
	}
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['person_shifting_schedule_id']="{$User['person_shifting_schedule_id']}";
		$jsonArrayItem['person_shifting_schedule_code']="{$User['person_shifting_schedule_code']}";
		$jsonArrayItem['person_id']=$User['person_id'];
		$jsonArrayItem['shifting_schedule_id']=$User['shifting_schedule_id'];	
		$jsonArrayItem['branch_id']=$User['branch_id'];	
		$jsonArrayItem['effective_date']=$User['effective_date'];	
		$jsonArrayItem['end_effective_date']=$User['end_effective_date'];	
		$jsonArrayItem['effective_date_details']=GetMonthDescription($User['effective_date'])." TO ".GetMonthDescription($User['end_effective_date']);	
		$days_of_week = "";
		if($User['shifting_schedule_monday'] == "Yes")
			$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Monday, ";
		else 
			$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Monday, ";
		if($User['shifting_schedule_tuesday'] == "Yes")
			$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Tuesday, ";
		else 
			$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Tuesday, ";
		if($User['shifting_schedule_wednesday'] == "Yes")
			$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Wednesday<br>";
		else 
			$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Wednesday<br>";
		if($User['shifting_schedule_thursday'] == "Yes")
			$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Thursday, ";
		else 
			$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Thursday, ";
		if($User['shifting_schedule_friday'] == "Yes")
			$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Friday, ";
		else 
			$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Friday, ";
		if($User['shifting_schedule_saturday'] == "Yes")
			$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Saturday, ";
		else 
			$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Saturday, ";
		if($User['shifting_schedule_sunday'] == "Yes")
			$days_of_week.="<i class='bx bx-calendar-check' style='color:green;'></i> Sunday";
		else 
			$days_of_week.="<i class='bx bx-window-close' style='color:red;'></i> Sunday";

		$jsonArrayItem['shifting_schedule_days_of_week']="<b>{$User['shifting_schedule_time_from']} TO {$User['shifting_schedule_time_to']}</b><br> 
		<b>Shift Break:</b> {$User['shifting_schedule_break_time_from']} TO {$User['shifting_schedule_break_time_to']}<br>$days_of_week<br><b>Effectivity Date:</b> ".GetMonthDescription($User['effective_date'])." TO ".GetMonthDescription($User['end_effective_date']);

		$jsonArrayItem['address']="<b>{$User['branch_name']}</b><br>{$User['branch_address']}, {$User['branch_barangay']}, {$User['branch_city']}, {$User['branch_province']}, {$User['branch_region']}<br>Contact #: +639 {$User['branch_contact_number']}";
		

		$person_shifting_schedule_added_by_name = PersonName("{$User['person_shifting_schedule_added_by']}");
		$jsonArrayItem['person_shifting_schedule_created_at']=$User['person_shifting_schedule_created_at'];
		$jsonArrayItem['person_shifting_schedule_created_at_by']="{$User['person_shifting_schedule_created_at']}<br><span style='color:gray;'>By: $person_shifting_schedule_added_by_name</span>";

		$jsonArrayItem['person_shifting_schedule_status']=$User['person_shifting_schedule_status'];
		$jsonArrayItem['person_shifting_schedule_status_description']=statusColor($User['person_shifting_schedule_status']);
		$jsonArrayItem['person_shifting_schedule_added_by']=$User['person_shifting_schedule_added_by'];
		$jsonArrayItem['person_shifting_schedule_added_by_name']=$person_shifting_schedule_added_by_name;

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>