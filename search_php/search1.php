<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>查詢課程</title>
	<style>
		.large-title {
		font-size: 25px;
		}
	</style>
</head>
<body>
	<h1 class="large-title">查詢課程</h1>

	<form name="search" method="post" action="search.php">
	課程代號: <input name ="inquire_id">
    <br>課程名稱: <input name ="inquire_name">
	<br>開課系所: <input name ="inquire_department">
	<br>課程開始時間: <input name ="inquire_time"><br><br>

	<input type="submit" name="search" value="查詢">
	<a href = "student.php"><button>返回</button></a>
	
	</form>
	
	<?php
	
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






