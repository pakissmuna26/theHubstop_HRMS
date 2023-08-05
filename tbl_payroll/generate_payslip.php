<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<?php include("../includes/session.php");?>
<?php 
	$signedin_user_type_id = $_SESSION['user_type'];
	$signedin_person_id = $_SESSION['person_id'];
?>
<?php 
	$obj = json_decode($_GET["data"], false);
	$payroll_id = add_escape_character($obj->payroll_id);
	$year = $month = $person_id = $payroll_period = 0;

	$total_salary = $salary_absent_adjustment = $salary_overtime = 0;
	$withholding_tax = 0;
	$query = "SELECT * FROM tbl_payroll 
	WHERE payroll_id = $payroll_id";
	$payrolls = mysqli_query($connection, $query);
	while ($payroll = mysqli_fetch_array($payrolls)) {
		$year = $payroll['payroll_year'];
		$month = $payroll['payroll_month'];
		$person_id = $payroll['payroll_person_id'];
		$payroll_period = $payroll['payroll_period_id'];
		$total_salary = $payroll['payroll_salary'];
		$salary_absent_adjustment = $payroll['payroll_absent_adjustment'];
		$salary_overtime = $payroll['payroll_overtime'];
		$withholding_tax = $payroll['payroll_withholding_tax'];
		break;
	}
?>

