<?php ob_start(); ?>
<?php include("includes/connection.php"); ?>
<?php include("includes/function.php"); ?>
<?php include("includes/session.php"); ?>
<?php include("includes/default_values.php"); ?>

<?php 
date_default_timezone_set("Asia/Manila");
$dateEncoded = date("Y-m-d");
$timeEncoded = date("h:i:s A");
$errorMessage = "";
if(isset($_POST['login'])){
    $username = $_POST['email-username'];
    $password = $_POST['password'];
    global $connection;
    $isValid = false; 
    $query = "SELECT * FROM tbl_person";
    $Users = mysqli_query($connection, $query);
    while ($User = mysqli_fetch_array($Users)) {
      if($User['email_address'] == $username && 
          password_verify($password,$User['password']) && 
          $User['person_status'] == "Activated"){
      
          $_SESSION['person_id'] = $User['person_id'];
          $_SESSION['person_code'] = $User['person_code'];
          $_SESSION['user_type'] = $User['user_type'];
          $_SESSION['person_status'] = $User['person_status'];

          setcookie('user',$_SESSION['person_id'], time() + 86400, '/');
          // 86,400 = 1day
          // 3,600 = 1hour
          // 600 = 10minutes
          // 60 = 1minute

          $ip = isset($_SERVER['HTTP_CLIENT_IP']) 
              ? $_SERVER['HTTP_CLIENT_IP'] 
              : (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
              ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
          
          // Transaction Logs
          Create_Logs("ACCOUNT LOGIN",$User['person_id'], "LOGIN","Date and Time of Login: $dateEncoded @ $timeEncoded<br>IP ADDRESS: $ip<br>Sign in through Email",$User['person_id']);
          // END OF Transaction Logs
          

          header('Location:dashboard.php');
                      
      }else if($User['email_address'] != $username
          && password_verify($password,$User['password']) == false
          && $User['person_status'] == "Activated"){
          $errorMessage = "<p class=\"alert alert-danger\"><b>Username or password is wrong.</b></p>";
      }else if($User['email_address'] == $username
          && password_verify($password,$User['password']) == false
          && $User['person_status'] == "Activated"){
          $errorMessage = "<p class=\"alert alert-danger\"><b>Username or password is wrong.</b></p>";
      }else if($User['email_address'] != $username
          && password_verify($password,$User['password']) == true
          && $User['person_status'] == "Activated"){
          $errorMessage = "<p class=\"alert alert-danger\"><b>Username or password is wrong.</b></p>";
      }else if($User['email_address'] == $username
          && password_verify($password,$User['password'])
          && $User['person_status'] == "Blocked"){
        $errorMessage = "<p class=\"alert alert-danger\"><b>Your account has been blocked!.</b></p>";
      }else if($User['email_address'] == $username
          && password_verify($password,$User['password'])
          && $User['person_status'] == "Deactivated"){
        $errorMessage = "<p class=\"alert alert-warning\"><b>Your account has been Deactivated!.</b></p>";
      }else if($User['email_address'] == $username
          && password_verify($password,$User['password'])
          && $User['person_status'] == "Registration"){
        $errorMessage = "<p class=\"alert alert-warning\"><b>Please proceed to your respective office to activate your account !.</b></p>";
      }
    }
}// end of IF
?>

<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Hubstop-HRMS</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
<!--     <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    /> -->

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <style type="text/css">
      table{cursor: pointer; font-size: 13px;text-transform: uppercase;}
      .validation-area{color: red; font-weight: bold;}
      h1, h2, h3, h4, h5, h6{text-transform: uppercase; color: black;}
      .modal{color:black; text-transform: uppercase;}
      b{font-weight: bold;}
      label{color: black;}
      i, span{cursor:  pointer;}
      a{text-decoration: none;}
      .alert{text-transform: uppercase; font-size: 12px;}
    </style>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <a href="index.php" class="app-brand-link gap-2">
                 
                  <span class="app-brand-text demo text-body fw-bolder" style="text-transform: uppercase; color: black; text-align: center;">HUBSTOP-HRMS<br>
                    <span style="font-size: 14px;">Human Resources Management System</span>
                  </span>
                </a>
              </div>
              <h5 class="mb-2">Welcome to Hubstop-HRMS! 👋</h5>
              <p class="mb-3">Please sign-in to your account and start the adventure</p>
              <?php 
                if($errorMessage != "") echo "<p class='mb-3'>".$errorMessage."</p>"; 
              ?>
              <form class="mb-3" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Email or Username</label>
                  <input type="text" class="form-control" id="email" name="email-username" placeholder="Enter your email or username" autofocus value="<?php if(isset($_POST['email-username'])) { echo $_POST['email-username']; }?>" required>
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <!-- <a href="auth-forgot-password-basic.html">
                      <small>Forgot Password?</small>
                    </a> -->
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" value="<?php if(isset($_POST['password'])) { echo $_POST['password']; }?>" required>
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" name="login">Sign in</button>
                </div>
              </form>

              <p class="text-center">
                <span>New on our platform?</span>
                <a href="sign_up.php">
                  <span>Create an account</span>
                </a>
              </p>
              <p class="text-center">
                <a href="rfid_attendance.php">
                  <span>RFID Attendance</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->
  </body>
</html>


<!-- 
Job Application
- Display Job Application
  (1) Administrator - can view all job application.
  (2) HR Staff - can view job application where branch he/she assigned.



 -->