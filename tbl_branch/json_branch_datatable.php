<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_branch ORDER BY branch_name ASC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['branch_id']="{$User['branch_id']}";
		$jsonArrayItem['branch_code']="{$User['branch_code']}";
		$jsonArrayItem['branch_name']=$User['branch_name'];
		$jsonArrayItem['branch_description']=$User['branch_description'];	
		$jsonArrayItem['branch_details']="<span style='color:gray;'>{$User['branch_code']}</span><br><b>{$User['branch_name']}</b>";

		$jsonArrayItem['branch_address']=$User['branch_address'];	
		$jsonArrayItem['branch_barangay']=$User['branch_barangay'];	
		$jsonArrayItem['branch_city']=$User['branch_city'];	
		$jsonArrayItem['branch_province']=$User['branch_province'];	
		$jsonArrayItem['branch_region']=$User['branch_region'];	
		$jsonArrayItem['address']="{$User['branch_address']}, {$User['branch_barangay']}, {$User['branch_city']}, {$User['branch_province']}, {$User['branch_region']}<br>Contact #: +639 {$User['branch_contact_number']}";


		$jsonArrayItem['branch_contact_number']=$User['branch_contact_number'];	
		
		$branch_added_by_name = PersonName("{$User['branch_added_by']}");
		$jsonArrayItem['branch_created_at']=$User['branch_created_at'];
		$jsonArrayItem['branch_created_at_by']="{$User['branch_created_at']}<br><span style='color:gray;'>By: $branch_added_by_name</span>";

		$jsonArrayItem['branch_status']=$User['branch_status'];
		$jsonArrayItem['branch_status_description']=statusColor($User['branch_status']);
		$jsonArrayItem['branch_added_by']=$User['branch_added_by'];
		$jsonArrayItem['branch_added_by_name']=$branch_added_by_name;

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>