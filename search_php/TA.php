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
	<h1 class="large-title">身分:助教</h1>
    <a href = "logout.php"><button>登出</button></a><p>
	
	</form>
	
<?php
	session_start();
    $teacher_id=$_SESSION["TA_id"] ;

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






