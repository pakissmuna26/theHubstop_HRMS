<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_id = add_escape_character($obj->contract_id);

echo "<div class='row'>
	<div class='col-lg-12'><br>
		<h6>Leave Credit</h6>
	</div>
</div>";
echo "<div class='row'>
	<div class='col-lg-12'>
	<table class='table'>
		<tr>
			<th style='width:20%;'>Leave</th>
			<th style='width:40%;'>Total Leave</th>
			<th style='width:40%;'>Paid Leave</th>
		</tr>";
$filterCounter = 0;
$query = "SELECT * FROM tbl_contract_leave_category INNER JOIN tbl_leave_category
ON tbl_contract_leave_category.leave_category_id = tbl_leave_category.leave_category_id
WHERE tbl_contract_leave_category.contract_id=$contract_id AND 
tbl_contract_leave_category.contract_category_credit_status=\"Activated\"
ORDER BY tbl_leave_category.leave_category_title ASC";
$leave_credits = mysqli_query($connection, $query);
while ($leave_credit = mysqli_fetch_array($leave_credits)) {
	echo "<tr>
		<td>{$leave_credit['leave_category_title']}</td>
		<td>{$leave_credit['leave_category_quantity']}</td>
		<td>{$leave_credit['leave_category_paid_quantity']}</td>
	</tr>";
}
echo "</table></div>
</div>";
?>