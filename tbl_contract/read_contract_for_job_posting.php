<?php include("../includes/connection.php");?>
<?php include("../includes/function.php");?>
<div class="row" data-masonry='{"percentPosition": true }'>
<?php 
$obj = json_decode($_GET["data"], false);
$person_id = add_escape_character($obj->person_id);

date_default_timezone_set("Asia/Manila");
$dateToday = date("Y-m-d");
$filterCounter = 0;
$query = "SELECT * FROM tbl_job_position INNER JOIN tbl_contract 
ON tbl_job_position.job_position_id = tbl_contract.contract_job_position_id 
WHERE tbl_contract.contract_status=\"Activated\" 
AND tbl_contract.contract_application_date_from <= \"$dateToday\" AND tbl_contract.contract_application_date_to >= \"$dateToday\"
ORDER BY tbl_job_position.job_position_title ASC";
$Users = mysqli_query($connection, $query);
while ($User = mysqli_fetch_array($Users)) {

	$applied=false;
	$query = "SELECT * FROM tbl_applicant_application
	WHERE contract_id = {$User['contract_id']} AND 
	applicant_id = $person_id";
	$job_applications = mysqli_query($connection, $query);
	while ($job_application = mysqli_fetch_array($job_applications)) {
		$applied=true;
		break;
	}

	if(!$applied){
		$contract_application_date_from = GetMonthDescription($User['contract_application_date_from']);
		$contract_application_date_to = GetMonthDescription($User['contract_application_date_to']);
		$contract_starting_date = GetMonthDescription($User['contract_starting_date']);
		$job_position_description = substr($User['job_position_description'], 0, 70);
		if(strlen($User['job_position_description']) > 70)
			$job_position_description.=" [...]";
		$contract_rate = addComma($User['contract_rate']);


		echo "<div class='col-lg-4 mb-2'>
	      <div class='card'>
	        <img class='card-img-top' src='assets/img/elements/5.jpg' alt='Card image cap' style='height:150px;'>
	        <div class='card-body'>
	          <div class='row'>
	            <div class='col-lg-12'>
		    		<h5><i class='bx bx-briefcase' style='color:green;'></i> {$User['job_position_title']}</h5>
	            	<label style='color:gray;text-align:justify;'>
	            		$job_position_description
	            	</label><br>
					<b>Rate (Monthly):</b> PHP $contract_rate<br>
					<b>Application Date:</b><br> 
						<span style='text-transform:uppercase;'>
							$contract_application_date_from TO $contract_application_date_to
						</span><br>
					<b>Starting Date:</b> 
						<span style='text-transform:uppercase;'>
							$contract_starting_date
						</span><br>
	            </div>
	            <div class='col-lg-12'><br>
	            	<button type='button' class='btn btn-success btn-sm d-grid w-100' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewJobDetails({$User['contract_id']})'>View Details</button>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>";
	}
}
?>
</div>