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
    <!-- Dashboard -->
    <!-- <li class="menu-item"><hr></li> -->
    
    <li class="menu-item">
      <a href="dashboard.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <?php 
      if($_SESSION['user_type'] == 1){ 
        include("menu_administrator.php");
      }//end of session user_type == 1 
      else if($_SESSION['user_type'] == 2){ 
        include("menu_hr_staff.php");
      }//end of session user_type == 2 
      else if($_SESSION['user_type'] == 3){ 
        include("menu_employee.php");
      }//end of session user_type == 3 
    ?>

  </ul>
</aside>