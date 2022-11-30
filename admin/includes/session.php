<?php
   error_reporting(0);
   include('includes/db_connect.php');
   session_start();
   
   $user_check = $_SESSION['username'];
   
   $ses_sql = mysqli_query($conn, "SELECT * FROM tbl_admin where username = '$user_check'");
   
   $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
   
   $_SESSION['id'] = $row['id'];
   $_SESSION['admin_id'] = $row['admin_id'];
   $_SESSION['admin_fname'] = $row['fname'];
   $_SESSION['admin_mname'] = $row['mname'];
   $_SESSION['admin_lname'] = $row['lname'];
   $_SESSION['admin_email'] = $row['email'];
   $_SESSION['position'] = $row['position'];
   $_SESSION['admin_gender'] = $row['gender'];
   $_SESSION['civil_stats'] = $row['civil_stats'];
   $_SESSION['admin_address'] = $row['address'];
   $_SESSION['bday'] = $row['bday'];
   $_SESSION['admin_image'] = $row['image'];
   $_SESSION['admin_username'] = $row['username']; //employee id
   $_SESSION['admin_password'] = ($row['password']);
   $admin_secret_quest = $row['secret_quest'];
   $admin_secret_ans = $row['secret_ans'];
   $_SESSION['admin_usertype'] = $row['userType'];

   $_SESSION['MY_FULLNAME_AS_DEAN'] = $row['fname']." ".$row['mname']." ".$row['lname'];

   $login_session = $row['username'];
   $my_password = ($row['password']);
   $my_bday = $row['bday'];

   if(!isset($_SESSION['username'])){
       header('location: ../../index-admin.php');
   }
   else {
      //header('location: index.php'); 
   }
?>