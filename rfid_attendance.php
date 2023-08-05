<?php include("includes/header_rfid_attendance.php"); ?>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card mb-2">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <a class="app-brand-link gap-2">
                  <span class="app-brand-text demo text-body fw-bolder" style="text-transform: uppercase; color: black; text-align: center;">HUBSTOP-HRMS<br>
                    <span style="font-size: 14px;">Human Resources Management System</span>
                  </span>
                </a>
              </div>
              <h6 class="mb-2">Please scan your RFID for your attendance.</h6>
              <div class="row">
                <div class="col-lg-12">
                  <input type="text" class="form-control fields" id="txt_rfid" autofocus onkeypress="Check_RFID()" onkeyup="Check_RFID()">
                </div>
              </div>              
            </div>
          </div>

          <div class="card divInfo" style="display: none;">
            <div class="card-body">
              <div class="attendance_feedback" style="color: black; text-transform: uppercase;text-align:center;"></div>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

<script type="text/javascript">
// 34645436
function Check_RFID() {
  let rfid = $("#txt_rfid").val();

  if(rfid == ""){
    $(".divInfo").attr("style", "display:none;");
    $(".attendance_feedback").text("");
  }else{
    let user_type_id = "";
    let obj={"user_type_id":user_type_id};
    let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_person/json_person.php?data='+parameter,
      method:'GET',
      success:function(data){
        let exist = false;
        let name = "";
        let person_id = "";
        for(let index = 0; index < data.length; index++){
          if(data[index].person_rfid == rfid){        
            name = data[index].full_name;
            person_id = data[index].person_id;
            exist = true;
            break;
          }
        }

        if(exist){
          $(".divInfo").attr("style", "display:block;");          
          SaveAttendance(person_id);
        }else{
          $(".divInfo").attr("style", "display:none;");
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Please contact the System Administrator. Person");
      }
    });//end of ajax
  }
}

// 34645436 - applicant 1
// 34645431 - applicant 2
function SaveAttendance(person_id) {
  let obj={"person_id":person_id};
  let parameter = JSON.stringify(obj); 
  $.ajax({url:'tbl_attendance/create_attendance_rfid.php?data='+parameter,
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        let type = data[index].type;
        let date_and_time = data[index].date_and_time;
        let name = data[index].name;
        $(".attendance_feedback").text("");
        $(".attendance_feedback").append("<div class='row'><div class='col-lg-12'><h6>"+type+"</h6></div></div>");
        $(".attendance_feedback").append("<div class='row'><div class='col-lg-12'><h5>"+name+"</h5></div></div>");
        $(".attendance_feedback").append("<div class='row'><div class='col-lg-12'>"+date_and_time+"</div></div>"); 
        $("#txt_rfid").val("");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Registration went something wrong, Please contact the System Administrator. Attendance");
    }
  });//end of ajax  
  
}
</script>

<?php include("includes/main-footer_rfid_attendance.php"); ?>