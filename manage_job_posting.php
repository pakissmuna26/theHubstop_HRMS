<?php include("includes/header.php"); ?>
<?php 
$position = "";
if(isset($_GET['id'])){
    if($_GET['id'] == ""){
        header('Location:read_job_posting.php');
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
          $(".page_name").text("Manage Job Posting");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl container-p-y">
          <span class="contract_id" style="display: none;"></span>
          <div class="row">
            <div class="col-lg-12">
              <div class="accordion" id="accordion">
                <div class="card accordion-item mb-1">
                  <h2 class="accordion-header" id="heading">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionContractDetails" aria-expanded="false" aria-controls="accordionContractDetails">
                      Contract Details
                    </button>
                  </h2>
                  <div id="accordionContractDetails" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">  
                    <div class="accordion-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="divContractDetails"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12"><br>
                          <div class="divPayrollPeriod"></div>
                          <div class="divLeaveCredit"></div>
                          <div class="divBranchPerContract"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card accordion-item active">
                  <h2 class="accordion-header" id="heading">
                    <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionApplicants" aria-expanded="true"aria-controls="accordionApplicants">
                      Applicants
                    </button>
                  </h2>
                  <div id="accordionApplicants" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">        
                      <div class="row">
                        <div class="col-lg-12">
                          <!-- <div class="table-responsive text-nowrap"> -->
                           <table class="table" id="list_of_data">
                              <thead>
                                <tr>
                                  <th style="width: 5%">No.</th>
                                  <th style="width: 30%">Applicant Name</th> 
                                  <th style="width: 25%">Current Process</th> 
                                  <th style="width: 25%">Date & Time Created</th>
                                  <th style="width: 10%">Status</th>
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

              </div><!-- end of accordion -->
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
  let contract_id = $(".contract_id").text();
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 
  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_applicant_application/json_applicant_application_datatable_per_contract.php?data="+parameter,
    "aoColumns": [
      { mData: 'number'},
      { mData: 'applicant_details'},
      { mData: 'application_category'},
      { mData: 'application_created_at_by'},
      { mData: 'application_status_description'},
      { mData: 'applicant_application_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {

        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalApplicationHistory' onclick='btnApplicationHistory("+row.applicant_application_id+")'><i class='bx bx-list-ul'></i> Application History</a>";

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnApplicationHistory(applicant_application_id) {
  ApplicationHistory(applicant_application_id);
}

function ApplicationHistory(applicant_application_id){
  $(".tblApplicationHistory").text("");
  $.ajax({url:'tbl_application_history/json_application_history.php',
    method:'GET',
    success:function(data){
      $(".tblApplicationHistory").text("");
      $(".tblApplicationHistory").append("<tr><th>Process Category</th><th>Meeting Details</th><th>Date & Time Created</th><th>Status</th></tr>");
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_application_id == applicant_application_id){
          $(".tblApplicationHistory").append("<tr><td>"+data[index].history_category+"</td><td>"+data[index].history_details+"</td><td>"+data[index].application_history_created_at_by+"</td><td>"+data[index].application_history_status_description+"</td></tr>");

        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

Get_Job_Posting();
function Get_Job_Posting() {
  let contract_branch_id = "<?php echo $_GET['id']; ?>";
  $.ajax({url:'tbl_contract_branch/json_contract_branch.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_branch_id == contract_branch_id){
          let contract_id = data[index].contract_id;
          $(".contract_id").text(contract_id);
          Get_Contract_Details(contract_id);
          Read_Payroll_Period_Details(contract_id);
          Read_Leave_Credit_Details(contract_id);
          Read_Branch_Per_Contract_Details(contract_id);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function Get_Contract_Details(contract_id) {
  $(".divContractDetails").text("");
  $.ajax({url:'tbl_contract/json_contract.php',
    method:'GET',
    success:function(data){
      $(".divContractDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_id == contract_id){
          $(".divContractDetails").append("<div class='row'><div class='col-lg-12'><h6>"+data[index].contract_title+"</h6><span style='text-transform:uppercase;font-size:13px;'>"+data[index].contract_description+"</span></div></div>");

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

function Read_Payroll_Period_Details(contract_id){
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $(".divPayrollPeriod").text("");
  $.ajax({url:'tbl_contract_payroll_period/read_contract_payroll_period_with_deduction_benefits.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divPayrollPeriod").text("");
      $(".divPayrollPeriod").append(data);
      
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax   
}

function Read_Leave_Credit_Details(contract_id) {
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $(".divLeaveCredit").text("");
  $.ajax({url:'tbl_contract_leave_category/read_contract_leave_category_per_contract.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divLeaveCredit").text("");
      $(".divLeaveCredit").append(data);
      
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function Read_Branch_Per_Contract_Details(contract_id) {
  let obj={"contract_id":contract_id};
  let parameter = JSON.stringify(obj); 

  $(".divBranchPerContract").text("");
  $.ajax({url:'tbl_contract_branch/read_contract_branch_per_contract.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divBranchPerContract").text("");
      $(".divBranchPerContract").append(data);
      
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}
</script>

<div class="modal fade" id="modalApplicationHistory" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Application History</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <table class="table tblApplicationHistory"></table>
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