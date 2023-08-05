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
          $(".page_name").text("Generated Payroll Management");          
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
                              <th style="width: 40%">Payroll Details</th> 
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
    let obj={"person_id":""};
    let parameter = JSON.stringify(obj);

  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_payroll/json_payroll_datatable.php?data="+parameter,
    // dom: 'Bfrtip',
    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    "aoColumns": [
      { mData: 'number'},
      { mData: 'payroll_details'},
      { mData: 'payroll_created_at_by'},
      { mData: 'payroll_status_description'},
      { mData: 'payroll_id'}
    ],
    "columnDefs": [{
      "targets": 4,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.payroll_id+")'><i class='bx bx-list-ul'></i> View Details</a>";

        let button_view_payslip = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewPayslip' onclick='btnViewPayslip("+row.payroll_id+")'><i class='bx bx-list-ul'></i> View Payslip</a>";

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_view_payslip+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnViewDetails(payroll_id) {
  ViewDetails(payroll_id);
}

function ViewDetails(payroll_id){
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_payroll/json_payroll.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].payroll_id == payroll_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Name</div><div class='col-lg-7'>: "+data[index].payroll_person_name+"</div</div>");
          
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'>"+data[index].payroll_period_description+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Salary</div><div class='col-lg-7'>: PHP "+data[index].payroll_salary_description+"</div><div class='col-lg-5'>Absent Adjustment</div><div class='col-lg-7'>: PHP "+data[index].payroll_absent_adjustment_description+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Overtime</div><div class='col-lg-7'>: PHP "+data[index].payroll_overtime_description+"</div><div class='col-lg-5'>Non-Taxable Earnings</div><div class='col-lg-7'>: PHP "+data[index].payroll_non_taxable_earnings_description+"</div></div>");
          
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Deduction</div><div class='col-lg-7'>: PHP "+data[index].payroll_deductions_description+"</div><div class='col-lg-5'>Withholding Tax</div><div class='col-lg-7'>: PHP "+data[index].payroll_withholding_tax_description+"</div></div>");
          
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Net Pay</div><div class='col-lg-7'>: PHP "+data[index].payroll_net_pay_description+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].payroll_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].payroll_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].payroll_added_by_name+"</div></div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnViewPayslip(payroll_id) {
  var obj={"payroll_id":payroll_id};
  var parameter = JSON.stringify(obj); 

  $(".divViewPayslip").text("");
  $.ajax({url:'tbl_payroll/generate_payslip.php?data='+parameter,
      method:'GET',
    success:function(data){
      $(".divViewPayslip").append(data);
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Registration went something wrong, Please contact the System Administrator.");
    }
  });
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

<div class="modal fade" id="modalViewPayslip" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">View Payslip</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="divViewPayslip" style="text-transform: uppercase; font-size: 14px;"></div>
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