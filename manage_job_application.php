<?php include("includes/header.php"); ?>
<?php 
$position = "";
if(isset($_GET['id'])){
    if($_GET['id'] == ""){
        header('Location:read_job_application.php');
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
          $(".page_name").text("Manage Job Application");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl container-p-y">
          <span class="applicant_id" style="display: none;"></span>
          <span class="contract_id" style="display: none;"></span>
          <div class="row" style="text-transform: uppercase;font-size: 14px;">
            <div class="col-lg-12">
               <div class="card mb-1">
                <div class="card-body"> 
                <div class="row">
                  <div class="col-lg-8">
                    <div class="row">
                      <div class="col-lg-3"><b>Application Code</b></div>
                      <div class="col-lg-9">: <span class="applictionCode"></span></div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3"><b>Contract Code</b></div>
                      <div class="col-lg-9">: <span class="contractCode"></span></div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3"><b>Applicant Name</b></div>
                      <div class="col-lg-9">: <span class="applicantName"></span></div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <label class="contractMessage"></label>
                        <div class="divChangeContractStatus"></div>
                      </div>
                    </div>
                  </div>
                </div>               

                </div>
              </div>

              <div class="accordion" id="accordion">
                <div class="card accordion-item mb-1">
                  <h2 class="accordion-header" id="heading">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionApplicantInformation" aria-expanded="false" aria-controls="accordionApplicantInformation">
                      Applicant Information
                    </button>
                  </h2>
                  <div id="accordionApplicantInformation" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">  
                    <div class="accordion-body">
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

                <div class="card accordion-item mb-1">
                  <h2 class="accordion-header" id="heading">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionApplicationContract" aria-expanded="false" aria-controls="accordionApplicationContract">
                      Job Details & Contract
                    </button>
                  </h2>
                  <div id="accordionApplicationContract" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">  
                    <div class="accordion-body">     
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="divContractDetails"></div>
                          <span class="shifting_schedule_id" style="display: none;"></span>
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
                  </div>
                </div>

                <div class="card accordion-item active">
                  <h2 class="accordion-header" id="heading">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionApplicantProcess" aria-expanded="true"aria-controls="accordionApplicantProcess">
                      Application Process
                    </button>
                  </h2>
                  <div id="accordionApplicantProcess" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <button type="button" id="btnAddNewProcess" class="btn btn-success" data-bs-toggle='modal' data-bs-target='#modalApplicationProcessManagement' onclick="btnAddNewData()" disabled="true">Add New Process</button>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12"><br>
                          <!-- <div class="table-responsive text-nowrap"> -->
                           <table class="table" id="list_of_data">
                              <thead>
                                <tr>
                                  <th style="width: 5%">No.</th>
                                  <th style="width: 20%">Process Category</th> 
                                  <th style="width: 40%">Process Details</th> 
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

              </div><!-- end of accordion -->

            </div>            
          </div>              
        </div>
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
  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  let obj={"applicant_application_id":applicant_application_id};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_application_history/json_application_history_datatable.php?data="+parameter,
    // dom: 'Bfrtip',
    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    "aoColumns": [
      { mData: 'number'},
      { mData: 'history_category'},
      { mData: 'history_details'},
      { mData: 'application_history_created_at_by'},
      { mData: 'application_history_status_description'},
      { mData: 'application_history_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalApplicationProcessManagement' onclick='btnUpdateDetails("+row.application_history_id+")'><i class='bx bx-edit'></i> Update Process</a>";
        let history_category = row.history_category;
        let application_history_status = row.application_history_status;

        let button_change_status = "";
        if(history_category != "For Contract Signing" && application_history_status == "Scheduled"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.application_history_id+", \"Passed\", \"Pass\")'><i class='bx bx-refresh'></i> Pass "+history_category+"</a>";
          button_change_status += "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.application_history_id+", \"Failed\", \"Fail\")'><i class='bx bx-refresh'></i> Fail "+history_category+"</a>";
          button_change_status += "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.application_history_id+", \"Re-scheduled\", \"Re-schedule\")'><i class='bx bx-refresh'></i> Re-schedule "+history_category+"</a>";

        }else if(history_category == "For Contract Signing" && application_history_status == "Scheduled"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.application_history_id+", \"Done\", \"Done\")'><i class='bx bx-refresh'></i> Done "+history_category+"</a>";
          button_change_status += "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.application_history_id+", \"Cancelled\", \"Cancel\")'><i class='bx bx-refresh'></i> Cancel "+history_category+"</a>";
          button_change_status += "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.application_history_id+", \"Re-scheduled\", \"Re-schedule\")'><i class='bx bx-refresh'></i> Re-schedule "+history_category+"</a>";
        }

        let action_button = "";
        if(history_category != "Application Submitted" && application_history_status == "Scheduled"){
          action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_update_details+" "+button_change_status+"</div>";
        }
        return action_button;        
      }
    }]
  });
}//end of function

