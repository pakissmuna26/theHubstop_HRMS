<?php include("includes/header.php"); ?>
<?php 
$position = "";
if(isset($_GET['id'])){
    if($_GET['id'] == ""){
        header('Location:read_job_application.php');
    }else{ 
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
          $(".page_name").text("Manage Job Application");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl container-p-y">
          <div class="row" style="text-transform: uppercase;font-size: 14px;">
            <div class="col-lg-12">
              <div class="card mb-1">
                <div class="card-body">     
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="divContractDetails"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="accordion" id="accordion">
                <div class="card accordion-item mb-1">
                  <h2 class="accordion-header" id="heading">
                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionApplicantInformation" aria-expanded="false" aria-controls="accordionApplicantInformation">
                      Applicant Information
                    </button>
                  </h2>
                  <div id="accordionApplicantInformation" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">  
                    <div class="accordion-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="divApplicantDetails"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card accordion-item active">
                  <h2 class="accordion-header" id="heading">
                    <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionApplicantProcess" aria-expanded="true"aria-controls="accordionApplicantProcess">
                      Application Process
                    </button>
                  </h2>
                  <div id="accordionApplicantProcess" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">                      
                      <div class="row">
                        <div class="col-lg-12">
                          <!-- <div class="table-responsive text-nowrap"> -->
                           <table class="table" id="list_of_data">
                            <thead>
                              <tr>
                                <th style="width: 5%">No.</th> 
                                <th style="width: 20%">Process Category</th> 
                                <th style="width: 40%">Process Details</th> 
                                <th style="width: 20%">Date & Time Created</th> 
                                <th style="width: 5%">Status</th>
                              </tr>
                            </thead>
                          </table>
                          <!-- </div> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div><!-- end of accordion -->

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
  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  let obj={"applicant_application_id":applicant_application_id};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_application_history/json_application_history_datatable.php?data="+parameter,
    // dom: 'Bfrtip',
    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    "aoColumns": [
      { mData: 'number'},
      { mData: 'history_category'},
      { mData: 'history_details'},
      { mData: 'application_history_created_at_by'},
      { mData: 'application_history_status_description'}
    ]
  });  
}//end of function

ApplicantDetails();
function ApplicantDetails(){
  let person_id = "<?php echo $_SESSION['person_id']; ?>";
  let user_type_id = 0;
  let obj={"user_type_id":user_type_id};
  let parameter = JSON.stringify(obj); 

  $(".divApplicantDetails").text("");
  $.ajax({url:'tbl_person/json_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      $(".divApplicantDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].person_id == person_id){
          $(".divApplicantDetails").append("<div class='row'><div class='col-lg-12'><h6>"+data[index].full_name + "</h6></div></div>");
          $(".divApplicantDetails").append("<div class='row'><div class='col-lg-12'>"+data[index].address+ "</div></div>");
          
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

CheckApplicationStatus();
function CheckApplicationStatus() {
  $("#btnAddNewProcess").attr("disabled", true);
  $("#btnAddNewProcess").attr("onclick", "");
  let applicant_application_id = "<?php echo $_GET['id']; ?>";
  $.ajax({url:'tbl_applicant_application/json_applicant_application.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].applicant_application_id == applicant_application_id){
          let applicant_id = data[index].applicant_id;
          let contract_id = data[index].contract_id;
      
          Get_Contract_Details(contract_id);
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });
}

function Get_Contract_Details(contract_id) {
  $(".divContractDetails").text("");
  $.ajax({url:'tbl_contract/json_contract.php',
    method:'GET',
    success:function(data){
      $(".divContractDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].contract_id == contract_id){
          $(".divContractDetails").append("<div class='row'><div class='col-lg-12'><h6>"+data[index].job_position_title+"</h6><span style='text-transform:uppercase;font-size:13px;'>"+data[index].job_position_description+"</span></div></div>");

          $(".divContractDetails").append("<div class='row'><div class='col-lg-5'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Application Period:</b> "+data[index].contract_application_date_from_description+" TO "+data[index].contract_application_date_to_description+"</span></div><div class='col-lg-3'><span style='text-transform:uppercase;font-size:13px;'><b>Starting Date:</b>  "+data[index].contract_starting_date_description+"</span></div><div class='col-lg-4'><span style='text-transform:uppercase;font-size:13px;'>"+"<b>Rate (Monthly):</b> "+data[index].contract_rate_peso+"</span></div></div>");             
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}
</script>

<?php include("includes/main-footer.php"); ?>