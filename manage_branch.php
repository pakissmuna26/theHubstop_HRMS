<?php include("includes/header.php"); ?>
<?php 
$position = "";
if(isset($_GET['id'])){
    if($_GET['id'] == ""){
        header('Location:read_branch.php');
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
          $(".page_name").text("Manage Branch");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl container-p-y">
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-1">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="divBranchDetails"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12">                 
                      <button type="button" class="btn btn-outline-success float-right" data-bs-toggle='modal' data-bs-target='#modalAssignNewEmployee' onclick="btnAssignNewEmployee()">Assign New Personnel</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12"><br>
                      <!-- <div class="table-responsive text-nowrap"> -->
                       <table class="table" id="list_of_data">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Employee Details</th> 
                              <th>Remarks</th>
                              <th>Date & Time Created</th> 
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
  let branch_id = "<?php echo $_GET['id']; ?>";
  let obj={"branch_id":branch_id};
  let parameter = JSON.stringify(obj); 

  $('#list_of_data').dataTable({
    "bProcessing": true,
    "sAjaxSource": "tbl_branch_person/json_branch_person_datatable.php?data="+parameter,
    "aoColumns": [
      { mData: 'number'},
      { mData: 'person_name_details'},
      { mData: 'branch_person_remarks'},      
      { mData: 'branch_person_created_at_by'},
      { mData: 'branch_person_status_description'},
      { mData: 'branch_person_id'}
    ],
    "columnDefs": [{
      "targets": 5,  "searchable":false,"sortable":false,
      "render": function ( data, type, row ) {
        let button_change_status = "";
        if(row.branch_person_status == "Added"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.branch_person_id+", \"Removed\", \"Remove\")'><i class='bx bx-refresh'></i> Remove Personnel</a>";
        }else if(row.branch_person_status == "Removed"){
          button_change_status = "<a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#modalChangeStatus' onclick='btnChangeStatus("+row.branch_person_id+", \"Added\", \"Add\")'><i class='bx bx-refresh'></i> Add Personnel</a>";
        }

        let action_button = "<button class='btn p-0' type='button' id='action_button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='bx bx-dots-vertical-rounded'></i></button><div class='dropdown-menu dropdown-menu-end'aria-labelledby='action_button'>"+button_change_status+"</div>";
        return action_button;        
      }
    }]
  });  
}//end of function

let branch_id = "<?php echo $_GET['id']; ?>";
ViewDetails(branch_id);
function ViewDetails(branch_id){
  $(".divBranchDetails").text("");
  $.ajax({url:'tbl_branch/json_branch.php',
    method:'GET',
    success:function(data){
      $(".divBranchDetails").text("");
      for(let index = 0; index < data.length; index++){
        if(data[index].branch_id == branch_id){
          $(".divBranchDetails").append("<div class='row'><div class='col-lg-6'><h5>"+data[index].branch_name+"</h5><span style='text-transform:uppercase;font-size:13px;'>"+data[index].branch_description+"</span></div><div class='col-lg-6'><span style='text-transform:uppercase;font-size:13px;'>Address: "+data[index].address+"<br>Contact Number: "+data[index].branch_contact_number_full+"</span></div></div>");
          
          break;
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function btnAssignNewEmployee() {
  Empty();
  $("#select_person").text("");

  let branch_id = "<?php echo $_GET['id']; ?>";
  let obj={"branch_id":branch_id};
  let parameter = JSON.stringify(obj); 

  $.ajax({url:"tbl_branch_person/json_branch_person_check.php?data="+parameter,
    method:'GET',
    success:function(data){
      $("#select_person").text("");
      let counter=0;
      for(let index = 0; index < data.length; index++){
        counter++;
        $("#select_person").append("<option value='"+data[index].person_id+"'>"+data[index].full_name+"</option>");
      }
      if(counter == 0){
        $("#select_person").append("<option value=''>No available personnel</option>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function SaveAssignEmployee() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");

  let branch_id = "<?php echo $_GET['id']; ?>";
  let person_id = $("#select_person").val();
  let branch_person_remarks = $("#txt_remarks").val();

  if(person_id == ""){
    validations[0].innerHTML = "* Field is required";
  }else{
    validations[0].innerHTML = "*";
    let obj={"branch_id":branch_id, "person_id":person_id, "branch_person_remarks":branch_person_remarks};
    let parameter = JSON.stringify(obj); 
    $("#select_person").text("");
    $("#select_person").append("<option value=''></option>");
    $.ajax({url:'tbl_branch_person/create_branch_person.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Personnel successfully added.");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
        Empty();
      }
      else{
        ShowToast("bg-warning", "Warning", "Adding of personnel was failed, Please try again.");
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Adding of personnel went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
  }
}

function Empty() {
  let all_Fields = document.getElementsByClassName("fields");
  let validations = document.getElementsByClassName("validation-area");
  
  for(let index=0; index<all_Fields.length; index++){
    all_Fields[index].value = "";
    if(index!=1)
      validations[index].innerHTML = "*";
  }
}

// ------------------------- CHANGE STATUS ------------------------- //
function btnChangeStatus(branch_id, past_tense_status, present_tense_status) {
  $(".past_tense_status").text(past_tense_status);
  $(".present_tense_status").text(present_tense_status);
  $(".message").text("");
  $(".message").append("Are you sure you want to <b>"+present_tense_status+"</b> this personnel to this branch?");
  $("#btnChangeStatus").val(branch_id);
}

function SaveChangeStatus() {
  let past_tense_status = $(".past_tense_status").text();
  let present_tense_status = $(".present_tense_status").text();
  let branch_person_id = $("#btnChangeStatus").val();

  let obj={"branch_person_id":branch_person_id,"past_tense_status":past_tense_status,"present_tense_status":present_tense_status};  
  let parameter = JSON.stringify(obj); 
    $.ajax({url:'tbl_branch_person/update_branch_person_status.php?data='+parameter,
    method:'GET',
    success:function(data){
      if(data == true){
        ShowToast("bg-success", "Success", "Branch personnel successfully "+past_tense_status+".");
        $(".btnModalClose").click();
        $("#list_of_data").DataTable().ajax.reload();
      }else{
        ShowToast("bg-warning", "Warning", data);
        console.log(data);
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Updating of branch personnel status went something wrong, Please contact the System Administrator.");
    }
  });//end of ajax  
}
// ------------------------- END OF CHANGE STATUS ------------------------- //
</script>

<div class="modal fade" id="modalAssignNewEmployee" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Assign New Personnel</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Select Employee: <span class="validation-area">*</span></label>
            <select class="form-control fields" id="select_person"></select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="form-label">Remarks: (Optional)<span class="validation-area"></span></label>
            <input type="text" class="form-control fields" id="txt_remarks">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnSubmit" class="btn btn-success" onclick="SaveAssignEmployee()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalChangeStatus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">Change Status</h5>      
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
<?php include("includes/main-footer.php"); ?>