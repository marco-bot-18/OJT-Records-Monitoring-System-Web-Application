<?php 
// DB credentials.
include 'db_connect_pdo.php';
include 'session.php';

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
		echo "<span style='color:green'> Student ID Available for Registration .</span>";
		echo "<script>$('#add').prop('disabled',false);</script>";
	}
}


//CHECK IF  THE STUDENT EMAIL IS AVAILABLE
if(!empty($_POST["stud_email"])) {
	$stud_email1=$_POST["stud_email"];
	
	$sql1 ="SELECT email FROM tbl_students WHERE email=:stud_email";
	$query1= $dbh->prepare($sql1);
	$query1-> bindParam(':stud_email',$stud_email1, PDO::PARAM_STR);
	$query1-> execute();
	$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
	if($query1->rowCount() > 0)
	{
		echo "<span style='color:red'> Email Already Exists! </span>";
		echo "<script>$('#add').prop('disabled',true);</script>";
	} 
	else{
		$sql2 ="SELECT email FROM tbl_coordinators WHERE email=:stud_email";
		$query2= $dbh->prepare($sql1);
		$query2-> bindParam(':stud_email',$stud_email1, PDO::PARAM_STR);
		$query2-> execute();
		$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
		if($query1->rowCount() > 0)
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
		$sql1 ="SELECT email FROM tbl_students WHERE email=:coordinator_email";
		$query1= $dbh->prepare($sql1);
		$query1-> bindParam(':coordinator_email',$coordinator_email, PDO::PARAM_STR);
		$query1-> execute();
		$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
		if($query1->rowCount() > 0)
		{
			echo "<span style='color:red'> Email Already Exists! </span>";
			echo "<script>$('#add').prop('disabled',true);</script>";
		}
		else{
			$sql11 ="SELECT email FROM tbl_admin WHERE email=:coordinator_email";
			$query11= $dbh->prepare($sql1);
			$query11-> bindParam(':coordinator_email',$coordinator_email, PDO::PARAM_STR);
			$query11-> execute();
			$results11 = $query11 -> fetchAll(PDO::FETCH_OBJ);
			if($query11->rowCount() > 0)
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

//CHECK IF  THE COORDINATOR ID IS AVAILABLE
if(!empty($_POST["coordinator_id"])) {
	$coordinator_id=$_POST["coordinator_id"];
	
	$sql ="SELECT coordinator_id FROM tbl_coordinators WHERE coordinator_id=:coordinator_id";
	$query= $dbh->prepare($sql);
	$query-> bindParam(':coordinator_id',$coordinator_id, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'>Employee ID Already Exists! </span>";
		echo "<script>$('#add').prop('disabled',true);</script>";
	} 
	else{

		$sql1 ="SELECT stud_id FROM tbl_students WHERE stud_id=:coordinator_id";
		$query1 = $dbh->prepare($sql1);
		$query1-> bindParam(':coordinator_id',$coordinator_id, PDO::PARAM_STR);
		$query1-> execute();
		$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
		if($query1->rowCount() > 0)
		{
			echo "<span style='color:red'>Employee ID Already Exists! </span>";
			echo "<script>$('#add').prop('disabled',true);</script>";
		}
		else{
			$sql2 ="SELECT username FROM tbl_admin WHERE username=:coordinator_id";
			$query2 = $dbh->prepare($sql2);
			$query2-> bindParam(':coordinator_id',$coordinator_id, PDO::PARAM_STR);
			$query2-> execute();
			$results2 = $query2 -> fetchAll(PDO::FETCH_OBJ);
			if($query2->rowCount() > 0)
			{
				echo "<span style='color:red'>Employee ID Already Exists! </span>";
				echo "<script>$('#add').prop('disabled',true);</script>";
			}
			else{
				echo "<span style='color:green'>Employee ID Available for Registration.</span>";
				echo "<script>$('#add').prop('disabled',false);</script>";
			}
		}
	}
}

// for modifying account of ojt teacher
if(!empty($_POST["coordinator_id1"])) {
	$coordinator_id1=$_POST["coordinator_id1"];
	
	$sql ="SELECT coordinator_id FROM tbl_coordinators WHERE coordinator_id=:coordinator_id1";
	$query = $dbh->prepare($sql);
	$query-> bindParam(':coordinator_id1',$coordinator_id1, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'>Employee ID Already Exists! </span>";
		echo "<script>$('#update').prop('disabled',true);</script>";
	} 
	else{
		$sql1 ="SELECT stud_id FROM tbl_students WHERE stud_id=:coordinator_id1";
		$query1 = $dbh->prepare($sql1);
		$query1-> bindParam(':coordinator_id1',$coordinator_id1, PDO::PARAM_STR);
		$query1-> execute();
		$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
		if($query1->rowCount() > 0)
		{
			echo "<span style='color:red'>Employee ID Already Exists! </span>";
			echo "<script>$('#update').prop('disabled',true);</script>";
		}
		else{
			$sql2 ="SELECT username FROM tbl_admin WHERE username=:coordinator_id1";
			$query2 = $dbh->prepare($sql2);
			$query2-> bindParam(':coordinator_id1',$coordinator_id1, PDO::PARAM_STR);
			$query2-> execute();
			$results2 = $query2 -> fetchAll(PDO::FETCH_OBJ);
			if($query2->rowCount() > 0)
			{
				echo "<span style='color:red'>Employee ID Already Exists! </span>";
				echo "<script>$('#update').prop('disabled',true);</script>";
			}
			else{
				echo "<span style='color:green'>Employee ID Available.</span>";
				echo "<script>$('#update').prop('disabled',false);</script>";
			}
		}
	}
}

// for modifying account of program head
if(!empty($_POST["coordinator_id2"])) {
	$coordinator_id2=$_POST["coordinator_id2"];
	
	$sql ="SELECT coordinator_id FROM tbl_coordinators WHERE coordinator_id=:coordinator_id2";
	$query = $dbh->prepare($sql);
	$query-> bindParam(':coordinator_id2',$coordinator_id2, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'>Employee ID Already Exists! </span>";
		echo "<script>$('#update').prop('disabled',true);</script>";
	} 
	else{

		$sql1 ="SELECT stud_id FROM tbl_students WHERE stud_id=:coordinator_id2";
		$query1 = $dbh->prepare($sql1);
		$query1-> bindParam(':coordinator_id2',$coordinator_id2, PDO::PARAM_STR);
		$query1-> execute();
		$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
		if($query1->rowCount() > 0)
		{
			echo "<span style='color:red'>Employee ID Already Exists! </span>";
			echo "<script>$('#update').prop('disabled',true);</script>";
		}
		else{
			$sql2 ="SELECT username FROM tbl_admin WHERE username=:coordinator_id2";
			$query2 = $dbh->prepare($sql2);
			$query2-> bindParam(':coordinator_id2',$coordinator_id2, PDO::PARAM_STR);
			$query2-> execute();
			$results2 = $query2 -> fetchAll(PDO::FETCH_OBJ);
			if($query2->rowCount() > 0)
			{
				echo "<span style='color:red'>Employee ID Already Exists! </span>";
				echo "<script>$('#update').prop('disabled',true);</script>";
			}
			else{
				echo "<span style='color:green'>Employee ID Available.</span>";
				echo "<script>$('#update').prop('disabled',false);</script>";
			}
		}
	}
}


//CHECK IF  THE ADMIN USERNAME IS AVAILABLE - admin
if(!empty($_POST["new_uname"])) {
	$new_uname=$_POST["new_uname"];
	
	$sql ="SELECT username FROM tbl_admin WHERE username=:new_uname";
	$query= $dbh->prepare($sql);
	$query-> bindParam(':new_uname',$new_uname, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'> Username Already Exists! </span>";
		echo "<script>$('#add').prop('disabled',true);</script>";
	} 
	else{
		echo "<span style='color:green'> Username Available is Available.</span>";
		echo "<script>$('#add').prop('disabled',false);</script>";
	}
}


//CHECK IF MY EMAIL IS AVAILABLE
if(!empty($_POST["my_email"])) {
	$my_email = $_POST["my_email"];
	
	$exist_email = $_SESSION['admin_email'];

	$sql ="SELECT email FROM tbl_coordinators WHERE email=:my_email";
	$query= $dbh->prepare($sql);
	$query-> bindParam(':my_email',$my_email, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);

	if($my_email == $exist_email){
		echo "<span style='color:green'> This is Your Email.</span>";
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
			// $sql2 ="SELECT email FROM tbl_coordinators WHERE email=:my_email";
			// $query2 = $dbh->prepare($sql2);
			// $query2-> bindParam(':my_email',$my_email, PDO::PARAM_STR);
			// $query2-> execute();
			// $results2 = $query2 -> fetchAll(PDO::FETCH_OBJ);
			// if($query2->rowCount() > 0)
			// {
			// 	echo "<span style='color:red'> Email is Already Taken! </span>";
			// 	echo "<script>$('#update_account').prop('disabled',true);</script>";
			// }
			// else{
				echo "<span style='color:green'> Email is Available.</span>";
				echo "<script>$('#update_account').prop('disabled',false);</script>";
			
		}
	}
}

//CHECK IF MY ID IS AVAILABLE
if(!empty($_POST["my_emp_id"])) {
	$my_emp_id=$_POST["my_emp_id"];
	
	$sql ="SELECT coordinator_id FROM tbl_coordinators WHERE coordinator_id=:my_emp_id";
	$query = $dbh->prepare($sql);
	$query-> bindParam(':my_emp_id',$my_emp_id, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	if($query->rowCount() > 0)
	{
		echo "<span style='color:red'>Employee ID Already Exists! </span>";
		echo "<script>$('#update_account').prop('disabled',true);</script>";
	} 
	else{

		$sql1 ="SELECT stud_id FROM tbl_students WHERE stud_id=:my_emp_id";
		$query1 = $dbh->prepare($sql1);
		$query1-> bindParam(':my_emp_id',$my_emp_id, PDO::PARAM_STR);
		$query1-> execute();
		$results1 = $query1 -> fetchAll(PDO::FETCH_OBJ);
		if($query1->rowCount() > 0)
		{
			echo "<span style='color:red'>Employee ID Already Exists! </span>";
			echo "<script>$('#update_account').prop('disabled',true);</script>";
		}
		else{
			echo "<span style='color:green'>Employee ID Available.</span>";
			echo "<script>$('#update_account').prop('disabled',false);</script>";
		}
	}
}


?>