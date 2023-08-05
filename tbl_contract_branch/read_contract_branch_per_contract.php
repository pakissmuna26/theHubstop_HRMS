<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_id = add_escape_character($obj->contract_id);

echo "<div class='row'>
	<div class='col-lg-12'><br>
		<h6>Available Branch</h6>
	</div>
</div>";
echo "<div class='row'>
	<div class='col-lg-12'>
	<table class='table'>
		<tr>
			<th style='width:40%;'>Branch Details</th>
			<th style='width:40%;'>Branch HR Staff</th>
		</tr>";
$filterCounter = 0;
$query = "SELECT * FROM tbl_job_position INNER JOIN tbl_contract 
ON tbl_job_position.job_position_id = tbl_contract.contract_job_position_id 
INNER JOIN tbl_contract_branch 
ON tbl_contract.contract_id = tbl_contract_branch.contract_id 
INNER JOIN tbl_branch 
ON tbl_contract_branch.branch_id = tbl_branch.branch_id 
WHERE tbl_contract_branch.contract_id=$contract_id AND 
tbl_contract_branch.contract_branch_status=\"Activated\"
ORDER BY tbl_contract_branch.contract_branch_id DESC";
$contract_branches = mysqli_query($connection, $query);
while ($contract_branch = mysqli_fetch_array($contract_branches)) {
	$filterCounter++;
	echo "<tr>
		<td>
			<b>{$contract_branch['branch_name']}</b><br>
			Address: {$contract_branch['branch_address']}, {$contract_branch['branch_barangay']}, {$contract_branch['branch_city']}, {$contract_branch['branch_province']}, {$contract_branch['branch_region']}<br>
			Contact #: +639 {$contract_branch['branch_contact_number']}
		</td>";
		echo "<td><ul>";
		$query = "SELECT * FROM tbl_branch_person INNER JOIN tbl_person 
		ON tbl_branch_person.person_id = tbl_person.person_id
		WHERE tbl_branch_person.branch_id = {$contract_branch['branch_id']} AND 
		tbl_branch_person.branch_person_status=\"Added\" AND 
		tbl_person.user_type=2";
		$branch_persons = mysqli_query($connection, $query);
		while ($branch_person = mysqli_fetch_array($branch_persons)) {
			echo "<li>{$branch_person['last_name']} {$branch_person['affiliation_name']}, {$branch_person['first_name']} {$branch_person['middle_name']}</li>";
		}
		echo "</ul></td>
	</tr>";
}
if ($filterCounter == 0) {
	echo "<tr>
		<td colspan='10'>NO DATA AVAILABLE IN TABLE</td>
	</tr>";
}
echo "</table></div>
</div>";
?>