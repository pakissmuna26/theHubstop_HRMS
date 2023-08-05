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
          $(".page_name").text("Dashboard");          
        </script>
      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
          <div class="row">
            <div class="col-lg-9 mb-4">
              <div class="card">
                <div class="d-flex align-items-end row">
                  <div class="col-lg-8">
                    <div class="card-body">
                      <h5 class="card-title text-primary">Hi,  
                        <?php echo PersonName($_SESSION['person_id']); ?>! 🎉
                      </h5>
                      <p class="mb-4">
                        Welcome to <span class="fw-bold">HUBSTOP</span>-Human Resources Management System
                      </p>

                      <!-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> -->
                    </div>
                  </div>
                  <div class="col-lg-4 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                      <img
                        src="assets/img/illustrations/man-with-laptop-light.png"
                        height="130"
                        alt="View Badge User"
                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                        data-app-light-img="illustrations/man-with-laptop-light.png"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php 
              date_default_timezone_set("Asia/Manila");
              $dateEncoded = date("Y-m-d");
              $yearToday = date("Y");
              $dayToday = date("d");
              $monthToday = date("m");
              $months = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec");
              $monthToday = number_format($monthToday);
              $monthTodayDescription = $months[$monthToday];
            ?>
            <div class="col-lg-3 mb-4">
              <div class="card" style="text-align: center;">
                <div class="card-body">
                  <div class="row row-bordered">
                    <div class="col-lg-6">
                      <h1 style="font-size: 70px;text-align: center;"><?php echo $dayToday; ?></h1>
                    </div>
                    <div class="col-lg-6">
                      <h2><?php echo $monthTodayDescription; ?></h2>
                      <hr>
                      <h4><?php echo $yearToday; ?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <?php 
            if($_SESSION['user_type'] != 3)
              include("dashboard_administrator.php"); 
          ?>         

          <div class="row">
            <div class="col-lg-12 order-2 mb-4">
              <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                  <div class="card-title mb-0">
                    <h6>My Attendance Report 
                       <span style="font-size: 12px;">(<?php echo $yearToday; ?>)</span>
                    </h6>
                  </div>
                </div>
                <div class="card-body px-0">
                  <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">                    
                      <div id="divAttendanceChart"></div>
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

$(document).ready(function() {
  let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.white;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;

  let labels_array_attendance = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', ''];
  let series_array_attendance = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

  $.ajax({url:'tbl_attendance/json_attendance_dashboard.php',
  method:'GET',
  success:function(data){
    for(let monthCounter = 1; monthCounter <= 12; monthCounter++){
      let counter=0;
      for(let index = 0; index < data.length; index++){
        let date = data[index].attendance_date_in;
        let yearToday = "<?php echo $yearToday; ?>";
        let year = date.substring(0, 4);
        let month = date.substring(5, 7);
        if(parseInt(month) == monthCounter && parseInt(year) == yearToday){
          counter++;
        }
      }
      series_array_attendance[monthCounter] = counter;
    }
    // console.log(series_array_attendance);

      const attendanceChart = document.querySelector('#divAttendanceChart'),
        attendanceChartConfig = {
          series: [
            {
              data: series_array_attendance
            }
          ],
          chart: {
            height: 215, parentHeightOffset: 0, parentWidthOffset: 0,
            toolbar: {
              show: false
            },
            type: 'area'
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: 2, curve: 'smooth'
          },
          legend: {
            show: false
          },
          markers: {
            size: 6, colors: 'transparent', strokeColors: 'transparent',
            strokeWidth: 4,
            discrete: [
              {
                fillColor: config.colors.white,
                seriesIndex: 0,
                dataPointIndex: 7,
                strokeColor: config.colors.primary,
                strokeWidth: 2,
                size: 6,
                radius: 8
              }
            ],
            hover: {
              size: 7
            }
          },
          colors: [config.colors.primary],
          fill: {
            type: 'gradient',
            gradient: {
              shade: shadeColor, shadeIntensity: 0.6,
              opacityFrom: 0.5, opacityTo: 0.25,
              stops: [0, 95, 100]
            }
          },
          grid: {
            borderColor: borderColor, strokeDashArray: 3,
            padding: {
              top: -20, bottom: -8, left: -10, right: 8
            }
          },
          xaxis: {
            categories: labels_array_attendance,
            axisBorder: {
              show: false
            },
            axisTicks: {
              show: false
            },
            labels: {
              show: true,
              style: {
                fontSize: '13px', colors: axisColor
              }
            }
          },
          yaxis: {
            labels: {
              show: false
            },
            min: 10, max: 50, tickAmount: 4
          }
        };
      if (typeof attendanceChart !== undefined && attendanceChart !== null) {
        const incomeChart = new ApexCharts(attendanceChart, attendanceChartConfig);
        incomeChart.render();
      }
    },
    error:function(){
      ShowToast("bg-danger", "Danger", "Please contact the System Administrator.");
    }
  });//end of ajax 
});
</script>
<!-- / Layout wrapper -->
<?php include("includes/main-footer.php"); ?>