<?php 
	$months = array("", "January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December");
	$month = (int)$month;
	
	$payroll_period_from = $payroll_period_to = 0;
	$payroll_cutoff_from = $payroll_cutoff_to = 0;
	$query = "SELECT * FROM tbl_payroll_period 
	WHERE payroll_period_id = $payroll_period";
	$payroll_periods = mysqli_query($connection, $query);
	while ($payroll_period_ = mysqli_fetch_array($payroll_periods)) {
		$payroll_period_from = $payroll_period_['payroll_period_from'];
		$payroll_period_to = $payroll_period_['payroll_period_to'];
		$payroll_cutoff_from = $payroll_period_['payroll_period_cutoff_from'];
		$payroll_cutoff_to = $payroll_period_['payroll_period_cutoff_to'];
		break;
	}

	$from_year = $year;
	$to_year = $year;
	$cutoff_date_from = $cutoff_date_to = "";

	$cutoff_from_string = $cutoff_to_string = "";
	$month_description_from = $months[$month];
	if($payroll_cutoff_from > $payroll_cutoff_to ){
		$cutoff_month = $month - 1;
		$month_description_to = $months[$cutoff_month];
		if($cutoff_month == 0){
			$month_description_to = $months[12];
			$from_year = $year - 1;
		}
		$cutoff_date_from = "$month_description_to $payroll_cutoff_from, $from_year"; 
		$cutoff_date_to = "$month_description_from $payroll_cutoff_to, $to_year";

		$cutoff_month_display="$cutoff_month";
		if($cutoff_month < 10) $cutoff_month_display="0$cutoff_month";

		$payroll_cutoff_from_display="$payroll_cutoff_from";
		if($payroll_cutoff_from < 10) $payroll_cutoff_from_display="0$payroll_cutoff_from";
		$cutoff_from_string="$from_year-$cutoff_month_display-$payroll_cutoff_from_display";

		$cutoff_month_display="$month";
		if($month < 10) $cutoff_month_display="0$month";

		$payroll_cutoff_to_display="$payroll_cutoff_to";
		if($payroll_cutoff_to < 10) $payroll_cutoff_to_display="0$payroll_cutoff_to";
		$cutoff_to_string = "$from_year-$cutoff_month_display-$payroll_cutoff_to_display";
	}else{
		$cutoff_date_from="$month_description_from $payroll_cutoff_from, $year";
		$cutoff_date_to="$month_description_from $payroll_cutoff_to, $year";

		$cutoff_month_display="$month";
		if($month < 10) $cutoff_month_display="0$month";

		$payroll_cutoff_from_display="$payroll_cutoff_from";
		if($payroll_cutoff_from < 10) $payroll_cutoff_from_display="0$payroll_cutoff_from";
		$cutoff_from_string="$year-$cutoff_month_display-$payroll_cutoff_from_display"; 

		$payroll_cutoff_to_display="$payroll_cutoff_to";
		if($payroll_cutoff_to < 10) $payroll_cutoff_to_display="0$payroll_cutoff_to";
		$cutoff_to_string="$year-$cutoff_month_display-$payroll_cutoff_to_display";
	}

	$from_year = $year;
	$to_year = $year;
	$payroll_date_from = $payroll_date_to = "";

	$month_description_from = $months[$month];
	if($payroll_period_from > $payroll_period_to ){
		$payroll_month = $month - 1;
		$month_description_to = $months[$payroll_month];
		if($payroll_month == 0){
			$month_description_to = $months[12];
			$from_year = $year - 1;
		}
		$payroll_date_from = "$month_description_to $payroll_period_from, $from_year"; 
		$payroll_date_to = "$month_description_from $payroll_period_to, $to_year";
	}else{
		$payroll_date_from = "$month_description_from $payroll_period_from, $year";
		$payroll_date_to = "$month_description_from $payroll_period_to, $year";
	}

	$salary = 0;
	$job_position = "";
	$get_contract_id = 0;
	$query = "SELECT * FROM tbl_job_position INNER JOIN  tbl_contract 
	ON tbl_job_position.job_position_id = tbl_contract.contract_job_position_id
	INNER JOIN tbl_applicant_application
	ON tbl_contract.contract_id = tbl_applicant_application.contract_id
	WHERE tbl_applicant_application.applicant_id = $person_id";
	$contract_salaries = mysqli_query($connection, $query);
	while ($contract_salary = mysqli_fetch_array($contract_salaries)) {
		if($contract_salary['application_contract_end_date'] == "0000-00-00"){
			// if($contract_salary['application_contract_start_date'] <= $cutoff_from_string){
				$salary = $contract_salary['contract_rate'];
				$get_contract_id = $contract_salary['contract_id'];
				$job_position = $contract_salary['job_position_title'];
				break;
			// }
		}else{
			if($contract_salary['application_contract_start_date'] >= $cutoff_from_string &&
				$contract_salary['application_contract_end_date'] <= $cutoff_to_string){
				$salary = $contract_salary['contract_rate'];
				$get_contract_id = $contract_salary['contract_id'];
				$job_position = $contract_salary['job_position_title'];
				break;
			}
		}
	}

	$name = PersonName($person_id);
	echo "<div class='row'>
			<div class='col-lg-6'>
				<div class='row'>
					<div class='col-lg-3'><b>Name</b></div>
					<div class='col-lg-9'>: $name</div>
				</div>
				<div class='row'>
					<div class='col-lg-3'><b>Position</b></div>
					<div class='col-lg-9'>: $job_position</div>
				</div>
			</div>
			<div class='col-lg-6'>
				<div class='row'>
					<div class='col-lg-4'><b>Cutoff Period</b></div>
					<div class='col-lg-8'>: $cutoff_date_from TO $cutoff_date_to</div>
				</div>
				<div class='row'>
					<div class='col-lg-4'><b>Payroll Period</b></div>
					<div class='col-lg-8'>: $payroll_date_from TO $payroll_date_to</div>
				</div>
			</div>
		</div>";

		echo "<div class='row'><div class='col-lg-12'><hr></div></div>";

	// COMPUTE ATTENDANCE
	$attendance_counter=0;
	$total_hours_working = $total_minutes_working = 0;

	$attendance_summary = "";
	$attendance_adjustment_summary = "";
	$query = "SELECT * FROM tbl_attendance 
	WHERE attendance_requested_by = $person_id AND 
	attendance_status = \"Payroll\" AND 
	payroll_id = $payroll_id
	ORDER BY attendance_id ASC";
	$Users = mysqli_query($connection, $query);
	while ($User = mysqli_fetch_array($Users)) {
		// echo "{$User['attendance_date_in']} >= $cutoff_from_string && {$User['attendance_date_in']} <= $cutoff_to_string<br>";
		// $User['attendance_date_in'] >= $cutoff_from_string && 
			
		if($User['attendance_date_in'] <= $cutoff_to_string){

		$shift_time_from = $shift_time_to = "";
		$shift_break_time_from = $shift_break_time_to = "";
		$has_schedule=false;
		include("../tbl_attendance/shift_schedule_checker.php");	

		// CHECK ATTENDANCE
		$attendance_from_hours = substr("{$User['attendance_time_in']}", 0, 2);
		$attendance_from_minutes = substr("{$User['attendance_time_in']}", 3, 2);
		$attendance_to_hours = substr("{$User['attendance_time_out']}", 0, 2);
		$attendance_to_minutes = substr("{$User['attendance_time_out']}", 3, 2);
		// END OF CHECK ATTENDANCE

		// CHECK SHIFT SCHEDULE
		$shift_time_from_hours = substr($shift_time_from, 0, 2);
		$shift_time_from_minutes = substr($shift_time_from, 3, 2);
		$shift_time_to_hours = substr($shift_time_to, 0, 2);
		$shift_time_to_minutes = substr($shift_time_to, 3, 2);
		// END OF CHECK SHIFT SCHEDULE

		// CHECK BREAK TIME
		$break_time_from_hours = substr($shift_break_time_from, 0, 2);
		$break_time_from_minutes = substr($shift_break_time_from, 3, 2);
		$break_time_to_hours = substr($shift_break_time_to, 0, 2);
		$break_time_to_minutes = substr($shift_break_time_to, 3, 2);
		// END OF CHECK BREAK TIME

		// ATTENDANCE
		$attendance_time_in="{$User['attendance_date_in']} {$User['attendance_time_in']}";
		$attendance_time_out="{$User['attendance_date_out']} {$User['attendance_time_out']}";
		$time_in = new DateTime($attendance_time_in);
		$time_out = new DateTime($attendance_time_out);
		// END OF ATTENDANCE

		// EXPECTED SHIFT SCHEDULE
		$date_attendance_from = "{$User['attendance_date_in']}";
		$date_attendance_to = "{$User['attendance_date_in']}"; 
	
		$shift_type = "";
		if((int)$shift_time_from_hours > (int)$shift_time_to_hours) {
			$shift_type = "Night Shift";

			if($attendance_from_hours >= ($shift_time_from_hours-1) ||   
				$attendance_from_hours >= $shift_time_from_hours &&  
				$attendance_from_hours <= 23 && 
				$attendance_from_minutes <= 59){
				// $date_attendance_from = "{$User['attendance_date_in']}";
			}else{
				$date_attendance_from=date("Y-m-d", strtotime($date_attendance_from."- 1 day"));
			}
			$date_attendance_to = date("Y-m-d", strtotime($date_attendance_from."+ 1 day"));
		}
		else {
			$shift_type = "Day Shift";
			if($attendance_from_hours >= ($shift_time_from_hours-1) ||   
				$attendance_from_hours >= $shift_time_from_hours &&  
				$attendance_from_hours <= 23 && 
				$attendance_from_minutes <= 59){
				
				$date_attendance_from = "{$User['attendance_date_in']}";
				$date_attendance_to = "{$User['attendance_date_in']}";
			}else{
				$date_attendance_from = "";
				$date_attendance_to = "";
			}
		}
		
		$shift_time_from_with_date="$date_attendance_from $shift_time_from";
		$shift_time_to_with_date="$date_attendance_to $shift_time_to";
		$expected_shift_schedule = GetMonthDescription("$date_attendance_from")." @  $shift_time_from TO ".GetMonthDescription("$date_attendance_to")." @ $shift_time_to";
		$shift_from = new DateTime($shift_time_from_with_date);
		$shift_to = new DateTime($shift_time_to_with_date);
		// END OF EXPECTED SHIFT SCHEDULE

		// SHIFT BREAK
		if($shift_time_from_hours > $break_time_from_hours)
			$date_attendance_from=date("Y-m-d", strtotime($date_attendance_from."+ 1 day"));
		
		$date_attendance_to = "$date_attendance_from";
		if($break_time_to_hours < $break_time_from_hours){
			$date_attendance_to = date("Y-m-d", strtotime($date_attendance_from."+ 1 day"));
		}
		$shift_break_time_from_with_date="$date_attendance_from $shift_break_time_from";
		$shift_break_time_to_with_date="$date_attendance_to $shift_break_time_to";
		$expected_shift_break = GetMonthDescription("$date_attendance_from")." @ $shift_break_time_from TO ".GetMonthDescription("$date_attendance_to")." @ $shift_break_time_to";
		$break_from = new DateTime($shift_break_time_from_with_date);
		$break_to = new DateTime($shift_break_time_to_with_date);
		// END OF SHIFT BREAK

		$time_in_only=false;
		if($User['attendance_time_out'] == "") $time_in_only = true;

		// COMPUTE WORKING HOURS
		$work_status = $working_time_display = "";
		$working_time_hours = $working_time_minutes = 0;

		if($time_in_only){
			$working_time_display = "TIME OUT IS NEEDED TO COMPUTE THE WORKING HOURS";
		}else{
			$working_time = $time_out->diff($time_in);
			$working_time_days = $working_time->d;

			if($working_time_days >= 1){
				$work_status = "<span style='color:red;'>ASK THE HR STAFF REGARDING YOUR ATTENDANCE</span>";
				$working_time_hours = 0;
				$working_time_minutes = 0;
				$working_time_display = "$working_time_hours HR/S $working_time_minutes MIN/S";
			}else{
				if($User['attendance_type'] == "Daily" || $User['attendance_type'] == "Leave Request"){
					include("../tbl_attendance/attendance_checker_daily.php");
				}else if($User['attendance_type'] == "Overtime"){
					if($attendance_from_hours >= $shift_time_to_hours && $attendance_from_minutes >= $shift_time_to_minutes){
						$working_time = $time_in->diff($time_out);
						$working_time_hours = $working_time->h;
						$working_time_minutes = $working_time->i;
						$working_time_display="$working_time_hours HR/S $working_time_minutes MIN/S";						
					}else{
						$work_status = "<span style='color:red;'>ASK THE HR STAFF REGARDING YOUR ATTENDANCE</span>";
						$working_time_hours = 0;
						$working_time_minutes = 0;
						$working_time_display = "$working_time_hours HR/S $working_time_minutes MIN/S";	
					}
				}
			}//end of else $working_time_days
		}//end of else $time_in_only
		// COMPUTE WORKING HOURS
			$holiday_description = "";
			$query = "SELECT * FROM tbl_holiday 
			WHERE holiday_date_from >= \"{$User['attendance_date_in']}\" AND 
			holiday_date_to <= \"{$User['attendance_date_in']}\"";
			$holidays = mysqli_query($connection, $query);
			while ($holiday = mysqli_fetch_array($holidays)) {
				$holiday_description .= "{$holiday['holiday_title']}<br>";
			}

			$attendance_category_color = statusColor($User['attendance_category']);
			$attendance_type_color = statusColor($User['attendance_type']);
			$attendance_counter++;

			$status = "Approved/Denied";
			if($User['attendance_status'] != "Pending")
				$status = $User['attendance_status'];
			$attendance_approved_by = PersonName($User['attendance_approved_by']);

			$working_details = "No Schedule on this day";
			if($has_schedule){
				$working_details="$work_status<br><span style='color:gray;'>$status By: $attendance_approved_by</span>";
			}

			$attendance_summary.= "<tr>
			<td><span class='payroll_attendance_id' style='display:none;'>{$User['attendance_id']}</span> 
				$attendance_counter
			</td>
			<td>
				Time In: ".GetMonthDescription($User['attendance_date_in'])." @ {$User['attendance_time_in']} | 
				Time Out: ".GetMonthDescription($User['attendance_date_out'])." @ {$User['attendance_time_out']}<br>
				$working_details<br>
				<i>$holiday_description</i>
			</td>
			<td>$day</td>
			<td>$working_time_display</td>
			<td>$attendance_category_color</td>
			<td>$attendance_type_color</td>
		</tr>";
			if($User['attendance_date_in'] >= $cutoff_from_string && 
				$User['attendance_date_in'] <= $cutoff_to_string){
				$total_hours_working += $working_time_hours;
				$total_minutes_working += $working_time_minutes;
			}else if($User['attendance_date_in'] < $cutoff_from_string){
				$total_hours_working += $working_time_hours;
				$total_minutes_working += $working_time_minutes;
			}
		}//end of if
	}//end of outer while

	$total_per_cutoff = round(($total_salary+$salary_absent_adjustment),2);
	
	$benefits_display = $deduction_display = "";
	$subtotal_nontaxable_earnings = $subtotal_contributions = 0;
	$query = "SELECT * FROM tbl_payroll_benefits_deduction 
	WHERE payroll_id = $payroll_id";
	$payroll_periods = mysqli_query($connection, $query);
	while ($payroll_period = mysqli_fetch_array($payroll_periods)) {
		if($payroll_period['benefits_deduction_category'] == "Benefits"){
			$query = "SELECT * FROM tbl_benefits_category
			WHERE benefits_category_id = {$payroll_period['benefits_deduction_id']} 
			ORDER BY benefits_category_title ASC";
			$benefits = mysqli_query($connection, $query);
			while ($benefit = mysqli_fetch_array($benefits)) {
				$benefits_display .= "<tr><td>{$benefit['benefits_category_title']}</td>
							<td>: PHP ".addComma($benefit['benefits_category_amount'])."</td>
						</tr>";
				$subtotal_nontaxable_earnings+=$benefit['benefits_category_amount'];
			}
		}else if($payroll_period['benefits_deduction_category'] == "Deduction"){
			$query = "SELECT * FROM tbl_deduction_category
			WHERE deduction_category_id = {$payroll_period['benefits_deduction_id']} 
			ORDER BY deduction_category_title ASC";
			$deductions = mysqli_query($connection, $query);
			while ($deduction = mysqli_fetch_array($deductions)) {
				$deduction_amount = 0;
				if($deduction['deduction_category_is_percentage'] == "Yes"){
					$sub = $total_per_cutoff * ($deduction['deduction_category_personnel_share'] / 100);
					$deduction_amount = round($sub, 2);
				}else if($deduction['deduction_category_is_percentage'] == "No"){
					$deduction_amount = $deduction['deduction_category_personnel_share'];
				}
				$subtotal_contributions += $deduction_amount;

				$deduction_display .= "<tr><td>{$deduction['deduction_category_title']}</td>
							<td>: PHP ".addComma($deduction_amount)."</td>
						</tr>";
			}
		}
	}


	$subtotal_taxable_earnings = $total_salary + $salary_absent_adjustment + $salary_overtime;
	$total_earnings = $subtotal_taxable_earnings + $subtotal_nontaxable_earnings;	

	$subtotal_deductions = $subtotal_contributions + $withholding_tax;

	echo "<div class='row row-bordered'>
		<div class='col-lg-8'>
			<h6 class='text-center'>Earnings</h6>
			<div class='row'>
				<div class='col-lg-6'>
					<p style='font-size:14px;text-align:center;'>Taxable</p>
					<table class='table'>						
						<tr>
							<td>Salary</td>
							<td>: PHP ".addComma($total_salary)."</td>
						</tr>
						<tr>
							<td>Absent Adjustment</td>
							<td>: PHP ".addComma($salary_absent_adjustment)."</td>
						</tr>
						<tr>
							<td>Overtime</td>
							<td>: PHP ".addComma($salary_overtime)."</td>
						</tr>
						<tr style='font-size:12px;'>
							<td><b>Subtotal</b></td>
							<td><b>: PHP ".addComma($subtotal_taxable_earnings)."</b></td>
						</tr>
					</table>
				</div>
				<div class='col-lg-6'>
					<p style='font-size:14px;text-align:center;'>Non-Taxable</p>
					<div class='row'>
						<div class='col-lg-12'>
							<table class='table'>
								$benefits_display
								<tr style='font-size:12px;'>
									<td><b>Subtotal</b></td>
									<td><b>: PHP ".addComma($subtotal_nontaxable_earnings)."</b></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='col-lg-4'>
			<h6 class='text-center'>Deductions</h6>
			<div class='row'>
				<div class='col-lg-12'>
					<p style='font-size:14px;text-align:center;'>Statutory Contribution</p>
					<table class='table'>
						$deduction_display
						<tr>
							<td>Withhoding Tax</td>
							<td>: PHP ".addComma($withholding_tax)."</td>

						</tr>
						<tr style='font-size:12px;'>
							<td><b>Subtotal</b></td>
							<td><b>: PHP ".addComma($subtotal_deductions)."</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>";

	$net_pay = round((($total_earnings)-$subtotal_deductions),2);
	echo "<div class='row'>
		<div class='col-lg-4'><br>
			<h6 class='text-center'>Rate & Working Time</h6>
			<table class='table'>
				<tr>
					<td>Rate (Monthly)</td>
					<td>: PHP ".addComma($salary)."</td>
				</tr>
				<tr>
					<td>Working Hours</td>
					<td>: $total_hours_working HR/S & $total_minutes_working MIN/S</td>
				</tr>
			</table>
		</div>
		<div class='col-lg-4'><br>
			<h6 class='text-center'>Summary</h6>
			<table class='table'>
				<tr>
					<td>Total Earnings</td>
					<td>: PHP ".addComma($total_earnings)."</td>
				</tr>		
				<tr>
					<td>Total Deduction</td>
					<td>: PHP ".addComma($subtotal_deductions)."</td>
				</tr>
				<tr class='alert alert-success'>
					<td><b>Net Pay</b></td>
					<td><b>: PHP ".addComma($net_pay)."</b></td>
				</tr>
			</table>
		</div>
		<div class='col-lg-4'></div>
	</div>";

	echo "<div class='row'><div class='col-lg-12'><hr></div></div>";

	echo "<div class='row'>
			<div class='col-lg-12'>
				<h6 class='text-center'>Verify Attendance</h6>
				<table class='table'>
					<tr>
						<th style='width: 5%;'>No.</th>
						<th style='width: 50%;'>Time In & Out</th>
						<th style='width: 10%;'>Day</th>
						<th style='width: 15%;'>Working Hours</th>
						<th style='width: 10%;'>Category</th>
						<th style='width: 10%;'>Type</th>
					</tr>
					$attendance_summary
				</table>
			</div>
		</div>";
?>