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
          $(".page_name").text("Job Posting");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl container-p-y">
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-2">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>              
          <div class="divAvailableJobs"></div>
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
CheckApplicationStatus();
function CheckApplicationStatus() {
  $("#btnApplyNow").attr("disabled", true);
  $("#btnApplyNow").attr("onclick", "");
  let applicant_id = "<?php echo $_SESSION['person_id']; ?>";
  $.ajax({url:'tbl_applicant_application/json_applicant_application.php',
    method:'GET',
    success:function(data){
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_id == applicant_id &&
          data[index].application_contract_status == "Activated"){
          counter++;
        }
      }
      if(counter == 0){
        $("#btnApplyNow").attr("disabled", false);
        $("#btnApplyNow").attr("onclick", "ApplyNow()");
      }else{
        $("#btnApplyNow").attr("disabled", true);
        $("#btnApplyNow").attr("onclick", "");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

Read_Available_Jobs();
function Read_Available_Jobs() {
  let person_id = "<?php echo $_SESSION['person_id']; ?>";
  let obj={"person_id":person_id};
  let parameter = JSON.stringify(obj); 

  $(".divAvailableJobs").text("");
  $.ajax({url:'tbl_contract/read_contract_for_job_posting.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divAvailableJobs").text("");
      $(".divAvailableJobs").append(data);      
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnViewJobDetails(contract_id) {
  $(".divViewDetails").text("");
  $.ajax({url:'tbl_contract/json_contract.php',
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_id == contract_id){       
          $(".contract_id").text(contract_id);
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><h6>"+data[index].job_position_title+"</h6></div></div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'>"+data[index].job_position_description+"</div></div>");
          
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Rate (Monthly)</div><div class='col-lg-7'>: "+data[index].contract_rate_peso+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Application Period</div><div class='col-lg-7'>: "+data[index].contract_application_date_from_description+" TO "+data[index].contract_application_date_to_description+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Starting Date</div><div class='col-lg-7'>: "+data[index].contract_starting_date_description+"</div></div>");


          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax
}

function ApplyNow() {
  let applicant_id = "<?php echo $_SESSION['person_id']; ?>";
  let contract_id = $(".contract_id").text();
  let application_category = "Application Submitted";

  let obj={"applicant_id":applicant_id, "contract_id":contract_id, "application_category":application_category};
  let parameter = JSON.stringify(obj); 

  $.ajax({url:'tbl_applicant_application/create_applicant_application.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Job application successfully submitted.");
        
        $(".btnModalClose").click();
        Read_Available_Jobs();
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
            <span class="contract_id" style="display: none;"></span>
            <div class="divViewDetails" style="text-transform: uppercase; font-size: 14px;"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnApplyNow" class="btn btn-success">Apply Now</button>
      </div>
    </div>
  </div>
</div>

<?php include("includes/main-footer.php"); ?>