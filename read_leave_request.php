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
          $(".page_name").text("Leave Request Management");          
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
                              <th style="width: 45%;">Leave Details</th> 
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
  let obj={"person_id":""};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_leave_request/json_leave_request_datatable.php?data="+parameter,
    "aoColumns": [
      { mData: 'number'},
      { mData: 'leave_request_details'},
      { mData: 'leave_request_created_at_by'},
      { mData: 'leave_request_status_description'},
      { mData: 'leave_request_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.leave_request_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
       
        let button_change_status = "";
        if(row.leave_request_status == "Pending" || row.leave_request_status == "Retrieved"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.leave_request_id+", \"Approved\", \"Approve\")'><i class='bx bx-refresh'></i> Approve Request</a>";
          button_change_status += "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.leave_request_id+", \"Denied\", \"Deny\")'><i class='bx bx-refresh'></i> Deny Request</a>";
        }else if(row.leave_request_status == "Approved"){
          button_change_status += "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.leave_request_id+", \"Denied\", \"Deny\")'><i class='bx bx-refresh'></i> Deny Request</a>";
        }
        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function


function btnViewDetails(leave_request_id) {
  ViewDetails(leave_request_id);
}

function ViewDetails(leave_request_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_leave_request/json_leave_request.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].leave_request_id == leave_request_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Category</div><div class='col-lg-7'>: "+data[index].leave_request_category+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'> Date</div><div class='col-lg-7'>: "+data[index].leave_request_date_from_description+" TO "+data[index].leave_request_date_to_description+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Remarks</div><div class='col-lg-7'>: "+data[index].leave_request_remarks+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>"+data[index].leave_request_status+" By</div><div class='col-lg-7'>: "+data[index].leave_request_approved_by_name+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>"+data[index].leave_request_status+" Date & Time</div><div class='col-lg-7'>: "+data[index].leave_request_approved_by_date_time+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].leave_request_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].leave_request_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].leave_request_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(leave_request_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this leave request?");
  $("#btnChangeStatus").val(leave_request_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let leave_request_id = $("#btnChangeStatus").val();

  let obj={"leave_request_id":leave_request_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_leave_request/update_leave_request_approval.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Leave request successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of leave request status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of leave request status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

</script>

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