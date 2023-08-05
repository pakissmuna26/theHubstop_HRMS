<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="dashboard.php" class="app-brand-link">
      <!-- <span class="app-brand-logo demo"></span> -->
      <span class="app-brand-text demo menu-text fw-bolder" style="text-transform: uppercase; text-align: center;">HUBSTOP<br>
        <span style="font-size: 10px;">Human Resources Management System</span>
      </span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
  	<li class="menu-item">
	  <a href="read_account.php?id=<?php echo $_GET['id']; ?>" class="menu-link">
	    <i class="menu-icon tf-icons bx bx-left-arrow-alt"></i>Go Back
	  </a>
	</li>

	<li class="menu-item">
	  <a class="menu-link" onclick="DisplayPortfolioSummary()">
	    <i class="menu-icon tf-icons bx bx-list-ul"></i>Portfolio Summary
	  </a>
	</li>

	<li class="menu-item">
	  <a class="menu-link" onclick="DisplayShiftSchedule()">
	    <i class="menu-icon tf-icons bx bx-calendar"></i>Shift Schedule
	  </a>
	</li>
	
	<li class="menu-item">
	  <a href="javascript:void(0);" class="menu-link menu-toggle"><i class="menu-icon tf-icons bx bx-briefcase"></i>Contact</a>
	  <ul class="menu-sub">
    	<span class="spanListOfContract"></span>
	  </ul>
	</li>

	<li class="menu-item">
	  <a class="menu-link">
	    <i class="menu-icon tf-icons bx bx-user-check"></i>Attendance Report
	  </a>
	</li>

  </ul>
</aside>