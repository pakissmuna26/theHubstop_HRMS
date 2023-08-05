<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Hubstop-HRMS</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
<!--     <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    /> -->

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <script type="text/javascript" src="assets/jquery.min.js"></script>

    <style type="text/css">
      table{cursor: pointer; font-size: 13px;text-transform: uppercase;}
      .validation-area{color: red; font-weight: bold;}
      h1, h2, h3, h4, h5, h6{text-transform: uppercase; color: black;}
      .modal{color:black; text-transform: uppercase;}
      b{font-weight: bold;}
      label{color: black;}
      i, span{cursor:  pointer;}
      a{text-decoration: none;}
      .alert{text-transform: uppercase; font-size: 12px;}
    </style>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->
    <div class="content-wrapper">
      <!-- Content -->
      <div class="container-xxl container-p-y">
        <div class="row">
          <div class="col-lg-1">
          </div>
          <div class="col-lg-10">
            <div class="card mb-1">
              <div class="card-body">
                <div class="col-lg-12">
                  <div class="app-brand justify-content-center">
                    <a href="index.html" class="app-brand-link gap-2">           
                      <span class="app-brand-text demo text-body fw-bolder" style="text-transform: uppercase; color: black; text-align: center;">HUBSTOP-HRMS<br>
                        <span style="font-size: 14px;">Human Resources Management System</span>
                      </span>
                    </a>
                  </div>
                  <!-- /Logo -->
                </div>
              </div>
            </div>
            <?php include("includes/form_information_registration.php"); ?>
            <div class="card mb-1">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4"></div>
                  <div class="col-lg-4">
                    <button type="button" class="btn btn-primary d-grid w-100" onclick="Check_Email_Exist()">Submit</button>
                  </div>
                  <div class="col-lg-4"></div>

                  <div class="col-lg-12"><br>
                    <p class="text-center">
                      <span>Already have an account?</span>
                      <a href="index.php">
                        <span>Sign in instead</span>
                      </a>
                    </p>
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
    <!-- / Content -->
<script type="text/javascript">
  
var all_Fields = document.getElementsByClassName("fields");
var validations = document.getElementsByClassName("validation-area");

function Empty(){
  for(var index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    if(index!=1 && index!=3 && index!=18 && index!=19 && index!=20 && index!=21 && index!=22 && index!=23 && index!=24 && index!=25 && index!=26 && index!=27){
      validations[index].innerHTML = "*";
    }
  }
}

function Validate_Data(){
  var counter = 0;
    for(var index=0; index<all_Fields.length; index++){
      if(index!=1 && index!=3 && index!=18 && index!=19 && index!=20 && index!=21 && index!=22 && index!=23 && index!=24 && index!=25 && index!=26 && index!=27){
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
  var user_type = 3;
  var personAddedBy = "";
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
    "status":"Registration",
    "password":"default123",
    "personAddedBy":personAddedBy,};
    
    var parameter = JSON.stringify(obj); 

    Empty();
    $.ajax({url:'tbl_person/registration.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Registration successfully saved.");
        // location.reload();
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

<?php include("includes/main-footer.php"); ?>