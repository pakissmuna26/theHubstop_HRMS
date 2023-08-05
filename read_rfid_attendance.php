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
          $(".page_name").text("RFID Attendance Management");          
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
                    <div class="col-lg-12">
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th  style="width: 5%;">No.</th>
                              <th style="width: 50%;">Attendance Details</th> 
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
  let obj={"attendance_category":"RFID"};
  let parameter = JSON.stringify(obj);

  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_attendance/json_attendance_datatable.php?data="+parameter,
    "aoColumns": [
      { mData: 'number'},
      { mData: 'attendance_details'},
      { mData: 'attendance_created_at_by'},
      { mData: 'attendance_status_description'},
      { mData: 'attendance_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.attendance_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        
        let button_update_details = "";    
        let button_change_status = "";
        if(row.attendance_status == "Pending"){
          button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalManualAttendanceManagement' onclick='btnUpdateDetails("+row.attendance_id+")'><i class='bx bx-edit'></i> Update Details</a>";
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.attendance_id+", \"Approved\", \"Approve\")'><i class='bx bx-refresh'></i> Approve Attendance</a>";
          button_change_status += "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.attendance_id+", \"Denied\", \"Deny\")'><i class='bx bx-refresh'></i> Deny Attendance</a>";
        }

        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

Get_Personnel();
function Get_Personnel(){
  $("#select_attendance_requested_by").text("");
  $.ajax({url:'tbl_person/json_person.php',
    method:'GET',
    success:function(data){
      $("#select_attendance_requested_by").text("");
      for(let index = 0; index < data.length; index++){
        $("#select_attendance_requested_by").append("<option value='"+data[index].person_id+"'>"+data[index].full_name+"</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnAddNewData() {
  Empty();
  $(".attendance_management_header").text("Add New Data");
  
  $("#divButtonAttendanceManagement").text("");
  $("#divButtonAttendanceManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
}

function Validate_Shift_Schedule(){
  let person_id = $("#select_attendance_requested_by").val();
  if(person_id != ""){
    $.ajax({url:'tbl_person_shifting_schedule/json_person_shifting_schedule.php',
    method:'GET',
      success:function(data){
        let counter=0;
        $(".divShiftSchedule").text("");
        for(let index = 0; index < data.length; index++){
          if(data[index].person_id == person_id && data[index].person_shifting_schedule_status == "Activated"){
            counter++;
          }
        }
        if(counter == 0){
          $(".divShiftSchedule").append("<div class='row'><div class='col-lg-12'><div class='col-lg-12'>No Active Schedule</div>"); 
          $("#btnAddNewData").attr("disabled", true);
          $("#btnAddNewData").attr("onclick", "");
        }else{
          $(".divShiftSchedule").append("<div class='row'><div class='col-lg-12'><div class='col-lg-12'>There is an Active Schedule</div>"); 
          $("#btnAddNewData").attr("disabled", false);
          $("#btnAddNewData").attr("onclick", "Validate_Data()");
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
      }
    });
  } 
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
      SaveAttendance();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SaveAttendance() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let attendance_category = "Manual";
  let attendance_date_in = $("#txt_attendance_date_in").val();
  let attendance_time_in = $("#txt_attendance_time_in").val();
  let attendance_date_out = $("#txt_attendance_date_out").val();
  let attendance_time_out = $("#txt_attendance_time_out").val();
  let attendance_requested_by = $("#select_attendance_requested_by").val();
  let attendance_requested_by_out = $("#select_attendance_requested_by").val();

  let obj={"attendance_category":attendance_category,
    "attendance_date_in":attendance_date_in, 
    "attendance_time_in":attendance_time_in, 
    "attendance_requested_by":attendance_requested_by,
    "attendance_date_out":attendance_date_out, 
    "attendance_time_out":attendance_time_out, 
    "attendance_approved_by":0, 
    "status":"Pending"};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_attendance/create_attendance.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Attendance successfully saved.");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }
      else{
        ShowToast("bg-warning", "Warning", "Registration was failed, Please try again."+data);
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

function btnViewDetails(attendance_id) {
  ViewDetails(attendance_id);
}

function ViewDetails(attendance_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_attendance/json_attendance.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].attendance_id == attendance_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Category</div><div class='col-lg-7'>: "+data[index].attendance_category+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Time-In: </div><div class='col-lg-7'>: "+data[index].attendance_date_in_description+" @ "+data[index].attendance_time_in+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Time-Out: </div><div class='col-lg-7'>: "+data[index].attendance_date_out_description+" @ "+data[index].attendance_time_out+"</div>");
          
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Requested By</div><div class='col-lg-7'>: "+data[index].attendance_requested_by_name+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Approved By</div><div class='col-lg-7'>: "+data[index].attendance_approved_by_name+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].attendance_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].attendance_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].attendance_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(attendance_id) {
  Empty();
  $(".attendance_management_header").text("Update Details");

  $("#divButtonAttendanceManagement").text("");
  $("#divButtonAttendanceManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateAttendance()' value='"+attendance_id+"'>Submit</button>");

  $.ajax({url:'tbl_attendance/json_attendance.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].attendance_id == attendance_id){        
          $("#txt_attendance_date_in").val(data[index].attendance_date_in);
          $("#txt_attendance_time_in").val(data[index].attendance_time_in);
          $("#select_attendance_requested_by").val(data[index].attendance_requested_by);
          $("#txt_attendance_date_out").val(data[index].attendance_date_out);
          $("#txt_attendance_time_out").val(data[index].attendance_time_out);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateAttendance() {
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
    let attendance_id = $("#btnUpdateData").val();
    let attendance_date_in = $("#txt_attendance_date_in").val();
    let attendance_time_in = $("#txt_attendance_time_in").val();
    let attendance_requested_by = $("#select_attendance_requested_by").val();
    let attendance_date_out = $("#txt_attendance_date_out").val();
    let attendance_time_out = $("#txt_attendance_time_out").val();
    let attendance_requested_by_out = $("#select_attendance_requested_by").val();

    let obj={"attendance_id":attendance_id,
      "attendance_date_in":attendance_date_in, 
      "attendance_time_in":attendance_time_in, 
      "attendance_requested_by":attendance_requested_by,
      "attendance_date_out":attendance_date_out, 
      "attendance_time_out":attendance_time_out};
    let parameter = JSON.stringify(obj); 

    Empty();
    $.ajax({url:'tbl_attendance/update_attendance.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Attendance successfully updated.");
          $(".btnModalClose").click();
          $("#list_of_data").DataTable().ajax.reload();
        }
        else{
          ShowToast("bg-warning", "Warning", "Updating attendance was failed, Please try again.");
          console.log(data);
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Updating attendance went something wrong, Please contact the System Administrator.");
      }
    });//end of ajax  
  }else{
    ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
  }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(attendance_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this attendance?");
  $("#btnChangeStatus").val(attendance_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let attendance_id = $("#btnChangeStatus").val();

  let obj={"attendance_id":attendance_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_attendance/update_attendance_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Attendance successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of attendance status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of attendance status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

function ViewShiftDetails(details) {
  $(".divViewShiftDetails").text("");
  $(".divViewShiftDetails").append(details);
}
</script>

<div class="modal fade" id="modalManualAttendanceManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title attendance_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Select Personnel: <span class="validation-area">*</span></label>
            <select class="form-control fields" id="select_attendance_requested_by" onclick="Validate_Shift_Schedule()" onchange="Validate_Shift_Schedule()"></select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12"><br>
            <h6>Shift Schedule</h6>
            <div class="divShiftSchedule"></div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12"><br>
            <h6>Time-In</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Date: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_attendance_date_in">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Time: <span class="validation-area">*</span></label>
            <input type="time" class="form-control fields" id="txt_attendance_time_in">
          </div>
        </div> 

        <div class="row">
          <div class="col-lg-12"><br>
            <h6>Time-Out</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Date: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_attendance_date_out">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Time: <span class="validation-area">*</span></label>
            <input type="time" class="form-control fields" id="txt_attendance_time_out">
          </div>
        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonAttendanceManagement"></div>
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

<div class="modal fade" id="modalViewShiftDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Shift Details</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="divViewShiftDetails" style="text-transform: uppercase; font-size: 14px;"></div>
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

<!-- 
8:00 AM to 5:00 PM = 8 HOURS (DONE) - 
8:00 AM to 5:30 PM = 8 HOURS (DONE) - 

8:00 AM to 12:00 PM = 4 HOURS (DONE) - 
8:00 AM to 12:30 PM = 4 HOURS (DONE) - 
8:00 AM to 11:00 AM = 3 HOURS (DONE) - 

12:00 PM to 1:30 PM = 30 MINUTES (DONE) - 
1:00 PM to 1:30 PM = 30 MINUTES (DONE) - 
1:00 PM to 5:00 PM = 4 HOURS (DONE) - 
1:00 PM to 5:10 PM = 4 HOURS (DONE) - 

10:00 AM to 2:00 PM = 3 HOURS (DONE) - 
 -->

