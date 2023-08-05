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
          $(".page_name").text("Holiday Management");          
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
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalHolidayManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th  style="width: 5%;">No.</th>
                              <th style="width: 25%;">Holiday Details</th> 
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
    "sAjaxSource": "tbl_holiday/json_holiday_datatable.php",
    "aoColumns": [
      { mData: 'number'},
      { mData: 'holiday_details'},
      { mData: 'holiday_created_at_by'},
      { mData: 'holiday_status_description'},
      { mData: 'holiday_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.holiday_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalHolidayManagement' onclick='btnUpdateDetails("+row.holiday_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.holiday_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.holiday_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Holiday</a>";
        }else if(row.holiday_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.holiday_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Holiday</a>";
        }

        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  $(".holiday_management_header").text("Add New Data");
  
  $("#divButtonHolidayManagement").text("");
  $("#divButtonHolidayManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
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
          // validations[index].innerHTML = "*";
        }    
      }
    }
    if(counter == 0){
      SaveHoliday();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SaveHoliday() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let holiday_title = $("#txt_holiday_title").val();
  let holiday_description = $("#txt_holiday_description").val();
  let holiday_date_from = $("#txt_holiday_date_from").val();
  let holiday_date_to = $("#txt_holiday_date_to").val();
  let holiday_is_paid = $("#select_holiday_is_paid").val();

  let obj={"holiday_title":holiday_title, 
    "holiday_description":holiday_description, 
    "holiday_date_from":holiday_date_from, 
    "holiday_date_to":holiday_date_to, 
    "holiday_is_paid":holiday_is_paid};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_holiday/create_holiday.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Holiday successfully saved.");
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
    if(index != 1)
      validations[index].innerHTML = "*";
  }
}

function btnViewDetails(holiday_id) {
  ViewDetails(holiday_id);
}

function ViewDetails(holiday_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_holiday/json_holiday.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].holiday_id == holiday_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Holiday Title</div><div class='col-lg-7'>: "+data[index].holiday_title+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Holiday Description</div><div class='col-lg-7'>: "+data[index].holiday_description+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Holiday Date</div><div class='col-lg-7'>: "+data[index].holiday_date_from_description+" TO "+data[index].holiday_date_to_description+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Holiday is Paid?</div><div class='col-lg-7'>: "+data[index].holiday_is_paid+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].holiday_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].holiday_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].holiday_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(holiday_id) {
  Empty();
  $(".holiday_management_header").text("Update Details");

  $("#divButtonHolidayManagement").text("");
  $("#divButtonHolidayManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateHoliday()' value='"+holiday_id+"'>Submit</button>");

  $.ajax({url:'tbl_holiday/json_holiday.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].holiday_id == holiday_id){        
          $("#txt_holiday_title").val(data[index].holiday_title);
          $("#txt_holiday_description").val(data[index].holiday_description);
          $("#txt_holiday_date_from").val(data[index].holiday_date_from);
          $("#txt_holiday_date_to").val(data[index].holiday_date_to);
          $("#select_holiday_is_paid").val(data[index].holiday_is_paid);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateHoliday() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  var counter = 0;
  for(var index=0; index<all_Fields.length; index++){    
    if(index != 1){
      if(all_Fields[index].value == ""){
        validations[index].innerHTML = "* Field is required";
        counter++;
      }else{
        // validations[index].innerHTML = "*";
      }    
    }
  }
  if(counter == 0){  
    let holiday_id = $("#btnUpdateData").val();
    let holiday_title = $("#txt_holiday_title").val();
    let holiday_description = $("#txt_holiday_description").val();
    let holiday_date_from = $("#txt_holiday_date_from").val();
    let holiday_date_to = $("#txt_holiday_date_to").val();
    let holiday_is_paid = $("#select_holiday_is_paid").val();

    let obj={"holiday_id":holiday_id,
      "holiday_title":holiday_title, 
      "holiday_description":holiday_description, 
      "holiday_date_from":holiday_date_from, 
      "holiday_date_to":holiday_date_to, 
      "holiday_is_paid":holiday_is_paid};
    let parameter = JSON.stringify(obj); 

    Empty();
    $.ajax({url:'tbl_holiday/update_holiday.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Holiday successfully updated.");
          $(".btnModalClose").click();
          $("#list_of_data").DataTable().ajax.reload();
        }
        else{
          ShowToast("bg-warning", "Warning", "Updating holiday was failed, Please try again.");
          console.log(data);
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Updating holiday went something wrong, Please contact the System Administrator.");
      }
    });//end of ajax  
  }else{
    ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
  }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(holiday_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this holiday?");
  $("#btnChangeStatus").val(holiday_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let holiday_id = $("#btnChangeStatus").val();

  let obj={"holiday_id":holiday_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_holiday/update_holiday_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Holiday successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of holiday status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of holiday status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

<div class="modal fade" id="modalHolidayManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title holiday_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Holiday Title: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_holiday_title">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Holiday Description: (Optional) <span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_holiday_description">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Date From: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_holiday_date_from">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Date To: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_holiday_date_to">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Holiday Paid?:<span class="validation-area">*</span></label>
            <select class="form-control fields" id="select_holiday_is_paid">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonHolidayManagement"></div>
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