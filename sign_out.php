<?php
   // // Four steps to closing a session

   // 1. Find the session
   session_start();
   // 2. Unset all session variables
   $_SESSION = array();
   // 3. Destroy the session cookie
   if(isset($_COOKIE['person_id'])){
      setcookie(session_name(),'',time(-42000), '/');
   }
   // 4. Destroy the session
   session_destroy();
   header("Location: index.php");
?>