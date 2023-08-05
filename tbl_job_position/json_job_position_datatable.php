<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_job_position ORDER BY job_position_title ASC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['job_position_id']="{$User['job_position_id']}";
		$jsonArrayItem['job_position_code']="{$User['job_position_code']}";
		$jsonArrayItem['job_position_title']=$User['job_position_title'];
		$jsonArrayItem['job_position_description']=$User['job_position_description'];
		$jsonArrayItem['job_position_details']="<span style='color:gray;'>{$User['job_position_code']}</span><br><b>{$User['job_position_title']}</b><br><span style='color:gray;'>{$User['job_position_description']}</span>";	
		
		$job_position_added_by_name = PersonName("{$User['job_position_added_by']}");
		$jsonArrayItem['job_position_created_at']=$User['job_position_created_at'];
		$jsonArrayItem['job_position_created_at_by']="{$User['job_position_created_at']}<br><span style='color:gray;'>By: $job_position_added_by_name</span>";
		
		$jsonArrayItem['job_position_status']=$User['job_position_status'];
		$jsonArrayItem['job_position_status_description']=statusColor($User['job_position_status']);
		$jsonArrayItem['job_position_added_by']=$User['job_position_added_by'];
		$jsonArrayItem['job_position_added_by_name']=PersonName("{$User['job_position_added_by']}");

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>