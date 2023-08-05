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
          $(".page_name").text("Attendance Management");          
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
  let obj={"attendance_category":""};
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
        
        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function


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
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Type</div><div class='col-lg-7'>: "+data[index].attendance_type+"</div>");

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

function ViewShiftDetails(details) {
  $(".divViewShiftDetails").text("");
  $(".divViewShiftDetails").append(details);
}
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

