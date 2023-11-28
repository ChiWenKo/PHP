<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
	</form>
<?php
session_start();
if(isset($_POST['id']) && isset($_POST['password'])) {
    $dbhost = '127.0.0.1';
    $dbuser = 'hj';
    $dbpass = 'test1234';
    $dbname = 'testdb';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
    mysqli_query($conn, "SET NAMES 'utf8'");
    mysqli_select_db($conn, $dbname);

    if (isset($_POST['student'])) {
        $student_id = $_POST["id"]; //獲取表格中輸入的用戶名和密碼
        $student_password = $_POST["password"];

        $sql = "SELECT * FROM student 
				WHERE s_id = ".$student_id." and s_password = ".$student_password.";";
		$result = mysqli_query($conn, $sql) or die('MySQL query error');

		if(mysqli_num_rows($result) == 1){ //如果記錄數為1，則說明輸入的用戶名和密碼正確，登錄成功
			session_start();
			$_SESSION["student_id"]= $student_id; 
			
			header('Location: student.php?status=success');
    		exit;
    	}else{
       
			header('Location: login.php?status=fail');
        	exit();
    	}
    }
    if (isset($_POST['teacher'])) {
        $teacher_id = $_POST["id"]; //獲取表格中輸入的用戶名和密碼
        $teacher_password = $_POST["password"];

    }
    if (isset($_POST['TA'])) {
        $TA_id = $_POST["id"]; //獲取表格中輸入的用戶名和密碼
        $TA_password = $_POST["password"];
        
    }
    // 關閉資料庫連接
    mysqli_close($conn);
}

    

?>
