<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_holiday ORDER BY holiday_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['holiday_id']="{$User['holiday_id']}";
		$jsonArrayItem['holiday_code']="{$User['holiday_code']}";
		$jsonArrayItem['holiday_title']=$User['holiday_title'];
		$jsonArrayItem['holiday_description']=$User['holiday_description'];	
		$jsonArrayItem['holiday_date_from']=$User['holiday_date_from'];
		
		$holiday_date_from = GetMonthDescription($User['holiday_date_from']);
		$jsonArrayItem['holiday_date_from_description']=$holiday_date_from;
		
		$holiday_date_to = GetMonthDescription($User['holiday_date_to']);
		$jsonArrayItem['holiday_date_to']=$User['holiday_date_to'];
		$jsonArrayItem['holiday_date_to_description']=$holiday_date_to;

		$jsonArrayItem['holiday_is_paid']=$User['holiday_is_paid'];

		$jsonArrayItem['holiday_details']="<span style='color:gray;'>{$User['holiday_code']}</span><br><b>{$User['holiday_title']}</b><br>
		Date: $holiday_date_from TO $holiday_date_to <br>
		Paid?: {$User['holiday_is_paid']}";

		$holiday_added_by_name = PersonName("{$User['holiday_added_by']}");
		$jsonArrayItem['holiday_created_at']=$User['holiday_created_at'];
		$jsonArrayItem['holiday_created_at_by']="{$User['holiday_created_at']}<br><span style='color:gray;'>By: $holiday_added_by_name</span>";
		$jsonArrayItem['holiday_status']=$User['holiday_status'];
		$jsonArrayItem['holiday_status_description']=statusColor($User['holiday_status']);
		$jsonArrayItem['holiday_added_by']=$User['holiday_added_by'];
		$jsonArrayItem['holiday_added_by_name']=PersonName("{$User['holiday_added_by']}");


		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>