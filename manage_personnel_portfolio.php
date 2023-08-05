<?php include("includes/header.php"); ?>
<?php 
$position = "";
if(isset($_GET['id'])){
    if($_GET['id'] == ""){
        header('Location:dashboard.php');
    }else{ 
    }
}else{
    header('Location:dashboard.php');
}
?>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    <!-- Menu -->
      <?php include("includes/menu.php"); ?>
    <!-- / Menu -->

    <!-- Layout container -->
    <div class="layout-page">
      <!-- Navbar -->
        <?php include("includes/navbar.php"); ?>
        <script type="text/javascript">
          $(".page_name").text("Personnel Portfolio Management");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl container-p-y" style="text-transform: uppercase; font-size: 14px;">
          <div class="accordion" id="accordion">
            <div class="card accordion-item mb-1">
              <h2 class="accordion-header" id="heading">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionApplicantInformation" aria-expanded="false" aria-controls="accordionApplicantInformation">
                  Applicant Information (<span class="applicantName"></span>)
                </button>
              </h2>
              <div id="accordionApplicantInformation" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">  <div class="accordion-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="divApplicantDetails"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <h6>Working History</h6>
                      <table class="table tblApplicantWorkingHistory"></table>
                    </div>
                  </div>
                </div>
              </div>
            </div>              
          </div>

          <div class="card accordion-item active mb-2">
            <h2 class="accordion-header" id="heading">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionApplicantProcess" aria-expanded="true"aria-controls="accordionApplicantProcess">
                Shifting Schedule
              </button>
            </h2>
            <div id="accordionApplicantProcess" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="row">
                  <div class="col-lg-12">
                    <button type="button" id="btnAddNewShiftSchedule" class="btn btn-outline-success float-right" data-bs-toggle='modal' data-bs-target='#modalAddNewSchedule'>Add New Schedule</button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12"><br>
                    <!-- <div class="table-responsive text-nowrap"> -->
                    <table class="table" id="list_of_data_shift_schedule">
                      <thead>
                        <tr>
                          <th style="width: 5%">No.</th>
                          <th style="width: 25%">Branch</th> 
                          <th style="width: 40%">Shift Schedule</th> 
                          <th style="width: 20%">Date & Time Created</th> 
                          <th style="width: 5%">Status</th>
                          <th style="width: 5%">Action</th>
                        </tr>
                      </thead>
                    </table>
                    <!-- </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>        

          <div class="divListOfContract"></div>
        <!-- / Content -->

        <!-- Footer -->
          <?php //include("includes/footer.php"); ?>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
      </div>
      <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
  </div>

  <!-- Overlay -->
  <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<script type="text/javascript">
$(document).ready(function() {
  ListOfData();
});

function ListOfData(){
  let person_id = "<?php echo $_GET['applicant_id']; ?>";
  let obj={"person_id":person_id};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data_shift_schedule').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_person_shifting_schedule/json_person_shifting_schedule_datatable.php?data="+parameter,
    // dom: 'Bfrtip',
    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    "aoColumns": [
      { mData: 'number'},      
      { mData: 'address'},
      { mData: 'shifting_schedule_days_of_week'},
      { mData: 'person_shifting_schedule_created_at_by'},
      { mData: 'person_shifting_schedule_status_description'},
      { mData: 'person_shifting_schedule_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalApplicationProcessManagement' onclick='btnUpdateDetails("+row.person_shifting_schedule_id+")'><i class='bx bx-edit'></i> Update Schedule</a>";
        let person_shifting_schedule_id = row.person_shifting_schedule_id;
        let person_shifting_schedule_status = row.person_shifting_schedule_status;

        let button_change_status = "";
        if(person_shifting_schedule_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.person_shifting_schedule_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Schedule</a>";
        }else if(person_shifting_schedule_status == "Deactivated" || person_shifting_schedule_status == "For Checking"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.person_shifting_schedule_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Schedule</a>";
        }

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_update_details+" "+button_change_status+"</div>";


        return action_button;        
      }
    }]
  });
}//end of function

