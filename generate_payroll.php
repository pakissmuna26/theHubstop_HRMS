<?php include("includes/header.php"); ?>

<?php 
// global $connection;
// $sql = "UPDATE tbl_attendance 
// SET payroll_id = 0,
// attendance_status = \"Approved\"
// WHERE attendance_status=\"Payroll\" AND payroll_id <> 0";
// if(mysqli_query($connection, $sql)){
//   echo true;
// }else{
//   echo "Updating Attendance Status Error: ".$connection->error." || ".$sql;
// }

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
          $(".page_name").text("Generate Payroll");          
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
                    <div class="col-lg-4">
                      <label class="form-label">Select Month & Year: <span class="validation-area">*</span></label>
                      <input type="month" class="form-control fields" id="txt_month_year" onclick="Get_Payroll_Period_ComboBox()" onchange="Get_Payroll_Period_ComboBox()">
                    </div>
                    <div class="col-lg-4">
                      <label class="form-label">Select Payroll Period: <span class="validation-area">*</span></label>
                      <select class="form-control fields" id="select_payroll_period" onclick="Get_Payroll_Period_Per_Personnel_ComboBox()" onchange="Get_Payroll_Period_Per_Personnel_ComboBox()"></select>
                    </div>
                    <div class="col-lg-4">
                      <label class="form-label">Select Personnel: <span class="validation-area">*</span></label>
                      <select class="form-control fields" id="select_personnel"></select>
                    </div>                    
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <button type="button" id="btnReset" class="btn btn-outline-info" onclick="Reset()" disabled>Reset</button>
                      <button type="button" id="btnGeneratePayroll" class="btn btn-success" onclick="Validate_Data()" disabled>Generate Payroll</button>
                    </div>
                  </div>
                </div>
              </div>

              <div style='text-transform:uppercase; font-size:14px;'>
                <div class="generatedPayroll"></div>
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
var all_Fields = document.getElementsByClassName("fields");
var validations = document.getElementsByClassName("validation-area");

