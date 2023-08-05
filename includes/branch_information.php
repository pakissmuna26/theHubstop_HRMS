<div class="row">
  <div class="col-lg-12">
    <label class="form-label">Branch Name: <span class="validation-area">*</span></label>
    <input type="text" class="form-control fields" id="txt_branch_name">
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <label class="form-label">Branch Description: (Optional) <span class="validation-area"></span></label>
    <input type="text" class="form-control fields" id="txt_branch_description">
  </div>
</div>

<div class="row">
  <div class="col-lg-12"><br>
    <h6>Branch Address</h6>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <label class="form-label">House Number/Street Name/Subdivision/Village: <span class="validation-area">*</span></label>
    <input type="text" class="form-control fields" id="txt_house_number">
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <label class="form-label">Region: <span class="validation-area">*</span></label>
    <select class="form-control fields" id="select_region" onclick="Choose_Province()"></select>
  </div>
  <div class="col-lg-12">
    <label class="form-label">Province: <span class="validation-area">*</span></label>
    <select class="form-control fields" id="select_province" onclick="Choose_Municipality()"></select>
  </div>
  <div class="col-lg-12">
    <label class="form-label">City: <span class="validation-area">*</span></label>
    <select class="form-control fields" id="select_city" onclick="Choose_Barangay()"></select>
  </div>
  <div class="col-lg-12">
    <label class="form-label">Barangay: <span class="validation-area">*</span></label>
    <select class="form-control fields" id="select_barangay"></select>
  </div>
</div>

<div class="row">
  <div class="col-lg-12"><br>
    <h6>Contact Details</h6>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <label class="form-label">Contact Number (Phone): <span class="validation-area error_contact_number">*</span></label>
    <div class="input-group">
      <span class="input-group-text">+639</span>
      <input type="number" class="form-control fields" id="txt_contact_number">
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