CheckApplicationStatus();
function CheckApplicationStatus() {
  $("#btnAddNewShiftSchedule").attr("disabled", true);
  $("#btnAddNewShiftSchedule").attr("onclick", "");
  let applicant_id = "<?php echo $_GET['applicant_id']; ?>";
  $.ajax({url:'tbl_applicant_application/json_applicant_application.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_id == applicant_id &&
          data[index].application_contract_status == "Activated"){
          $("#btnAddNewShiftSchedule").attr("disabled", false);
          $("#btnAddNewShiftSchedule").attr("onclick", "btnAddNewData()");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function Empty() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");
  
  for(let index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    validations[index].innerHTML = "*";
  }
}

function btnUpdateDetails(person_shifting_schedule_id) {
  Empty();
  $.ajax({url:'tbl_person_shifting_schedule/json_person_shifting_schedule.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].person_shifting_schedule_id == person_shifting_schedule_id){
          $("#btnUpdateDetails").val(data[index].person_shifting_schedule_id);
          $("#txt_effective_date").val(data[index].effective_date);
          $("#txt_end_effective_date").val(data[index].end_effective_date);
          break;         
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateSchedule() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let person_shifting_schedule_id = $("#btnUpdateDetails").val();
  let effective_date = $("#txt_effective_date").val();
  let end_effective_date = $("#txt_end_effective_date").val();

  let counter = 0;
    for(let index=0; index<all_Fields.length; index++){
      if(all_Fields[index].value == ""){
        validations[index].innerHTML = "* Field is required";
        counter++;
      }else{
        // validations[index].innerHTML = "*";
      }
    }
    if(counter == 0){
      
      let obj={"person_shifting_schedule_id":person_shifting_schedule_id,
        "effective_date":effective_date,
        "end_effective_date":end_effective_date};
      let parameter = JSON.stringify(obj); 
    
      Empty();
      $.ajax({url:'tbl_person_shifting_schedule/update_person_shifting_schedule.php?data='+parameter,
        method:'GET',
        success:function(data){
          if(data == true){
            ShowToast("bg-success", "Success", "Schedule successfully updated.");
            $(".btnModalClose").click();
            $("#list_of_data_shift_schedule").DataTable().ajax.reload();
          }
          else{
            ShowToast("bg-warning", "Warning", "Updating schedule was failed, Please try again.");
            console.log(data);
          }
        },
        error:function(){
          ShowToast("bg-danger", "Danger", "Updating schedule went something wrong, Please contact the System Administrator.");
        }
      });//end of ajax  
      
     }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(person_shifting_schedule_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this schedule?");
  $("#btnChangeStatus").val(person_shifting_schedule_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let person_shifting_schedule_id = $("#btnChangeStatus").val();

  let obj={"person_shifting_schedule_id":person_shifting_schedule_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_person_shifting_schedule/update_person_shifting_schedule_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Schedule status successfully changed to: "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data_shift_schedule").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of schedule status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of schedule status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

Get_Contract();
function Get_Contract(){
  let applicant_id = "<?php echo $_GET['applicant_id']; ?>";
  $.ajax({url:'tbl_applicant_application/json_applicant_application.php',
    method:'GET',
    success:function(data){
      $(".divListOfContract").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_id == applicant_id){
          let link = "";        
          if(data[index].application_contract_status == "Pending"){
            link = "<a href='manage_job_application.php?id="+data[index].applicant_application_id+"'>Click here</a> to activate contract";
          }else if(data[index].application_contract_status == "Activated"){
            link = "<a href='manage_job_application.php?id="+data[index].applicant_application_id+"'>Click here</a> to deactivate contract";
          }else{
            link = "Contract has been Deactivated.";
          }

          $(".divListOfContract").append("<div class='card accordion-item mb-1'><h2 class='accordion-header' id='heading'><button type='button' class='accordion-button collapsed' data-bs-toggle='collapse' data-bs-target='#accordionContract"+data[index].applicant_application_id+"' aria-expanded='false' aria-controls='accordionContract"+data[index].applicant_application_id+"'>Application Code: "+data[index].applicant_application_code+" | Contract Code: "+data[index].contract_code+"</button></h2>  <div id='accordionContract"+data[index].applicant_application_id+"' class='accordion-collapse collapse' aria-labelledby='heading' data-bs-parent='#accordionExample'><div class='accordion-body'><div class='row'><div class='col-lg-5'><b>Application Code</b>: "+data[index].applicant_application_code+"<br><b>Contract Code</b>: "+data[index].contract_code+"</div><div class='col-lg-3'><b>Starting Date</b>: "+data[index].application_contract_start_date_description+"<br><b>End Date</b>: "+data[index].application_contract_end_date_description+"</div><div class='col-lg-4'><b>Status</b>: "+data[index].application_contract_status_color+"<br>"+link+"</div><div class='row'><div class='col-lg-12'><br><h6 class='float-left'>Application Process</h6><button type='button' id='btnAddNewShiftSchedule' class='btn btn-outline-success float-right btn-sm' data-bs-toggle='modal' data-bs-target='#modalContractDetails' onclick='ApplicationDetails("+data[index].applicant_application_id+")'>View Contract Details</button>  <table class='table tblApplicationHistory_"+data[index].applicant_application_id+"'></table></div></div> </div></div></div></div>");
          ApplicationHistory(data[index].applicant_application_id);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}//end of function

function ApplicationDetails(applicant_application_id) {
  $.ajax({url:'tbl_applicant_application/json_applicant_application.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_application_id == applicant_application_id){      
          let applicant_id = data[index].applicant_id;
          let contract_id = data[index].contract_id;    
          ApplicationHistory(applicant_application_id)
          Get_Contract_Details(contract_id);
          Read_Payroll_Period_Details(contract_id);
          Read_Leave_Credit_Details(contract_id);
          Read_Branch_Per_Contract_Details(contract_id);

          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}


function ApplicationHistory(applicant_application_id) {
  $(".tblApplicationHistory_"+applicant_application_id).text("");
  $.ajax({url:'tbl_application_history/json_application_history.php',
    method:'GET',
    success:function(data){
      $(".tblApplicationHistory_"+applicant_application_id).append("<tr><th>Process Category</th><th>Meeting Details</th><th>Date & Time Created</th><th>Status</th></tr>");
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_application_id == applicant_application_id){
          $(".tblApplicationHistory_"+applicant_application_id).append("<tr><td>"+data[index].history_category+"</td><td>"+data[index].history_details+"</td><td>"+data[index].application_history_created_at_by+"</td><td>"+data[index].application_history_status_description+"</td></tr>");

        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax
}

function Get_Contract_Details(contract_id) {
  $(".divContractDetails").text("");
  $.ajax({url:'tbl_contract/json_contract.php',
    method:'GET',
    success:function(data){
      $(".divContractDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_id == contract_id){
          
          $(".divContractDetails").append("<div class='row'><div class='col-lg-12'><h6>"+data[index].contract_title+"</h6><span style='text-transform:uppercase;font-size:13px;'>"+data[index].contract_description+"</span></div></div>");

          $(".divContractDetails").append("<div class='row'><div class='col-lg-5'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Application Period:</b> "+data[index].contract_application_date_from_description+" TO "+data[index].contract_application_date_to_description+"<br><b>Starting Date:</b> "+data[index].contract_starting_date_description+"</span></div><div class='col-lg-3'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Job Position:</b> "+data[index].job_position_title+"<br><b>Rate (Monthly):</b> "+data[index].contract_rate_peso+"</span></div><div class='col-lg-4'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Shifting Schedule:</b> "+data[index].shifting_schedule+"<br><b>Shift Break:</b> "+data[index].break_schedule+"</span></div></div>");             
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function Read_Payroll_Period_Details(contract_id){
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $(".divPayrollPeriod").text("");
  $.ajax({url:'tbl_contract_payroll_period/read_contract_payroll_period_with_deduction_benefits.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divPayrollPeriod").text("");
      $(".divPayrollPeriod").append(data);
      
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax   
}

function Read_Leave_Credit_Details(contract_id) {
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $(".divLeaveCredit").text("");
  $.ajax({url:'tbl_contract_leave_category/read_contract_leave_category_per_contract.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divLeaveCredit").text("");
      $(".divLeaveCredit").append(data);
      
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function Read_Branch_Per_Contract_Details(contract_id) {
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $(".divBranchPerContract").text("");
  $.ajax({url:'tbl_contract_branch/read_contract_branch_per_contract.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divBranchPerContract").text("");
      $(".divBranchPerContract").append(data);
      
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

ApplicantDetails();
function ApplicantDetails(){
  let person_id = "<?php echo $_GET['applicant_id']; ?>";
  let user_type_id = 0;
  let obj={"user_type_id":user_type_id};
  let parameter = JSON.stringify(obj); 

  $(".divApplicantDetails").text("");
  $.ajax({url:'tbl_person/json_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divApplicantDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].person_id == person_id){        
          $(".applicantName").text(data[index].full_name);

          $(".divApplicantDetails").append("<div class='row'><div class='col-lg-12'><h6>"+data[index].full_name + "</h6></div></div>");
          $(".divApplicantDetails").append("<div class='row'><div class='col-lg-12'>"+data[index].address+ "</div></div>");
          
          $(".divApplicantDetails").append("<div class='row'><div class='col-lg-12'><br></div></div>");

          $(".divApplicantDetails").append("<div class='row'><div class='col-lg-6'><div class='row'><div class='col-lg-4'>Date of Birth</div><div class='col-lg-8'>: "+data[index].date_of_birth_description+"</div><div class='col-lg-4'>Sex</div><div class='col-lg-8'>: "+data[index].sex+"</div><div class='col-lg-4'>Civil Status</div><div class='col-lg-8'>: "+data[index].civil_status+"</div></div><div class='row'><div class='col-lg-4'>Religion</div><div class='col-lg-8'>: "+data[index].religion+"</div><div class='col-lg-4'>Nationality</div><div class='col-lg-8'>: "+data[index].nationality+"</div></div><div class='row'><div class='col-lg-4'>Height</div><div class='col-lg-8'>: "+data[index].height_with_unit+"</div><div class='col-lg-4'>Weight</div><div class='col-lg-8'>: "+data[index].weight_with_unit+"</div></div> <div class='row'><div class='col-lg-12'><br><h6>Contact Details</h6></div></div>  <div class='row'><div class='col-lg-4'>Email Address</div><div class='col-lg-8'>: "+data[index].email_address+"</div><div class='col-lg-4'>Contact Number</div><div class='col-lg-8'>: "+data[index].contact_number_full+"</div><div class='col-lg-4'>Telephone Number</div><div class='col-lg-8'>: "+data[index].telephone_number+"</div></div>   </div>   <div class='col-lg-6'><div class='row'><div class='col-lg-12'><h6>Family Information</h6></div></div> <div class='row'><div class='col-lg-5'>Spouse Name</div><div class='col-lg-7'>: "+data[index].spouse_name+"</div><div class='col-lg-5'>Spouse Occupation</div><div class='col-lg-7'>: "+data[index].spouse_occupation+"</div></div> <div class='row'><div class='col-lg-5'>Father Name</div><div class='col-lg-7'>: "+data[index].father_name+"</div><div class='col-lg-5'>Father Occupation</div><div class='col-lg-7'>: "+data[index].father_occupation+"</div></div> <div class='row'><div class='col-lg-5'>Mother Name</div><div class='col-lg-7'>: "+data[index].mother_name+"</div><div class='col-lg-5'>Mother Occupation</div><div class='col-lg-7'>: "+data[index].mother_occupation+"</div></div> <div class='row'><div class='col-lg-12'><br><h6>Emergency Contact Details</h6></div></div> <div class='row'><div class='col-lg-5'>FullName</div><div class='col-lg-7'>: "+data[index].person_emergency_contact+"</div><div class='col-lg-5'>Relationship</div><div class='col-lg-7'>: "+data[index].relations_to_person_emergency_contact+"</div><div class='col-lg-5'>Contact Number</div><div class='col-lg-7'>: "+data[index].person_emergency_contact_number_full+"</div></div>    </div>   </div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}  

ApplicantWorkingHistory();
function ApplicantWorkingHistory(){
  let work_history_applicant_id = "<?php echo $_GET['applicant_id']; ?>";
  $.ajax({url:'tbl_working_history/json_working_history.php',
    method:'GET',
    success:function(data){
      $(".tblApplicantWorkingHistory").text("");
      $(".tblApplicantWorkingHistory").append("<tr><th>No.</th><th>Work Details</th><th>Date</th><th>Company</th></tr>");
      for(let index = 0; index < data.length; index++){
        if(data[index].work_history_applicant_id == work_history_applicant_id){
          $(".tblApplicantWorkingHistory").append("<tr><td>"+data[index].number+"</td><td>"+data[index].work_history_job_title+"<br>"+data[index].work_history_job_responsibilities+"</td><td>"+data[index].work_history_date_from_description+" TO "+data[index].work_history_date_to_description+"</td><td>"+data[index].work_history_company+"</td></tr>");
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}//end of function

function btnAddNewData() {
  $.ajax({url:"tbl_branch_person/json_branch_person_assigned.php",
    method:'GET',
    success:function(data){
      $("#select_branch").text("");
      let counter=0;
      for(let index = 0; index < data.length; index++){
          counter++;
          $("#select_branch").append("<option value='"+data[index].branch_id+"'>"+data[index].branch_name+"</option>");
      }
      if(counter == 0){
        $("#select_branch").append("<option value=''>No available branch</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax
  
  // $.ajax({url:"tbl_branch/json_branch.php",
  //   method:'GET',
  //   success:function(data){
  //     $("#select_branch").text("");
  //     let counter=0;
  //     for(let index = 0; index < data.length; index++){
  //       if(data[index].branch_status == "Activated"){
  //         counter++;
  //         $("#select_branch").append("<option value='"+data[index].branch_id+"'>"+data[index].branch_name+"</option>");
  //       }
  //     }
  //     if(counter == 0){
  //       $("#select_branch").append("<option value=''>No available branch</option>");
  //     }
  //   },
  //   error:function(){
  //     ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
  //   }
  // });//end of ajax 

  $.ajax({url:"tbl_shifting_schedule/json_shifting_schedule.php",
    method:'GET',
    success:function(data){
      $("#select_shifting_schedule").text("");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].shifting_schedule_status == "Activated"){
          counter++;
          $("#select_shifting_schedule").append("<option value='"+data[index].shifting_schedule_id+"'>"+data[index].shifting_schedule_details2+"</option>");
        }
      }
      if(counter == 0){
        $("#select_shifting_schedule").append("<option value=''>No available shifting  schedule</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
}

function ViewBranchDetails(){
  let branch_id = $("#select_branch").val();
  $(".divBranchDetails").text("");
  $.ajax({url:'tbl_branch/json_branch.php',
    method:'GET',
    success:function(data){
      $(".divBranchDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].branch_id == branch_id){
          $(".divBranchDetails").append("<div class='row'><div class='col-lg-5'>Branch Name</div><div class='col-lg-7'>: "+data[index].branch_name+"</div><div class='col-lg-5'>Branch Description</div><div class='col-lg-7'>: "+data[index].branch_description+"</div>");

          $(".divBranchDetails").append("<div class='row'><div class='col-lg-5'>Branch Address</div><div class='col-lg-7'>: "+data[index].address+"</div><div class='col-lg-5'>Contact Number</div><div class='col-lg-7'>: "+data[index].branch_contact_number_full+"</div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function ViewShiftScheduleDetails(){
  let shifting_schedule_id = $("#select_shifting_schedule").val();
  $(".divShiftScheduleDetails").text("");
  $.ajax({url:'tbl_shifting_schedule/json_shifting_schedule.php',
    method:'GET',
    success:function(data){
      $(".divShiftScheduleDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].shifting_schedule_id == shifting_schedule_id){
          $(".divShiftScheduleDetails").append("<div class='row'><div class='col-lg-5'>Shift Schedule</div><div class='col-lg-7'>: "+data[index].shifting_schedule_time_from+" TO "+data[index].shifting_schedule_time_to+"</div>");
          $(".divShiftScheduleDetails").append("<div class='row'><div class='col-lg-5'>Shift Break Schedule</div><div class='col-lg-7'>: "+data[index].shifting_schedule_break_time_from+" TO "+data[index].shifting_schedule_break_time_to+"</div>");

          $(".divShiftScheduleDetails").append("<div class='row'><div class='col-lg-12'><br>Days of Week</div></div>");
          $(".divShiftScheduleDetails").append("<div class='row'><div class='col-lg-12'>"+data[index].shifting_schedule_days_of_week+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function Validate_Data(){
  let all_Fields = document.getElementsByClassName("fieldsAssign");
  let validations = document.getElementsByClassName("validation-area-assign");

  var counter = 0;
  for(var index=0; index<all_Fields.length; index++){    
    if(all_Fields[index].value == ""){
      validations[index].innerHTML = "* Field is required";
      counter++;
    }else{
      validations[index].innerHTML = "*";
    }    
  }
  if(counter == 0){
    // CheckShiftingSchedule();
    SaveShiftingSchedule();
  }else{
    ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
  }
}

function CheckShiftingSchedule() {
  let person_id = "<?php echo $_GET['applicant_id']; ?>";
  let effective_date = $("#txt_effective_date_add").val();
  let end_effective_date = $("#txt_end_effective_date_add").val();
  $.ajax({url:'tbl_person_shifting_schedule/json_person_shifting_schedule.php',
    method:'GET',
      success:function(data){
        let counter=0;
        for(let index = 0; index < data.length; index++){
          if(data[index].person_id == person_id && 
            data[index].effective_date <= effective_date &&
            data[index].end_effective_date >= end_effective_date){
            counter++;
          }
        }
        if(counter == 0){
          ShowToast("bg-success", "Success", "Saved");
        }else{
          ShowToast("bg-warning", "Warning", "Existing");
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
      }
    });
}

function SaveShiftingSchedule() {
  let person_id = "<?php echo $_GET['applicant_id']; ?>";
  let shifting_schedule_id = $("#select_shifting_schedule").val();
  let contract_branch_id = $("#select_branch").val();
  let effective_date = $("#txt_effective_date_add").val();
  let end_effective_date = $("#txt_end_effective_date_add").val();

  let obj={"person_id":person_id, 
    "shifting_schedule_id":shifting_schedule_id, 
    "contract_branch_id":contract_branch_id, 
    "effective_date":effective_date, 
    "end_effective_date":end_effective_date};
  let parameter = JSON.stringify(obj); 

  $.ajax({url:'tbl_person_shifting_schedule/create_person_shifting_schedule.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Shifting Schedule successfully saved.");
        $(".btnModalClose").click();
        $("#list_of_data_shift_schedule").DataTable().ajax.reload();
      }
      else{
        ShowToast("bg-warning", "Warning", "Registration was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Registration went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}

function DisplayPortfolioSummary() {
  // body...
}
</script>
<div class="modal fade" id="modalAddNewSchedule" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Add New Schedule</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Select Branch: <span class="validation-area-assign">*</span></label>
            <select class="form-control fieldsAssign" id="select_branch" onclick="ViewBranchDetails()" onchange="ViewBranchDetails()"></select>
          </div>
        </div>

        <div class="row" style="text-transform: uppercase;font-size: 14px;">
          <div class="col-lg-12"><br>
            <div class="divBranchDetails"></div><br>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Select Shifting Schedule: <span class="validation-area-assign">*</span></label>
            <select class="form-control fieldsAssign" id="select_shifting_schedule" onclick="ViewShiftScheduleDetails()" onchange="ViewShiftScheduleDetails()"></select>
          </div>
        </div>

        <div class="row" style="text-transform: uppercase;font-size: 14px;">
          <div class="col-lg-12"><br>
            <div class="divShiftScheduleDetails"></div><br>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Effective Date: <span class="validation-area-assign">*</span></label>
            <input type="date" class="form-control fieldsAssign" id="txt_effective_date_add">
          </div>
          <div class="col-lg-12">
            <label class="form-label">End of Effective Date: <span class="validation-area-assign">*</span></label>
            <input type="date" class="form-control fieldsAssign" id="txt_end_effective_date_add">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type='button' class='btn btn-success' onclick='Validate_Data()'>Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalChangeStatus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Change Status</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <span class="past_tense_status" style="display: none;"></span>
            <span class="present_tense_status" style="display: none;"></span>
            <p class="message" style="font-size: 18px;"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnChangeStatus" class="btn btn-success" onclick="SaveChangeStatus()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalApplicationProcessManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Update Schedule</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Effective Date: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_effective_date">
          </div>
          <div class="col-lg-12">
            <label class="form-label">End of Effective Date: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_end_effective_date">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type='button' id='btnUpdateDetails' class='btn btn-success' onclick='UpdateSchedule()'>Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalContractDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-scollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Contract Details</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="divContractDetails"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12"><br>
            <div class="divPayrollPeriod"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="divLeaveCredit"></div>
            <div class="divBranchPerContract"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php include("includes/main-footer.php"); ?>