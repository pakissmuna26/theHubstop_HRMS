<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php
	$obj = json_decode($_GET["data"], false);
	$contract_id = add_escape_character($obj->contract_id);

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_contract_leave_category WHERE contract_id=$contract_id ORDER BY contract_category_credit_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		$jsonArrayItem['contract_category_credit_id']="{$User['contract_category_credit_id']}";
		$jsonArrayItem['contract_category_credit_code']="{$User['contract_category_credit_code']}";
		$jsonArrayItem['contract_id']=$User['contract_id'];
		$jsonArrayItem['leave_category_id']=$User['leave_category_id'];

		$leave_category_description = "";
		$query="SELECT * FROM tbl_leave_category WHERE leave_category_id = {$User['leave_category_id']} ORDER BY leave_category_title ASC";
		$leave_categories = mysqli_query($connection, $query);
		while ($leave_category = mysqli_fetch_array($leave_categories)) {
			$leave_category_description = "<span style='color:gray;'>{$leave_category['leave_category_code']}</span><br><b>{$leave_category['leave_category_title']}</b><br>Total Quantity: {$leave_category['leave_category_quantity']} | Paid Leave: {$leave_category['leave_category_paid_quantity']}";
		}
		$jsonArrayItem['leave_category_description']=$leave_category_description;

		$contract_category_credit_added_by_name = PersonName("{$User['contract_category_credit_added_by']}");
		$jsonArrayItem['contract_category_credit_created_at']=$User['contract_category_credit_created_at'];
		$jsonArrayItem['contract_category_credit_created_at_by']="{$User['contract_category_credit_created_at']}<br><span style='color:gray;'>By: $contract_category_credit_added_by_name</span>";
	
		$jsonArrayItem['contract_category_credit_status']=$User['contract_category_credit_status'];
		$jsonArrayItem['contract_category_credit_status_description']=statusColor($User['contract_category_credit_status']);
		$jsonArrayItem['contract_category_credit_added_by']=$User['contract_category_credit_added_by'];
		$jsonArrayItem['contract_category_credit_added_by_name']=PersonName("{$User['contract_category_credit_added_by']}");

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>