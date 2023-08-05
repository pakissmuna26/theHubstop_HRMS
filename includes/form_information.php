<div class="card mb-1">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <h6>Personal Information</h6>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="row">
          <div class="col-12">
            <label class="form-label">Select User Type: <span class="validation-area">*</span></label>
            <select class="form-control fields" id="select_user_type">
              <?php 
                if($_SESSION['user_type'] == 1){
                  echo "<option value='1'>Administrator</option>
                        <option value='2'>HR Staff</option>";
                }
              ?>              
              <option value="3">Employee</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <label class="form-label">First Name: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_first_name">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Middle Name: (Optional) <span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_middle_name">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Last Name: <span class="validation-area">*</span></label>
            <input type="text" class="form-control fields" id="txt_last_name">
          </div>
          <div class="col-lg-6">
            <label class="form-label">Affiliation Name: (Optional) <span class="validation-area"></span></label>
            <select class="form-control fields" id="select_affiliation">
              <option value="">N/A</option>
              <option value="Sr">Sr.</option>
              <option value="Jr">Jr.</option>
              <option value="II">II</option>
              <option value="III">III</option>
              <option value="IV">IV</option>
            </select>
          </div>
        </div>      
      </div>
      <div class="col-lg-4">
        <div class="row">
          <div class="col-12">
            <div id="preview" style="text-align: center;">Preview</div>
            <input class="btn bnt-default" name="files" type="file" id="files"  accept="image/*"/>
            <script type="text/javascript">              
              if (window.FileReader) {
                function handleFileSelect(evt) {
                var files = evt.target.files;
                var f = files[0];
                var reader = new FileReader();
                  reader.onload = (function(theFile) {
                    return function(e) {
                      document.getElementById('preview').innerHTML = ['<img src="', e.target.result,'" title="', theFile.name, '" height="150" width="50%" style="border-radius: 50% 50% 50% 50%"/>'].join('');
                    };
                  })(f);
                  reader.readAsDataURL(f);
                }
              }else{
                alert('This browser does not support FileReader');
              }
              document.getElementById('files').addEventListener('change', handleFileSelect, false);
            </script>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <label class="form-label">Date of Birth: <span class="validation-area">*</span></label>
        <input type="date" class="form-control fields" id="txt_date_of_birth">
      </div>
      <div class="col-lg-4">
        <label class="form-label">Sex: <span class="validation-area">*</span></label>
        <select class="form-control fields" id="select_sex">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="col-lg-4">
        <label class="form-label">Civil Status: <span class="validation-area">*</span></label>
        <select class="form-control fields" id="select_civil_status">
          <option value="Single">Single</option>
          <option value="Married">Married</option>
          <option value="Widowed">Widowed</option>
          <option value="Separated">Separated</option>
          <option value="Divorced">Divorced</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <label class="form-label">Religion: <span class="validation-area">*</span></label>
        <input type="text" class="form-control fields" id="txt_religion">
      </div>
      <div class="col-lg-6">
        <label class="form-label">Nationality: <span class="validation-area">*</span></label>
        <input type="text" class="form-control fields" id="txt_nationality">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <label class="form-label">Height: <span class="validation-area">*</span></label>
        <div class="input-group">
          <input type="number" class="form-control fields" id="txt_height" min="0">
          <span class="input-group-text">cm</span>
        </div>
      </div>
      <div class="col-lg-6">
        <label class="form-label">Weight: <span class="validation-area">*</span></label>
        <div class="input-group">
          <input type="number" class="form-control fields" id="txt_weight" min="0">
          <span class="input-group-text">kg</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-1">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <h6>Home Address</h6>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <label class="form-label">House Number/Street Name/Subdivision/Village: <span class="validation-area">*</span></label>
        <input type="text" class="form-control fields" id="txt_house_number">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3">
        <label class="form-label">Region: <span class="validation-area">*</span></label>
        <select class="form-control fields" id="select_region" onclick="Choose_Province()"></select>
      </div>
      <div class="col-lg-3">
        <label class="form-label">Province: <span class="validation-area">*</span></label>
        <select class="form-control fields" id="select_province" onclick="Choose_Municipality()"></select>
      </div>
      <div class="col-lg-3">
        <label class="form-label">City: <span class="validation-area">*</span></label>
        <select class="form-control fields" id="select_city" onclick="Choose_Barangay()"></select>
      </div>
      <div class="col-lg-3">
        <label class="form-label">Barangay: <span class="validation-area">*</span></label>
        <select class="form-control fields" id="select_barangay"></select>
      </div>
    </div>
  </div>
