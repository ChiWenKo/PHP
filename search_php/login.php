<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>選課系統</title>
	<style>
		.large-title {
		font-size: 25px;
		}
	</style>
</head>
<body>
	<h1 class="large-title">選課系統</h1>
    <form name="table1" method="post" action="identity_login.php">
    帳號: <input name ="id"><p>
	密碼: <input name ="password"><p>    
    請選擇身分:<p>
    <input type="submit" name="student" value="學生登入">
    <input type="submit" name="teacher" value="老師登入">
    <input type="submit" name="TA" value="助教登入">
	
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
		session_start();

		$dbhost = '127.0.0.1';
		$dbuser = 'hj';
		$dbpass = 'test1234';
		$dbname = 'testdb';
		$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
		mysqli_query($conn, "SET NAMES 'utf8'");
		mysqli_select_db($conn, $dbname);
	
	?>
</body>
</html>