Get_Payroll_Period_ComboBox();
function Get_Payroll_Period_ComboBox() {
  $.ajax({url:"tbl_payroll_period/json_payroll_period.php",
    method:'GET',
    success:function(data){
      $("#select_payroll_period").text("");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].payroll_period_status == "Activated"){
          counter++;
          $("#select_payroll_period").append("<option value='"+data[index].payroll_period_id+"'>"+data[index].payroll_period_title+"</option>");
        }
      }
      if(counter == 0){
        $("#select_payroll_period").append("<option value=''>No available payroll period</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
} 

function Get_Payroll_Period_Per_Personnel_ComboBox() {
  let payroll_period_id = $("#select_payroll_period").val();
  var obj={"payroll_period_id":payroll_period_id};
  var parameter = JSON.stringify(obj); 

  $.ajax({url:"tbl_contract_payroll_period/json_contract_payroll_period_get_personnel.php?data="+parameter,
    method:'GET',
    success:function(data){
      $("#select_personnel").text("");
      $("#select_personnel").append("<option value=''>Please select a personnel</option>");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        counter++;
        $("#select_personnel").append("<option value='"+data[index].person_id+"'>"+data[index].person_name+"</option>");
      }
      if(counter == 0){
        $("#select_personnel").append("<option value=''>No available personnel</option>");
        $("#btnGeneratePayroll").attr("disabled", true);
      }else{        
        $("#btnGeneratePayroll").attr("disabled", false);        
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
} 

function Empty(){
  for(var index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    validations[index].innerHTML = "*";
  }
}

function Validate_Data(){
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
      Verify();      
    }else{
      $(".generatedPayroll").text("");
      ShowToast("bg-warning", "Warning", "Kindly fill-out all the required field/s.");
    }
}

function Verify() {
  let select_payroll_period = $("#select_payroll_period").val();
  let txt_month_year = $("#txt_month_year").val();
  let year = parseFloat(txt_month_year.substring(0, 4));
  let month = parseFloat(txt_month_year.substring(5, 7));
  let person_id = $("#select_personnel").val();

  $.ajax({url:"tbl_payroll/json_payroll.php",
    method:'GET',
    success:function(data){
      let exist=false;
      for(let index = 0; index < data.length; index++){
        if(data[index].payroll_period_id == select_payroll_period &&
          data[index].payroll_month == month &&
          data[index].payroll_year == year &&
          data[index].payroll_person_id == person_id){
          exist = true;
        }
      }
      if(!exist){
        Generate_Payroll();
      }else{
        $(".generatedPayroll").text("");
        $(".generatedPayroll").append("<div class='card'><div class='card-body'><div class='row'><div class='col-lg-12'>Payroll is already generated.</div></div></div></div>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
} 

function Generate_Payroll() {
  $("#btnReset").attr("disabled", false);

  // $("#btnGeneratePayroll").attr("disabled", true);
  // $("#select_payroll_period").attr("disabled", true);
  // $("#txt_month_year").attr("disabled", true);
  // $("#select_personnel").attr("disabled", true);

  let select_payroll_period = $("#select_payroll_period").val();
  let txt_month_year = $("#txt_month_year").val();
  let person_id = $("#select_personnel").val();

  $(".generatedPayroll").text("");
  var obj={"month_year":txt_month_year, "payroll_period":select_payroll_period, "person_id":person_id};
  var parameter = JSON.stringify(obj); 
  $.ajax({url:'tbl_payroll/generate_payroll.php?data='+parameter,
      method:'GET',
    success:function(data){
      $(".generatedPayroll").append(data);
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Registration went something wrong, Please contact the System Administrator.");
    }
  });
}

function Reset() {
  $("#btnReset").attr("disabled", true);

  $("#btnGeneratePayroll").attr("disabled", false);
  $("#select_payroll_period").attr("disabled", false);
  $("#txt_month_year").attr("disabled", false);
  $("#select_personnel").attr("disabled", false);
  $(".generatedPayroll").text("");
}

function VerifyPayroll(total_salary, salary_absent_adjustment, salary_overtime, subtotal_nontaxable_earnings, subtotal_contributions, withholding_tax, net_pay) {
  $("#total_salary").text(total_salary);
  $("#salary_absent_adjustment").text(salary_absent_adjustment);
  $("#salary_overtime").text(salary_overtime);
  $("#subtotal_nontaxable_earnings").text(subtotal_nontaxable_earnings);
  $("#subtotal_contributions").text(subtotal_contributions);
  $("#withholding_tax").text(withholding_tax);
  $("#net_pay").text(net_pay);
}

function Save_Payroll() {
  let total_salary = parseFloat($("#total_salary").text());
  let salary_absent_adjustment = parseFloat($("#salary_absent_adjustment").text());
  let salary_overtime = parseFloat($("#salary_overtime").text());
  let subtotal_nontaxable_earnings = parseFloat($("#subtotal_nontaxable_earnings").text());
  let subtotal_contributions = parseFloat($("#subtotal_contributions").text());
  let withholding_tax = parseFloat($("#withholding_tax").text());
  let net_pay = parseFloat($("#net_pay").text());

  let select_payroll_period = $("#select_payroll_period").val();
  let txt_month_year = $("#txt_month_year").val();
  let year = parseFloat(txt_month_year.substring(0, 4));
  let month = parseFloat(txt_month_year.substring(5, 7));
  let person_id = $("#select_personnel").val();
  
  let objAttendance = [];
  let attendance_id=document.getElementsByClassName("payroll_attendance_id");
  for(let index=0; index<attendance_id.length; index++){
    objAttendance.push(attendance_id[index].innerHTML);
  }
  let parameter_attendance_id = JSON.stringify(objAttendance); 

  let objBenefitsId = [];
  let benefits_id=document.getElementsByClassName("benefits_id");
  let objBenefitsAmount = [];
  let benefits_amount=document.getElementsByClassName("benefits_amount");
  for(let index=0; index<benefits_id.length; index++){
    objBenefitsId.push(benefits_id[index].innerHTML);
    objBenefitsAmount.push(benefits_amount[index].innerHTML);
  }
  let parameter_benefits_id = JSON.stringify(objBenefitsId); 
  let parameter_benefits_amount = JSON.stringify(objBenefitsAmount); 

  let objDeductionId = [];
  let deduction_id=document.getElementsByClassName("deduction_id");
  let objDeductionAmount = [];
  let objDeductionAmountCompanyShare = [];
  let deduction_amount=document.getElementsByClassName("deduction_amount");
  let deduction_amount_company_share=document.getElementsByClassName("deduction_amount_company_share");
  for(let index=0; index<deduction_id.length; index++){
    objDeductionId.push(deduction_id[index].innerHTML);
    objDeductionAmount.push(deduction_amount[index].innerHTML);
    objDeductionAmountCompanyShare.push(deduction_amount_company_share[index].innerHTML);
  }
  let parameter_deduction_id = JSON.stringify(objDeductionId); 
  let parameter_deduction_amount = JSON.stringify(objDeductionAmount); 
  let parameter_deduction_amount_company_share=JSON.stringify(objDeductionAmountCompanyShare); 

  var obj={"payroll_person_id":person_id, "payroll_month":month, "payroll_year":year,
  "payroll_period_id":select_payroll_period,
  "payroll_salary":total_salary,
  "payroll_absent_adjustment":salary_absent_adjustment,
  "payroll_overtime":salary_overtime,
  "payroll_non_taxable_earnings":subtotal_nontaxable_earnings,
  "payroll_deductions":subtotal_contributions,
  "payroll_withholding_tax":withholding_tax,
  "payroll_net_pay":net_pay};

  $(".btnModalClose").click();
  ShowToast("bg-info", "Info", "Payroll is processing.");
  $(".generatedPayroll").text("");

  var parameter = JSON.stringify(obj); 
  $.ajax({url:'tbl_payroll/create_payroll.php?data='+parameter+'&attendance_id='+parameter_attendance_id+"&benefits_id="+parameter_benefits_id+"&benefits_amount="+parameter_benefits_amount+"&deduction_id="+parameter_deduction_id+"&deduction_amount="+parameter_deduction_amount+"&deduction_amount_company_share="+parameter_deduction_amount_company_share,
      method:'GET',
    success:function(data){
       if(data == true){
          ShowToast("bg-success", "Success", "Payroll successfully saved.");          
        }
        else{
          ShowToast("bg-warning", "Warning", "Registration was failed, Please try again.");
          console.log(data);
        }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Registration went something wrong, Please contact the System Administrator.");
    }
  });
}

</script>

<div class="modal fade" id="modalConfirmation" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Confirmation</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div style="display: none;">
              <span id="total_salary"></span>
              <span id="salary_absent_adjustment"></span>
              <span id="salary_overtime"></span>
              <span id="subtotal_nontaxable_earnings"></span>
              <span id="subtotal_contributions"></span>
              <span id="withholding_tax"></span>
              <span id="net_pay"></span>
            </div>
            Are you sure you want to save this payroll?
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="Save_Payroll()">Submit</button>
      </div>
    </div>
  </div>
</div>

<?php include("includes/main-footer.php"); ?>