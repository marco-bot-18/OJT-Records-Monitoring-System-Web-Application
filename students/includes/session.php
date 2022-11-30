<?php
   error_reporting(0);
   include('includes/db_connect.php');
   session_start();
   
   $user_check = $_SESSION['studentID'];
   $ses_sql = mysqli_query($conn,"SELECT * FROM tbl_students where stud_id = '$user_check' ");
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   //to fetch the data of student account
   $_SESSION['student_auto_id'] = $row['id'];
   $_SESSION['student_id'] = $row['stud_id'];
   $_SESSION['stud_fullname'] = $row['stud_fullname'];
   $_SESSION['student_fname'] = $row['fname'];
   $_SESSION['student_mname'] = $row['mname'];
   $_SESSION['student_lname'] = $row['lname'];
   $_SESSION['student_email'] = $row['email'];
   $_SESSION['student_gender'] = $row['gender'];
   $_SESSION['student_contact'] = $row['contact'];
   $_SESSION['student_civil_stats'] = $row['civil_status'];
   $_SESSION['student_bday'] = $row['bday'];
   $_SESSION['student_address'] = $row['address'];
   $_SESSION['student_gender'] = $row['gender'];
   $_SESSION['student_image'] = $row['image'];
   $_SESSION['student_password'] = ($row['password']);
   $_SESSION['student_image'] = $row['image'];
   $_SESSION['student_academic_yr_semester'] = $row['academic_yr_semester'];
   $_SESSION['student_teacher'] = $row['coordinator'];
   $_SESSION['student_course'] = $row['course'];
   $_SESSION['student_ojt_category'] = $row['ojt_category'];
   $_SESSION['category_desc'] = $row['category_desc'];
   $_SESSION['remarks'] = $row['remarks'];
   $_SESSION['student_in_off_campus'] = $row['in_off_campus'];
   $_SESSION['student_ojt_company'] = $row['supervisor'];
   $_SESSION['student_hours_required'] = $row['hours_required'];

   $login_session = $row['stud_id'];
   $my_password = ($row['password']);

   $id1 = $row['stud_id'];
   $sql1 = "SELECT Concat(fname,' ', mname,' ', lname,' ', '(',stud_id,')') AS fullname FROM tbl_students where stud_id = '$id1'";
   $query1 = $conn->query($sql1);
   while($row1 = $query1->fetch_assoc()){
      $_SESSION['student_fullname_session'] = $row1['fullname'];
   }

   if(!isset($_SESSION['studentID'])){
      header('location: ../../index.php');
   }
   else {
      //header('location: index.php'); 
   }
?>