</div>
<div class="card mb-1">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <h6>Contact Details</h6>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <label class="form-label">Email / Username: <span class="validation-area error_email_user_name">*</span></label>
        <input type="text" class="form-control fields" id="txt_email_user_name">
      </div>
      <div class="col-lg-4">
        <label class="form-label">Contact Number (Phone): <span class="validation-area error_contact_number">*</span></label>
        <div class="input-group">
          <span class="input-group-text">+639</span>
          <input type="number" class="form-control fields" id="txt_contact_number" min="0">
        </div>
      </div>
      <div class="col-lg-4">
        <label class="form-label">Telephone Number: (Optional)<span class="validation-area"></span></label>
        <input type="text" class="form-control fields" id="txt_telephone_number">
      </div>
    </div>
  </div>
</div>
<div class="card mb-1">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <h6>Family Information</h6>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <label class="form-label">Spouse Name: (Optional)<span class="validation-area"></span></label>
        <input type="text" class="form-control fields" id="txt_spouse_name">
      </div>
      <div class="col-lg-6">
        <label class="form-label">Spouse Occupation: (Optional)<span class="validation-area"></span></label>
        <input type="text" class="form-control fields" id="txt_spouse_occupation">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <label class="form-label">Father Name: (Optional)<span class="validation-area"></span></label>
        <input type="text" class="form-control fields" id="txt_father_name">
      </div>
      <div class="col-lg-6">
        <label class="form-label">Father Occupation: (Optional)<span class="validation-area"></span></label>
        <input type="text" class="form-control fields" id="txt_father_occupation">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <label class="form-label">Mother Name: (Optional)<span class="validation-area"></span></label>
        <input type="text" class="form-control fields" id="txt_mother_name">
      </div>
      <div class="col-lg-6">
        <label class="form-label">Mother Occupation: (Optional)<span class="validation-area"></span></label>
        <input type="text" class="form-control fields" id="txt_mother_occupation">
      </div>
    </div>
  </div>
</div>

<div class="card mb-1">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <h6>Emergency Contact Details</h6>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <label class="form-label">Full Name: (Optional)<span class="validation-area"></span></label>
        <input type="text" class="form-control fields" id="txt_emergency_full_name">
      </div>
      <div class="col-lg-4">
        <label class="form-label">Relation: (Optional)<span class="validation-area"></span></label>
        <input type="text" class="form-control fields" id="txt_emergency_relation">
      </div>
      <div class="col-lg-4">
        <label class="form-label">Contact Number: (Optional)<span class="validation-area"></span></label>
        <div class="input-group">
          <span class="input-group-text">+639</span>
          <input type="text" class="form-control fields" id="txt_emergency_contact_number">
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
var jsonAddress="";
var region_number=[];
var region=[];
var province=[];
var provinces = {};
var city=[];
var cities = [];
var barangay=[];
var brgy = [];
var addresses = [];

loadRegion();
function loadRegion(){
  var xobj = new XMLHttpRequest();
      xobj.overrideMimeType("application/json");
      xobj.open("GET", "assets/json/address.json", true);

  xobj.onreadystatechange = function()      {
    if(xobj.readyState==4 && xobj.status=="200"){
      jsonAddress = JSON.parse(xobj.responseText);
      addresses = Object.values(jsonAddress);
      for(var x = 0; x < addresses.length;x++){
        region_number.push(addresses[x].region_name);
      }
        // console.log(region_number);
      for(var index=0; index<region_number.length; index++){
        $("#select_region").append("<option value='"+region_number[index]+"'>"+region_number[index]+"</option>")
      //   region.push(jsonAddress[region_number[index]]["region_name"]);
      }
      // console.log(Object.values(jsonAddress));
    }
  };
  xobj.send();
}

function Choose_Province() {
  $("#select_province").text("");
  var selected_region=$("#select_region").val();
  for(var index=0; index<region_number.length; index++){ 
    if(addresses[index].region_name == selected_region){
      province = Object.keys(addresses[index].province_list);
      provinces = Object.values(addresses[index].province_list);
      for(var x = 0; x < province.length;x++){
         $("#select_province").append("<option value='"+province[x]+"'>"+province[x]+"<//option>")
      }
      Choose_Municipality();
      Choose_Barangay();
    }
  }
}

function Choose_Municipality() {
  $("#select_city").text("");
  var selected_province=$("#select_province").val();
  for(var index=0; index<province.length; index++){
    if(province[index] == selected_province){    
      city = Object.keys(provinces[index].municipality_list);
      cities = Object.values(provinces[index].municipality_list);
      for(var x = 0; x < city.length;x++){
         $("#select_city").append("<option value='"+city[x]+"'>"+city[x]+"<//option>")
      }
      Choose_Barangay();
    }
  }
}

function Choose_Barangay() {
  $("#select_barangay").text("");
  var selected_city=$("#select_city").val();
  for(var index=0; index<city.length; index++){
    if(city[index] == selected_city){    
      barangay = cities[index].barangay_list;
      for(var x = 0; x < barangay.length;x++){
         $("#select_barangay").append("<option value='"+barangay[x]+"'>"+barangay[x]+"<//option>")
      }
    }
  }
}
</script>