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
          $(".page_name").text("Create Account");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl container-p-y">
          <div class="row">
            <div class="col-lg-12">          
              <?php include("includes/form_information.php"); ?>
              <div class="card mb-1">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <button type="button" class="btn btn-outline-secondary" onclick="Empty()">Clear</button>
                      <button type="button" class="btn btn-success" onclick="Check_Email_Exist()">Submit</button>
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

<script type="text/javascript">
  
var all_Fields = document.getElementsByClassName("fields");
var validations = document.getElementsByClassName("validation-area");

function Empty(){
  for(var index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    if(index!=2 && index!=4 && index!=19 && index!=20 && index!=21 && index!=22 && index!=23 && index!=24 && index!=25 && index!=26 && index!=27 && index!=28){
      validations[index].innerHTML = "*";
    }
  }
}

function Validate_Data(){
  var counter = 0;
    for(var index=0; index<all_Fields.length; index++){
      if(index!=2 && index!=4 && index!=19 && index!=20 && index!=21 && index!=22 && index!=23 && index!=24 && index!=25 && index!=26 && index!=27 && index!=28){
        if(all_Fields[index].value == ""){
          validations[index].innerHTML = "* Field is required";
          counter++;
        }else{
          validations[index].innerHTML = "*";
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
  var email = $("#txt_email_user_name").val();
  var obj={"user_type_id":0};
  var parameter = JSON.stringify(obj); 
  $.ajax({url:'tbl_person/json_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      var flag = false;
      for(var index = 0; index < data.length; index++){
        if(data[index].email_address == email){
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

function Submit(){
  var user_type = $("#select_user_type").val();
  var personAddedBy = "<?php echo $_SESSION['person_id']; ?>";
  var obj={"first_name":$("#txt_first_name").val(), 
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
    "user_type_id":user_type, 
    "status":"Activated",
    "password":"default123",
    "personAddedBy":personAddedBy,};
    
    var parameter = JSON.stringify(obj); 

    Empty();
    $.ajax({url:'tbl_person/create_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Registration successfully saved.");
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
}//END OF Submit_Registration
</script>

<!-- / Layout wrapper -->
<?php include("includes/main-footer.php"); ?>