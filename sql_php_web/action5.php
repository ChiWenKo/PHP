課程退選判斷
<?php
	if(isset($_POST['drop_c_id'])) {
		session_start();
		
		$drop_c_id=$_POST["drop_c_id"];
		$_SESSION["drop_c_id"]= $drop_c_id;

		$student_id=$_SESSION["student_id"] ;
	
		$dbhost = '127.0.0.1';
		$dbuser = 'hj';
		$dbpass = 'test1234';
		$dbname = 'testdb';
		$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
		mysqli_query($conn, "SET NAMES 'utf8'");
		mysqli_select_db($conn, $dbname);

		$query="SELECT c_credit FROM courses WHERE c_id = $drop_c_id";
		$result = mysqli_query($conn, $query) or die('MySQL query error');
		$row = mysqli_fetch_assoc($result);
		$credits = $row['c_credit'];
		
		//先判斷是否為必修課程
		$sql_check = "SELECT required FROM enrollments WHERE c_id = $drop_c_id";
		$result_check = mysqli_query($conn, $sql_check) or die('MySQL query error');;
		$row_check = mysqli_fetch_assoc($result_check);
		$req = "必修";
		if ($row_check["required"] == $req) {	
			header('Location: action4.php?status=compulsory');//必修課程不可退選
			exit;
		}

		//判斷是否低於9學分
		$sql_credit = "SELECT s.credits, c.c_credit
					   FROM student AS s,Courses AS C
		               WHERE s.s_id='$student_id' AND c.c_id='$drop_c_id'";
   		$result_credit = mysqli_query($conn, $sql_credit);
        if ($result_credit) {
	    	$row = mysqli_fetch_assoc($result_credit);
	    if ($row['credits'] - $row['c_credit'] < 9) {
	    	header('Location: action4.php?status=less than 9');//低於9學分
	   		exit;
		}
    } else {
		die('Error:' . mysqli_error($conn));
   	} 
   
    //其餘可退選
    $sql = "DELETE FROM enrollments
			WHERE c_id = $drop_c_id AND s_id = ".$student_id.";";
    $result = mysqli_query($conn, $sql) or die('MySQL query error');
	//選課人數減少
    $sql2 = "UPDATE courses 
		     SET current_enrollment = current_enrollment-1 
	         WHERE c_id = '$drop_c_id';";
    $result5 = mysqli_query($conn, $sql2) or die('MySQL query error');
    //學分更新
    $sql3 = "UPDATE student s
	 		 SET s.credits = s.credits - (SELECT c_credit FROM courses WHERE c_id = '$drop_c_id') 
			 WHERE s_id = '$student_id'";
    $result6 = mysqli_query($conn, $sql3) or die('MySQL query error');

    header('Location: action4.php?status=unselected');//退選成功
	exit;
    }    
?>
