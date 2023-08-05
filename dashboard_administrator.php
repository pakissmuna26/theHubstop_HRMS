<div class="row">
  <div class="col-lg-4 order-0 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between pb-0">
        <div class="card-title mb-0">
          <h6>Job Application</h6>
        </div>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column align-items-center gap-1">
            <h2 class="mb-2 totalApplication"></h2>
            <span>Total Application</span>
          </div>
          <div id="jobApplicationReportChart"></div>
        </div>
        <ul class="p-0 m-0">
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-warning"
                ><i class="bx bx-briefcase"></i
              ></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Pending</h6>
                <small class="text-muted">Application</small>
              </div>
              <div class="user-progress">
                <label class="fw-bold pendingApplication"></label>
              </div>
            </div>
          </li>
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-success"><i class="bx bx-briefcase"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Accepted</h6>
                <small class="text-muted">Application</small>
              </div>
              <div class="user-progress">
                <label class="fw-bold acceptedApplication"></label>
              </div>
            </div>
          </li>
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-briefcase"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Denied</h6>
                <small class="text-muted">Application</small>
              </div>
              <div class="user-progress">
                <label class="fw-bold deniedApplication"></label>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-4 order-1 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between pb-0">
        <div class="card-title mb-0">
          <h6>Branch
            <span style="font-size: 12px;">(Assigned)</span>
          </h6>
        </div>
      </div>
      <div class="card-body"><br>
        <ul class="p-0 m-0 ulAssignedBranch" style="font-size: 14px; text-transform: uppercase;cursor:  pointer;"></ul>
      </div>
    </div>
  </div>
  <?php 
    date_default_timezone_set("Asia/Manila");
    $dateToday = date("Y-m-d");
    $dateToday = GetMonthDescription($dateToday);
  ?>
  <div class="col-lg-4 order-2 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between pb-0">
        <div class="card-title mb-0">
          <h6>Scheduled Employee
              <span style="font-size: 12px;">(<?php echo $dateToday; ?>)</span>
          </h6>
        </div>
      </div>
      <div class="card-body"><br>
        <ul class="p-0 m-0 ulAssignedPersonnelToday" style="font-size: 14px; text-transform: uppercase;cursor:  pointer;"></ul>
      </div>
    </div>
  </div>

</div>

