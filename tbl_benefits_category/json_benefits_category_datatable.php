<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_benefits_category ORDER BY benefits_category_title ASC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['benefits_category_id']="{$User['benefits_category_id']}";
		$jsonArrayItem['benefits_category_code']="{$User['benefits_category_code']}";
		$jsonArrayItem['benefits_category_title']=$User['benefits_category_title'];
		$jsonArrayItem['benefits_category_description']=$User['benefits_category_description'];
		$jsonArrayItem['benefits_category_amount']=$User['benefits_category_amount'];
		$jsonArrayItem['benefits_category_amount_display']="PHP ".addComma($User['benefits_category_amount']);
		$jsonArrayItem['benefits_category_details']="<span style='color:gray;'>{$User['benefits_category_code']}</span><br><b>{$User['benefits_category_title']}</b>";	
		
		$benefits_category_added_by_name = PersonName("{$User['benefits_category_added_by']}");
		$jsonArrayItem['benefits_category_created_at']=$User['benefits_category_created_at'];
		$jsonArrayItem['benefits_category_created_at_by']="{$User['benefits_category_created_at']}<br><span style='color:gray;'>By: $benefits_category_added_by_name</span>";
		
		$jsonArrayItem['benefits_category_status']=$User['benefits_category_status'];
		$jsonArrayItem['benefits_category_status_description']=statusColor($User['benefits_category_status']);
		$jsonArrayItem['benefits_category_added_by']=$User['benefits_category_added_by'];
		$jsonArrayItem['benefits_category_added_by_name']=PersonName("{$User['benefits_category_added_by']}");

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>