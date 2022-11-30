<!-- Ayusin yung sa uniq_id at update teacher's and program head info and sa add sa dean user account -->
<!-- Gawin na yung sa forgot password -->
<?php
include 'includes/db_connect.php';
session_start();
date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

//document
$file_location = "../admin/upload_docs/";
$file = $_FILES['sample_file']['name'];
$file_temp = $_FILES['sample_file']['tmp_name'];
$file_size = $_FILES['sample_file']['size'];

$title = $_POST['announcement_title'];
$description = $_POST['announcement_description'];
$sendTo = $_POST['send_announcement_to'];
$_time = $td;
$stats = "not archived";
$publish_stats = "published";
$isRead = 0;

$announcement_id_PH = uniqid('ann-program-head');

// $id1 = $_SESSION['coordinator_id'];         
// $sql1 = "SELECT Concat(fname, ' ', mname,' ', lname, ' ', '(', coordinator_id, ')') AS fullname FROM tbl_coordinators where coordinator_id = '$id1'";
// $query1 = $conn->query($sql1);
// while($row1 = $query1->fetch_assoc()){
//     $_SESSION['coordinator_fullname'] = $row1['fullname'];
// }

// $coordinator_fullname = $_SESSION['coordinator_fullname']; //getting the students coordinator

if($sendTo == "student"){
    $send_to_stud = "Students";
    $sql2 = "SELECT Concat(fname,' ',mname, ' ', lname,' ','(', stud_id,')') AS stud_fullname, uniq_id FROM tbl_students";
    $program_head = "Program Head";
    $query2 = $conn->query($sql2);
    while($row2 = $query2->fetch_assoc()){
        $student_fullname_id = $row2['stud_fullname'];//selecting the student names and id
        $stud_uniq_id = $row2['uniq_id'];// to call uniq id

        //insert data in my announcement receivers
        $sql3 = "INSERT INTO tbl_announcement_receiver(title, description, date_, time_, publish_status, status, isRead, sendTo, posted_by, receiver_name, announcement_id, file, uniq_id) 
        VALUES ('$title', '$description', '$td', '$time', '$publish_stats', '$stats', '$isRead', '$send_to_stud', '$program_head', '$student_fullname_id', '$announcement_id_PH', '$file', '$stud_uniq_id')";
        
        $query_run3 = mysqli_query($conn, $sql3);
            
        if($query_run3){

        }
        else
        {
            echo " ".$conn->error;
        }
    }

    //insert data in my announcement
    $sql = "INSERT INTO tbl_announcement(title, description, date_, time_, publish_status, status, isRead, sendTo, posted_by, announcement_id, file) VALUES ('$title', '$description', '$td', '$time', '$publish_stats', '$stats', '$isRead', '$send_to_stud', '$program_head', '$announcement_id_PH', '$file')";

    $query_run = mysqli_query($conn, $sql);
        
    if($query_run)  {
        move_uploaded_file($file_temp, $file_location.$_FILES['sample_file']['name']);
        header('location: my_announcement_for_today.php?created=1');
    }
    else
    {
        echo " ".$conn->error;
    }
}


else if($sendTo == "teacher"){
    $program_head = "Program Head";
    $send_to_teacher = "Teachers";
    $usertype = "teacher";
    $sql4 = "SELECT Concat(fname,' ',mname, ' ', lname,' ','(', coordinator_id,')') AS teacher_fullname, uniq_id FROM tbl_coordinators where userType='$usertype'";
    $query4 = $conn->query($sql4);
    while($row4 = $query4->fetch_assoc()){
        $teacher_fullname_id = $row4['teacher_fullname'];//selecting the teacher names and id
        $teacher_uniq_id = $row2['uniq_id'];

        //insert data in my announcement receivers
        $sql5 = "INSERT INTO tbl_announcement_receiver(title, description, date_, time_, publish_status, status, isRead, sendTo, posted_by, receiver_name, announcement_id, file, uniq_id) 
        VALUES ('$title', '$description', '$td', '$time', '$publish_stats', '$stats', '$isRead', '$send_to_teacher', '$program_head', '$teacher_fullname_id', '$announcement_id_PH', '$file', '$teacher_uniq_id')";
        
        $query_run5 = mysqli_query($conn, $sql5);
            
        if($query_run5){

        }
        else
        {
            echo " ".$conn->error;
        }
    }
    //insert data in my announcement
    $sql6 = "INSERT INTO tbl_announcement(title, description, date_, time_, publish_status, status, isRead, sendTo, posted_by, announcement_id, file) VALUES ('$title', '$description', '$td', '$time', '$publish_stats', '$stats', '$isRead', '$send_to_teacher', '$program_head', '$announcement_id_PH', '$file')";

    $query_run6 = mysqli_query($conn, $sql6);
        
    if($query_run6) {
        header('location: my_announcement_for_today.php?created=1');
    }
    else
    {
        echo " ".$conn->error;
    }
}


?>