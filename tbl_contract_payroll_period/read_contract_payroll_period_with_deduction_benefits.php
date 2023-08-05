<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php 
$obj = json_decode($_GET["data"], false);
$contract_id = add_escape_character($obj->contract_id);

echo "<div class='row'>
	<div class='col-lg-12'>
		<h6>Payroll Period</h6>
	</div>
</div>";
echo "<div class='row'>
		<div class='col-lg-12'>
			<div class='row'>
				<div class='col-lg-12'>
		
		<table class='table'>
			<tr>
				<th style='width:20%;'>Payroll Period</th>
				<th style='width:40%;'>Benefits</th>
				<th style='width:40%;'>Deduction</th>
			</tr>";
$filterCounter = 0;
$query = "SELECT * FROM tbl_contract_payroll_period INNER JOIN tbl_payroll_period
ON tbl_contract_payroll_period.payroll_period_id = tbl_payroll_period.payroll_period_id
WHERE tbl_contract_payroll_period.contract_id=$contract_id AND 
tbl_contract_payroll_period.contract_payroll_period_status=\"Activated\"
ORDER BY tbl_contract_payroll_period.contract_payroll_period_id ASC";
$payroll_periods = mysqli_query($connection, $query);
while ($payroll_period = mysqli_fetch_array($payroll_periods)) {
	echo "<tr>
		<td><b>{$payroll_period['payroll_period_title']}</b><br>
			Payroll Period: {$payroll_period['payroll_period_from']} TO {$payroll_period['payroll_period_to']}<br>
			Cut-off Period: {$payroll_period['payroll_period_cutoff_from']} TO {$payroll_period['payroll_period_cutoff_to']}
		</td>
	</td>";
	echo "<td><ul>";
	$query = "SELECT * FROM tbl_payroll_period_benefits_deduction
	WHERE contract_payroll_period_id={$payroll_period['contract_payroll_period_id']}
	AND benefits_deduction_category=\"Benefits\" 
	AND payroll_period_benefits_deduction_status=\"Activated\"
	ORDER BY payroll_period_benefits_deduction_id ASC";
	$benefits_deductions = mysqli_query($connection, $query);
	while ($benefits_deduction = mysqli_fetch_array($benefits_deductions)) {
		$benefits_details = "";
		$query = "SELECT * FROM tbl_benefits_category WHERE benefits_category_id = {$benefits_deduction['benefits_deduction_id']}";
		$Benefits = mysqli_query($connection, $query);
		while ($Benefit = mysqli_fetch_array($Benefits)) {
			$benefits_details="<b>{$Benefit['benefits_category_title']}</b><br> 
			Amount: "."PHP ".addComma($Benefit['benefits_category_amount']);
			break;
		}
		echo "<li>$benefits_details</li>";
	}
	echo "</ul></td>";
	echo "<td><ul>";
	$query = "SELECT * FROM tbl_payroll_period_benefits_deduction
	WHERE contract_payroll_period_id={$payroll_period['contract_payroll_period_id']}
	AND benefits_deduction_category=\"Deduction\"
	AND payroll_period_benefits_deduction_status=\"Activated\"
	ORDER BY payroll_period_benefits_deduction_id ASC";
	$benefits_deductions = mysqli_query($connection, $query);
	while ($benefits_deduction = mysqli_fetch_array($benefits_deductions)) {
		$deduction_details="";
		$query = "SELECT * FROM tbl_deduction_category WHERE deduction_category_id = {$benefits_deduction['benefits_deduction_id']}";
		$Deductions = mysqli_query($connection, $query);
		while ($Deduction = mysqli_fetch_array($Deductions)) {
			if($Deduction['deduction_category_is_percentage'] == "Yes")
				$deduction_details="<b>{$Deduction['deduction_category_title']}</b><br>Company Share: {$Deduction['deduction_category_company_share']}% | Personnel Share: {$Deduction['deduction_category_personnel_share']}%";
			else if($Deduction['deduction_category_is_percentage'] == "No")
				$deduction_details="<b>{$Deduction['deduction_category_title']}</b><br>Company Share: PHP ".addComma($Deduction['deduction_category_company_share'])." | Personnel Share: PHP ".addComma($Deduction['deduction_category_personnel_share']);
			break;
		}
		echo "<li>$deduction_details</li>";
	}
	echo "</ul></td>";
}
	echo "</table>";
	echo "</div>";

echo "</div>
	</div>
</div>";
?>