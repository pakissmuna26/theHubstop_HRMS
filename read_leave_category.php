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
          $(".page_name").text("Leave Category Management");          
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
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalLeaveCategoryManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Leave Details</th> 
                              <th>Quantity</th> 
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
    "sAjaxSource": "tbl_leave_category/json_leave_category_datatable.php",
    "aoColumns": [
      { mData: 'number'},
      { mData: 'leave_category_details'},
      { mData: 'leave_category_quantity_details'},
      { mData: 'leave_category_created_at_by'},
      { mData: 'leave_category_status_description'},
      { mData: 'leave_category_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.leave_category_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalLeaveCategoryManagement' onclick='btnUpdateDetails("+row.leave_category_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.leave_category_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.leave_category_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Leave</a>";
        }else if(row.leave_category_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.leave_category_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Leave</a>";
        }
        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  $(".leave_category_management_header").text("Add New Data");
  
  $("#divButtonLeaveCategoryManagement").text("");
  $("#divButtonLeaveCategoryManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
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
      SaveLeaveCategory();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SaveLeaveCategory() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let leave_category_title = $("#txt_leave_category_title").val();
  let leave_category_description = $("#txt_leave_category_description").val();
  let leave_category_quantity = $("#txt_leave_category_quantity").val();
  let leave_category_paid_quantity = $("#txt_leave_category_paid_quantity").val();

  let obj={"leave_category_title":leave_category_title, 
  "leave_category_description":leave_category_description, 
  "leave_category_quantity":leave_category_quantity, 
  "leave_category_paid_quantity":leave_category_paid_quantity};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_leave_category/create_leave_category.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Leave category successfully saved.");
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

function btnViewDetails(leave_category_id) {
  ViewDetails(leave_category_id);
}

function ViewDetails(leave_category_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_leave_category/json_leave_category.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].leave_category_id == leave_category_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Leave Title</div><div class='col-lg-7'>: "+data[index].leave_category_title+"</div><div class='col-lg-5'>Leave Description</div><div class='col-lg-7'>: "+data[index].leave_category_description+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Leave Quantity</div><div class='col-lg-7'>: "+data[index].leave_category_quantity+"</div><div class='col-lg-5'>Leave Paid</div><div class='col-lg-7'>: "+data[index].leave_category_paid_quantity+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].leave_category_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].leave_category_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].leave_category_added_by+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(leave_category_id) {
  Empty();
  $(".leave_category_management_header").text("Update Details");

  $("#divButtonLeaveCategoryManagement").text("");
  $("#divButtonLeaveCategoryManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateLeaveCategory()' value='"+leave_category_id+"'>Submit</button>");

  $.ajax({url:'tbl_leave_category/json_leave_category.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].leave_category_id == leave_category_id){        
          $("#txt_leave_category_title").val(data[index].leave_category_title);
          $("#txt_leave_category_description").val(data[index].leave_category_description);
          $("#txt_leave_category_quantity").val(data[index].leave_category_quantity);
          $("#txt_leave_category_paid_quantity").val(data[index].leave_category_paid_quantity);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateLeaveCategory() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let leave_category_id = $("#btnUpdateData").val();
  let leave_category_title = $("#txt_leave_category_title").val();
  let leave_category_description = $("#txt_leave_category_description").val();
  let leave_category_quantity = $("#txt_leave_category_quantity").val();
  let leave_category_paid_quantity = $("#txt_leave_category_paid_quantity").val();

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
    let obj={"leave_category_id":leave_category_id,
    "leave_category_title":leave_category_title, 
    "leave_category_description":leave_category_description, 
    "leave_category_quantity":leave_category_quantity, 
    "leave_category_paid_quantity":leave_category_paid_quantity};
    let parameter = JSON.stringify(obj); 
    
    Empty();
    $.ajax({url:'tbl_leave_category/update_leave_category.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Leave category successfully updated.");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }
      else{
        ShowToast("bg-warning", "Warning", "Updating leave category was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating leave category went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
  }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(leave_category_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this leave category?");
  $("#btnChangeStatus").val(leave_category_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let leave_category_id = $("#btnChangeStatus").val();

  let obj={"leave_category_id":leave_category_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_leave_category/update_leave_category_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Leave category successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of leave category status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of leave category status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

<div class="modal fade" id="modalLeaveCategoryManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title leave_category_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Leave Title: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_leave_category_title">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Leave Description: (Optional) <span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_leave_category_description">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Quantity: <span class="validation-area">*</span></label>
            <input type="number" class="form-control fields" id="txt_leave_category_quantity">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Quantity that is paid: <span class="validation-area">*</span></label>
            <input type="number" class="form-control fields" id="txt_leave_category_paid_quantity">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonLeaveCategoryManagement"></div>
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