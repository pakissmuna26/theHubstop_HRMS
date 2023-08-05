<?php include("includes/header.php"); ?>
<!--  
PAYROLL PERIOD TITLE: PAYROLL PERIOD 2 TITLE
PAYROLL PERIOD: 16 TO 31
CUT-OFF: 9 TO 22

PAYROLL PERIOD TITLE: PAYROLL PERIOD 1 TITLE
PAYROLL PERIOD: 1 TO 15
CUT-OFF: 23 TO 8

-->

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
          $(".page_name").text("Payroll Period Management");          
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
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalPayrolPeriodManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th  style="width: 5%;">No.</th>
                              <th style="width: 25%;">Payroll Period Details</th> 
                              <th style="width: 25%;">Date & Time Created</th> 
                              <th style="width: 5%;">Status</th>
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
    "sAjaxSource": "tbl_payroll_period/json_payroll_period_datatable.php",
    "aoColumns": [
      { mData: 'number'},
      { mData: 'payroll_period_details'},
      { mData: 'payroll_period_created_at_by'},
      { mData: 'payroll_period_status_description'},
      { mData: 'payroll_period_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.payroll_period_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalPayrolPeriodManagement' onclick='btnUpdateDetails("+row.payroll_period_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.payroll_period_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.payroll_period_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Payroll</a>";
        }else if(row.payroll_period_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.payroll_period_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Payroll</a>";
        }

        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  $(".payroll_period_management_header").text("Add New Data");
  
  $("#divButtonPayrollPeriodManagement").text("");
  $("#divButtonPayrollPeriodManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
}

function Validate_Data(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

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
      SavePayrollPeriod();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SavePayrollPeriod() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let payroll_period_title = $("#txt_payroll_period_title").val();
  let payroll_period_from = $("#txt_payroll_period_from").val();
  let payroll_period_to = $("#txt_payroll_period_to").val();
  let payroll_period_cutoff_from = $("#txt_payroll_period_cutoff_from").val();
  let payroll_period_cutoff_to = $("#txt_payroll_period_cutoff_to").val();

  let obj={"payroll_period_title":payroll_period_title, 
    "payroll_period_from":payroll_period_from, 
    "payroll_period_to":payroll_period_to, 
    "payroll_period_cutoff_from":payroll_period_cutoff_from, 
    "payroll_period_cutoff_to":payroll_period_cutoff_to};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_payroll_period/create_payroll_period.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Payroll period successfully saved.");
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
    validations[index].innerHTML = "*";
  }
}

function btnViewDetails(payroll_period_id) {
  ViewDetails(payroll_period_id);
}

function ViewDetails(payroll_period_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_payroll_period/json_payroll_period.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].payroll_period_id == payroll_period_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Payroll Period Title</div><div class='col-lg-7'>: "+data[index].payroll_period_title+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Payroll Period</div><div class='col-lg-7'>: "+data[index].payroll_period_from+" TO "+data[index].payroll_period_to+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Cut-off</div><div class='col-lg-7'>: "+data[index].payroll_period_cutoff_from+" TO "+data[index].payroll_period_cutoff_to+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].payroll_period_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].payroll_period_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].payroll_period_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(payroll_period_id) {
  Empty();
  $(".payroll_period_management_header").text("Update Details");

  $("#divButtonPayrollPeriodManagement").text("");
  $("#divButtonPayrollPeriodManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdatePayrollPeriod()' value='"+payroll_period_id+"'>Submit</button>");

  $.ajax({url:'tbl_payroll_period/json_payroll_period.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].payroll_period_id == payroll_period_id){        
          $("#txt_payroll_period_title").val(data[index].payroll_period_title);
          $("#txt_payroll_period_from").val(data[index].payroll_period_from);
          $("#txt_payroll_period_to").val(data[index].payroll_period_to);
          $("#txt_payroll_period_cutoff_from").val(data[index].payroll_period_cutoff_from);
          $("#txt_payroll_period_cutoff_to").val(data[index].payroll_period_cutoff_to);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdatePayrollPeriod() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

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
    let payroll_period_id = $("#btnUpdateData").val();
    let payroll_period_title = $("#txt_payroll_period_title").val();
    let payroll_period_from = $("#txt_payroll_period_from").val();
    let payroll_period_to = $("#txt_payroll_period_to").val();
    let payroll_period_cutoff_from = $("#txt_payroll_period_cutoff_from").val();
    let payroll_period_cutoff_to = $("#txt_payroll_period_cutoff_to").val();

    let obj={"payroll_period_id":payroll_period_id,
      "payroll_period_title":payroll_period_title, 
      "payroll_period_from":payroll_period_from, 
      "payroll_period_to":payroll_period_to, 
      "payroll_period_cutoff_from":payroll_period_cutoff_from, 
      "payroll_period_cutoff_to":payroll_period_cutoff_to};
    let parameter = JSON.stringify(obj); 

    Empty();
    $.ajax({url:'tbl_payroll_period/update_payroll_period.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Payroll period successfully updated.");
          $(".btnModalClose").click();
          $("#list_of_data").DataTable().ajax.reload();
        }
        else{
          ShowToast("bg-warning", "Warning", "Updating payroll period was failed, Please try again.");
          console.log(data);
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Updating payroll period went something wrong, Please contact the System Administrator.");
      }
    });//end of ajax  
  }else{
    ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
  }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(payroll_period_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this payroll period?");
  $("#btnChangeStatus").val(payroll_period_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let payroll_period_id = $("#btnChangeStatus").val();

  let obj={"payroll_period_id":payroll_period_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_payroll_period/update_payroll_period_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Payroll period successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of payroll period status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of payroll period status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

<div class="modal fade" id="modalPayrolPeriodManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title payroll_period_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Payroll Period Title: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_payroll_period_title">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12"><br>
            <h6>Payroll Period</h6>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Payroll Day From: <span class="validation-area">*</span></label>
            <input type="number" class="form-control fields" id="txt_payroll_period_from">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Payroll Day To: <span class="validation-area">*</span></label>
            <input type="number" class="form-control fields" id="txt_payroll_period_to">
          </div>
        </div>
    
        <div class="row">
          <div class="col-lg-12"><br>
            <h6>Cut-off Period</h6>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Cut-off Day From: <span class="validation-area">*</span></label>
            <input type="number" class="form-control fields" id="txt_payroll_period_cutoff_from">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Cut-off Day To: <span class="validation-area">*</span></label>
            <input type="number" class="form-control fields" id="txt_payroll_period_cutoff_to">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonPayrollPeriodManagement"></div>
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