<script type="text/javascript">
Get_Assigned_Branch();
function Get_Assigned_Branch(){
  let person_id = "<?php echo $_SESSION['person_id']; ?>";
  let user_type = "<?php echo $_SESSION['user_type']; ?>";

  $(".ulAssignedBranch").text("");
  $.ajax({url:'tbl_branch_person/json_branch_person_dashboard.php',
    method:'GET',
    success:function(data){
      $(".ulAssignedBranch").text("");
      let counter=0;
      let length=3;
      for(let index = 0; index < data.length; index++){
        if(user_type != 1){
          if(data[index].person_id == person_id){
            counter++;
            if(counter < length){
              $(".ulAssignedBranch").append("<li class='d-flex mb-4 pb-1'><div class='avatar flex-shrink-0 me-3'><span class='avatar-initial rounded bg-label-primary'><i class='bx bx-building'></i></span></div><div class='d-flex w-100 flex-wrap align-items-center justify-content-between gap-2'><div class='me-2'><label class='mb-0'><b>"+data[index].branch_name+"</b></label><br><small class='text-muted'>"+data[index].address+"</small></div></div></li>");            
            }
          }
        }else{
          counter++;
          if(counter < length){
            $(".ulAssignedBranch").append("<li class='d-flex mb-4 pb-1'><div class='avatar flex-shrink-0 me-3'><span class='avatar-initial rounded bg-label-primary'><i class='bx bx-building'></i></span></div><div class='d-flex w-100 flex-wrap align-items-center justify-content-between gap-2'><div class='me-2'><label class='mb-0'><b>"+data[index].branch_name+"</b></label><br><small class='text-muted'>"+data[index].address+"</small></div></div></li>");
          }
        }
      }
        $(".ulAssignedBranch").append("<li class='d-flex mb-4 pb-1' data-bs-toggle='modal' data-bs-target='#modalViewAssignedBranch' onclick='Get_Assigned_Branch_All()'><small class='text-muted'  style='text-align:center;'>Total: "+counter+" Branch/s Assigned (View All)</small></li>");
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function Get_Assigned_Branch_All(){
  let person_id = "<?php echo $_SESSION['person_id']; ?>";
  let user_type = "<?php echo $_SESSION['user_type']; ?>";

  $(".ulAssignedBranchAll").text("");
  $.ajax({url:'tbl_branch_person/json_branch_person_dashboard.php',
    method:'GET',
    success:function(data){
      $(".ulAssignedBranchAll").text("");
      for(let index = 0; index < data.length; index++){
        if(user_type != 1){
          if(data[index].person_id == person_id){
            $(".ulAssignedBranchAll").append("<li class='d-flex mb-4 pb-1'><div class='avatar flex-shrink-0 me-3'><span class='avatar-initial rounded bg-label-primary'><i class='bx bx-building'></i></span></div><div class='d-flex w-100 flex-wrap align-items-center justify-content-between gap-2'><div class='me-2'><label class='mb-0'><b>"+data[index].branch_name+"</b></label><br><small class='text-muted'>"+data[index].address+"</small></div></div></li>");            
          }
        }else{
          $(".ulAssignedBranchAll").append("<li class='d-flex mb-4 pb-1'><div class='avatar flex-shrink-0 me-3'><span class='avatar-initial rounded bg-label-primary'><i class='bx bx-building'></i></span></div><div class='d-flex w-100 flex-wrap align-items-center justify-content-between gap-2'><div class='me-2'><label class='mb-0'><b>"+data[index].branch_name+"</b></label><br><small class='text-muted'>"+data[index].address+"</small></div></div></li>");
        }
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

Get_Personnel_Today();
function Get_Personnel_Today(){
  let user_type = "<?php echo $_SESSION['user_type']; ?>";

  $(".ulAssignedPersonnelToday").text("");
  $.ajax({url:'tbl_person_shifting_schedule/json_person_shifting_schedule_dashboard.php',
    method:'GET',
    success:function(data){
      console.log(data);
      $(".ulAssignedPersonnelToday").text("");
      let counter=0;
      let length=4;
      for(let index = 0; index < data.length; index++){
        counter++;
        if(counter < length){
          $(".ulAssignedPersonnelToday").append("<li class='d-flex mb-4 pb-1'><div class='avatar flex-shrink-0 me-3'><span class='avatar-initial rounded bg-label-primary'><i class='bx bx-user'></i></span></div><div class='d-flex w-100 flex-wrap align-items-center justify-content-between gap-2'><div class='me-2'><label class='mb-0'><b>"+data[index].person_name+"</b></label><br><small class='text-muted'>"+data[index].branch_name+": "+data[index].shifting_schedule_time_from +" TO "+data[index].shifting_schedule_time_to+")</small></div></div></li>");
        }
      }
      $(".ulAssignedPersonnelToday").append("<li class='d-flex mb-4 pb-1' data-bs-toggle='modal' data-bs-target='#modalViewScheduledToday' onclick='Get_Personnel_Today_All()'><small class='text-muted'  style='text-align:center;'>Total: "+counter+" Personnel/s Scheduled Today (View All)</small></li>");
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

function Get_Personnel_Today_All(){
  let user_type = "<?php echo $_SESSION['user_type']; ?>";
  $(".ulAssignedPersonnelTodayAll").text("");
  $.ajax({url:'tbl_person_shifting_schedule/json_person_shifting_schedule_dashboard.php',
    method:'GET',
    success:function(data){
      console.log(data);
      $(".ulAssignedPersonnelTodayAll").text("");
      for(let index = 0; index < data.length; index++){
        $(".ulAssignedPersonnelTodayAll").append("<li class='d-flex mb-4 pb-1'><div class='avatar flex-shrink-0 me-3'><span class='avatar-initial rounded bg-label-primary'><i class='bx bx-user'></i></span></div><div class='d-flex w-100 flex-wrap align-items-center justify-content-between gap-2'><div class='me-2'><label class='mb-0'><b>"+data[index].person_name+"</b></label><br><small class='text-muted'>"+data[index].branch_name+": "+data[index].shifting_schedule_time_from +" TO "+data[index].shifting_schedule_time_to+")</small></div></div></li>");
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax  
}

$(document).ready(function() {
  let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.white;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;


  let labels_array = ['Pending', 'Accepted', 'Denied'];
  let series_array = [];

  let Pending = 0;
  let Accepted = 0;
  let Denied = 0;
  $.ajax({url:'tbl_applicant_application/json_applicant_application_dashboard.php',
    method:'GET',
    success:function(data){
      for(let index = 0; index < data.length; index++){
        if(data[index].application_status == "Pending")
          Pending++;
        if(data[index].application_status == "Accepted")
          Accepted++;
        if(data[index].application_status == "Denied")
          Denied++;
      }

      $(".pendingApplication").text(Pending);
      $(".acceptedApplication").text(Accepted);
      $(".deniedApplication").text(Denied);
      let totalApplication = parseInt(Pending) + parseInt(Accepted) + parseInt(Denied);
      $(".totalApplication").text(totalApplication);

      series_array[0] = parseInt(Pending);
      series_array[1] = parseInt(Accepted);
      series_array[2] = parseInt(Denied);

      const charJobApplication = document.querySelector('#jobApplicationReportChart'),
        jobApplicationChartConfig = {
          chart: {
            height: 165, width: 130, type: 'donut'
          },
          labels: labels_array, series: series_array,
          colors: [config.colors.warning, config.colors.success, config.colors.danger],
          stroke: {
            width: 5, colors: cardColor
          },
          dataLabels: {
            enabled: false,
            formatter: function (val, opt) {
              return parseInt(val) + '%';
            }
          },
          legend: {
            show: false
          },
          grid: {
            padding: {
              top: 0, bottom: 0, right: 15
            }
          },
          plotOptions: {
            pie: {
              donut: {
                size: '75%',
                labels: {
                  show: true,
                  value: {
                    fontSize: '1.5rem', fontFamily: 'Public Sans', color: headingColor, offsetY: -15,
                    formatter: function (val) {
                      return parseInt(val);
                    }
                  },
                  name: {
                    offsetY: 20,
                    fontFamily: 'Public Sans'
                  },
                  total: {
                    show: true, fontSize: '0.8125rem', color: axisColor, label: 'Total',
                    formatter: function (w) {
                      return totalApplication;
                    }
                  }
                }
              }
            }
          }
        };
      if (typeof charJobApplication !== undefined && charJobApplication !== null) {
        const statisticsChart = new ApexCharts(charJobApplication, jobApplicationChartConfig);
        statisticsChart.render();
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
});
</script>

<div class="modal fade" id="modalViewAssignedBranch" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">View Assigned Branch</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <ul class="p-0 m-0 ulAssignedBranchAll" style="font-size: 14px; text-transform: uppercase;cursor:  pointer;"></ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalViewScheduledToday" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalScrollableTitle">View Scheduled Employee</h5>      
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <ul class="p-0 m-0 ulAssignedPersonnelTodayAll" style="font-size: 14px; text-transform: uppercase;cursor:  pointer;"></ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btnModalClose" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>