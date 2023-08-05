<?php include("includes/header.php"); ?>
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
          $(".page_name").text("Job Contract Management");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl container-p-y">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-3">
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalJobContractManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th style="width: 5%;">No.</th>
                              <th style="width: 30%;">Job Contract Details</th> 
                              <th style="width: 25%;"></th> 
                              <th style="width: 20%;">Date & Time Created</th> 
                              <th style="width: 10%;">Status</th>
                              <th style="width: 5%;">Action</th>
                            </tr>
                          </thead>
                        </table>
                      <!-- </div> -->
                    </div>
                  </div>
                </div>
              </div>
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
  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_contract/json_contract_datatable.php",
    "aoColumns": [
      { mData: 'number'},
      { mData: 'contract_details'},
      { mData: 'contract_details_2'},
      { mData: 'contract_created_at_by'},
      { mData: 'contract_status_description'},
      { mData: 'contract_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.contract_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalJobContractManagement' onclick='btnUpdateDetails("+row.contract_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.contract_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.contract_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Contract</a>";
        }else if(row.contract_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.contract_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Contract</a>";
        }

        let button_manage_contract = "<a class='dropdown-item' href='manage_contract.php?id="+row.contract_id+"'><i class='bx bx-list-ul'></i>Manage Contract <i class='bx bx-right-arrow-alt'></i></a>";
        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+" "+button_manage_contract+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  Get_Job_Position();
  $(".job_contract_management_header").text("Add New Data");
  
  $("#divButtonJobContractManagement").text("");
  $("#divButtonJobContractManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
}

function Validate_Data(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  var counter = 0;
    for(var index=0; index<all_Fields.length; index++){    
      if(index != 1){
        if(all_Fields[index].value == ""){
          validations[index].innerHTML = "* Field is required";
          counter++;
        }else{
          validations[index].innerHTML = "*";
        } 
      }   
    }
    if(counter == 0){
      SaveJobContract();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SaveJobContract() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let contract_title = $("#txt_contract_title").val();
  let contract_description = $("#txt_contract_description").val();
  let contract_application_date_from = $("#txt_contract_application_date_from").val();
  let contract_application_date_to = $("#txt_contract_application_date_to").val();
  let contract_starting_date = $("#txt_contract_starting_date").val();
  let contract_job_position_id = $("#select_job_position").val();
  let contract_rate = $("#txt_contract_rate").val();
  let contract_shifting_schedule_id = $("#select_contract_shifting_schedule_id").val();

  let obj={"contract_title":contract_title, 
  "contract_description":contract_description, 
  "contract_application_date_from":contract_application_date_from, 
  "contract_application_date_to":contract_application_date_to, 
  "contract_starting_date":contract_starting_date, 
  "contract_job_position_id":contract_job_position_id, 
  "contract_rate":contract_rate, 
  "contract_shifting_schedule_id":contract_shifting_schedule_id};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_contract/create_contract.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Job contract successfully saved.");
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
    if(index!=1)
      validations[index].innerHTML = "*";
  }
}

function btnViewDetails(contract_id) {
  ViewDetails(contract_id);
}

function ViewDetails(contract_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_contract/json_contract.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_id == contract_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Contract Title</div><div class='col-lg-7'>: "+data[index].contract_title+"</div><div class='col-lg-5'>Contract Description</div><div class='col-lg-7'>: "+data[index].contract_description+"</div></div>");
          
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Application Period</div><div class='col-lg-7'>: "+data[index].contract_application_date_from_description+" TO "+data[index].contract_application_date_to_description+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Job Position</div><div class='col-lg-7'>: "+data[index].job_position_title+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Starting Date</div><div class='col-lg-7'>: "+data[index].contract_starting_date_description+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Rate (Monthly)</div><div class='col-lg-7'>: "+data[index].contract_rate_peso+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Shift Scehdule</div><div class='col-lg-7'>: "+data[index].shifting_schedule+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].contract_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].contract_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].contract_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(contract_id) {
  Empty();
  Get_Job_Position();
  $(".job_contract_management_header").text("Update Details");

  $("#divButtonJobContractManagement").text("");
  $("#divButtonJobContractManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateJobContract()' value='"+contract_id+"'>Submit</button>");

  $.ajax({url:'tbl_contract/json_contract.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_id == contract_id){        
          $("#txt_contract_title").val(data[index].contract_title);
          $("#txt_contract_description").val(data[index].contract_description);
          $("#txt_contract_application_date_from").val(data[index].contract_application_date_from);
          $("#txt_contract_application_date_to").val(data[index].contract_application_date_to);
          $("#txt_contract_starting_date").val(data[index].contract_starting_date);
          $("#select_job_position").val(data[index].contract_job_position_id);
          $("#txt_contract_rate").val(data[index].contract_rate);
          $("#select_contract_shifting_schedule_id").val(data[index].contract_shifting_schedule_id);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateJobContract() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let contract_id = $("#btnUpdateData").val();
  let contract_title = $("#txt_contract_title").val();
  let contract_description = $("#txt_contract_description").val();
  let contract_application_date_from = $("#txt_contract_application_date_from").val();
  let contract_application_date_to = $("#txt_contract_application_date_to").val();
  let contract_starting_date = $("#txt_contract_starting_date").val();
  let contract_job_position_id = $("#select_job_position").val();
  let contract_rate = $("#txt_contract_rate").val();
  let contract_shifting_schedule_id = $("#select_contract_shifting_schedule_id").val();

  var counter = 0;
  for(var index=0; index<all_Fields.length; index++){    
    if(index != 1){
      if(all_Fields[index].value == ""){
        validations[index].innerHTML = "* Field is required";
        counter++;
      }else{
        validations[index].innerHTML = "*";
      }    
    }
  }
  if(counter != 0){
    ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
  }else{
    let obj={"contract_id":contract_id,"contract_title":contract_title, 
  "contract_description":contract_description, 
  "contract_application_date_from":contract_application_date_from, 
  "contract_application_date_to":contract_application_date_to, 
  "contract_starting_date":contract_starting_date, 
  "contract_job_position_id":contract_job_position_id, 
  "contract_rate":contract_rate, 
  "contract_shifting_schedule_id":contract_shifting_schedule_id};
    let parameter = JSON.stringify(obj); 
    
    Empty();
    $.ajax({url:'tbl_contract/update_contract.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Job contract successfully updated.");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }
      else{
        ShowToast("bg-warning", "Warning", "Updating job contract was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating job contract went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
  }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(contract_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this job contract?");
  $("#btnChangeStatus").val(contract_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let contract_id = $("#btnChangeStatus").val();

  let obj={"contract_id":contract_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_contract/update_contract_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Job contract successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of job contract status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of job contract status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //
function Get_Job_Position() {
  $.ajax({url:"tbl_job_position/json_job_position.php",
    method:'GET',
    success:function(data){
      $("#select_job_position").text("");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        // if(data[index].job_position_status == "Activated"){
          counter++;
          $("#select_job_position").append("<option value='"+data[index].job_position_id+"'>"+data[index].job_position_title+"</option>");
        // }
      }
      if(counter == 0){
        $("#select_job_position").append("<option value=''>No available job position</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
} 

Get_Shift_Schedule();
function Get_Shift_Schedule() {
  $.ajax({url:"tbl_shifting_schedule/json_shifting_schedule.php",
    method:'GET',
    success:function(data){
      $("#select_contract_shifting_schedule_id").text("");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].shifting_schedule_status == "Activated"){
          counter++;
          $("#select_contract_shifting_schedule_id").append("<option value='"+data[index].shifting_schedule_id+"'>Schedule: "+data[index].shifting_schedule_time_from+" TO "+data[index].shifting_schedule_time_to+" (Break: "+data[index].shifting_schedule_break_time_from+" TO "+data[index].shifting_schedule_break_time_from+")</option>");
        }
      }
      if(counter == 0){
        $("#select_contract_shifting_schedule_id").append("<option value=''>No available shifting schedule</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
}  

</script>

<div class="modal fade" id="modalJobContractManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title job_contract_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Contract Title: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_contract_title">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Contract Description: (Optional) <span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_contract_description">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Application Date From: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_contract_application_date_from">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Application Date To: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_contract_application_date_to">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12"><br></div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Select Job Position: <span class="validation-area">*</span></label>
            <select class="form-control fields" id="select_job_position"></select>
          </div>                    
          <div class="col-lg-6">
            <label class="form-label">Starting Date: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_contract_starting_date">
          </div>                    
        </div>

        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Contract Rate (Monthly): <span class="validation-area">*</span></label>
            <div class="input-group">
              <span class="input-group-text" >PHP</span>
              <input type="number" class="form-control fields" id="txt_contract_rate">
            </div>
          </div>
          <div class="col-lg-6">
            <label class="form-label">Shift Schedule: <span class="validation-area">*</span></label>
            <select class="form-control fields" id="select_contract_shifting_schedule_id"></select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonJobContractManagement"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalViewDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">View Details</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="divViewDetails" style="text-transform: uppercase; font-size: 14px;"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
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
<?php include("includes/main-footer.php"); ?>