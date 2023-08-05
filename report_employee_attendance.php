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
          $(".page_name").text("Employee Attendance Report");          
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
                    <div class="col-lg-4">
                      <label class="form-label">Date From: <span class="validation-area">*</span></label>
                      <input type="date" class="form-control fields" id="txt_date_from" value="2023-06-01">
                    </div>
                    <div class="col-lg-4">
                      <label class="form-label">Date To: <span class="validation-area">*</span></label>
                      <input type="date" class="form-control fields" id="txt_date_to" value="2023-06-30">
                    </div>
                    <div class="col-lg-4">
                      <label class="form-label">Select Personnel: <span class="validation-area">*</span></label>
                      <select class="form-control fields" id="select_personnel"></select>
                    </div>
                  </div>
                  <div class="row">              
                    <div class="col-lg-4">
                      <button type="button" id="btnGenerateReport" class="btn btn-success" onclick="Validate_Data()">Generate Report</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>            
          </div>

          <div class="divListOfAttendance" style="font-size: 12px;text-transform: uppercase;"></div>
                    
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
Get_Personnel();
function Get_Personnel(){
  $("#select_personnel").text("");
  $.ajax({url:'tbl_person/json_person_assigned_per_branch.php',
    method:'GET',
    success:function(data){
      $("#select_personnel").text("");
      $("#select_personnel").append("<option value=''>Please select personnel</option>");
      let counter = 0;
      for(let index = 0; index < data.length; index++){
        counter++;
        $("#select_personnel").append("<option value='"+data[index].person_id+"'>"+data[index].full_name+"</option>");
      }

      if(counter == 0){
        $("#select_personnel").append("<option value=''>No available personnel.</option>");
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

  var counter = 0;
    for(var index=0; index<all_Fields.length; index++){    
      if(all_Fields[index].value == ""){
        validations[index].innerHTML = "* Field is required";
        counter++;
      }else{
        validations[index].innerHTML = "*";
      }    
    }
    if(counter == 0){
      Generate_Report();
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function Generate_Report() {
  Get_Daily_Attendance_Report();
}

function Get_Daily_Attendance_Report(){
  let date_from = $("#txt_date_from").val();
  let date_to = $("#txt_date_to").val();
  let personnel = $("#select_personnel").val();

  var obj={"date_from":date_from, "date_to":date_to, "personnel":personnel};
  var parameter = JSON.stringify(obj); 

  $(".divListOfAttendance").text("");
  $.ajax({url:'tbl_attendance/json_attendance_report.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divListOfAttendance").append(data);
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}
</script>

<?php include("includes/main-footer.php"); ?>

<!-- 
Before Break: Early In & Early Out | After Break: No Attendance
Before Break: On Time & Half Day | After Break: No Attendance
Before Break: Late & Half Day | After Break: No Attendance
Before Break: On Time | After Break: Early Out
Before Break: Late | After Break: Early Out
Before Break: On Time | After Break: On Time
Before Break: Late | After Break: On Time
Before Break: On Time | After Break: Overtime
Before Break: Late | After Break: Overtime
Break Time
Before Break: No Attendance | After Break: Early Out
Before Break: No Attendance | After Break: On Time
Before Break: No Attendance | After Break: Overtime
Before Break: Early In | After Break: Overtime
Before Break: Early In | After Break: Early Out
Before Break: Early In | After Break: On Time
Before Break: Not Valid | After Break: Not Valid
 -->