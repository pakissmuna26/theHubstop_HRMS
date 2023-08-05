<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_deduction_category ORDER BY deduction_category_title ASC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['deduction_category_id']="{$User['deduction_category_id']}";
		$jsonArrayItem['deduction_category_code']="{$User['deduction_category_code']}";
		$jsonArrayItem['deduction_category_title']=$User['deduction_category_title'];
		$jsonArrayItem['deduction_category_description']=$User['deduction_category_description'];
		$jsonArrayItem['deduction_category_is_percentage']=$User['deduction_category_is_percentage'];
		$jsonArrayItem['deduction_category_company_share']=$User['deduction_category_company_share'];
		$jsonArrayItem['deduction_category_personnel_share']=$User['deduction_category_personnel_share'];

		$jsonArrayItem['deduction_category_details']="<span style='color:gray;'>{$User['deduction_category_code']}</span><br><b>{$User['deduction_category_title']}</b>";

		if($User['deduction_category_is_percentage'] == "Yes")
		$jsonArrayItem['deduction_category_is_percentage_details']="Company Share: {$User['deduction_category_company_share']}%<br>Personnel Share: {$User['deduction_category_personnel_share']}%";
		else if($User['deduction_category_is_percentage'] == "No")
		$jsonArrayItem['deduction_category_is_percentage_details']="Company Share: PHP ".addComma($User['deduction_category_company_share'])."<br>Personnel Share: PHP ".addComma($User['deduction_category_personnel_share'])."";	
		
		$deduction_category_added_by_name = PersonName("{$User['deduction_category_added_by']}");
		$jsonArrayItem['deduction_category_created_at']=$User['deduction_category_created_at'];
		$jsonArrayItem['deduction_category_created_at_by']="{$User['deduction_category_created_at']}<br><span style='color:gray;'>By: $deduction_category_added_by_name</span>";
		
		$jsonArrayItem['deduction_category_status']=$User['deduction_category_status'];
		$jsonArrayItem['deduction_category_status_description']=statusColor($User['deduction_category_status']);
		$jsonArrayItem['deduction_category_added_by']=$User['deduction_category_added_by'];
		$jsonArrayItem['deduction_category_added_by_name']=PersonName("{$User['deduction_category_added_by']}");

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>