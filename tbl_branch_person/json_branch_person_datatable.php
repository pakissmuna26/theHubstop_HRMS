<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php
	$obj = json_decode($_GET["data"], false);
	$branch_id = add_escape_character($obj->branch_id);

	$results["data"] = array();

	$result=$db->prepare("SELECT * FROM tbl_branch_person INNER JOIN tbl_person ON tbl_branch_person.person_id = tbl_person.person_id WHERE tbl_branch_person.branch_id = $branch_id ORDER BY tbl_branch_person.branch_person_id DESC");
	$result->execute();

	$filterCounter=0;
	for($i=0; $User = $result->fetch(); $i++){
		
		$filterCounter++;
		$jsonArrayItem=array();		
		$jsonArrayItem['number']=$filterCounter;
		
		$jsonArrayItem['branch_person_id']="{$User['branch_person_id']}";
		$jsonArrayItem['branch_person_code']="{$User['branch_person_code']}";
		$jsonArrayItem['branch_id']=$User['branch_id'];
		$jsonArrayItem['person_id']=$User['person_id'];	
		$jsonArrayItem['person_name_details']="<span style='color:gray;'>{$User['branch_person_code']}</span><br>".PersonName($User['person_id'])."<br>"."<span style='color:gray;'>".Get_Type_Description($User['user_type'])."</span>";
		
		$jsonArrayItem['branch_person_remarks']=$User['branch_person_remarks'];	

		$branch_person_added_by_name=PersonName("{$User['branch_person_added_by']}");
		$jsonArrayItem['branch_person_created_at']=$User['branch_person_created_at'];
		$jsonArrayItem['branch_person_created_at_by']="{$User['branch_person_created_at']}<br><span style='color:gray;'>By: $branch_person_added_by_name</span>";

		$jsonArrayItem['branch_person_status']=$User['branch_person_status'];
		$jsonArrayItem['branch_person_status_description']=statusColor($User['branch_person_status']);
		$jsonArrayItem['branch_person_added_by']=$User['branch_person_added_by'];
		$jsonArrayItem['branch_person_added_by_name']=$branch_person_added_by_name;

		array_push($results["data"], $jsonArrayItem);

	}

	$data[] =$results["data"];
	$results["sEcho"]=1;
	$results["iTotalRecords"]=count($data);
	$results["iTotalDisplayRecords"]=count($data);
	echo json_encode($results);
?>