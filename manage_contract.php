<?php include("includes/header.php"); ?>
<?php 
$position = "";
if(isset($_GET['id'])){
    if($_GET['id'] == ""){
        header('Location:read_branch.php');
    }else{ 
    }
}else{
    header('Location:dashboard.php');
}
?>
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
          $(".page_name").text("Manage Contract");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl container-p-y">
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-1">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="divContractDetails"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mb-1">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <h6 class="float-left">Benefits and Deduction Management</h6>
                    </div>
                    <div class="col-lg-6">
                      <button type="button" class="btn btn-outline-success float-right" data-bs-toggle='modal' data-bs-target='#modalAddNewPayrollPeriod' onclick="btnAddNewPayrollPeriod()">Add New Payroll Period</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      Note: Click the 
                      <i class='bx bx-check-square' style='color:green;'></i>
                      or 
                      <i class='bx bx-window-close' style='color:red;'></i> 
                      to change the status of the benefits or deduction per payroll period.
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th style="width: 5%;">No.</th>
                              <th style="width: 20%;">Payroll Period</th>
                              <th style="width: 25%;">Benefits</th>
                              <th style="width: 25%;">Deduction</th>
                              <th style="width: 20%;">Date & Time Created</th>
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

              <div class="card mb-1">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                    <h6 class="float-left">Leave Credit Management</h6>  
                    <button type="button" class="btn btn-outline-success float-right" data-bs-toggle='modal' data-bs-target='#modalAddNewLeaveCredit' onclick="btnAddNewLeaveCredit()">Add New Leave Credit</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data_leave_credit">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Leave Credit</th>
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

              <div class="card mb-1">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                    <h6 class="float-left">Branch Management</h6>  
                    <button type="button" class="btn btn-outline-success float-right" data-bs-toggle='modal' data-bs-target='#modalAddNewBranch' onclick="btnAddNewBranch()">Add New Branch</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data_job_posting">
                          <thead>
                            <tr>
                              <th style="width: 5%;">No.</th>
                              <th style="width: 20%;">Branch Details</th>
                              <th style="width: 20%;">Branch HR Staff</th>
                              <th style="width: 15%;">Date & Time Created</th>
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
  ListOfDataLeaveCredit();
  ListOfDataJobPosting();
});

