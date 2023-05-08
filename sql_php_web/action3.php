加選課程判斷
<?php
//課程加選	
	session_start();
	//$MyHead=$_POST["courses_id"];
	$enter_c_id=$_POST["enter_c_id"];
	$student_id=$_SESSION["student_id"] ;
	
	$dbhost = '127.0.0.1';
	$dbuser = 'hj';
	$dbpass = 'test1234';
	$dbname = 'testdb';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
	mysqli_query($conn, "SET NAMES 'utf8'");
	mysqli_select_db($conn, $dbname);

	//檢查是否符合加選條件
	$sql = "SELECT s.credits, c.c_name, c.c_credit, c.current_enrollment, c.c_limit,c.day, c.start_time, c.end_time 
			FROM student s, courses c 
			LEFT JOIN enrollments e ON c.c_id = e.c_id AND e.s_id='$student_id'
			WHERE s.s_id='$student_id' AND c.c_id='$enter_c_id'";
	$result = mysqli_query($conn, $sql) or die('MySQL query error');
	$row = mysqli_fetch_assoc($result);
	if (!$row) {
		header('Location: action2.php?status=no found');//查無此學生或課程
		exit;
	}
	if ($row['credits'] + $row['c_credit'] > 30) {
		header('Location: action2.php?status=score limit');//學分已達上限
		exit;
	}
	if ($row['current_enrollment'] >= $row['c_limit']) {
		header('Location: action2.php?status=course full');//課程人數已滿
		exit;
	}
		
	$sql2 = "SELECT COUNT(*) as count 
             FROM enrollments e 
             WHERE e.s_id='$student_id' AND e.c_name IN (SELECT c_name FROM courses WHERE c_id='$enter_c_id')";
	$result2 = mysqli_query($conn, $sql2) or die('MySQL query error');
	$row2 = $result2->fetch_assoc();
    $count = $row2['count'];
    if ($count > 0) {
		header('Location: action2.php?status=already selected');//已選擇過此課程
		exit;
    }

	$sql3 = "SELECT * FROM enrollments WHERE s_id='$student_id'";
	$result3 = mysqli_query($conn, $sql3)or die('MySQL query error');
	while ($row3 = mysqli_fetch_assoc($result3)) {
		if ($row['day'] === $row3['day'] && ($row3['start_time'] <= $row['end_time'] && $row['start_time'] <= $row3['end_time'])) {
			header('Location: action2.php?status=time conflict');//課程時間有衝突
			exit;
		}
	}

	//加選成功，新增資料到enrollments
    $sql4 = "INSERT INTO enrollments (s_id, c_id, c_name, required, c_credit, day, start_time,end_time)
			 SELECT DISTINCT s.s_id, c.c_id, c.c_name, c.required, c.c_credit, c.day, c.start_time,c.end_time
			 FROM student s
			 INNER JOIN courses c ON s.major = c.department
			 WHERE s.s_id = ".$student_id." AND c.c_id = ".$enter_c_id.";";
	$result4 = mysqli_query($conn, $sql4) or die('MySQL query error');
	if ($result4=mysqli_query($conn, $sql4)) {
		//選課人數+1
		$sql5 = "UPDATE courses 
				 SET current_enrollment = current_enrollment+1 
				 WHERE c_id = ".$enter_c_id.";";
		$result5 = mysqli_query($conn, $sql5) or die('MySQL query error');
		//已選學分更新
		$sql6 = "UPDATE student s
				 INNER JOIN courses c ON s.major = c.department
				 INNER JOIN enrollments e ON s.s_id = e.s_id AND c.c_id = e.c_id
				 SET s.credits = s.credits + c.c_credit
				 WHERE s.s_id = ".$student_id." AND c.c_id = ".$enter_c_id.";";
		$result6 = mysqli_query($conn, $sql6) or die('MySQL query error');
		header('Location: action2.php?status=successfully');//加選成功
		exit;
	}else{
		header('Location: action2.php?status=addition failed');//加選失敗
		exit;
	}
?>
