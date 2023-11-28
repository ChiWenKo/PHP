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
	<h1 class="large-title">身分:學生</h1>
    <a href = "search1.php"><button>課程查詢</button></a>
    <a href = "logout.php"><button>登出</button></a><p>
	
	</form>
	
<?php
	
	session_start(); //開始存取
	$student_id=$_SESSION["student_id"] ;
	
	$dbhost = '127.0.0.1';
	$dbuser = 'hj';
	$dbpass = 'test1234';
	$dbname = 'testdb';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
	mysqli_query($conn, "SET NAMES 'utf8'");
	mysqli_select_db($conn, $dbname);
	
	//學生個人資訊
	$sql = "SELECT distinct s_id, s_name,major,credits,s_grade
			FROM student 
			where s_id =".$student_id.";";
	$result = mysqli_query($conn, $sql) or die('MySQL query error');
	echo "個人資訊";	
	echo "<br><table border='1'><br>";
	echo "<tr> 
			<th> 學號 </th> 
			<th> 姓名 </th>
			<th> 科系 </th>
			<th> 年級 </th> 
			<th> 已選學分 </th> 
			<tr>";
	while($row = mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>" .$row['s_id']."</td>";
		echo "<td>" .$row['s_name']."</td>";
		echo "<td>" .$row['major']."</td>";			
		echo "<td>" .$row['s_grade']."</td>";			
		echo "<td>" .$row['credits']."</td>";
		echo "<tr>";		
	}
	echo "</table>";
	?>
</body>
</html>






