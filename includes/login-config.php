<?php
include('db_connect.php');
session_start();

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$date_ = date("F d, Y");
$time_ = date("h:i:s A");

if(isset($_POST['signin'])) {
   $my_ID = $_POST['ID'];
   $mypassword = md5($_POST['password']); 
   
   //program head user
   $userType = "program_head";
   $sql = "SELECT * FROM tbl_coordinators WHERE coordinator_id = '$my_ID' and password = '$mypassword' and userType='$userType'";
   $result = mysqli_query($conn, $sql);
   $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
   $active = $row['status'];
   $isArchived = $row['isArchived'];
   
   $count = mysqli_num_rows($result);
   
   // If result matched $myusername and $mypassword, table row must be 1 row
   if($count == 1) {
      if($active == "not active" || $isArchived == "archived") {
         $_SESSION['err_message'] = "Your account is NOT ACTIVE. Please contact the administrator!";
         header("location: ../index.php?=InactiveAccount");
      } 
      else{
         if(md5($my_ID) == $mypassword){
            $_SESSION['coordinator_id_'] = "Please change your password immediately! Click on your profile photo icon on the right side then choose settings.";
            $_SESSION['changepassword'] = $my_ID;
            $_SESSION['coordinator_id'] = $my_ID;
            
            $active = "active";
            $session_login = "You logged in at e-OJT aCCeSs";
            //log session
            $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
            $query_log_run = mysqli_query($conn, $sql_log);
            if($query_log_run){
               $fname = $row['fname'];
               $mname = $row['mname'];
               $lname = $row['lname'];
               $coordinator_id = $row['coordinator_id'];

               $get_name_id = $fname." ".$mname." ".$lname." (".$coordinator_id.")";
               
               $userType = "Program Head";
               $session_audit = $get_name_id. " logged in the system";
               $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
               $query_audit_run = mysqli_query($conn, $sql_audit);
               if($query_audit_run){
                  $_SESSION['coordinator_id'] = $my_ID;
                  header("location: ../program_head/index.php");
               }
            }

         }
      }
   }

   else{
      $sql = "SELECT * FROM tbl_students WHERE stud_id = '$my_ID' and password = '$mypassword'";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $active = $row['status'];
      $isArchived = $row['archived'];

      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) {
         if($active == "not active" || $isArchived == "archive") {
            $_SESSION['err_message'] = "Your Account is Not Active. Please contact your OJT Teacher!";
            //header("location: index.php?=InactiveAccount");
            header('location: ../index.php?=YourAccountIsNotActive');
         } 
         else{
            if(md5($my_ID) == $mypassword){
               $_SESSION['studentID_'] = "Please change your password immediately! Click on your profile photo icon on the right side then choose settings.";
               $_SESSION['changepassword'] = $my_ID;
               $_SESSION['studentID'] = $my_ID;

               $active = "active";
               $session_login = "You logged in at e-OJT aCCeSs";
               
               //log session
               $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
               $query_log_run = mysqli_query($conn, $sql_log);
               if($query_log_run){

                  $fname = $row['fname'];
                  $mname = $row['mname'];
                  $lname = $row['lname'];
                  $coordinator_id = $row['coordinator_id'];

                  $get_name_id = $fname." ".$mname." ".$lname." (".$stud_id.")";
                  
                  $userType = "Student";
                  $session_audit = $get_name_id. " logged in the system";
                  $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_login', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
                  $query_audit_run = mysqli_query($conn, $sql_audit);
                  if($query_audit_run){
                     header("location: ../students/index.php");
                  }
               }
               else{
                  echo $conn->error;
               }
            }
            else{
               $active = "active";
               $session_login = "You logged in at e-OJT aCCeSs";
               
               //log session
               $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
               $query_log_run = mysqli_query($conn, $sql_log);
               if($query_log_run){
                  $fname = $row['fname'];
                  $mname = $row['mname'];
                  $lname = $row['lname'];
                  $stud_id = $row['stud_id'];

                  $get_name_id = $fname." ".$mname." ".$lname." (".$stud_id.")";
                  
                  $userType = "Student";
                  $session_audit = $get_name_id. " logged in the system";
                  $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
                  $query_audit_run = mysqli_query($conn, $sql_audit);
                  if($query_audit_run){
                     $_SESSION['studentID'] = $my_ID;
                     header("location: ../students/index.php");
                  }
               }
            }
         }
      }
      else {
         $userType = "teacher";
         $sql = "SELECT * FROM tbl_coordinators WHERE coordinator_id = '$my_ID' and password = '$mypassword' and userType='$userType'";
         $result = mysqli_query($conn,$sql);
         $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
         $active = $row['status'];
         $isArchived = $row['isArchived'];

         $count = mysqli_num_rows($result);
         
         // If result matched $my_ID and $mypassword, table row must be 1 row
         if($count == 1) {
            //session_register("admin_username");
            if($active == "not active" || $isArchived == "archived") {
               $_SESSION['err_message'] = "Your account is inactive. Please contact the administrator!";
               header("location: ../index.php?=InactiveAccount");
            } 
            else{
               if(md5($my_ID) == $mypassword){
                  $_SESSION['coordinator_id_'] = "Please change your password immediately! Click on your profile photo icon on the right side then choose settings.";
                  $_SESSION['changepassword'] = $my_ID;
                  $_SESSION['coordinator_id'] = $my_ID;
                  
                  $active = "active";
                  $session_login = "You logged in at e-OJT aCCeSs";
                  //log session
                  $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
                  $query_log_run = mysqli_query($conn, $sql_log);
                  if($query_log_run){
                     $fname = $row['fname'];
                     $mname = $row['mname'];
                     $lname = $row['lname'];
                     $coordinator_id = $row['coordinator_id'];

                     $get_name_id = $fname." ".$mname." ".$lname." (".$coordinator_id.")";
                     
                     $userType = "Teacher";
                     $session_audit = $get_name_id. " logged in the system";
                     $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
                     $query_audit_run = mysqli_query($conn, $sql_audit);
                     if($query_audit_run){
                        header("location: ../coordinator/index.php");
                     }
                  }
               }
               else{
                  $active = "active";
                  $session_login = "You logged in at e-OJT aCCeSs";
                  //log session
                  $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
                  $query_log_run = mysqli_query($conn, $sql_log);
                  if($query_log_run){

                     $fname = $row['fname'];
                     $mname = $row['mname'];
                     $lname = $row['lname'];
                     $coordinator_id = $row['coordinator_id'];

                     $get_name_id = $fname." ".$mname." ".$lname." (".$coordinator_id.")";
                     
                     $userType = "Teacher";
                     $session_audit = $get_name_id. " logged in the system";
                     $sql_audit = "INSERT INTO tbl_audit_trail (activity, date_, time_, by_, status, userType) VALUES ('$session_audit', '$date_', '$time_', '$get_name_id', '$active', '$userType')";
                     $query_audit_run = mysqli_query($conn, $sql_audit);
                     if($query_audit_run){
                        $_SESSION['coordinator_id'] = $my_ID;
                        header("location: ../coordinator/index.php");
                     }
                  }
               }
            }
         }
         else {
            $sql = "SELECT * FROM tbl_admin WHERE username = '$my_ID' and password = '$mypassword'";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $active = $row['image'];
            
            $count = mysqli_num_rows($result);
            
            // If result matched $myusername and $mypassword, table row must be 1 row
            if($count == 1) {
               $active = "active";
               $session_login = "You logged in at e-OJT aCCeSs";
               //log session
               $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$date_', '$time_', '$my_ID', '$active')";
               $query_log_run = mysqli_query($conn, $sql_log);
               if($query_log_run){
                  $_SESSION['username'] = $my_ID;
                  header("location: ../admin/index.php");
               }
            }
            else {
               $_SESSION['err_message'] = "Invalid ID or Password!";
               header('location: ../index.php?=IncorrectIdOrPassword');
            }
         }
      }
   }
}
?>