function ListOfData(){
  let contract_id = "<?php echo $_GET['id']; ?>";
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_contract_payroll_period/json_contract_payroll_period_datatable.php?data="+parameter,
    "aoColumns": [
      { mData: 'number'},
      { mData: 'payroll_period_details'},
      { mData: 'list_of_benefits'},
      { mData: 'list_of_deduction'},
      { mData: 'contract_payroll_period_created_at_by'},
      { mData: 'contract_payroll_period_status_description'},
      { mData: 'contract_payroll_period_id'}
    ],
    "columnDefs": [{
      "targets": 6,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {

        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalAddNewBenefitsAndDeduction' onclick='btnAddNewBenefitsAndDeduction("+row.contract_payroll_period_id+","+row.payroll_period_id+")'><i class='bx bx-plus'></i> Add Benefits & Deduction</a>";

        let button_change_status = "";
        if(row.contract_payroll_period_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.contract_payroll_period_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Payroll</a>";
        }else if(row.contract_payroll_period_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.contract_payroll_period_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Payroll</a>";
        }

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

let contract_id = "<?php echo $_GET['id']; ?>";
ViewDetails(contract_id);
function ViewDetails(contract_id){
  $(".divContractDetails").text("");
  $.ajax({url:'tbl_contract/json_contract.php',
    method:'GET',
    success:function(data){
      $(".divContractDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_id == contract_id){
          $(".divContractDetails").append("<div class='row'><div class='col-lg-12'><h5>"+data[index].contract_title+"</h5><span style='text-transform:uppercase;font-size:13px;'>"+data[index].contract_description+"</span></div></div>");

          $(".divContractDetails").append("<div class='row'><div class='col-lg-5'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Application Period:</b> "+data[index].contract_application_date_from_description+" TO "+data[index].contract_application_date_to_description+"<br><b>Starting Date:</b> "+data[index].contract_starting_date_description+"</span></div><div class='col-lg-3'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Job Position:</b> "+data[index].job_position_title+"<br><b>Rate (Monthly):</b> "+data[index].contract_rate_peso+"</span></div><div class='col-lg-4'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Shifting Schedule:</b> "+data[index].shifting_schedule+"<br><b>Shift Break:</b> "+data[index].break_schedule+"</span></div></div>");      
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}


function btnAddNewBenefitsAndDeduction(contract_payroll_period_id, payroll_period_id) {
  $(".contract_payroll_period_id").text(contract_payroll_period_id);
  Get_Benefits_ComboBox(contract_payroll_period_id);
  Get_Deduction_ComboBox(contract_payroll_period_id);
}

function btnAddNewPayrollPeriod() {
  Get_Payroll_Period();
}

function Get_Payroll_Period() {
  $.ajax({url:"tbl_payroll_period/json_payroll_period.php",
    method:'GET',
    success:function(data){
      $("#select_payroll_period").text("");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].payroll_period_status == "Activated"){
          counter++;
          $("#select_payroll_period").append("<option value='"+data[index].payroll_period_id+"'>"+data[index].payroll_period_title+"</option>");
        }
      }
      if(counter == 0){
        $("#select_payroll_period").append("<option value=''>No available payroll period</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
} 

function Get_Payroll_Period_Details() {
  let payroll_period_id = $("#select_payroll_period").val();
  $.ajax({url:"tbl_payroll_period/json_payroll_period.php",
    method:'GET',
    success:function(data){
      $(".divPayrollPeriodDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].payroll_period_id == payroll_period_id){
          $(".divPayrollPeriodDetails").append("<div class='row'><div class='col-lg-5'>Payroll Period Title</div><div class='col-lg-7'>: "+data[index].payroll_period_title+"</div>");
          $(".divPayrollPeriodDetails").append("<div class='row'><div class='col-lg-5'>Payroll Period</div><div class='col-lg-7'>: "+data[index].payroll_period_from+" TO "+data[index].payroll_period_to+"</div>");
          $(".divPayrollPeriodDetails").append("<div class='row'><div class='col-lg-5'>Cut-off</div><div class='col-lg-7'>: "+data[index].payroll_period_cutoff_from+" TO "+data[index].payroll_period_cutoff_to+"</div>");
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
} 

function Get_Benefits_ComboBox(payroll_period_benefits_deduction_id) {
  let contract_id = "<?php echo $_GET['id']; ?>";
  let obj={"payroll_period_benefits_deduction_id":payroll_period_benefits_deduction_id};
  let parameter = JSON.stringify(obj); 

  $.ajax({url:"tbl_benefits_category/json_benefits_category_per_contract.php?data="+parameter,
    method:'GET',
    success:function(data){
      $(".tblListOfBenefits").text("");
      $(".tblListOfBenefits").append("<thead><tr><th style='width:5%'>Action</th><th style='width:40%'>Benefits Details</th><th style='width:30%'>Amount</th></tr></thead>");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].benefits_category_status == "Activated"){
          counter++;
          $(".tblListOfBenefits").append("<tr><td style='text-align:center;'><input class='form-check-input chkBenefits' type='checkbox' value='"+data[index].benefits_category_id+"'></td><td>"+data[index].benefits_category_title+"</td><td> "+data[index].benefits_category_amount_display+"</td></tr>");
        }
      }
      if(counter == 0){
        $(".tblListOfBenefits").append("No available benefits");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
} 

function Get_Deduction_ComboBox(payroll_period_benefits_deduction_id) {
  let contract_id = "<?php echo $_GET['id']; ?>";
  let obj={"payroll_period_benefits_deduction_id":payroll_period_benefits_deduction_id};
  let parameter = JSON.stringify(obj); 

  $.ajax({url:"tbl_deduction_category/json_deduction_category_per_contract.php?data="+parameter,
    method:'GET',
    success:function(data){
      $(".tblListOfDeduction").text("");
      $(".tblListOfDeduction").append("<thead><tr><th style='width:5%'>Action</th><th style='width:40%'>Deduction Details</th><th style='width:40%'>Deduction Share</th></tr></thead>");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].deduction_category_status == "Activated"){
          counter++;
          $(".tblListOfDeduction").append("<tr><td style='text-align:center;'><input class='form-check-input chkDeduction' type='checkbox' value='"+data[index].deduction_category_id+"'></td><td>"+data[index].deduction_category_title+"</td><td>"+data[index].share+"</td></tr>");
        }
      }
      if(counter == 0){
        $(".tblListOfDeduction").append("No available benefits");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
} 

function SavePayrollPeriod() {
  let contract_id = "<?php echo $_GET['id']; ?>";
  let payroll_period_id = $("#select_payroll_period").val();

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

  if(counter != 0){

  }else{    
    let obj={"contract_id":contract_id, 
    "payroll_period_id":payroll_period_id};
    let parameter = JSON.stringify(obj); 

    $("#select_payroll_period").text("");
    $(".divPayrollPeriodDetails").text("");
    $.ajax({url:'tbl_contract_payroll_period/create_contract_payroll_period.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Payroll period successfully saved.");
          $(".btnModalClose").click();
          $("#list_of_data").DataTable().ajax.reload();
        }
        else{
          ShowToast("bg-warning", "Warning", data);
          console.log(data);
          Get_Payroll_Period();
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Registration went something wrong, Please contact the System Administrator.");
      }
    });//end of ajax  
  }
}

function SaveBenefitsAndDeduction() {
  let contract_payroll_period_id = $(".contract_payroll_period_id").text();

  let objBenefits = [];
  let benefits_counter=0; 
  let chkBenefits=document.getElementsByClassName("chkBenefits");
  for(let index_benefits=0; index_benefits<chkBenefits.length; index_benefits++){
    if(chkBenefits[index_benefits].checked == true){
      objBenefits.push(chkBenefits[index_benefits].value);
      benefits_counter++;
    }
  }
  
  let objDeduction = [];
  let deduction_counter=0;
  let chkDeduction=document.getElementsByClassName("chkDeduction");
  for(let index_benefits=0; index_benefits<chkDeduction.length; index_benefits++){
    if(chkDeduction[index_benefits].checked == true){
      objDeduction.push(chkDeduction[index_benefits].value);
      deduction_counter++;
    }
  }
  
  if(benefits_counter == 0 && deduction_counter == 0 ){
    ShowToast("bg-warning", "Warning", "Please select atleast one among the list of benefits or list of deduction");
  }else{
    let obj={"contract_payroll_period_id":contract_payroll_period_id};
    let parameter = JSON.stringify(obj); 

    let parameter_benefits = JSON.stringify(objBenefits); 
    let parameter_deduction = JSON.stringify(objDeduction); 

    // Empty(); 
    $(".divPayrollPeriodDetails").text("");
    $.ajax({url:'tbl_payroll_period_benefits_deduction/create_payroll_period_benefits_deduction.php?data='+parameter+"&data_benefits="+parameter_benefits+"&data_deduction="+parameter_deduction,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Benefits or deduction successfully saved.");
          
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

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(contract_payroll_period_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this contract payroll?");
  $("#btnChangeStatus").val(contract_payroll_period_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let contract_payroll_period_id = $("#btnChangeStatus").val();

  let obj={"contract_payroll_period_id":contract_payroll_period_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_contract_payroll_period/update_contract_payroll_period_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Contract payroll category successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of contract payroll status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of contract payroll status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //


// ------------------------- CHANGE STATUS BENEFITS AND DEDUCTION ------------------------- //
function btnChangeStatusBenefitsAndDeduction(payroll_period_benefits_deduction_id, past_tense_status, present_tense_status) {
  $(".past_tense_status_benefits_deduction").text(past_tense_status);
  $(".present_tense_status_benefits_deduction").text(present_tense_status);
  $(".message_benefits_deduction").text("");
  $(".message_benefits_deduction").append("Are you sure you want to <b>"+present_tense_status+"</b> this?");
  $("#btnChangeStatus_benefits_deduction").val(payroll_period_benefits_deduction_id);
}

function SaveChangeStatusBenefitsDeduction() {
  let past_tense_status = $(".past_tense_status_benefits_deduction").text();
  let present_tense_status = $(".present_tense_status_benefits_deduction").text();
  let payroll_period_benefits_deduction_id = $("#btnChangeStatus_benefits_deduction").val();

  let obj={"payroll_period_benefits_deduction_id":payroll_period_benefits_deduction_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_payroll_period_benefits_deduction/update_payroll_period_benefits_deduction_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Benefits or deduction successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of benefits or deduction status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of benefits or deduction status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

// ------------------------- LEAVE CREDIT ------------------------- //
function ListOfDataLeaveCredit(){
  let contract_id = "<?php echo $_GET['id']; ?>";
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data_leave_credit').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_contract_leave_category/json_contract_leave_category_datatable.php?data="+parameter,
    "aoColumns": [
      { mData: 'number'},
      { mData: 'leave_category_description'},
      { mData: 'contract_category_credit_created_at_by'},      
      { mData: 'contract_category_credit_status_description'},
      { mData: 'contract_category_credit_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {

        let button_change_status = "";
        if(row.contract_category_credit_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatusLeaveCredit' onclick='btnChangeStatusLeaveCredit("+row.contract_category_credit_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Leave Credit</a>";
        }else if(row.contract_category_credit_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatusLeaveCredit' onclick='btnChangeStatusLeaveCredit("+row.contract_category_credit_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Leave Credit</a>";
        }

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function
// ------------------------- END OF LEAVE CREDIT ------------------------- //
function btnAddNewLeaveCredit() {
  let contract_id = "<?php echo $_GET['id']; ?>";
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $.ajax({url:"tbl_leave_category/json_leave_category_per_contract.php?data="+parameter,
    method:'GET',
    success:function(data){
      $(".tblListOfLeaveCredit").text("");
      $(".tblListOfLeaveCredit").append("<thead><tr><th style='width:5%'>Action</th><th style='width:40%'>Leave Details</th><th style='width:30%'>Total Leave</th><th style='width:30%'>Paid Leave</th></tr></thead>");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].leave_category_status == "Activated"){
          counter++;
          $(".tblListOfLeaveCredit").append("<tr><td style='text-align:center;'><input class='form-check-input chkLeaveCategory' type='checkbox' value='"+data[index].leave_category_id+"'></td><td>"+data[index].leave_category_title+"</td><td>"+data[index].leave_category_quantity+"</td><td>"+data[index].leave_category_paid_quantity+"</tr></tr>");
        }
      }
      if(counter == 0){
        $(".tblListOfLeaveCredit").append("No available leave category");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
}

function SaveLeaveCredit() {
  let contract_id = "<?php echo $_GET['id']; ?>";

  let objLeaveCredits = [];
  let leave_counter=0; 
  let chkLeaveCategory=document.getElementsByClassName("chkLeaveCategory");
  for(let index_leave=0; index_leave<chkLeaveCategory.length; index_leave++){
    if(chkLeaveCategory[index_leave].checked == true){
      objLeaveCredits.push(chkLeaveCategory[index_leave].value);
      leave_counter++;
    }
  }
  
  if(leave_counter == 0 ){
    ShowToast("bg-warning", "Warning", "Please select atleast one among the list of leave category");
  }else{
    let obj={"contract_id":contract_id};
    let parameter = JSON.stringify(obj); 
    let parameter_leave = JSON.stringify(objLeaveCredits); 
     
    $(".divPayrollPeriodDetails").text("");
    $.ajax({url:'tbl_contract_leave_category/create_contract_leave_category.php?data='+parameter+"&data_leave="+parameter_leave,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Leave credit successfully saved.");
          
          $(".btnModalClose").click();
          $("#list_of_data_leave_credit").DataTable().ajax.reload();
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

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatusLeaveCredit(contract_category_credit_id, past_tense_status, present_tense_status) {
  $(".past_tense_status_leave_credit").text(past_tense_status);
  $(".present_tense_status_leave_credit").text(present_tense_status);
  $(".message_leave_credit").text("");
  $(".message_leave_credit").append("Are you sure you want to <b>"+present_tense_status+"</b> this leave credit?");
  $("#btnChangeStatus_leave_credit").val(contract_category_credit_id);
}

function SaveChangeStatusLeaveCredit() {
  let past_tense_status = $(".past_tense_status_leave_credit").text();
  let present_tense_status = $(".present_tense_status_leave_credit").text();
  let contract_category_credit_id = $("#btnChangeStatus_leave_credit").val();

  let obj={"contract_category_credit_id":contract_category_credit_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_contract_leave_category/update_contract_leave_category_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Contract leave credit successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data_leave_credit").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of contract leave credit status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of contract leave credit status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

function btnAddNewBranch() {
  Get_List_of_Branch();
}

function Get_List_of_Branch() {
  let contract_id = "<?php echo $_GET['id']; ?>";
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $.ajax({url:"tbl_branch/json_branch_create_job_posting.php?data="+parameter,
    method:'GET',
    success:function(data){
      $(".tblListOfBranch").text("");
      $(".tblListOfBranch").append("<thead><tr><th style='width:5%'>Action</th><th style='width:60%'>Branch Details</th><th style='width:45%'>Branch HR Staff</th></tr></thead>");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].branch_status == "Activated"){
          counter++;
          $(".tblListOfBranch").append("<tr><td style='text-align:center;'><input class='form-check-input chkBranch' type='checkbox' value='"+data[index].branch_id+"'></td><td>"+data[index].branch_name+"<br>Address: "+data[index].branch_address+", "+data[index].address+"<br>Contact #:"+data[index].branch_contact_number_full+"</td><td>"+data[index].branch_hr_staff+"</td></tr>");
        }
      }
      if(counter == 0){
        $(".tblListOfBranch").append("<tr><td colspan='5'>No available branch / all branches has been added to this job posting</td></tr>");
        $("#btnSubmitContractBranch").attr("style", "display:none;");
      }else{
        $("#btnSubmitContractBranch").attr("style", "display:block;");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
  
} 

function SaveContractBranch() {
  let contract_id = "<?php echo $_GET['id']; ?>";

  let objContractBranch = [];
  let branch_counter=0; 
  let chkBranch=document.getElementsByClassName("chkBranch");
  for(let index_leave=0; index_leave<chkBranch.length; index_leave++){
    if(chkBranch[index_leave].checked == true){
      objContractBranch.push(chkBranch[index_leave].value);
      branch_counter++;
    }
  }
  
  if(branch_counter == 0 ){
    ShowToast("bg-warning", "Warning", "Please select atleast one among the list of branch");
  }else{
    let obj={"contract_id":contract_id};
    let parameter = JSON.stringify(obj); 
    let parameter_leave = JSON.stringify(objContractBranch); 
     
    $.ajax({url:'tbl_contract_branch/create_contract_branch.php?data='+parameter+"&data_branch="+parameter_leave,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Branch successfully saved.");          
          $(".btnModalClose").click();
          $("#list_of_data_job_posting").DataTable().ajax.reload();
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

function ListOfDataJobPosting(){
  let contract_id = "<?php echo $_GET['id']; ?>";
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data_job_posting').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_contract_branch/json_contract_branch_datatable_per_contract.php?data="+parameter,
    "aoColumns": [
      { mData: 'number'},
      { mData: 'branch_details'},
      { mData: 'branch_hr_staff'},
      { mData: 'contract_branch_created_at_by'},      
      { mData: 'contract_branch_status_description'},
      { mData: 'contract_branch_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {

        let button_change_status = "";
        if(row.contract_branch_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatusJobPosting' onclick='btnChangeStatusJobPosting("+row.contract_branch_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Job Posting</a>";
        }else if(row.contract_branch_status == "Deactivated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatusJobPosting' onclick='btnChangeStatusJobPosting("+row.contract_branch_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Job Posting</a>";
        }

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatusJobPosting(contract_branch_id, past_tense_status, present_tense_status) {
  $(".past_tense_status_job_posting").text(past_tense_status);
  $(".present_tense_status_job_posting").text(present_tense_status);
  $(".message_job_posting").text("");
  $(".message_job_posting").append("Are you sure you want to <b>"+present_tense_status+"</b> this job posting?");
  $("#btnChangeStatusJobPosting").val(contract_branch_id);
}

function SaveChangeStatusJobPosting() {
  let past_tense_status = $(".past_tense_status_job_posting").text();
  let present_tense_status = $(".present_tense_status_job_posting").text();
  let contract_branch_id = $("#btnChangeStatusJobPosting").val();

  let obj={"contract_branch_id":contract_branch_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_contract_branch/update_contract_branch_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Job posting successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data_job_posting").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of job posting status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of job posting status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>


<div class="modal fade" id="modalAddNewPayrollPeriod" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Add New Payroll</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Select Payroll Period: <span class="validation-area">*</span></label>
            <select class="form-control fields" id="select_payroll_period" onclick="Get_Payroll_Period_Details()" onchange="Get_Payroll_Period_Details()"></select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12"><br>
            <h6>Payroll Details</h6>
            <div class="divPayrollPeriodDetails"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnSubmit" class="btn btn-success" onclick="SavePayrollPeriod()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAddNewBenefitsAndDeduction" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Add New Benefits & Deduction</h5>      
      </div>
      <div class="modal-body">
        <span class="contract_payroll_period_id" style="display: none;;"></span>
        <div class="row">
          <div class="col-lg-12">
            <h6>List of Benefits</h6>
            <table class="table tblListOfBenefits"></table>
            <!-- <ul class="ulListOfBenefits"></ul> -->
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <h6>List of Deduction</h6>
            <table class="table tblListOfDeduction"></table>
            <!-- <ul class="ulListOfDeduction"></ul> -->
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnSubmit" class="btn btn-success" onclick="SaveBenefitsAndDeduction()">Submit</button>
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

<div class="modal fade" id="modalUpdateBenefitsAndDeduction" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Update Benefits & Deduction</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12"><br>
            <!-- <div class="table-responsive text-nowrap"> -->
             <table class="table" id="list_of_data_benefits_deduction">
                <thead>
                  <tr>
                    <th>Benefits or Deduction Details</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            <!-- </div> -->
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalChangeStatusBenefitsAndDeduction" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Change Status</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <span class="past_tense_status_benefits_deduction" style="display: none;"></span>
            <span class="present_tense_status_benefits_deduction" style="display: none;"></span>
            <p class="message_benefits_deduction" style="font-size: 18px;"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnChangeStatus_benefits_deduction" class="btn btn-success" onclick="SaveChangeStatusBenefitsDeduction()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAddNewLeaveCredit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Add New Leave Credit</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <h6>List of Leave Credit</h6>
            <table class="table tblListOfLeaveCredit"></table>
            <!-- <ul class="ulListOfLeaveCredit"></ul> -->
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnSubmit" class="btn btn-success" onclick="SaveLeaveCredit()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalChangeStatusLeaveCredit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Change Status</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <span class="past_tense_status_leave_credit" style="display: none;"></span>
            <span class="present_tense_status_leave_credit" style="display: none;"></span>
            <p class="message_leave_credit" style="font-size: 18px;"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnChangeStatus_leave_credit" class="btn btn-success" onclick="SaveChangeStatusLeaveCredit()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAddNewBranch" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Add New Branch</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <h6>List of Branch</h6>
            <table class="table tblListOfBranch"></table>            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnSubmitContractBranch" class="btn btn-success" onclick="SaveContractBranch()" style="display: none;">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalChangeStatusJobPosting" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Change Status</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <span class="past_tense_status_job_posting" style="display: none;"></span>
            <span class="present_tense_status_job_posting" style="display: none;"></span>
            <p class="message_job_posting" style="font-size: 18px;"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnChangeStatusJobPosting" class="btn btn-success" onclick="SaveChangeStatusJobPosting()">Submit</button>
      </div>
    </div>
  </div>
</div>
<?php include("includes/main-footer.php"); ?>