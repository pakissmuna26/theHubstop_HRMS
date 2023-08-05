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
          $(".page_name").text("Personnel Schedule");          
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
                    <?php 
                      date_default_timezone_set("Asia/Manila");
                      $dateToday = date("Y-m-d");
                      $dateAfterSevenDays = date("Y-m-d", strtotime($dateToday.'+6 days'));
                    ?>
                    <div class="col-lg-4">
                      <label class="form-label">Date From: <span class="validation-area">*</span></label>
                      <input type="date" class="form-control fields" id="txt_date_from" value="<?php echo $dateToday; ?>">
                    </div>
                    <div class="col-lg-4">
                      <label class="form-label">Date To: <span class="validation-area">*</span></label>
                      <input type="date" class="form-control fields" id="txt_date_to" value="<?php echo $dateAfterSevenDays; ?>">
                    </div>
                    <div class="col-lg-4">
                      <label class="form-label">Select Branch: <span class="validation-area">*</span></label>
                      <select class="form-control fields" id="select_branch"></select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <button type="button" id="btnGeneratePayroll" class="btn btn-success" onclick="Validate_Data()">Generate Schedule</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="divListOfSchedule"></div>
             
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
Get_Branch_Assigned();
function Get_Branch_Assigned() {
  $.ajax({url:"tbl_branch_person/json_branch_person_assigned.php",
    method:'GET',
    success:function(data){
      $("#select_branch").text("");
      let counter=0;
      for(let index = 0; index < data.length; index++){
          counter++;
          $("#select_branch").append("<option value='"+data[index].branch_id+"'>"+data[index].branch_name+"</option>");
      }
      if(counter == 0){
        $("#select_branch").append("<option value=''>No available branch</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
}

function Validate_Data(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let counter = 0;
    for(let index=0; index<all_Fields.length; index++){
      if(all_Fields[index].value == ""){
        validations[index].innerHTML = "* Field is required";
        counter++;
      }else{
        // validations[index].innerHTML = "*";
      }
    }
    if(counter == 0){
      Generate_Schedule();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function Generate_Schedule() {
  let date_from = $("#txt_date_from").val();
  let date_to = $("#txt_date_to").val();
  let branch_id = $("#select_branch").val();
  var obj={"date_from":date_from, "date_to":date_to, "branch_id":branch_id};
  var parameter = JSON.stringify(obj);  

  $(".divListOfSchedule").text("");
  $.ajax({url:"tbl_person_shifting_schedule/json_person_shifting_schedule_report.php?data="+parameter,
    method:'GET',
    success:function(data){
      $(".divListOfSchedule").text("");
      $(".divListOfSchedule").append(data);
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
}


</script>

<?php include("includes/main-footer.php"); ?>