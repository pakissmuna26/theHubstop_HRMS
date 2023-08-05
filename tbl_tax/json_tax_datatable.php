<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_tax ORDER BY tax_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['tax_id']="{$User['tax_id']}";
		$jsonArrayItem['tax_code']="{$User['tax_code']}";
		$jsonArrayItem['tax_title']=$User['tax_title'];
		$jsonArrayItem['tax_description']=$User['tax_description'];	
		$jsonArrayItem['tax_date_from']=$User['tax_date_from'];	
		$jsonArrayItem['tax_date_from_description']=GetMonthDescription($User['tax_date_from']);
		$jsonArrayItem['tax_date_to']=$User['tax_date_to'];	
		$jsonArrayItem['tax_date_to_description']=GetMonthDescription($User['tax_date_to']);
		$jsonArrayItem['tax_amount_from']=$User['tax_amount_from'];	
		$jsonArrayItem['tax_amount_from_description']=addComma($User['tax_amount_from']);	
		$jsonArrayItem['tax_amount_to']=$User['tax_amount_to'];	
		$jsonArrayItem['tax_amount_to_description']=addComma($User['tax_amount_to']);
		$jsonArrayItem['tax_additional']=$User['tax_additional'];	
		$jsonArrayItem['tax_additional_description']=addComma($User['tax_additional']);	
		$jsonArrayItem['tax_percentage']=$User['tax_percentage'];
		$jsonArrayItem['tax_details']="<b>{$User['tax_title']}</b><br>Effectivity Date: ".GetMonthDescription($User['tax_date_from'])." TO ".GetMonthDescription($User['tax_date_to'])."<br>Amount: PHP ".addComma($User['tax_amount_from'])." TO PHP ".addComma($User['tax_amount_to'])."<br>Additional: PHP ".addComma($User['tax_additional'])." | Percentage: {$User['tax_percentage']}%";

		
		$tax_added_by_name = PersonName("{$User['tax_added_by']}");
		$jsonArrayItem['tax_created_at']=$User['tax_created_at'];
		$jsonArrayItem['tax_created_at_by']="{$User['tax_created_at']}<br><span style='color:gray;'>By: $tax_added_by_name</span>";

		$jsonArrayItem['tax_status']=$User['tax_status'];
		$jsonArrayItem['tax_status_description']=statusColor($User['tax_status']);
		$jsonArrayItem['tax_added_by']=$User['tax_added_by'];
		$jsonArrayItem['tax_added_by_name']=$tax_added_by_name;

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>