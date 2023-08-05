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
          $(".page_name").text("Create Job Posting");          
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
                    <div class="col-lg-12">
                      <label class="form-label">Select Contract: <span class="validation-area">*</span></label>
                      <select class="form-control fields" id="select_contract" onclick="Generate_Contract()" onchange="Generate_Contract()"></select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="divContractDetails"></div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12" style="text-transform: uppercase; font-size: 13px;"><br>
                      <div class="divPayrollPeriod"></div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12" style="text-transform: uppercase; font-size: 13px;">
                      <div class="divLeaveCredit"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card" id="divListOfBranch" style="display: none;">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <h6>List of Branch</h6>
                      <table class="table tblListOfBranch"></table>
                      <button type="button" id="btnSubmitContractBranch" class="btn btn-success" onclick="SaveContractBranch()" style="display: none;">Submit</button>
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
Get_Contract_ComboBox();
function Get_Contract_ComboBox() {
  $.ajax({url:"tbl_contract/json_contract.php",
    method:'GET',
    success:function(data){
      $("#select_contract").text("");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_status == "Activated"){
          counter++;
          $("#select_contract").append("<option value='"+data[index].contract_id+"'>"+data[index].contract_title+"</option>");
        }
      }
      if(counter == 0){
        $("#select_contract").append("<option value=''>No available contract</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
}   

function Generate_Contract() {
  Get_Contract_Details();
  Read_Payroll_Period_Details();
  Read_Leave_Credit_Details();
  $("#divListOfBranch").attr("style", "display:block");
  Get_List_of_Branch();
}

function Get_Contract_Details() {
  let contract_id = $("#select_contract").val();
  if(contract_id==""){
    ShowToast("bg-warning", "Warning", "Please select contract.");
  }else{
    $(".divContractDetails").text("");
    $.ajax({url:'tbl_contract/json_contract.php',
      method:'GET',
      success:function(data){
        $(".divContractDetails").text("");
        for(let index = 0; index < data.length; index++){
          if(data[index].contract_id == contract_id){
            $(".divContractDetails").append("<div class='row'><div class='col-lg-12'><br><h5>"+data[index].contract_title+"</h5><span style='text-transform:uppercase;font-size:13px;'>"+data[index].contract_description+"</span></div></div>");

            $(".divContractDetails").append("<div class='row'><div class='col-lg-5'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Application Period:</b> "+data[index].contract_application_date_from_description+" TO "+data[index].contract_application_date_to_description+"<br><b>Starting Date:</b> "+data[index].contract_starting_date_description+"</span></div><div class='col-lg-3'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Job Position:</b> "+data[index].job_position_title+"<br><b>Rate (Monthly):</b> "+data[index].contract_rate_peso+"</span></div><div class='col-lg-4'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Shifting Schedule:</b> "+data[index].shifting_schedule+"<br><b>Shift Break:</b> "+data[index].break_schedule+"</span></div></div>");             
            break;
          }
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
      }
    });//end of ajax  
  }
}

function Read_Payroll_Period_Details() {
  let contract_id = $("#select_contract").val();
  if(contract_id==""){
    // ShowToast("bg-warning", "Warning", "Please select contract.");
  }else{
    let obj={"contract_id":contract_id};
    let parameter = JSON.stringify(obj); 

    $(".divPayrollPeriod").text("");
    $.ajax({url:'tbl_contract_payroll_period/read_contract_payroll_period_with_deduction_benefits.php?data='+parameter,
      method:'GET',
      success:function(data){
        $(".divPayrollPeriod").text("");
        $(".divPayrollPeriod").append(data);
        
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
      }
    });//end of ajax  
  }
}

function Read_Leave_Credit_Details() {
  let contract_id = $("#select_contract").val();
  if(contract_id==""){
    // ShowToast("bg-warning", "Warning", "Please select contract.");
  }else{
    let obj={"contract_id":contract_id};
    let parameter = JSON.stringify(obj); 

    $(".divLeaveCredit").text("");
    $.ajax({url:'tbl_contract_leave_category/read_contract_leave_category_per_contract.php?data='+parameter,
      method:'GET',
      success:function(data){
        $(".divLeaveCredit").text("");
        $(".divLeaveCredit").append(data);
        
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
      }
    });//end of ajax  
  }
}

function Get_List_of_Branch() {
  let contract_id = $("#select_contract").val();
  if(contract_id==""){
    // ShowToast("bg-warning", "Warning", "Please select contract.");
  }else{
    let obj={"contract_id":contract_id};
    let parameter = JSON.stringify(obj); 

    $.ajax({url:"tbl_branch/json_branch_create_job_posting.php?data="+parameter,
      method:'GET',
      success:function(data){
        $(".tblListOfBranch").text("");
        $(".tblListOfBranch").append("<thead><tr><th style='width:5%'>Action</th><th style='width:50%'>Branch Details</th><th style='width:45%'>Branch HR Staff</th></tr></thead>");
        let counter=0;
        for(let index = 0; index < data.length; index++){
          if(data[index].branch_status == "Activated"){
            counter++;
            $(".tblListOfBranch").append("<tr><td style='text-align:center;'><input class='form-check-input chkBranch' type='checkbox' value='"+data[index].branch_id+"'></td><td>"+data[index].branch_name+"<br>Address: "+data[index].branch_address+", "+data[index].address+"<br>Contact #:"+data[index].branch_contact_number_full+"</td><td>"+data[index].branch_hr_staff+"</td></tr>");
          }
        }
        if(counter == 0){
          $(".tblListOfBranch").append("<tr><td colspan='5'>No available branch / all branches has been added to this job posting</td></tr>");
          $("#btnSubmitContractBranch").attr("style", "display:none;");
        }else{
          $("#btnSubmitContractBranch").attr("style", "display:block;");
        }
      },
      error:function(){
        ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
      }
    });//end of ajax 
  }
} 

function SaveContractBranch() {
  let contract_id = $("#select_contract").val();

  let objContractBranch = [];
  let branch_counter=0; 
  let chkBranch=document.getElementsByClassName("chkBranch");
  for(let index_leave=0; index_leave<chkBranch.length; index_leave++){
    if(chkBranch[index_leave].checked == true){
      objContractBranch.push(chkBranch[index_leave].value);
      branch_counter++;
    }
  }
  
  if(branch_counter == 0 ){
    ShowToast("bg-warning", "Warning", "Please select atleast one among the list of branch");
  }else{
    let obj={"contract_id":contract_id};
    let parameter = JSON.stringify(obj); 
    let parameter_leave = JSON.stringify(objContractBranch); 
     
    $.ajax({url:'tbl_contract_branch/create_contract_branch.php?data='+parameter+"&data_branch="+parameter_leave,
      method:'GET',
      success:function(data){
        if(data == true){
          ShowToast("bg-success", "Success", "Branch successfully saved.");          
          $(".btnModalClose").click();
          location.reload();
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
  } 
}
</script>

<div class="modal fade" id="id" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">header</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            
          </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php include("includes/main-footer.php"); ?>