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
          $(".page_name").text("My Profile");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl container-p-y">
          <div class="row">
            <div class="col-lg-12" style="text-transform: uppercase;font-size: 14px;">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <button type="button" class="btn btn-success float-right" data-bs-toggle='modal' data-bs-target='#modalChangePassword' onclick="btnChangePassword()">Change Password</button>
                      <button type="button" class="btn btn-success float-right mr-2" data-bs-toggle='modal' data-bs-target='#modalUpdateDetails' onclick="btnUpdateDetails()">Update Profile</button> 
                      <div class="divApplicantName float-left"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="divApplicantDetails"></div>
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
ApplicantDetails();
function ApplicantDetails(){
  let person_id = "<?php echo $_SESSION['person_id']; ?>";
  let user_type_id = 0;
  let obj={"user_type_id":user_type_id};
  let parameter = JSON.stringify(obj); 

  $(".divApplicantDetails").text("");
  $(".divApplicantName").text("");
  $.ajax({url:'tbl_person/json_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divApplicantDetails").text("");
      $(".divApplicantName").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].person_id == person_id){
          $(".divApplicantName").append("<div class='row'><div class='col-lg-12'><h6>"+data[index].full_name + "</h6></div></div>");
          $(".divApplicantName").append("<div class='row'><div class='col-lg-12'>"+data[index].address+ "</div></div>");
          
          $(".divApplicantDetails").append("<div class='row'><div class='col-lg-12'><br></div></div>");

          $(".divApplicantDetails").append("<div class='row'><div class='col-lg-6'><div class='row'><div class='col-lg-4'>Date of Birth</div><div class='col-lg-8'>: "+data[index].date_of_birth_description+"</div><div class='col-lg-4'>Sex</div><div class='col-lg-8'>: "+data[index].sex+"</div><div class='col-lg-4'>Civil Status</div><div class='col-lg-8'>: "+data[index].civil_status+"</div></div><div class='row'><div class='col-lg-4'>Religion</div><div class='col-lg-8'>: "+data[index].religion+"</div><div class='col-lg-4'>Nationality</div><div class='col-lg-8'>: "+data[index].nationality+"</div></div><div class='row'><div class='col-lg-4'>Height</div><div class='col-lg-8'>: "+data[index].height_with_unit+"</div><div class='col-lg-4'>Weight</div><div class='col-lg-8'>: "+data[index].weight_with_unit+"</div></div> <div class='row'><div class='col-lg-12'><br><h6>Contact Details</h6></div></div>  <div class='row'><div class='col-lg-4'>Email Address</div><div class='col-lg-8'>: "+data[index].email_address+"</div><div class='col-lg-4'>Contact Number</div><div class='col-lg-8'>: "+data[index].contact_number_full+"</div><div class='col-lg-4'>Telephone Number</div><div class='col-lg-8'>: "+data[index].telephone_number+"</div></div>   </div>   <div class='col-lg-6'><div class='row'><div class='col-lg-12'><h6>Family Information</h6></div></div> <div class='row'><div class='col-lg-5'>Spouse Name</div><div class='col-lg-7'>: "+data[index].spouse_name+"</div><div class='col-lg-5'>Spouse Occupation</div><div class='col-lg-7'>: "+data[index].spouse_occupation+"</div></div> <div class='row'><div class='col-lg-5'>Father Name</div><div class='col-lg-7'>: "+data[index].father_name+"</div><div class='col-lg-5'>Father Occupation</div><div class='col-lg-7'>: "+data[index].father_occupation+"</div></div> <div class='row'><div class='col-lg-5'>Mother Name</div><div class='col-lg-7'>: "+data[index].mother_name+"</div><div class='col-lg-5'>Mother Occupation</div><div class='col-lg-7'>: "+data[index].mother_occupation+"</div></div> <div class='row'><div class='col-lg-12'><br><h6>Emergency Contact Details</h6></div></div> <div class='row'><div class='col-lg-5'>FullName</div><div class='col-lg-7'>: "+data[index].person_emergency_contact+"</div><div class='col-lg-5'>Relationship</div><div class='col-lg-7'>: "+data[index].relations_to_person_emergency_contact+"</div><div class='col-lg-5'>Contact Number</div><div class='col-lg-7'>: "+data[index].person_emergency_contact_number_full+"</div></div>    </div>   </div>");
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}  
// ------------------------- UPDATE DETAILS ------------------------- //

function Empty(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");
  
  for(let index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    if(index!=1 && index!=3 && index!=18 && index!=19 && index!=20 && index!=21 && index!=22 && index!=23 && index!=24 && index!=25 && index!=26 && index!=27){
      validations[index].innerHTML = "*";
    }
  }
}

function Validate_Data(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let counter = 0;
    for(let index=0; index<all_Fields.length; index++){
      if(index!=1 && index!=3 && index!=18 && index!=19 && index!=20 && index!=21 && index!=22 && index!=23 && index!=24 && index!=25 && index!=26 && index!=27){
        if(all_Fields[index].value == ""){
          validations[index].innerHTML = "* Field is required";
          counter++;
        }else{
          // validations[index].innerHTML = "*";
        }
      }
    }
    if(counter == 0){
      let contact_number = $("#txt_contact_number").val();
      if(contact_number.length < 10 || contact_number.length > 10){
        validations[17].innerHTML = "* Enter the 10 digits number";
        ShowToast("bg-warning", "Warning", "Kindly check the contact number.");
      }else{
        validations[17].innerHTML = "*";
        let emergency_contact_number = $("#txt_emergency_contact_number").val();
        if(emergency_contact_number == ""){
          Submit();
        }else{
          if(emergency_contact_number.length < 10 || emergency_contact_number.length > 10){
            validations[27].innerHTML = "* Enter the 10 digits number";
            ShowToast("bg-warning", "Warning", "Kindly check the contact number.");
          }else{
            validations[27].innerHTML = "*";
            Submit();
          }
        }
        

      }
    }else{
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function Check_Email_Exist(){
  let email = $("#txt_email_user_name").val();
  let selected_person = $("#btnSubmitUpdateDetails").val();

  let obj={"user_type_id":0};
  let parameter = JSON.stringify(obj); 
  $.ajax({url:'tbl_person/json_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      let flag = false;
      for(let index = 0; index < data.length; index++){
        if(data[index].email_address == email && data[index].person_id != selected_person){
          flag = true;
          break
        }
      }

      if(flag){
       $(".error_email_user_name").text("* Email is already exist."); 
       ShowToast("bg-warning", "Warning", "Email is already exist.");
     }else{
      $(".error_email_user_name").text("*");
      Validate_Data();
     }
    }
  });
}

function btnUpdateDetails() {
  let user_type_id = 0;
  let person_id = "<?php echo $_SESSION['person_id']; ?>";
  let obj={"user_type_id":user_type_id};
  let parameter = JSON.stringify(obj); 

  $.ajax({url:'tbl_person/json_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].person_id == person_id){        
          $("#btnSubmitUpdateDetails").val(data[index].person_id);
          $("#txt_first_name").val(data[index].first_name);
          $("#txt_middle_name").val(data[index].middle_name);
          $("#txt_last_name").val(data[index].last_name);
          $("#select_affiliation").val(data[index].affiliation_name);
          $("#txt_date_of_birth").val(data[index].date_of_birth);
          $("#select_sex").val(data[index].sex);
          $("#select_civil_status").val(data[index].civil_status);
          $("#txt_religion").val(data[index].religion);
          $("#txt_nationality").val(data[index].nationality);
          $("#txt_height").val(data[index].height);
          $("#txt_weight").val(data[index].weight);
          $("#txt_house_number").val(data[index].house_number);
          $("#select_region").val(data[index].region);
          Choose_Province();
          $("#select_province").val(data[index].province);
          Choose_Municipality();
          $("#select_city").val(data[index].city);
          Choose_Barangay();
          $("#select_barangay").val(data[index].barangay);
          $("#txt_email_user_name").val(data[index].email_address);
          $("#txt_contact_number").val(data[index].contact_number);
          $("#txt_telephone_number").val(data[index].telephone_number);

          $("#txt_spouse_name").val(data[index].spouse_name);
          $("#txt_spouse_occupation").val(data[index].spouse_occupation);
          $("#txt_father_name").val(data[index].father_name);
          $("#txt_father_occupation").val(data[index].father_occupation);
          $("#txt_mother_name").val(data[index].mother_name);
          $("#txt_mother_occupation").val(data[index].mother_occupation);

          $("#txt_emergency_full_name").val(data[index].person_emergency_contact);
          $("#txt_emergency_relation").val(data[index].relations_to_person_emergency_contact);
          $("#txt_emergency_contact_number").val(data[index].person_emergency_contact_number);
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
}

function Submit(){
  let user_type = "<?php echo $_SESSION['user_type']; ?>";
  let person_id = $("#btnSubmitUpdateDetails").val();
  let obj={"person_id":person_id,
    "first_name":$("#txt_first_name").val(), 
    "middle_name":$("#txt_middle_name").val(), 
    "last_name":$("#txt_last_name").val(), 
    "affiliation_name":$("#select_affiliation").val(),
    "date_of_birth":$("#txt_date_of_birth").val(),
    "sex":$("#select_sex").val(), 
    "civil_status":$("#select_civil_status").val(), 
    "region_option":$("#select_region").val(), 
    "province_option":$("#select_province").val(), 
    "city_option":$("#select_city").val(), 
    "barangay_option":$("#select_barangay").val(), 
    "house_number":$("#txt_house_number").val(), 
    "email_address":$("#txt_email_user_name").val(), 
    "contact_number":$("#txt_contact_number").val(), 
    "telephone_number":$("#txt_telephone_number").val(), 
    "height":$("#txt_height").val(), 
    "weight":$("#txt_weight").val(), 
    "religion":$("#txt_religion").val(), 
    "nationality":$("#txt_nationality").val(), 
    "spouse_name":$("#txt_spouse_name").val(), 
    "spouse_occupation":$("#txt_spouse_occupation").val(), 
    "father_name":$("#txt_father_name").val(), 
    "father_occupation":$("#txt_father_occupation").val(), 
    "mother_name":$("#txt_mother_name").val(), 
    "mother_occupation":$("#txt_mother_occupation").val(), 
    "person_emergency_contact":$("#txt_emergency_full_name").val(), 
    "relations_to_person_emergency_contact":$("#txt_emergency_relation").val(), 
    "person_emergency_contact_number":$("#txt_emergency_contact_number").val(), 
    "user_type_id":user_type};
    
    let parameter = JSON.stringify(obj); 

    Empty(); 
    $.ajax({url:'tbl_person/update_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Profile successfully updated.");
        $(".btnModalClose").click();
        ApplicantDetails();
      }
      else{
        ShowToast("bg-warning", "Warning", "Updating of profile was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of profile went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}//end of function

function Empty_Password() {
  let all_Fields = document.getElementsByClassName("classPassword");
  let validations = document.getElementsByClassName("validation-area-password");
  
  for(let index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    validations[index].innerHTML = "*";
  }
}

function btnChangePassword() {
  Empty_Password();
}

function ValidatePassword() {
  let all_Fields = document.getElementsByClassName("classPassword");
  let validations = document.getElementsByClassName("validation-area-password");

  let counter=0;
  for(let index=0; index<all_Fields.length; index++){
    if(all_Fields[index].value == ""){
      validations[index].innerHTML = "* Field is required";
      counter++;
    }else{
      // validations[index].innerHTML = "*";
    }
  }
  if(counter == 0){
    let old_password = $("#txt_old_password").val();
    let txt_new_password = $("#txt_new_password").val();
    let txt_repeat_new_password = $("#txt_repeat_new_password").val();
    let person_id = "<?php echo $_SESSION['person_id']; ?>";

    let obj={"person_id":person_id, "old_password":old_password};
    let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_person/validate_person_password.php?data='+parameter,
      method:'GET',
      success:function(data){
        let match = false;
        for(let index = 0; index < data.length; index++){
          if(data[index].match == "Yes"){
            match = true;
            validations[0].innerHTML = "*";
            break;
          }else{
            ShowToast("bg-warning", "Warning", "Check the old password.");
            validations[0].innerHTML = "* Old password does not match with this account.";
            break;
          }
        }

        if(match){
          if(txt_new_password != txt_repeat_new_password){
            ShowToast("bg-warning", "Warning", "Check the new password & repeat new password.");
            validations[1].innerHTML = "* Password does not match";
            validations[2].innerHTML = "* Password does not match";
          }else{
            validations[1].innerHTML = "*";
            validations[2].innerHTML = "*";
            SaveNewPassword();
          }
        }

      }
    });
  }
}

function SaveNewPassword() {
  let password = $("#txt_new_password").val();
  let person_id = "<?php echo $_SESSION['person_id']; ?>";

  let obj={"person_id":person_id, "password":password};
  let parameter = JSON.stringify(obj); 
  Empty_Password(); 
    $.ajax({url:'tbl_person/update_person_reset_password.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Password successfully updated.");
        $(".btnModalClose").click();
      }
      else{
        ShowToast("bg-warning", "Warning", "Updating of password was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of password went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
</script>

<div class="modal fade" id="modalUpdateDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Update Profile</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <?php include("includes/form_information_registration.php"); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnSubmitUpdateDetails" class="btn btn-success" onclick="Check_Email_Exist()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalChangePassword" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Change Password</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label">Old Password: <span class="validation-area-password">*</span></label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="txt_old_password" class="form-control classPassword" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label">New Password: <span class="validation-area-password">*</span></label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="txt_new_password" class="form-control classPassword" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label">Repeat New Password: <span class="validation-area-password">*</span></label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="txt_repeat_new_password" class="form-control classPassword" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnChangePassword" class="btn btn-success" onclick="ValidatePassword()">Submit</button>
      </div>
    </div>
  </div>
</div>

<?php include("includes/main-footer.php"); ?>