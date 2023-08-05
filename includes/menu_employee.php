<li class="menu-item">
  <a href="read_my_working_experience.php" class="menu-link">
    <i class="menu-icon tf-icons bx bx-briefcase"></i>
    <div data-i18n="Analytics">Working Experience</div>
  </a>
</li>

<li class="menu-item">
  <a href="read_available_jobs.php" class="menu-link">
    <i class="menu-icon tf-icons bx bx-news"></i>
    <div data-i18n="Analytics">Job Posting</div>
  </a>
</li>

<li class="menu-item">
  <a href="read_my_job_application.php" class="menu-link">
    <i class="menu-icon tf-icons bx bx-list-check"></i>
    <div data-i18n="Analytics">Job Application Tracker</div>
  </a>
</li>
<?php if($_SESSION['person_status'] == "Activated"){ ?>
<li class="menu-item">
  <a href="manage_my_attendance.php" class="menu-link">
    <i class="menu-icon tf-icons bx bx-user-check"></i>
    <div data-i18n="Analytics">Attendance</div>
  </a>
</li>

<li class="menu-item">
  <a href="manage_my_leave_request.php" class="menu-link">
    <i class="menu-icon tf-icons bx bx-list-ul"></i>
    <div data-i18n="Analytics">Leave Request</div>
  </a>
</li>

<li class="menu-item">
  <a href="read_my_work_schedule.php" class="menu-link">
    <i class="menu-icon tf-icons bx bx-briefcase"></i>
    <div data-i18n="Analytics">Work Schedule</div>
  </a>
</li>

<li class="menu-item">
  <a href="read_my_payslip.php" class="menu-link">
    <i class="menu-icon tf-icons bx bx-list-check"></i>
    <div data-i18n="Analytics">Payslip</div>
  </a>
</li>
<?php } ?>