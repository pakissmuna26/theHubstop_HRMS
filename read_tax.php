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
          $(".page_name").text("Tax Management");          
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
                      <button type="button" id="btnResetPassword" class="btn btn-outline-success" data-bs-toggle='modal' data-bs-target='#modalTaxManagement' onclick="btnAddNewData()">Add New Data</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th style="width: 5%">No.</th>
                              <th style="width: 55%">Tax Details</th> 
                              <th style="width: 30%">Date & Time Created</th> 
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
    "sAjaxSource": "tbl_tax/json_tax_datatable.php",
    // dom: 'Bfrtip',
    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    "aoColumns": [
      { mData: 'number'},
      { mData: 'tax_details'},
      { mData: 'tax_created_at_by'},
      { mData: 'tax_status_description'},
      { mData: 'tax_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.tax_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalTaxManagement' onclick='btnUpdateDetails("+row.tax_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.tax_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.tax_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Tax</a>";
        }else if(row.tax_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.tax_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Tax</a>";
        }

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnAddNewData() {
  Empty();
  $(".tax_management_header").text("Add New Data");
  
  $("#divButtonTaxManagement").text("");
  $("#divButtonTaxManagement").append("<button type='button' id='btnAddNewData' class='btn btn-success' onclick='Validate_Data()'>Submit</button>");
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
      SaveTax();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function SaveTax() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let tax_title = $("#txt_tax_title").val();
  let tax_description = $("#txt_tax_description").val();
  let tax_date_from = $("#txt_tax_date_from").val();
  let tax_date_to = $("#txt_tax_date_to").val();
  let tax_amount_from = $("#txt_tax_amount_from").val();
  let tax_amount_to = $("#txt_tax_amount_to").val();
  let tax_additional = $("#txt_tax_additional").val();
  let tax_percentage = $("#txt_tax_percentage").val();

  let obj={"tax_title":tax_title, "tax_description":tax_description, "tax_date_from":tax_date_from, "tax_date_to":tax_date_to,"tax_amount_from":tax_amount_from, "tax_amount_to":tax_amount_to, "tax_additional":tax_additional, "tax_percentage":tax_percentage};
  let parameter = JSON.stringify(obj); 

  Empty(); 
  $.ajax({url:'tbl_tax/create_tax.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Tax successfully saved.");
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

function btnViewDetails(tax_id) {
  ViewDetails(tax_id);
}

function ViewDetails(tax_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_tax/json_tax.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].tax_id == tax_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Tax Title</div><div class='col-lg-7'>: "+data[index].tax_title+"</div><div class='col-lg-5'>Tax Description</div><div class='col-lg-7'>: "+data[index].tax_description+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Tax Date Range</div><div class='col-lg-7'>: "+data[index].tax_date_from_description+" TO "+data[index].tax_date_to_description+"</div><div class='col-lg-5'>Tax Amount Range</div><div class='col-lg-7'>: PHP "+data[index].tax_amount_from_description+" TO PHP "+data[index].tax_amount_to_description+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Tax Additional</div><div class='col-lg-7'>: PHP "+data[index].tax_additional_description+"</div><div class='col-lg-5'>Tax Percentage</div><div class='col-lg-7'>: "+data[index].tax_percentage+"%</div>");


          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].tax_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].tax_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].tax_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnUpdateDetails(tax_id) {
  Empty();
  $(".tax_management_header").text("Update Details");

  $("#divButtonTaxManagement").text("");
  $("#divButtonTaxManagement").append("<button type='button' id='btnUpdateData' class='btn btn-success' onclick='UpdateTax()' value='"+tax_id+"'>Submit</button>");

  $.ajax({url:'tbl_tax/json_tax.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].tax_id == tax_id){        
          $("#txt_tax_title").val(data[index].tax_title);
          $("#txt_tax_description").val(data[index].tax_description);
          $("#txt_tax_date_from").val(data[index].tax_date_from);
          $("#txt_tax_date_to").val(data[index].tax_date_to);
          $("#txt_tax_amount_from").val(data[index].tax_amount_from);
          $("#txt_tax_amount_to").val(data[index].tax_amount_to);
          $("#txt_tax_additional").val(data[index].tax_additional);
          $("#txt_tax_percentage").val(data[index].tax_percentage);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function UpdateTax() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let tax_id = $("#btnUpdateData").val();
  let tax_title = $("#txt_tax_title").val();
  let tax_description = $("#txt_tax_description").val();
  let tax_date_from = $("#txt_tax_date_from").val();
  let tax_date_to = $("#txt_tax_date_to").val();
  let tax_amount_from = $("#txt_tax_amount_from").val();
  let tax_amount_to = $("#txt_tax_amount_to").val();
  let tax_additional = $("#txt_tax_additional").val();
  let tax_percentage = $("#txt_tax_percentage").val();

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
       let obj={"tax_id":tax_id,"tax_title":tax_title, "tax_description":tax_description, "tax_date_from":tax_date_from, "tax_date_to":tax_date_to,"tax_amount_from":tax_amount_from, "tax_amount_to":tax_amount_to, "tax_additional":tax_additional, "tax_percentage":tax_percentage};

        let parameter = JSON.stringify(obj); 
        
        Empty();
        $.ajax({url:'tbl_tax/update_tax.php?data='+parameter,
          method:'GET',
          success:function(data){
            if(data == true){
              ShowToast("bg-success", "Success", "Tax successfully updated.");
              $(".btnModalClose").click();
              $("#list_of_data").DataTable().ajax.reload();
            }
            else{
              ShowToast("bg-warning", "Warning", "Updating tax was failed, Please try again.");
              console.log(data);
            }
          },
          error:function(){
            ShowToast("bg-danger", "Danger", "Updating tax went something wrong, Please contact the System Administrator.");
          }
        });//end of ajax  
      
     }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(tax_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this tax?");
  $("#btnChangeStatus").val(tax_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let tax_id = $("#btnChangeStatus").val();

  let obj={"tax_id":tax_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_tax/update_tax_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Tax successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of tax status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of tax status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

<div class="modal fade" id="modalTaxManagement" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title tax_management_header" id="modalScrollableTitle"></h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Tax Title: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_tax_title">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Tax Description: (Optional) <span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_tax_description">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Date From: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_tax_date_from">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Date To: <span class="validation-area">*</span></label>
            <input type="date" class="form-control fields" id="txt_tax_date_to">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Amount From: <span class="validation-area">*</span></label>
            <div class="input-group">
              <span class="input-group-text">PHP</span>
              <input type="number" class="form-control fields" id="txt_tax_amount_from">
            </div>
          </div>
          <div class="col-lg-6">
            <label class="form-label">Amount To: <span class="validation-area">*</span></label>
            <div class="input-group">
              <span class="input-group-text">PHP</span>
              <input type="number" class="form-control fields" id="txt_tax_amount_to">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">Additional: <span class="validation-area">*</span></label>
            <div class="input-group">
              <span class="input-group-text">PHP</span>
              <input type="number" class="form-control fields" id="txt_tax_additional">
            </div>
          </div>
          <div class="col-lg-6">
            <label class="form-label">Percentage: <span class="validation-area">*</span></label>
            <div class="input-group">
              <input type="number" class="form-control fields" id="txt_tax_percentage">
              <span class="input-group-text">%</span>
            </div>
          </div>
        </div>        


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <div id="divButtonTaxManagement"></div>
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