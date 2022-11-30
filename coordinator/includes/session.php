<?php
   error_reporting(0);
   include('includes/db_connect.php');
   session_start();
   
   $user_check = $_SESSION['coordinator_id'];
   
   $ses_sql = mysqli_query($conn,"SELECT * FROM tbl_coordinators where coordinator_id = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   //to fetch the data of coordinator account
   $_SESSION['id'] = $row['id'];
   $_SESSION['uniq_id'] = $row['uniq_id'];
   $_SESSION['coordinator_id'] = $row['coordinator_id'];
   $_SESSION['coordinator_fname'] = $row['fname'];
   $_SESSION['coordinator_mname'] = $row['mname'];
   $_SESSION['coordinator_lname'] = $row['lname'];
   $_SESSION['coordinator_email'] = $row['email'];
   $_SESSION['coordinator_address'] = $row['address'];
   $_SESSION['coordinator_gender'] = $row['gender'];
   $_SESSION['coordinator_civil_stats'] = $row['civil_stats'];
   $_SESSION['coordinator_bday'] = $row['bday'];
   $_SESSION['coordinator_contact'] = $row['contact'];
   $_SESSION['coordinator_acad_yr_sem'] = ($row['academic_yr_sem']);
   $_SESSION['coordinator_address'] = ($row['address']);
   $_SESSION['coordinator_image'] = $row['image'];
   $_SESSION['coordinator_password'] = ($row['password']);
   $_SESSION['coordinator_course'] = ($row['course']);

   $login_session = $row['coordinator_id'];
   $my_password = ($row['password']);

   $id1 = $_SESSION['coordinator_id'];         
   $sql1 = "SELECT Concat(fname, ' ', mname,' ', lname, ' ', '(', coordinator_id, ')') AS fullname FROM tbl_coordinators where coordinator_id = '$id1'";
   $query1 = $conn->query($sql1);
   while($row1 = $query1->fetch_assoc()){
       $_SESSION['coordinator_fullname_session'] = $row1['fullname'];
   }

   if(!isset($_SESSION['coordinator_id'])){
      header('location: ../../index.php');
   }
   else {
      //header('location: index.php'); 
   }
?>