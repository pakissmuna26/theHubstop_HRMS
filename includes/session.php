<?php
   session_start();
   VerifyAccount();
   function VerifyAccount(){
      if(isset($_SESSION['person_id'])){
         if(isset($_COOKIE['user'])){

         }else{
            setcookie('user','', time() - 86400, '/');
            header("Location: index.php");
            log_out();
         }
      }
      else{
         $link = $_SERVER['REQUEST_URI'];
         if($link != "/Hubstop_HRMS/index.php" && 
            $link != "/Hubstop_HRMS/sign_up.php" && 
            $link != "/Hubstop_HRMS/rfid_attendance.php" && 
            $link != "/Hubstop_HRMS/rfid_attendance.php/tbl_attendance/create_attendance_rfid.php"){
            header("Location: index.php");
            log_out();
         }
      }
   }
   
   function log_out(){
	   // Four steps to closing a session

	   // 1. Find the session
	   // session_start();
	   // 2. Unset all session variables
	   $_SESSION = array();
	   // 3. Destroy the session cookie
	   if(isset($_COOKIE['person_id'])){
	      setcookie(session_name(),'',time() - 3600, '/');
	   }
	   // 4. Destroy the session
	   session_destroy();
	   header("index.php");
   }
?>
