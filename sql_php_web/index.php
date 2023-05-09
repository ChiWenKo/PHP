<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>選課系統</title>
	<style>
		.large-title {
		font-size: 30px;
		}
	</style>
</head>
<body>
	<h1 class="large-title">選課系統<p></h1>
	<form name="table1" method="post" action="login.php">
	學號: <input name ="student_id"><p>
	密碼: <input name ="student_password"><p>
	<input type="submit" value="登入">
	</form>
	<?php
		if (isset($_GET['status'])) {
			if($_GET['status'] === 'fail'){
				echo '<span style="color:red"><p>登入失敗，請檢查您輸入的資訊!</p></span>';
			}
			if($_GET['status'] === 'logout_success'){
				echo '<span style="color:blue"><p>登出成功，重新登入。</p></span>';
			}		
		}		 

		if(isset($_POST['student_id'])) {
			// 開啟 Session 儲存資訊
			session_start();
			$student_id=$_POST["student_id"];
			$_SESSION["student_id"]= $student_id;

			$dbhost = '127.0.0.1';
			$dbuser = 'hj';
			$dbpass = 'test1234';
			$dbname = 'testdb';
			$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
			mysql_query("SET NAMES 'utf8'");
			mysql_select_db($dbname);
			$sql = "SELECT s_id,s_name FROM student where s_id LIKE \"".$student_id."%\";";
			$result = mysql_query($sql) or die('MySQL query error');
		}
	?>
</body>
</html>

