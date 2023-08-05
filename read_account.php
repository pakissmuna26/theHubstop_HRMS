<?php include("includes/header.php"); ?>
<?php 
$position = "";
if(isset($_GET['id'])){
    if($_GET['id'] == ""){
        header('Location:dashboard.php');
    }else{
        $id = $_GET['id'];
        if($id == 1){
            $position = "Administrator";
        }else if($id == 2){
            $position = "HR Staff";
        }else if($id == 3){
            $position = "Employee";
        }else{
            header('Location:dashboard.php');
        }
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
          $(".page_name").text("Display <?php echo $position; ?> Account");          
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
                              <th>No.</th>
                              <th>Name</th> 
                              <th>RFID</th> 
                              <th>Address</th>  
                              <th>Status</th> 
                              <th>Action</th>
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
  let user_type_id = "<?php echo $_GET['id']; ?>";
  let obj={"user_type_id":user_type_id};
  let parameter = JSON.stringify(obj); 
  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_person/json_person_datatable.php?data="+parameter,
    "aoColumns": [
      { mData: 'number'},
      { mData: 'full_name'},
      { mData: 'person_rfid'},
      { mData: 'address'},
      { mData: 'person_status_description'},
      { mData: 'person_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_view_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalViewDetails' onclick='btnViewDetails("+row.person_id+")'><i class='bx bx-list-ul'></i> View Details</a>";
        let button_update_details = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalUpdateDetails' onclick='btnUpdateDetails("+row.person_id+")'><i class='bx bx-edit'></i> Update Details</a>";
        let button_change_status = "";
        if(row.person_status == "Activated"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.person_id+", \"Deactivated\", \"Deactivate\")'><i class='bx bx-refresh'></i> Deactivate Account</a>";
        }else if(row.person_status == "Deactivated" || row.person_status == "Registration"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.person_id+", \"Activated\", \"Activate\")'><i class='bx bx-refresh'></i> Activate Account</a>";
        }
        let button_reset_password = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalResetPassword' onclick='btnResetPassword("+row.person_id+")'><i class='bx bx-lock'></i> Reset Password</a>";

        let btn_rfid = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalUpdateRFID' onclick='btnRFID("+row.person_id+")'><i class='bx bx-barcode'></i> Update RFID</a>";

        let button_manage_job_application = "<a class='dropdown-item' href='manage_personnel_portfolio.php?id="+row.user_type+"&applicant_id="+row.person_id+"'><i class='bx bx-list-ul'></i> Manage Portfolio <i class='bx bx-right-arrow-alt'></i></a>";

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_view_details+" "+button_update_details+" "+button_change_status+" "+button_reset_password+" "+btn_rfid+" "+button_manage_job_application+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

function btnViewDetails(person_id) {
  ViewDetails(person_id);
}

function ViewDetails(person_id){
  let user_type_id = "<?php echo $_GET['id']; ?>";
  let obj={"user_type_id":user_type_id};
  let parameter = JSON.stringify(obj); 

  $(".divViewDetails").text("");
  $.ajax({url:'tbl_person/json_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divViewDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].person_id == person_id){
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><h6>"+data[index].full_name + "</h6></div></div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12' style='font-size:14px;'>"+data[index].address+ "</div></div>");
          
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-4'>Date of Birth</div><div class='col-lg-8'>: "+data[index].date_of_birth_description+"</div><div class='col-lg-4'>Sex</div><div class='col-lg-8'>: "+data[index].sex+"</div><div class='col-lg-4'>Civil Status</div><div class='col-lg-8'>: "+data[index].civil_status+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-4'>Religion</div><div class='col-lg-8'>: "+data[index].religion+"</div><div class='col-lg-4'>Nationality</div><div class='col-lg-8'>: "+data[index].nationality+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-4'>Height</div><div class='col-lg-8'>: "+data[index].height_with_unit+"</div><div class='col-lg-4'>Weight</div><div class='col-lg-8'>: "+data[index].weight_with_unit+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br><h6>Contact Details</h6></div></div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Email Address</div><div class='col-lg-7'>: "+data[index].email_address+"</div><div class='col-lg-5'>Contact Number</div><div class='col-lg-7'>: "+data[index].contact_number_full+"</div><div class='col-lg-5'>Telephone Number</div><div class='col-lg-7'>: "+data[index].telephone_number+"</div></div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br><h6>Family Information</h6></div></div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Spouse Name</div><div class='col-lg-7'>: "+data[index].spouse_name+"</div><div class='col-lg-5'>Spouse Occupation</div><div class='col-lg-7'>: "+data[index].spouse_occupation+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Father Name</div><div class='col-lg-7'>: "+data[index].father_name+"</div><div class='col-lg-5'>Father Occupation</div><div class='col-lg-7'>: "+data[index].father_occupation+"</div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>Mother Name</div><div class='col-lg-7'>: "+data[index].mother_name+"</div><div class='col-lg-5'>Mother Occupation</div><div class='col-lg-7'>: "+data[index].mother_occupation+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br><h6>Emergency Contact Details</h6></div></div>");
          $(".divViewDetails").append("<div class='row'><div class='col-lg-5'>FullName</div><div class='col-lg-7'>: "+data[index].person_emergency_contact+"</div><div class='col-lg-5'>Relationship</div><div class='col-lg-7'>: "+data[index].relations_to_person_emergency_contact+"</div><div class='col-lg-5'>Contact Number</div><div class='col-lg-7'>: "+data[index].person_emergency_contact_number_full+"</div>");

          $(".divViewDetails").append("<div class='row'><div class='col-lg-12'><br></div></div><div class='row'><div class='col-lg-5'>Date & Time Created</div><div class='col-lg-7'>: "+data[index].person_created_at+"</div><div class='col-lg-5'>Status</div><div class='col-lg-7'>: "+data[index].person_status+"</div><div class='col-lg-5'>Added By</div><div class='col-lg-7'>: "+data[index].added_by_name+"</div></div>");

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
    if(index!=2 && index!=4 && index!=19 && index!=20 && index!=21 && index!=22 && index!=23 && index!=24 && index!=25 && index!=26 && index!=27 && index!=28){
      validations[index].innerHTML = "*";
    }
  }
}

function Validate_Data(){
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let counter = 0;
    for(let index=0; index<all_Fields.length; index++){
      if(index!=2 && index!=4 && index!=19 && index!=20 && index!=21 && index!=22 && index!=23 && index!=24 && index!=25 && index!=26 && index!=27 && index!=28){
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
        validations[18].innerHTML = "* Enter the 10 digits number";
        ShowToast("bg-warning", "Warning", "Kindly check the contact number.");
      }else{
        validations[18].innerHTML = "*";
        let emergency_contact_number = $("#txt_emergency_contact_number").val();
        if(emergency_contact_number == ""){
          Submit();
        }else{
          if(emergency_contact_number.length < 10 || emergency_contact_number.length > 10){
            validations[28].innerHTML = "* Enter the 10 digits number";
            ShowToast("bg-warning", "Warning", "Kindly check the contact number.");
          }else{
            validations[28].innerHTML = "*";
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

function btnUpdateDetails(person_id) {
  let user_type_id = "<?php echo $_GET['id']; ?>";
  let obj={"user_type_id":user_type_id};
  let parameter = JSON.stringify(obj); 

  $(".divViewDetails").text("");
  $.ajax({url:'tbl_person/json_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].person_id == person_id){        
          $("#btnSubmitUpdateDetails").val(data[index].person_id);
          $("#select_user_type").attr("disabled", true);
          $("#select_user_type").val(data[index].user_type);
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
  let user_type = $("#select_user_type").val();
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
        ShowToast("bg-success", "Success", "Registration successfully updated.");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }
      else{
        ShowToast("bg-warning", "Warning", "Updating of details was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of details went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}//end of function
// ------------------------- END OF UPDATE DETAILS ------------------------- //

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(person_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this account?");
  $("#btnChangeStatus").val(person_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let person_id = $("#btnChangeStatus").val();

  let obj={"person_id":person_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_person/update_person_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "User successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Updating of user status was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of user status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //

// ------------------------- RESET PASSWORD ------------------------- //
function btnResetPassword(person_id) {
  $("#btnResetPassword").val(person_id);
}

function SaveResetPassword() {
  let person_id = $("#btnResetPassword").val();

  let obj={"person_id":person_id,"password":"default123"};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_person/update_person_reset_password.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Password successfully reset.");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", "Resetting of password was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Resetting of password went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax 
}
// ------------------------- END OF RESET PASSWORD ------------------------- //

function btnRFID(person_id) {
  $(".validation-area-rfid").text("*");
  $("#txt_rfid").val("");
  
  $("#btnRFID").val(person_id);
  
  let user_type_id = "<?php echo $_GET['id']; ?>";
  let obj={"user_type_id":user_type_id};
  let parameter = JSON.stringify(obj); 

  $.ajax({url:'tbl_person/json_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].person_id == person_id){        
            $("#txt_rfid").val(data[index].person_rfid);
            break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax
}

function SaveRFID() {
  let rfid = $("#txt_rfid").val();
  let person_id = $("#btnRFID").val();

  if(rfid == ""){
    $(".validation-area-rfid").text("* Field is required.");
  }else{
    $(".validation-area-rfid").text("*");

    let obj={"person_id":person_id,"rfid":rfid};  
    let parameter = JSON.stringify(obj); 
      $.ajax({url:'tbl_person/update_rfid.php?data='+parameter,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "RFID successfully updated.");
          $(".btnModalClose").click();
          $("#list_of_data").DataTable().ajax.reload();
        }else{
          ShowToast("bg-warning", "Warning", "Updating of user rfid was failed, Please try again.");
          console.log(data);
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Updating of user rfid went something wrong, Please contact the System Administrator.");
      }
    });//end of ajax  
  }
}
</script>

<div class="modal fade" id="modalViewDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
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

<div class="modal fade" id="modalUpdateDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Update Details</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <?php include("includes/form_information.php"); ?>
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

<div class="modal fade" id="modalChangeStatus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Change Account Status</h5>      
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

<div class="modal fade" id="modalResetPassword" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Reset Password</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <p style="font-size: 18px;">Are you sure you want to reset the password of this user?</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnResetPassword" class="btn btn-success" onclick="SaveResetPassword()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalUpdateRFID" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Update RFID</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">RFID: <span class="validation-area-rfid">*</span></label>
            <input type="text" class="form-control fieldsRFID" id="txt_rfid">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnRFID" class="btn btn-success" onclick="SaveRFID()">Submit</button>
      </div>
    </div>
  </div>
</div>
<?php include("includes/main-footer.php"); ?>