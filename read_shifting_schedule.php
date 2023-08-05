<?php include("includes/header.php"); ?>
<!-- 
SHIFT SCHEDULE: 08:00 TO 17:00
SHIFT BREAK SCHEDULE: 12:00 TO 13:00

SHIFT SCHEDULE: 20:00 TO 05:00
SHIFT BREAK SCHEDULE: 00:00 TO 01:00

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
          $(".page_name").text("Shifting Schedule Management");          
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
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalShiftingScheduleManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th  style="width: 5%;">No.</th>
                              <th style="width: 40%;">Shifting Schedule Details</th> 
                              <th style="width: 40%;">Days of Week</th> 
                              <!-- <th style="width: 20%;">Date & Time Created</th> -->
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
    "sAjaxSource": "tbl_shifting_schedule/json_shifting_schedule_datatable.php",
    "aoColumns": [
      { mData: 'number'},
      { mData: 'shifting_schedule_details'},
      { mData: 'shifting_schedule_days_of_week'},
      // { mData: 'shifting_schedule_created_at_by'},
      { mData: 'shifting_schedule_status_description'},
      { mData: 'shifting_schedule_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.shifting_schedule_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalShiftingScheduleManagement' onclick='btnUpdateDetails("+row.shifting_schedule_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.shifting_schedule_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.shifting_schedule_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Schedule</a>";
        }else if(row.shifting_schedule_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.shifting_schedule_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Schedule</a>";
        }

        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  $(".shifting_schedule_management_header").text("Add New Data");
  
  $("#divButtonShiftingScheduleManagement").text("");
  $("#divButtonShiftingScheduleManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
}

function Validate_Data(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");
  let chkDaysOfWeek = document.getElementsByClassName("chkDaysOfWeek");

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
      let check=0;
      for(var index=0; index<chkDaysOfWeek.length; index++){ 
        if(chkDaysOfWeek[index].checked == true){
          check++;
        }
      }

      if(check > 0){
        SaveShiftingSchedule();
      }else{
        ShowToast("bg-warning", "Warning", "Check the days of week.");  
      }
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SaveShiftingSchedule() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");
  let chkDaysOfWeek = document.getElementsByClassName("chkDaysOfWeek");

  let shifting_schedule_time_from = $("#txt_shifting_schedule_time_from").val();
  let shifting_schedule_time_to = $("#txt_shifting_schedule_time_to").val();
  let shifting_schedule_break_time_from = $("#txt_shifting_schedule_break_time_from").val();
  let shifting_schedule_break_time_to = $("#txt_shifting_schedule_break_time_to").val();

  let shifting_schedule_monday = "No";
  let shifting_schedule_tuesday = "No";
  let shifting_schedule_wednesday = "No";
  let shifting_schedule_thursday = "No";
  let shifting_schedule_friday = "No";
  let shifting_schedule_saturday = "No";
  let shifting_schedule_sunday = "No";

  if(chkDaysOfWeek[0].checked == true) shifting_schedule_monday = "Yes";
  if(chkDaysOfWeek[1].checked == true) shifting_schedule_tuesday = "Yes";
  if(chkDaysOfWeek[2].checked == true) shifting_schedule_wednesday = "Yes";
  if(chkDaysOfWeek[3].checked == true) shifting_schedule_thursday = "Yes";
  if(chkDaysOfWeek[4].checked == true) shifting_schedule_friday = "Yes";
  if(chkDaysOfWeek[5].checked == true) shifting_schedule_saturday = "Yes";
  if(chkDaysOfWeek[6].checked == true) shifting_schedule_sunday = "Yes";


  let obj={"shifting_schedule_time_from":shifting_schedule_time_from, 
    "shifting_schedule_time_to":shifting_schedule_time_to, 
    "shifting_schedule_break_time_from":shifting_schedule_break_time_from, 
    "shifting_schedule_break_time_to":shifting_schedule_break_time_to, 
    "shifting_schedule_monday":shifting_schedule_monday, 
    "shifting_schedule_tuesday":shifting_schedule_tuesday, 
    "shifting_schedule_wednesday":shifting_schedule_wednesday, 
    "shifting_schedule_thursday":shifting_schedule_thursday, 
    "shifting_schedule_friday":shifting_schedule_friday, 
    "shifting_schedule_saturday":shifting_schedule_saturday, 
    "shifting_schedule_sunday":shifting_schedule_sunday};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_shifting_schedule/create_shifting_schedule.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Shifting Schedule successfully saved.");
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
  let chkDaysOfWeek = document.getElementsByClassName("chkDaysOfWeek");

  for(let index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    validations[index].innerHTML = "*";
  }

  for(var index=0; index<chkDaysOfWeek.length; index++){ 
    chkDaysOfWeek[index].checked = false;
  }
}

function btnViewDetails(shifting_schedule_id) {
  ViewDetails(shifting_schedule_id);
}

function ViewDetails(shifting_schedule_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_shifting_schedule/json_shifting_schedule.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].shifting_schedule_id == shifting_schedule_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Shift Schedule</div><div class='col-lg-7'>: "+data[index].shifting_schedule_time_from+" TO "+data[index].shifting_schedule_time_to+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Shift Break Schedule</div><div class='col-lg-7'>: "+data[index].shifting_schedule_break_time_from+" TO "+data[index].shifting_schedule_break_time_to+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br>Days of Week</div></div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'>"+data[index].shifting_schedule_days_of_week+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].shifting_schedule_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].shifting_schedule_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].shifting_schedule_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(shifting_schedule_id) {
  Empty();
  $(".shifting_schedule_management_header").text("Update Details");

  $("#divButtonShiftingScheduleManagement").text("");
  $("#divButtonShiftingScheduleManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateShiftingSchedule()' value='"+shifting_schedule_id+"'>Submit</button>");

  let chkDaysOfWeek = document.getElementsByClassName("chkDaysOfWeek");

  $.ajax({url:'tbl_shifting_schedule/json_shifting_schedule.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].shifting_schedule_id == shifting_schedule_id){        
          $("#txt_shifting_schedule_time_from").val(data[index].shifting_schedule_time_from);
          $("#txt_shifting_schedule_time_to").val(data[index].shifting_schedule_time_to);
          $("#txt_shifting_schedule_break_time_from").val(data[index].shifting_schedule_break_time_from);
          $("#txt_shifting_schedule_break_time_to").val(data[index].shifting_schedule_break_time_to);

          if(data[index].shifting_schedule_monday == "Yes")
            chkDaysOfWeek[0].checked = true;
          if(data[index].shifting_schedule_tuesday == "Yes")
            chkDaysOfWeek[1].checked = true;
          if(data[index].shifting_schedule_wednesday == "Yes")
            chkDaysOfWeek[2].checked = true;
          if(data[index].shifting_schedule_thursday == "Yes")
            chkDaysOfWeek[3].checked = true;
          if(data[index].shifting_schedule_friday == "Yes")
            chkDaysOfWeek[4].checked = true;
          if(data[index].shifting_schedule_saturday == "Yes")
            chkDaysOfWeek[5].checked = true;
          if(data[index].shifting_schedule_sunday == "Yes")
            chkDaysOfWeek[6].checked = true;

        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateShiftingSchedule() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");
  let chkDaysOfWeek = document.getElementsByClassName("chkDaysOfWeek");

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
    let check=0;
      for(var index=0; index<chkDaysOfWeek.length; index++){ 
        if(chkDaysOfWeek[index].checked == true){
          check++;
        }
      }

      if(check > 0){

        let shifting_schedule_id = $("#btnUpdateData").val();
        let shifting_schedule_time_from = $("#txt_shifting_schedule_time_from").val();
        let shifting_schedule_time_to = $("#txt_shifting_schedule_time_to").val();
        let shifting_schedule_break_time_from = $("#txt_shifting_schedule_break_time_from").val();
        let shifting_schedule_break_time_to = $("#txt_shifting_schedule_break_time_to").val();

        let shifting_schedule_monday = "No";
        let shifting_schedule_tuesday = "No";
        let shifting_schedule_wednesday = "No";
        let shifting_schedule_thursday = "No";
        let shifting_schedule_friday = "No";
        let shifting_schedule_saturday = "No";
        let shifting_schedule_sunday = "No";

        if(chkDaysOfWeek[0].checked == true) shifting_schedule_monday = "Yes";
        if(chkDaysOfWeek[1].checked == true) shifting_schedule_tuesday = "Yes";
        if(chkDaysOfWeek[2].checked == true) shifting_schedule_wednesday = "Yes";
        if(chkDaysOfWeek[3].checked == true) shifting_schedule_thursday = "Yes";
        if(chkDaysOfWeek[4].checked == true) shifting_schedule_friday = "Yes";
        if(chkDaysOfWeek[5].checked == true) shifting_schedule_saturday = "Yes";
        if(chkDaysOfWeek[6].checked == true) shifting_schedule_sunday = "Yes";        
        let obj={"shifting_schedule_id":shifting_schedule_id,
          "shifting_schedule_time_from":shifting_schedule_time_from, 
          "shifting_schedule_time_to":shifting_schedule_time_to, 
          "shifting_schedule_break_time_from":shifting_schedule_break_time_from, 
          "shifting_schedule_break_time_to":shifting_schedule_break_time_to, 
          "shifting_schedule_monday":shifting_schedule_monday, 
          "shifting_schedule_tuesday":shifting_schedule_tuesday, 
          "shifting_schedule_wednesday":shifting_schedule_wednesday, 
          "shifting_schedule_thursday":shifting_schedule_thursday, 
          "shifting_schedule_friday":shifting_schedule_friday, 
          "shifting_schedule_saturday":shifting_schedule_saturday, 
          "shifting_schedule_sunday":shifting_schedule_sunday};
        let parameter = JSON.stringify(obj); 

        Empty();
        $.ajax({url:'tbl_shifting_schedule/update_shifting_schedule.php?data='+parameter,
          method:'GET',
          success:function(data){
            if(data == true){
              ShowToast("bg-success", "Success", "Shifting Schedule successfully updated.");
              $(".btnModalClose").click();
              $("#list_of_data").DataTable().ajax.reload();
            }
            else{
              ShowToast("bg-warning", "Warning", "Updating shifting schcedule was failed, Please try again.");
              console.log(data);
            }
          },
          error:function(){
            ShowToast("bg-danger", "Danger", "Updating shifting schcedule went something wrong, Please contact the System Administrator.");
          }
        });//end of ajax  
      }else{
        ShowToast("bg-warning", "Warning", "Check the days of week.");  
      }

  }else{
    ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
  }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(shifting_schedule_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this shifting schedule?");
  $("#btnChangeStatus").val(shifting_schedule_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let shifting_schedule_id = $("#btnChangeStatus").val();

  let obj={"shifting_schedule_id":shifting_schedule_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_shifting_schedule/update_shifting_schedule_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Shifting Schedule successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of shifting schedule status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of shifting schedule status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

<div class="modal fade" id="modalShiftingScheduleManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title shifting_schedule_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <h6>Shift Schedule</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Shift Schedule From: <span class="validation-area">*</span></label>
            <input type="time" class="form-control fields" id="txt_shifting_schedule_time_from">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Shift Schedule To: <span class="validation-area">*</span></label>
            <input type="time" class="form-control fields" id="txt_shifting_schedule_time_to">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12"><br>
            <h6>Shift Break</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Shift Break From: <span class="validation-area">*</span></label>
            <input type="time" class="form-control fields" id="txt_shifting_schedule_break_time_from">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Shift Break To: <span class="validation-area">*</span></label>
            <input type="time" class="form-control fields" id="txt_shifting_schedule_break_time_to">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12"><br>
            <h6>Days of Week</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <table class="table">
              <tr>
                <td></td>
                <td style="width: 5%;"><input class="form-check-input chkDaysOfWeek" type="checkbox" value="Yes"></td>
                <td><label class="form-check-label" for="defaultCheck1"> Monday </label></td>
                <td style="width: 5%;"><input class="form-check-input chkDaysOfWeek" type="checkbox" value="Yes"></td>
                <td><label class="form-check-label" for="defaultCheck1"> Tuesday </label></td>
              </tr>
              <tr>
                <td></td>
                <td style="width: 5%;"><input class="form-check-input chkDaysOfWeek" type="checkbox" value="Yes"></td>
                <td><label class="form-check-label" for="defaultCheck1"> Wednesday </label></td>
                <td style="width: 5%;"><input class="form-check-input chkDaysOfWeek" type="checkbox" value="Yes"></td>
                <td><label class="form-check-label" for="defaultCheck1"> Thursday </label></td>
              </tr>
              <tr>
                <td></td>
                <td style="width: 5%;"><input class="form-check-input chkDaysOfWeek" type="checkbox" value="Yes"></td>
                <td><label class="form-check-label" for="defaultCheck1"> Friday </label></td>
                <td style="width: 5%;"><input class="form-check-input chkDaysOfWeek" type="checkbox" value="Yes"></td>
                <td><label class="form-check-label" for="defaultCheck1"> Saturday </label></td>
              </tr>
              <tr>
                <td></td>
                <td style="width: 5%;"><input class="form-check-input chkDaysOfWeek" type="checkbox" value="Yes"></td>
                <td><label class="form-check-label" for="defaultCheck1"> Sunday </label></td>
                <td style="width: 5%;"></td>
                <td></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonShiftingScheduleManagement"></div>
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