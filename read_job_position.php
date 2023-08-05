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
          $(".page_name").text("Job Position Management");          
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
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalJobPositionManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Job Position Details</th> 
                              <th>Date & Time Created</th> 
                              <th>Status</th>
                              <th>Action</th>
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
    "sAjaxSource": "tbl_job_position/json_job_position_datatable.php",
    "aoColumns": [
      { mData: 'number'},
      { mData: 'job_position_details'},
      { mData: 'job_position_created_at_by'},
      { mData: 'job_position_status_description'},
      { mData: 'job_position_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.job_position_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalJobPositionManagement' onclick='btnUpdateDetails("+row.job_position_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.job_position_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.job_position_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Job Position</a>";
        }else if(row.job_position_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.job_position_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Job Position</a>";
        }

        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  $(".job_position_management_header").text("Add New Data");
  
  $("#divButtonJobPositionManagement").text("");
  $("#divButtonJobPositionManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='SaveJobPosition()'>Submit</button>");
}

function SaveJobPosition() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let job_position_title = $("#txt_job_position_title").val();
  let job_position_description = $("#txt_job_position_description").val();

  if(job_position_title == ""){
    validations[0].innerHTML = "* Field is required";
  }else{
    validations[0].innerHTML = "*";
    let obj={"job_position_title":job_position_title, "job_position_description":job_position_description};
    let parameter = JSON.stringify(obj); 

    Empty(); 
    $.ajax({url:'tbl_job_position/create_job_position.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Job Position successfully saved.");
        
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

function btnViewDetails(job_position_id) {
  ViewDetails(job_position_id);
}

function ViewDetails(job_position_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_job_position/json_job_position.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].job_position_id == job_position_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Job Position Title</div><div class='col-lg-7'>: "+data[index].job_position_title+"</div><div class='col-lg-5'>Job Position Description</div><div class='col-lg-7'>: "+data[index].job_position_description+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].job_position_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].job_position_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].job_position_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(job_position_id) {
  Empty();
  $(".job_position_management_header").text("Update Details");

  $("#divButtonJobPositionManagement").text("");
  $("#divButtonJobPositionManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateJobPosition()' value='"+job_position_id+"'>Submit</button>");

  $.ajax({url:'tbl_job_position/json_job_position.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].job_position_id == job_position_id){        
          $("#txt_job_position_title").val(data[index].job_position_title);
          $("#txt_job_position_description").val(data[index].job_position_description);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateJobPosition() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let job_position_id = $("#btnUpdateData").val();
  let job_position_title = $("#txt_job_position_title").val();
  let job_position_description = $("#txt_job_position_description").val();

  if(job_position_title == ""){
    validations[0].innerHTML = "* Field is required";
  }else{
    validations[0].innerHTML = "*";
    let obj={"job_position_id":job_position_id,"job_position_title":job_position_title, "job_position_description":job_position_description};
    let parameter = JSON.stringify(obj); 
    
    Empty();
    $.ajax({url:'tbl_job_position/update_job_position.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Job Position successfully updated.");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }
      else{
        ShowToast("bg-warning", "Warning", "Updating job position was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating job position went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
  }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(job_position_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this job position?");
  $("#btnChangeStatus").val(job_position_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let job_position_id = $("#btnChangeStatus").val();

  let obj={"job_position_id":job_position_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_job_position/update_job_position_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Job position successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of job position status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of job position status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

<div class="modal fade" id="modalJobPositionManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title job_position_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Job Position Title: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_job_position_title">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Job Position Description: (Optional) <span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_job_position_description">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonJobPositionManagement"></div>
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