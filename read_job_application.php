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
          $(".page_name").text("Display Job Application");          
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
                              <th style="width: 5%">No.</th>
                              <th style="width: 20%">Applicant Name</th> 
                              <th style="width: 25%">Job Description</th> 
                              <th style="width: 20%">Scheduled Process</th> 
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
  let applicant_id = 0;
  let obj={"applicant_id":applicant_id};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_applicant_application/json_applicant_application_datatable.php?data="+parameter,
    // dom: 'Bfrtip',
    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    "aoColumns": [
      { mData: 'number'},
      { mData: 'applicant_details'},
      { mData: 'contract_details'},
      { mData: 'application_history'},
      { mData: 'application_created_at_by'},
      { mData: 'application_status_description'},
      { mData: 'applicant_application_id'}
    ],
    "columnDefs": [{
      "targets": 6,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_change_status = "";
        if(row.application_status == "Pending" || row.application_status == "Retrieved"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.applicant_application_id+", \"Accepted\", \"Accept\")'><i class='bx bx-refresh'></i> Accept Application</a><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.applicant_application_id+", \"Denied\", \"Deny\")'><i class='bx bx-refresh'></i> Deny Application</a>";
        }else if(row.application_status == "Denied"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.applicant_application_id+", \"Accepted\", \"Accept\")'><i class='bx bx-refresh'></i> Accept Application</a>";
        }else if(row.application_status == "Accepted"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.applicant_application_id+", \"Denied\", \"Deny\")'><i class='bx bx-refresh'></i> Deny Application</a>";
        }else if(row.application_status == "Deleted"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.applicant_application_id+", \"Retrieved\", \"Retrieve\")'><i class='bx bx-refresh'></i> Retrieve Application</a>";
        }

        let button_manage_job_application = "<a class='dropdown-item' href='manage_job_application.php?id="+row.applicant_application_id+"'><i class='bx bx-list-ul'></i>Manage Application <i class='bx bx-right-arrow-alt'></i></a>";
        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+" "+button_manage_job_application+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(applicant_application_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this application?");
  $("#btnChangeStatus").val(applicant_application_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let applicant_application_id = $("#btnChangeStatus").val();

  let obj={"applicant_application_id":applicant_application_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_applicant_application/update_applicant_application_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Application successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of application status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of application status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

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