<?php include("includes/header.php"); ?>
<!-- Layout wrapper -->

<!-- 
HDMF
COMPANY SHARE: PHP100
PERSONNEL SHARE: PHP 100

PHILEALTH
COMPANY SHARE: 2.25%
PERSONNEL SHARE: 2.25%

SSS
COMPANY SHARE: 9.5%
PERSONNEL SHARE: 4.5%
 -->
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
          $(".page_name").text("Deduction Category Management");          
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
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalDeductionCategoryManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th style="width: 5%;">No.</th>
                              <th style="width: 20%;">Deduction Details</th> 
                              <th style="width: 25%;"></th> 
                              <th style="width: 25%;">Date & Time Created</th> 
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
    "sAjaxSource": "tbl_deduction_category/json_deduction_category_datatable.php",
    "aoColumns": [
      { mData: 'number'},
      { mData: 'deduction_category_details'},
      { mData: 'deduction_category_is_percentage_details'},
      { mData: 'deduction_category_created_at_by'},
      { mData: 'deduction_category_status_description'},
      { mData: 'deduction_category_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.deduction_category_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalDeductionCategoryManagement' onclick='btnUpdateDetails("+row.deduction_category_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.deduction_category_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.deduction_category_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Deduction</a>";
        }else if(row.deduction_category_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.deduction_category_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Deduction</a>";
        }

        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  $(".deduction_category_management_header").text("Add New Data");
  
  $("#divButtonDeductionCategoryManagement").text("");
  $("#divButtonDeductionCategoryManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
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
      SaveDeductionCategory();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SaveDeductionCategory() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let deduction_category_title = $("#txt_deduction_category_title").val();
  let deduction_category_description = $("#txt_deduction_category_description").val();
  let deduction_category_is_percentage = $("#txt_deduction_category_is_percentage").val();
  let deduction_category_company_share = $("#txt_deduction_category_company_share").val();
  let deduction_category_personnel_share = $("#txt_deduction_category_personnel_share").val();

  let obj={"deduction_category_title":deduction_category_title, 
  "deduction_category_description":deduction_category_description, 
  "deduction_category_is_percentage":deduction_category_is_percentage, 
  "deduction_category_company_share":deduction_category_company_share, 
  "deduction_category_personnel_share":deduction_category_personnel_share};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_deduction_category/create_deduction_category.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Deduction category successfully saved.");
        
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

function btnViewDetails(deduction_category_id) {
  ViewDetails(deduction_category_id);
}

function ViewDetails(deduction_category_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_deduction_category/json_deduction_category.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].deduction_category_id == deduction_category_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Deduction Title</div><div class='col-lg-7'>: "+data[index].deduction_category_title+"</div><div class='col-lg-5'>Deduction Description</div><div class='col-lg-7'>: "+data[index].deduction_category_description+"</div><div class='col-lg-5'>Percentage?</div><div class='col-lg-7'>: "+data[index].deduction_category_is_percentage+"</div><div class='col-lg-5'>Company Share</div><div class='col-lg-7'>: "+data[index].deduction_category_company_share+"</div><div class='col-lg-5'>Personnel Share</div><div class='col-lg-7'>: "+data[index].deduction_category_personnel_share+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].deduction_category_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].deduction_category_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].deduction_category_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(deduction_category_id) {
  Empty();
  $(".deduction_category_management_header").text("Update Details");

  $("#divButtonDeductionCategoryManagement").text("");
  $("#divButtonDeductionCategoryManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateDeductionCategory()' value='"+deduction_category_id+"'>Submit</button>");

  $.ajax({url:'tbl_deduction_category/json_deduction_category.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].deduction_category_id == deduction_category_id){        
          $("#txt_deduction_category_title").val(data[index].deduction_category_title);
          $("#txt_deduction_category_description").val(data[index].deduction_category_description);
          $("#txt_deduction_category_is_percentage").val(data[index].deduction_category_is_percentage);
          $("#txt_deduction_category_company_share").val(data[index].deduction_category_company_share);
          $("#txt_deduction_category_personnel_share").val(data[index].deduction_category_personnel_share);

          let deduction_category_is_percentage = data[index].deduction_category_is_percentage;
          if(deduction_category_is_percentage == "Yes"){
            $("#company_php").hide();
            $("#personnel_php").hide();
            $("#company_percentage").show();
            $("#personnel_percentage").show();
          }else if(deduction_category_is_percentage == "No"){
            $("#company_php").show();
            $("#personnel_php").show();
            $("#company_percentage").hide();
            $("#personnel_percentage").hide();
          }

        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateDeductionCategory() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let deduction_category_id = $("#btnUpdateData").val();
  let deduction_category_title = $("#txt_deduction_category_title").val();
  let deduction_category_description = $("#txt_deduction_category_description").val();
  let deduction_category_is_percentage = $("#txt_deduction_category_is_percentage").val();
  let deduction_category_company_share = $("#txt_deduction_category_company_share").val();
  let deduction_category_personnel_share = $("#txt_deduction_category_personnel_share").val();

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
    let obj={"deduction_category_id":deduction_category_id,
    "deduction_category_title":deduction_category_title, 
    "deduction_category_description":deduction_category_description, 
    "deduction_category_is_percentage":deduction_category_is_percentage, 
    "deduction_category_company_share":deduction_category_company_share, 
    "deduction_category_personnel_share":deduction_category_personnel_share};
    let parameter = JSON.stringify(obj); 
    
    Empty();
    $.ajax({url:'tbl_deduction_category/update_deduction_category.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Deduction category successfully updated.");
          $(".btnModalClose").click();
          $("#list_of_data").DataTable().ajax.reload();
        }
        else{
          ShowToast("bg-warning", "Warning", "Updating deduction category was failed, Please try again.");
          console.log(data);
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Updating deduction category went something wrong, Please contact the System Administrator.");
      }
    });//end of ajax  
  }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(deduction_category_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this deduction category?");
  $("#btnChangeStatus").val(deduction_category_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let deduction_category_id = $("#btnChangeStatus").val();

  let obj={"deduction_category_id":deduction_category_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_deduction_category/update_deduction_category_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Deduction category successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of deduction category status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of deduction category status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //
function Change() {
  let deduction_category_is_percentage = $("#txt_deduction_category_is_percentage").val();
  if(deduction_category_is_percentage == "Yes"){
    $("#company_php").hide();
    $("#personnel_php").hide();
    $("#company_percentage").show();
    $("#personnel_percentage").show();
  }else if(deduction_category_is_percentage == "No"){
    $("#company_php").show();
    $("#personnel_php").show();
    $("#company_percentage").hide();
    $("#personnel_percentage").hide();
  }
}
</script>

<div class="modal fade" id="modalDeductionCategoryManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title deduction_category_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Deduction Title: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_deduction_category_title">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Deduction Description: (Optional) <span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_deduction_category_description">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Percentage?: <span class="validation-area">*</span></label>
            <select class="form-control fields" id="txt_deduction_category_is_percentage" onchange="Change()">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Company Share: <span class="validation-area">*</span></label>
            <div class="input-group">
              <span class="input-group-text" id="company_php" style="display: none;">PHP</span>
              <input type="text" class="form-control fields" id="txt_deduction_category_company_share">
              <span class="input-group-text" id="company_percentage">%</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Personnel Share: <span class="validation-area">*</span></label>
            <div class="input-group">
              <span class="input-group-text" id="personnel_php" style="display: none;">PHP</span>
              <input type="text" class="form-control fields" id="txt_deduction_category_personnel_share">
              <span class="input-group-text" id="personnel_percentage">%</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonDeductionCategoryManagement"></div>
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