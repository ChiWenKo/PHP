<a href = "index.php"> Go Query Interface</a> <p>

<?php
	if(isset($_POST['student_id']) && isset($_POST['student_password'])) {
    $student_id = $_POST["student_id"]; //獲取表格中輸入的用戶名和密碼
    $student_password = $_POST["student_password"];

		$dbhost = '127.0.0.1';
		$dbuser = 'hj';
		$dbpass = 'test1234';
		$dbname = 'testdb';
		$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
		mysqli_query($conn, "SET NAMES 'utf8'");
		mysqli_select_db($conn, $dbname);

		$sql = "SELECT * FROM student 
				WHERE s_id = ".$student_id." and s_password = ".$student_password.";";
		$result = mysqli_query($conn, $sql) or die('MySQL query error');

		if(mysqli_num_rows($result) == 1){ //如果記錄數為1，則說明輸入的用戶名和密碼正確，登錄成功
			session_start();
			$_SESSION["student_id"]= $student_id; 
			
			header('Location: action1.php?status=success');
    		exit;
    	}else{
       
			header('Location: index.php?status=fail');
        	exit();
    	}

	}
	mysqli_close($conn);
?>


