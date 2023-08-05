<?php ob_start(); ?>
<?php include("includes/connection.php"); ?>
<?php include("includes/function.php"); ?>
<?php include("includes/session.php"); ?>
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
  class="light-style layout-menu-fixed"
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
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    <!-- <link href="assets/datatables_bootstrap4/bootstrap.css" rel="stylesheet"> -->
    <link href="assets/datatables_bootstrap4/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    
    
    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>


    <script type="text/javascript" src="assets/jquery.min.js"></script>
    <script type="Text/Javascript" src="assets/jquery.dataTables.min.js"></script>

    <style type="text/css">
      table{cursor: pointer; font-size: 13px; text-transform: uppercase; color: black;}
      .validation-area, .validation-area-password, .validation-area-assign, .validation-area-contract, .validation-area-rfid{color: red; font-weight: bold;}
      h1, h2, h3, h4, h5, h6{text-transform: uppercase; color: black;}
      /*.modal{color:black; text-transform: uppercase;}*/
      /*b{font-weight: bold;}*/
      label{color: black;}
      i, span{cursor:  pointer;}
      a{text-decoration: none;}
    </style>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
  </head>

  <body style="background-color: #f2f2f2;">