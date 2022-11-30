<?php 
// DB credentials.
include 'db_connect_pdo.php';

session_start();

//CHECK IF  THE COURSE CODE IS AVAILABLE
if(!empty($_POST["course_code"])) {
	$course_code=$_POST["course_code"];
	
	$sql ="SELECT course_code FROM tbl_courses WHERE course_code=:course_code";
	$query= $dbh->prepare($sql);
	$query-> bindParam(':course_code',$course_code, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'> Course Code Already exists .</span>";
		echo "<script>$('#add').prop('disabled',true);</script>";
	}
	else{
		echo "<span style='color:green'> Course Code Available for Registration .</span>";
		echo "<script>$('#add').prop('disabled',false);</script>";
	}
}

//CHECK IF  THE COURSE CODE IS AVAILABLE
if(!empty($_POST["course_code1"])) {
	$course_code1=$_POST["course_code1"];
	
	$sql ="SELECT course_code FROM tbl_courses WHERE course_code=:course_code";
	$query= $dbh->prepare($sql);
	$query-> bindParam(':course_code',$course_code1, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'> Course Code Already exists .</span>";
		echo "<script>$('#add').prop('disabled',true);</script>";
	} 
	else{
		echo "<span style='color:green'> Course Code Available for Registration .</span>";
		echo "<script>$('#add').prop('disabled',false);</script>";
	}
}

//CHECK IF  THE STUDENT ID IS AVAILABLE
if(!empty($_POST["stud_id"])) {
	$stud_id=$_POST["stud_id"];
	
	$sql ="SELECT stud_id FROM tbl_students WHERE stud_id=:stud_id";
	$query= $dbh->prepare($sql);
	$query-> bindParam(':stud_id',$stud_id, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'> Student ID Already exists .</span>";
		echo "<script>$('#add').prop('disabled',true);</script>";
	} 
	else{
		$sql1 ="SELECT coordinator_id FROM tbl_coordinators WHERE coordinator_id=:stud_id";
		$query1= $dbh->prepare($sql1);
		$query1-> bindParam(':stud_id',$stud_id, PDO::PARAM_STR);
		$query1-> execute();
		$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
		if($query1->rowCount() > 0)
		{
			echo "<span style='color:red'> Student ID Already exists .</span>";
			echo "<script>$('#add').prop('disabled',true);</script>";
		}
		else{
			$sql2 ="SELECT username FROM tbl_admin WHERE username=:stud_id";
			$query2= $dbh->prepare($sql2);
			$query2-> bindParam(':stud_id',$stud_id, PDO::PARAM_STR);
			$query2-> execute();
			$results2 = $query2 -> fetchAll(PDO::FETCH_OBJ);
			if($query2->rowCount() > 0)
			{
				echo "<span style='color:red'> Student ID Already exists .</span>";
				echo "<script>$('#add').prop('disabled',true);</script>";
			}
			else{
				echo "<span style='color:green'> Student ID Available for Registration .</span>";
				echo "<script>$('#add').prop('disabled',false);</script>";
			}

		}
	}
}

//CHECK IF  THE STUDENT EMAIL IS AVAILABLE
if(!empty($_POST["stud_email"])) {
	$stud_email=$_POST["stud_email"];
	
	$sql ="SELECT email FROM tbl_students WHERE email=:stud_email";
	$query= $dbh->prepare($sql);
	$query-> bindParam(':stud_email',$stud_email, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'> Email Already Exists! </span>";
		echo "<script>$('#add').prop('disabled',true);</script>";
	} 
	else{
		$sql1 ="SELECT email FROM tbl_coordinators WHERE email=:stud_email";
		$query1 = $dbh->prepare($sql1);
		$query1-> bindParam(':stud_email',$stud_email, PDO::PARAM_STR);
		$query1-> execute();
		$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
		if($query1->rowCount() > 0)
		{
			echo "<span style='color:red'> Email Already Exists! </span>";
			echo "<script>$('#add').prop('disabled',true);</script>";
		}
		else{
			$sql2 ="SELECT username FROM tbl_admin WHERE username=:stud_email";
			$query2 = $dbh->prepare($sql2);
			$query2-> bindParam(':stud_email',$stud_email, PDO::PARAM_STR);
			$query2-> execute();
			$results2 = $query1 -> fetchAll(PDO::FETCH_OBJ);
			if($query2->rowCount() > 0)
			{
				echo "<span style='color:red'> Email Already Exists! </span>";
				echo "<script>$('#add').prop('disabled',true);</script>";
			}
			else{
				echo "<span style='color:green'> Email Available for Registration.</span>";
				echo "<script>$('#add').prop('disabled',false);</script>";
			}
		}
	}
}

