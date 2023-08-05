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
          $(".page_name").text("Working History Management");          
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
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalWorkHistoryManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th style="width: 5%">No.</th>
                              <th style="width: 20%">Work Name</th> 
                              <th style="width: 30%">Work Details</th> 
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
  let work_history_applicant_id = "<?php echo $_SESSION['person_id']; ?>";
  let obj={"work_history_applicant_id":work_history_applicant_id};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_working_history/json_working_history_datatable_per_applicant.php?data="+parameter,
    // dom: 'Bfrtip',
    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    "aoColumns": [
      { mData: 'number'},
      { mData: 'work_name_details'},
      { mData: 'work_history_details'},
      { mData: 'work_history_status_description'},
      { mData: 'work_history_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.work_history_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalWorkHistoryManagement' onclick='btnUpdateDetails("+row.work_history_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.work_history_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.work_history_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Work History</a>";
        }else if(row.work_history_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.work_history_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Work History</a>";
        }

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  $(".work_history_management_header").text("Add New Data");
  
  $("#divButtonWorkHistoryManagement").text("");
  $("#divButtonWorkHistoryManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
}

function Empty(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");
  
  for(let index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    if(index!=1){
      validations[index].innerHTML = "*";
    }
  }
}

function Validate_Data(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let counter = 0;
    for(let index=0; index<all_Fields.length; index++){
      if(index!=1){
        if(all_Fields[index].value == ""){
          validations[index].innerHTML = "* Field is required";
          counter++;
        }else{
          // validations[index].innerHTML = "*";
        }
      }
    }
    if(counter == 0){
      SaveWorkHistory();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SaveWorkHistory() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let work_history_job_title = $("#txt_work_history_job_title").val();
  let work_history_job_responsibilities = $("#txt_work_history_job_responsibilities").val();
  let work_history_date_from = $("#txt_work_history_date_from").val();
  let work_history_date_to = $("#txt_work_history_date_to").val();
  let work_history_company = $("#txt_work_history_company").val();
  
  let work_history_applicant_id = "<?php echo $_SESSION['person_id']; ?>";
  let obj={"work_history_applicant_id":work_history_applicant_id,
  "work_history_job_title":work_history_job_title, 
  "work_history_job_responsibilities":work_history_job_responsibilities, 
  "work_history_date_from":work_history_date_from, 
  "work_history_date_to":work_history_date_to, 
  "work_history_company":work_history_company};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_working_history/create_working_history.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Working history successfully saved.");
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

function btnViewDetails(work_history_id) {
  ViewDetails(work_history_id);
}

function ViewDetails(work_history_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_working_history/json_working_history.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].work_history_id == work_history_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Job Title</div><div class='col-lg-7'>: "+data[index].work_history_job_title+"</div><div class='col-lg-5'>Job Reponsibilities</div><div class='col-lg-7'>: "+data[index].work_history_job_responsibilities+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Working Date</div><div class='col-lg-7'>: "+data[index].work_history_date_from_description+" TO "+data[index].work_history_date_to_description+"</div><div class='col-lg-5'>Job Reponsibilities</div><div class='col-lg-7'>: "+data[index].work_history_company+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].work_history_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].work_history_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].work_history_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(work_history_id) {
  Empty();
  $(".work_history_management_header").text("Update Details");

  $("#divButtonWorkHistoryManagement").text("");
  $("#divButtonWorkHistoryManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateWorkingHistory()' value='"+work_history_id+"'>Submit</button>");

  $.ajax({url:'tbl_working_history/json_working_history.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].work_history_id == work_history_id){        
          $("#txt_work_history_job_title").val(data[index].work_history_job_title);
          $("#txt_work_history_job_responsibilities").val(data[index].work_history_job_responsibilities);
          $("#txt_work_history_date_from").val(data[index].work_history_date_from);
          $("#txt_work_history_date_to").val(data[index].work_history_date_to);
          $("#txt_work_history_company").val(data[index].work_history_company);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateWorkingHistory() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let work_history_id = $("#btnUpdateData").val();
  let work_history_job_title = $("#txt_work_history_job_title").val();
  let work_history_job_responsibilities = $("#txt_work_history_job_responsibilities").val();
  let work_history_date_from = $("#txt_work_history_date_from").val();
  let work_history_date_to = $("#txt_work_history_date_to").val();
  let work_history_company = $("#txt_work_history_company").val();

  let counter = 0;
    for(let index=0; index<all_Fields.length; index++){
      if(index!=1){
        if(all_Fields[index].value == ""){
          validations[index].innerHTML = "* Field is required";
          counter++;
        }else{
          // validations[index].innerHTML = "*";
        }
      }
    }
    if(counter == 0){
      let obj={"work_history_id":work_history_id,
      "work_history_job_title":work_history_job_title, 
      "work_history_job_responsibilities":work_history_job_responsibilities, 
      "work_history_date_from":work_history_date_from, 
      "work_history_date_to":work_history_date_to, 
      "work_history_company":work_history_company};
      let parameter = JSON.stringify(obj); 
      
      Empty();
      $.ajax({url:'tbl_working_history/update_working_history.php?data='+parameter,
        method:'GET',
        success:function(data){
          if(data == true){
            ShowToast("bg-success", "Success", "Working history successfully updated.");
            $(".btnModalClose").click();
            $("#list_of_data").DataTable().ajax.reload();
          }
          else{
            ShowToast("bg-warning", "Warning", "Updating working history was failed, Please try again.");
            console.log(data);
          }
        },
        error:function(){
          ShowToast("bg-danger", "Danger", "Updating working history went something wrong, Please contact the System Administrator.");
        }
      });//end of ajax  
      
     }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(work_history_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this working history?");
  $("#btnChangeStatus").val(work_history_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let work_history_id = $("#btnChangeStatus").val();

  let obj={"work_history_id":work_history_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_working_history/update_working_history_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Working history successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of working history status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of working history status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

<div class="modal fade" id="modalWorkHistoryManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title work_history_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Job Title: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_work_history_job_title">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Job Reponsibilities: (Optional) <span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_work_history_job_responsibilities">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Date From: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_work_history_date_from">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Date To: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_work_history_date_to">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Company: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_work_history_company">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonWorkHistoryManagement"></div>
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