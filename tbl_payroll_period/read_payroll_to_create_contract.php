<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>

<table class="table" style="color: black;">
<thead>
	<tr>
	  <th style="width: 20%">Payroll Period</th>
	  <th style="width: 30%">Benefits</th>
	  <th style="width: 50%">Deduction</th>
	</tr>
</thead>
<?php 
$filterCounter = 0;
$query = "SELECT * FROM tbl_payroll_period WHERE payroll_period_status = \"Activated\" ORDER BY payroll_period_id DESC";
$payroll_periods = mysqli_query($connection, $query);
while ($payroll_period = mysqli_fetch_array($payroll_periods)) {

	$filterCounter++;
	echo "<tr>
		<td><input class='form-check-input chkPayrollPeriod' type='checkbox' value='{$payroll_period['payroll_period_id']}'>
		<b>{$payroll_period['payroll_period_title']}</b><br>
		Payroll Period: {$payroll_period['payroll_period_from']} TO {$payroll_period['payroll_period_to']}<br>
		Cut-off Period: {$payroll_period['payroll_period_cutoff_from']} TO {$payroll_period['payroll_period_cutoff_to']}</td>
		<td><ul>";
		$query = "SELECT * FROM tbl_benefits_category WHERE benefits_category_status = \"Activated\" ORDER BY benefits_category_title ASC";
		$benefits = mysqli_query($connection, $query);
		while ($benefit = mysqli_fetch_array($benefits)) {
			$amount = "PHP ".addComma($benefit['benefits_category_amount']);
			echo "<input class='form-check-input chkBenefits_{$payroll_period['payroll_period_id']}' type='checkbox' value='{$benefit['benefits_category_id']}'> <b>{$benefit['benefits_category_title']}</b>: $amount<br>";
		}
		echo "</ul></td>
		<td><ul>";
		$query = "SELECT * FROM tbl_deduction_category WHERE deduction_category_status = \"Activated\" ORDER BY deduction_category_title ASC";
		$deductions = mysqli_query($connection, $query);
		while ($deduction = mysqli_fetch_array($deductions)) {
			$share = "";
			if($deduction['deduction_category_is_percentage'] == "Yes")
				$share="Company Share: {$deduction['deduction_category_company_share']}% | Personnel Share: {$deduction['deduction_category_personnel_share']}%";
			else if($deduction['deduction_category_is_percentage'] == "No")
				$share="Company Share: PHP".addComma($deduction['deduction_category_company_share'])." | Personnel Share: PHP ".addComma($deduction['deduction_category_personnel_share'])."";

			echo "<input class='form-check-input chkDeduction_{$payroll_period['payroll_period_id']}' type='checkbox' value='{$deduction['deduction_category_id']}'><b>{$deduction['deduction_category_title']}</b>: $share<br>";
		}
		echo "</ul></td>
	</tr>";


}
?>
</table>