//CHECK IF  THE COORDINATOR EMAIL IS AVAILABLE
if(!empty($_POST["coordinator_email"])) {
	$coordinator_email=$_POST["coordinator_email"];
	
	$sql ="SELECT email FROM tbl_coordinators WHERE email=:coordinator_email";
	$query= $dbh->prepare($sql);
	$query-> bindParam(':coordinator_email',$coordinator_email, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'> Email Already Exists! </span>";
		echo "<script>$('#add').prop('disabled',true);</script>";
	} 
	else{
		echo "<span style='color:green'> Email Available for Registration.</span>";
		echo "<script>$('#add').prop('disabled',false);</script>";
	}
}

//CHECK IF MY ID IS AVAILABLE
if(!empty($_POST["my_email"])) {
	$my_email=$_POST["my_email"];
	
	$exist_email = $_SESSION['coordinator_email'];

	$sql ="SELECT email FROM tbl_coordinators WHERE email=:my_email";
	$query= $dbh->prepare($sql);
	$query-> bindParam(':my_email',$my_email, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($my_email == $exist_email){
		echo "<span style='color:green'> Email is Available.</span>";
		echo "<script>$('#update_account').prop('disabled',false);</script>";
	}
	else if($query->rowCount() > 0)
	{
		echo "<span style='color:red'> Email is Already Taken! </span>";
		echo "<script>$('#update_account').prop('disabled',true);</script>";
	} 
	else{
		$sql1 ="SELECT email FROM tbl_students WHERE email=:my_email";
		$query1= $dbh->prepare($sql1);
		$query1-> bindParam(':my_email',$my_email, PDO::PARAM_STR);
		$query1-> execute();
		$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
		if($query1->rowCount() > 0)
		{
			echo "<span style='color:red'> Email is Already Taken! </span>";
			echo "<script>$('#update_account').prop('disabled',true);</script>";
		}
		else{
			$sql2 ="SELECT email FROM tbl_admin WHERE email=:my_email";
			$query2 = $dbh->prepare($sql2);
			$query2-> bindParam(':my_email',$my_email, PDO::PARAM_STR);
			$query2-> execute();
			$results2 = $query2 -> fetchAll(PDO::FETCH_OBJ);
			if($query2->rowCount() > 0)
			{
				echo "<span style='color:red'> Email is Already Taken! </span>";
				echo "<script>$('#update_account').prop('disabled',true);</script>";
			}
			else{
				echo "<span style='color:green'> Email is Available.</span>";
				echo "<script>$('#update_account').prop('disabled',false);</script>";
			}
		}
	}
}


//CHECK IF  THE PASSWORD IS CORRECT OR INCORRECT di pa gumagana ito
if(!empty($_POST["my_password"])) {
	$password=$_POST["my_password"];
	
	$correct_password = $_SESSION['coordinator_password'];
	if($password == $correct_password)
	{
		echo "<span style='color:red'> Correct Password!</span>";
		echo "<script>$('#add').prop('disabled',true);</script>";
	} 
	else{
		echo "<span style='color:green'> ID Available for Registration.</span>";
		echo "<script>$('#add').prop('disabled',false);</script>";
	}
}

?>