CheckApplicationHistoryStatus();
function CheckApplicationHistoryStatus(){
  $(".divChangeContractStatus").text("");
  $(".contractMessage").text("");

  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  $.ajax({url:'tbl_application_history/json_application_history.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_application_id == applicant_application_id &&
          data[index].history_category == "For Contract Signing" &&
          data[index].application_history_status != "Re-scheduled"){
          $("#btnAddNewProcess").attr("disabled", true);
          $("#btnAddNewProcess").attr("onclick", "");
        }

        if(data[index].applicant_application_id == applicant_application_id &&
          data[index].history_category == "For Contract Signing" &&
          data[index].application_history_status == "Done" &&
          data[index].application_contract_status == "Pending"){
          $(".contractMessage").text("Contract needs to be activated after the contract signing");
          $(".divChangeContractStatus").text("");
          $(".divChangeContractStatus").append("<button type='button' class='btn btn-outline-success btn-sm' data-bs-toggle='modal' data-bs-target='#modalActivateContract'>Activate Contract</button>");
        }else if(data[index].applicant_application_id == applicant_application_id &&
          data[index].history_category == "For Contract Signing" &&
          data[index].application_history_status == "Done" &&
          data[index].application_contract_status == "Activated"){
          $(".contractMessage").text("Deactivate contract for contract termination or end of contract.");
          $(".divChangeContractStatus").text("");
          $(".divChangeContractStatus").append("<button type='button' class='btn btn-outline-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modalDeactivateContract'>Deactivate Contract</button>");
        }else if(data[index].applicant_application_id == applicant_application_id &&
          data[index].history_category == "For Contract Signing" &&
          data[index].application_history_status == "Done" &&
          data[index].application_contract_status == "Deactivated"){
          $(".contractMessage").text("Contract has been Deactivated");
          $(".divChangeContractStatus").text("");
        }else{
          $(".contractMessage").text("Contract needs to be activated after the contract signing");
          $(".divChangeContractStatus").text("");
          $(".divChangeContractStatus").append("<button type='button' class='btn btn-outline-success btn-sm' disabled>Activate Contract</button>");
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}//end of function

function ApplicantWorkingHistory(work_history_applicant_id){
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
  Empty();
  $("#select_history_category").attr("disabled", false);
  $(".application_process_management_header").text("Add New Process");
  
  $("#divButtonApplicationProcessManagement").text("");
  $("#divButtonApplicationProcessManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");

  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  $.ajax({url:'tbl_application_history/json_application_history.php',
    method:'GET',
    success:function(data){
      let process_added = [];
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_application_id == applicant_application_id){
          if(data[index].application_history_status == "Passed" || data[index].application_history_status == "Scheduled" || data[index].application_history_status == "Cancelled"){
            process_added.push(data[index].history_category);
          }
        }
      }

      $("#select_history_category").text("");
      let counter=0;
      let process_array = ["Initial Interview", "Technical Exam", "Technical Interview", "For Medical", "For Requirements", "For Contract Signing"];
      for(let index=0; index < process_array.length; index++){
        let flag = false;
        for(let added=0; added < process_added.length; added++){
          if(process_array[index] == process_added[added]){
            flag = true;
            break;
          }
        }
        if(!flag){
          counter++;
          $("#select_history_category").append("<option value='"+process_array[index]+"'>"+process_array[index]+"</option>");
        }
      }//end of for loop

      if(counter==0){
        $("#select_history_category").append("<option value=''>No available process</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function Validate_Data(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  var counter = 0;
    for(var index=0; index<all_Fields.length; index++){    
      if(index != 2 && index != 5){
        if(all_Fields[index].value == ""){
          validations[index].innerHTML = "* Field is required";
          counter++;
        }else{
          validations[index].innerHTML = "*";
        } 
      }   
    }
    if(counter == 0){
      SaveApplicationProcess();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

CheckApplicationStatus();
function CheckApplicationStatus() {
  $("#btnAddNewProcess").attr("disabled", true);
  $("#btnAddNewProcess").attr("onclick", "");
  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  $.ajax({url:'tbl_applicant_application/json_applicant_application.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_application_id == applicant_application_id){
          $(".applictionCode").text(data[index].applicant_application_code);

          let applicant_id = data[index].applicant_id;
          let contract_id = data[index].contract_id;
          $(".applicant_id").text(applicant_id);
          $(".contract_id").text(contract_id);

          ApplicantDetails(applicant_id);
          ApplicantWorkingHistory(applicant_id);
          Get_Contract_Details(contract_id);
          Read_Payroll_Period_Details(contract_id);
          Read_Leave_Credit_Details(contract_id);
          Read_Branch_Per_Contract_Details(contract_id);

          if(data[index].application_status != "Pending" && 
            data[index].application_status != "Denied" && 
            data[index].application_status != "Re-scheduled"){
            $("#btnAddNewProcess").attr("disabled", false);
            $("#btnAddNewProcess").attr("onclick", "btnAddNewData()");
          }
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function SaveApplicationProcess() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  let history_category = $("#select_history_category").val();
  let history_title = $("#txt_history_title").val();
  let history_description = $("#txt_history_description").val();
  let history_date = $("#txt_history_date").val();
  let history_time = $("#txt_history_time").val();
  let history_remarks = $("#txt_history_remarks").val();

  let obj={"applicant_application_id":applicant_application_id,
    "history_category":history_category, 
    "history_title":history_title, 
    "history_description":history_description, 
    "history_date":history_date, 
    "history_time":history_time, 
    "history_remarks":history_remarks};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_application_history/create_application_history.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Process successfully saved.");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
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

function Empty() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");
  
  for(let index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    if(index != 2 && index != 5)
      validations[index].innerHTML = "*";
  }
}


function btnUpdateDetails(application_history_id) {
  Empty();

  $("#select_history_category").text("");
  let process_array = ["Initial Interview", "Technical Exam", "Technical Interview", "For Medical", "For Requirements", "For Contract Signing"];
  for(let index=0; index < process_array.length; index++){
    $("#select_history_category").append("<option value='"+process_array[index]+"'>"+process_array[index]+"</option>");
  }//end of for loop

  $(".application_process_management_header").text("Update Process");

  $("#divButtonApplicationProcessManagement").text("");
  $("#divButtonApplicationProcessManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateApplicationProcess()' value='"+application_history_id+"'>Submit</button>");

  $.ajax({url:'tbl_application_history/json_application_history.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].application_history_id == application_history_id){        
          $("#select_history_category").attr("disabled", true);
          $("#select_history_category").val(data[index].history_category);
          $("#txt_history_title").val(data[index].history_title);
          $("#txt_history_description").val(data[index].history_description);
          $("#txt_history_date").val(data[index].history_date);
          $("#txt_history_time").val(data[index].history_time);
          $("#txt_history_title").val(data[index].history_title);
          $("#txt_history_remarks").val(data[index].history_remarks);
          break;         
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateApplicationProcess() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  let application_history_id = $("#btnUpdateData").val();
  let history_category = $("#select_history_category").val();
  let history_title = $("#txt_history_title").val();
  let history_description = $("#txt_history_description").val();
  let history_date = $("#txt_history_date").val();
  let history_time = $("#txt_history_time").val();
  let history_remarks = $("#txt_history_remarks").val();

  let counter = 0;
    for(let index=0; index<all_Fields.length; index++){
      if(index != 2 && index != 5){
        if(all_Fields[index].value == ""){
          validations[index].innerHTML = "* Field is required";
          counter++;
        }else{
          // validations[index].innerHTML = "*";
        }
      }
    }
    if(counter == 0){
      
      let obj={"applicant_application_id":applicant_application_id,
        "application_history_id":application_history_id,
        "history_category":history_category, 
        "history_title":history_title, 
        "history_description":history_description, 
        "history_date":history_date, 
        "history_time":history_time, 
        "history_remarks":history_remarks};

      let parameter = JSON.stringify(obj); 
      
      Empty();
      $.ajax({url:'tbl_application_history/update_application_history.php?data='+parameter,
        method:'GET',
        success:function(data){
          if(data == true){
            ShowToast("bg-success", "Success", "Process successfully updated.");
            $(".btnModalClose").click();
            $("#list_of_data").DataTable().ajax.reload();
          }
          else{
            ShowToast("bg-warning", "Warning", "Updating process was failed, Please try again.");
            console.log(data);
          }
        },
        error:function(){
          ShowToast("bg-danger", "Danger", "Updating process went something wrong, Please contact the System Administrator.");
        }
      });//end of ajax  
      
     }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}


// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(application_history_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this process?");
  $("#btnChangeStatus").val(application_history_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let application_history_id = $("#btnChangeStatus").val();

  let obj={"application_history_id":application_history_id,
    "past_tense_status":past_tense_status,
    "present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_application_history/update_application_history_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Process status successfully changed to: "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
        CheckApplicationHistoryStatus();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of process status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of process status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //



function ApplicantDetails(applicant_id){
  let person_id = applicant_id;
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

function Get_Contract_Details(contract_id) {
  $(".divContractDetails").text("");
  $.ajax({url:'tbl_contract/json_contract.php',
    method:'GET',
    success:function(data){
      $(".divContractDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_id == contract_id){
          $(".contractCode").text(data[index].contract_code);

          $(".divContractDetails").append("<div class='row'><div class='col-lg-12'><h6>"+data[index].contract_title+"</h6><span style='text-transform:uppercase;font-size:13px;'>"+data[index].contract_description+"</span></div></div>");

          $(".shifting_schedule_id").text(data[index].contract_shifting_schedule_id);
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

function ActivateContract() {
  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  let application_contract_start_date = $("#txt_application_contract_start_date").val();

  if(application_contract_start_date == ""){
    $("#error_txt_application_contract_start_date").text("* Field is required");
    ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
  }else{
    $("#error_txt_application_contract_start_date").text("*");
    let obj={"applicant_application_id":applicant_application_id, 
      "application_contract_start_date":application_contract_start_date, 
      "past_tense_status":"Activated"};
    let parameter = JSON.stringify(obj); 

    $.ajax({url:'tbl_applicant_application/update_applicant_application_contract_status.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Contract status successfully updated.");
          $(".btnModalClose").click();
          CheckApplicationHistoryStatus();
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
}

function DeactivateContract() {
  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  let application_contract_end_date = $("#txt_application_contract_end_date").val();

  if(application_contract_end_date == ""){
    $("#error_txt_application_contract_end_date").text("* Field is required");
    ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
  }else{
    $("#error_txt_application_contract_end_date").text("*");

    let obj={"applicant_application_id":applicant_application_id, 
      "application_contract_start_date":application_contract_end_date, 
      "past_tense_status":"Deactivated"};
    let parameter = JSON.stringify(obj); 

    $.ajax({url:'tbl_applicant_application/update_applicant_application_contract_status.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Contract status successfully updated.");
          $(".btnModalClose").click();
          CheckApplicationHistoryStatus();
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
}

</script>

<div class="modal fade" id="modalApplicationProcessManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title application_process_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label class="form-label">Select Process: <span class="validation-area">*</span></label>
            <select class="form-control fields" id="select_history_category"></select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12"><br>
            <h6>Process Details</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Title: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_history_title">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Description: (Optional)<span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_history_description">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Date: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_history_date">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Time: <span class="validation-area">*</span></label>
            <input type="time" class="form-control fields" id="txt_history_time">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Remarks: (Optional)<span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_history_remarks">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonApplicationProcessManagement"></div>
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

<div class="modal fade" id="modalActivateContract" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Activate Contract</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <h6>Are you sure you want to activate this contract?</h6>
          </div>
          <div class="col-lg-12">
            <label class="form-label">Start Date: <span class="validation-area-contract" id="error_txt_application_contract_start_date">*</span></label>
            <input type="date" class="form-control fieldsContract" id="txt_application_contract_start_date">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type='button' id='btnActivateContract' class='btn btn-success' onclick='ActivateContract()'>Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDeactivateContract" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Deactivate Contract</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <h6>Are you sure you want to deactivate this contract?</h6>
          </div>
          <div class="col-lg-12">
            <label class="form-label">End Date: <span class="validation-area-contract" id="error_txt_application_contract_end_date">*</span></label>
            <input type="date" class="form-control fieldsContract" id="txt_application_contract_end_date">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type='button' id='btnDeactivateContract' class='btn btn-success' onclick='DeactivateContract()'>Submit</button>
      </div>
    </div>
  </div>
</div>
<?php include("includes/main-footer.php"); ?>