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
          $(".page_name").text("Branch Management");          
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
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalBranchManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th style="width: 5%">No.</th>
                              <th style="width: 20%">Branch Details</th> 
                              <th style="width: 30%">Address</th> 
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
    "sAjaxSource": "tbl_branch/json_branch_datatable.php",
    // dom: 'Bfrtip',
    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    "aoColumns": [
      { mData: 'number'},
      { mData: 'branch_details'},
      { mData: 'address'},
      { mData: 'branch_created_at_by'},
      { mData: 'branch_status_description'},
      { mData: 'branch_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.branch_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalBranchManagement' onclick='btnUpdateDetails("+row.branch_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.branch_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.branch_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Branch</a>";
        }else if(row.branch_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.branch_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Branch</a>";
        }

        let button_assign_employee = "<a class='dropdown-item' href='manage_branch.php?id="+row.branch_id+"'><i class='bx bx-list-ul'></i>Manage Branch <i class='bx bx-right-arrow-alt'></i></a>";
        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+" "+button_assign_employee+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  $(".branch_management_header").text("Add New Data");
  
  $("#divButtonBranchManagement").text("");
  $("#divButtonBranchManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
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
      let contact_number = $("#txt_contact_number").val();
      if(contact_number.length < 10 || contact_number.length > 10){
        validations[7].innerHTML = "* Enter the 10 digits number";
        ShowToast("bg-warning", "Warning", "Kindly check the contact number.");
      }else{
        validations[7].innerHTML = "*";
        SaveBranch();
      }
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SaveBranch() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let branch_name = $("#txt_branch_name").val();
  let branch_description = $("#txt_branch_description").val();
  
  let branch_address = $("#txt_house_number").val();
  let branch_region = $("#select_region").val();
  let branch_province = $("#select_province").val();
  let branch_city = $("#select_city").val();
  let branch_barangay = $("#select_barangay").val();
  let branch_contact_number = $("#txt_contact_number").val();

  let obj={"branch_name":branch_name, "branch_description":branch_description, "branch_address":branch_address, "branch_region":branch_region, "branch_region":branch_region, "branch_province":branch_province, "branch_city":branch_city, "branch_barangay":branch_barangay, "branch_contact_number":branch_contact_number};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_branch/create_branch.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Branch successfully saved.");
        
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

function btnViewDetails(branch_id) {
  ViewDetails(branch_id);
}

function ViewDetails(branch_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_branch/json_branch.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].branch_id == branch_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Branch Name</div><div class='col-lg-7'>: "+data[index].branch_name+"</div><div class='col-lg-5'>Branch Description</div><div class='col-lg-7'>: "+data[index].branch_description+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Branch Address</div><div class='col-lg-7'>: "+data[index].address+"</div><div class='col-lg-5'>Contact Number</div><div class='col-lg-7'>: "+data[index].branch_contact_number_full+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].branch_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].branch_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].branch_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(branch_id) {
  Empty();
  $(".branch_management_header").text("Update Details");

  $("#divButtonBranchManagement").text("");
  $("#divButtonBranchManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateBranch()' value='"+branch_id+"'>Submit</button>");

  $.ajax({url:'tbl_branch/json_branch.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].branch_id == branch_id){        
          $("#txt_branch_name").val(data[index].branch_name);
          $("#txt_branch_description").val(data[index].branch_description);
          
          $("#txt_house_number").val(data[index].branch_address);
          $("#select_region").val(data[index].branch_region);
          Choose_Province();
          $("#select_province").val(data[index].branch_province);
          Choose_Municipality();
          $("#select_city").val(data[index].branch_city);
          Choose_Barangay();
          $("#select_barangay").val(data[index].branch_barangay);
          $("#txt_contact_number").val(data[index].branch_contact_number);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateBranch() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let branch_id = $("#btnUpdateData").val();
  let branch_name = $("#txt_branch_name").val();
  let branch_description = $("#txt_branch_description").val();

  let branch_address = $("#txt_house_number").val();
  let branch_region = $("#select_region").val();
  let branch_province = $("#select_province").val();
  let branch_city = $("#select_city").val();
  let branch_barangay = $("#select_barangay").val();
  let branch_contact_number = $("#txt_contact_number").val();

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
      let contact_number = $("#txt_contact_number").val();
      if(contact_number.length < 10 || contact_number.length > 10){
        validations[7].innerHTML = "* Enter the 10 digits number";
        ShowToast("bg-warning", "Warning", "Kindly check the contact number.");
      }else{

        let obj={"branch_id":branch_id,"branch_name":branch_name, "branch_description":branch_description, "branch_address":branch_address, "branch_region":branch_region, "branch_region":branch_region, "branch_province":branch_province, "branch_city":branch_city, "branch_barangay":branch_barangay, "branch_contact_number":branch_contact_number};
        let parameter = JSON.stringify(obj); 
        
        Empty();
        $.ajax({url:'tbl_branch/update_branch.php?data='+parameter,
          method:'GET',
          success:function(data){
            if(data == true){
              ShowToast("bg-success", "Success", "Branch successfully updated.");
              $(".btnModalClose").click();
              $("#list_of_data").DataTable().ajax.reload();
            }
            else{
              ShowToast("bg-warning", "Warning", "Updating branch was failed, Please try again.");
              console.log(data);
            }
          },
          error:function(){
            ShowToast("bg-danger", "Danger", "Updating branch went something wrong, Please contact the System Administrator.");
          }
        });//end of ajax  
      }
     }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(branch_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this branch?");
  $("#btnChangeStatus").val(branch_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let branch_id = $("#btnChangeStatus").val();

  let obj={"branch_id":branch_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_branch/update_branch_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Branch successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of branch status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of branch status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

<div class="modal fade" id="modalBranchManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title branch_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <?php include("includes/branch_information.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonBranchManagement"></div>
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