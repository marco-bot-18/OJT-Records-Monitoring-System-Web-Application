<?php
include 'includes/db_connect.php';
session_start();
//phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Manila');
$timestamp = time();
$td = date("F d, Y");
$time = date("h:i:s A");

$number = uniqid();
$varray = str_split($number);
$len = sizeof($varray);
$otp = array_slice($varray, $len-3, $len);
$otp = implode(",", $otp);
$otp = str_replace(',', '', $otp."-");

//document

$file_location = "../admin/upload_docs/";
$file = $_FILES['sample_file']['name'];
if($_FILES['sample_file']['name'] != "") {
    $file = $otp.basename($_FILES['sample_file']['name']);
}
else{
    $sample_file = basename($_FILES['sample_file']['name']);
}

$title = $_POST['announcement_title'];
$description = $_POST['announcement_description'];
$sendTo = $_POST['send_announcement_to'];
$_time = $td;
$stats = "not archived";
$publish_stats = "published";
$isRead = 0;

$announcement_id_teacher = uniqid('ann-teacher');

$id1 = $_SESSION['coordinator_id'];         
$sql1 = "SELECT Concat(fname, ' ', mname,' ', lname, ' ', '(', coordinator_id, ')') AS fullname FROM tbl_coordinators where coordinator_id = '$id1'";
$query1 = $conn->query($sql1);
while($row1 = $query1->fetch_assoc()){
    $_SESSION['coordinator_fullname'] = $row1['fullname'];
}

$coordinator_fullname = $_SESSION['coordinator_fullname']; //getting the students coordinator

if($sendTo == "student"){
    $send_to_stud = "Students";
    $sql2 = "SELECT Concat(fname,' ',mname, ' ', lname,' ','(', stud_id,')') AS stud_fullname, uniq_id, email FROM tbl_students where coordinator='$coordinator_fullname'";

    $query2 = $conn->query($sql2);

    //phpmailer
    require '../vendor/autoload.php';
    $mail = new  PHPMailer(true);
    $mail->SMTPDebug = 1;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'websiteet18@gmail.com';                     //SMTP username
    $mail->Password   = 'empowermenttechnology';                               //SMTP password
    $mail->SMTPSecure = "tls"; //Enable implicit TLS encryption
    $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    while($row2 = $query2->fetch_assoc()){
        $student_fullname_id = $row2['stud_fullname'];//selecting the student names and id
        $stud_uniq_id = $row2['uniq_id'];
        $get_email = $row2['email'];

        //insert data in my announcement receivers
        $sql3 = "INSERT INTO tbl_announcement_receiver(title, description, date_, time_, publish_status, status, isRead, sendTo, posted_by, receiver_name, announcement_id, file, uniq_id) 
        VALUES ('$title', '$description', '$td', '$time', '$publish_stats', '$stats', '$isRead', '$send_to_stud', '$coordinator_fullname', '$student_fullname_id', '$announcement_id_teacher', '$file', '$stud_uniq_id')";
        
        $query_run3 = mysqli_query($conn, $sql3);
        //Recipients
        $mail->setFrom('websiteet18@gmail.com', $coordinator_fullname);
        $mail->addAddress($get_email);//Name is optional

        //Content
        $mail->isHTML(true);//Set email format to HTML
        $mail->Subject = "Announcement from your OJT teacher";
        $template    = "<b>".$title."</b> <br> ".$description. " <br> Posted by: <b>".$_SESSION['coordinator_fullname']."</b>";
        $mail->Body = $template;
        header('location: announcement_for_today.php?created=1');
    }
    $mail->send();

    //insert data in my announcement
    $sql = "INSERT INTO tbl_announcement(title, description, date_, time_, publish_status, status, isRead, sendTo, posted_by, announcement_id, file) VALUES ('$title', '$description', '$td', '$time', '$publish_stats', '$stats', '$isRead', '$send_to_stud', '$coordinator_fullname', '$announcement_id_teacher', '$file')";

    $query_run = mysqli_query($conn, $sql);
        
    if($query_run) {
        $active = "active";
        $my_ID = $_SESSION['coordinator_id'];
        $session_login = "You posted an announcement entitled ".$title;
        //log session
        $sql_log = "INSERT INTO tbl_activity_log (activity, date_, time_, by_, status) VALUES ('$session_login', '$td', '$time', '$my_ID', '$active')";
        $query_log_run = mysqli_query($conn, $sql_log);
        if ($query_log_run) {
            $_SESSION['posted'] = $title;
            move_uploaded_file($file_temp, $file_location.$_FILES['sample_file']['name']);
            header('location: announcement_for_today.php');
        }
    }
    else
    {
        echo $conn->error;
    }
}
?>