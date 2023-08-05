<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_leave_category ORDER BY leave_category_title ASC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['leave_category_id']="{$User['leave_category_id']}";
		$jsonArrayItem['leave_category_code']="{$User['leave_category_code']}";
		$jsonArrayItem['leave_category_title']=$User['leave_category_title'];
		$jsonArrayItem['leave_category_description']=$User['leave_category_description'];
		$jsonArrayItem['leave_category_quantity']=$User['leave_category_quantity'];
		$jsonArrayItem['leave_category_paid_quantity']=$User['leave_category_paid_quantity'];
		$jsonArrayItem['leave_category_details']="<span style='color:gray;'>{$User['leave_category_code']}</span><br><b>{$User['leave_category_title']}</b>";	
		$jsonArrayItem['leave_category_quantity_details']="Total Quantity: {$User['leave_category_quantity']}<br>Paid Leave: {$User['leave_category_paid_quantity']}";	
		
		$leave_category_added_by_name = PersonName("{$User['leave_category_added_by']}");
		$jsonArrayItem['leave_category_created_at']=$User['leave_category_created_at'];
		$jsonArrayItem['leave_category_created_at_by']="{$User['leave_category_created_at']}<br><span style='color:gray;'>By: $leave_category_added_by_name</span>";
		
		$jsonArrayItem['leave_category_status']=$User['leave_category_status'];
		$jsonArrayItem['leave_category_status_description']=statusColor($User['leave_category_status']);
		$jsonArrayItem['leave_category_added_by']=$User['leave_category_added_by'];
		$jsonArrayItem['leave_category_added_by_name']=PersonName("{$User['leave_category_added_by']}");

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>