<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php
	$obj = json_decode($_GET["data"], false);
	$work_history_applicant_id = add_escape_character($obj->work_history_applicant_id);

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_work_history WHERE work_history_applicant_id = $work_history_applicant_id ORDER BY work_history_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['work_history_id']="{$User['work_history_id']}";
		$jsonArrayItem['work_history_code']="{$User['work_history_code']}";
		$jsonArrayItem['work_history_applicant_id']=$User['work_history_applicant_id'];
		$jsonArrayItem['work_history_job_title']=$User['work_history_job_title'];	
		$jsonArrayItem['work_history_job_responsibilities']=$User['work_history_job_responsibilities'];	
		$jsonArrayItem['work_history_date_from']=$User['work_history_date_from'];	
		$jsonArrayItem['work_history_date_to']=$User['work_history_date_to'];	
		$jsonArrayItem['work_history_company']=$User['work_history_company'];	

		$jsonArrayItem['work_name_details']="<b>{$User['work_history_job_title']}</b><br><span style='color:gray;'>{$User['work_history_job_responsibilities']}</span>";

		$jsonArrayItem['work_history_details']="Work Date: ".GetMonthDescription($User['work_history_date_from'])." TO ".GetMonthDescription($User['work_history_date_to'])."<br>Company: {$User['work_history_company']}";

		$work_history_added_by_name = PersonName("{$User['work_history_added_by']}");
		$jsonArrayItem['work_history_created_at']=$User['work_history_created_at'];
		$jsonArrayItem['work_history_created_at_by']="{$User['work_history_created_at']}<br><span style='color:gray;'>By: $work_history_added_by_name</span>";

		$jsonArrayItem['work_history_status']=$User['work_history_status'];
		$jsonArrayItem['work_history_status_description']=statusColor($User['work_history_status']);
		$jsonArrayItem['work_history_added_by']=$User['work_history_added_by'];
		$jsonArrayItem['work_history_added_by_name']=$work_history_added_by_name;

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>