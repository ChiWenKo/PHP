<a href = "logout.php"><button>登出</button></a><p>
<a href = "action2.php"><button>加選</button></a>
<a href="action1.php"><button>查看課表</button></a><p>

退選系統<p>
<form name="table4" method="post" action="action5.php">
請輸入想退選的課程代號: <input name ="drop_c_id">
<input type="submit" value="退選">
</form>

<?php
	if (isset($_GET['status'])) {
		if($_GET['status'] === 'compulsory'){
			echo '<span style="color:red"><p>退選失敗!必修課程不可退選</p></span>';//必修課程不可退選
		}
		if($_GET['status'] === 'less than 9'){
			echo '<span style="color:red"><p>退選失敗!低於9學分不可退選</p></span>';//低於9學分不可退選
		}
		if($_GET['status'] === 'unselected'){
			echo '<span style="color:blue"><p>退選成功!</p></span>';//退選成功
		}	
	}
	//課程退選
	session_start();
	$student_id=$_SESSION["student_id"] ;
	
	$dbhost = '127.0.0.1';
	$dbuser = 'hj';
	$dbpass = 'test1234';
	$dbname = 'testdb';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
	mysqli_query($conn, "SET NAMES 'utf8'");
	mysqli_select_db($conn, $dbname);

	//學生個人資訊
	$sql_s = "SELECT distinct s_id, s_name,major,credits,s_grade
	 		  FROM student 
			  where s_id =".$student_id.";";
	$result_s = mysqli_query($conn, $sql_s) or die('MySQL query error');		
	echo "個人資訊";	
	echo "<br><table border='1'><br>";
	echo "<tr> 
			<th> 學號 </th> 
			<th> 姓名 </th>
			<th> 科系 </th>
			<th> 年級 </th> 
			<th> 已選學分 </th> 
		<tr>";
	while($row_s = mysqli_fetch_array($result_s)){
		echo "<tr>";
		echo "<td>" .$row_s['s_id']."</td>";
		echo "<td>" .$row_s['s_name']."</td>";
		echo "<td>" .$row_s['major']."</td>";			
		echo "<td>" .$row_s['s_grade']."</td>";			
		echo "<td>" .$row_s['credits']."</td>";
		echo "<tr>";
	}
	echo "</table>";

	//列出已選課表

	//學生姓名
	$sql_n = "SELECT s_name FROM student WHERE s_id =".$student_id.";";
	$result_n = mysqli_query($conn, $sql_n) or die('MySQL query error');
	while($row_n = mysqli_fetch_array($result_n)){
		echo "<br>".$row_n["s_name"]. " 的已選課表<br>";	
	}
	//已選課表
	$sql = "SELECT distinct  c_id, c_name, required, c_credit, day, start_time,end_time 
			FROM enrollments 
			where s_id =".$student_id.";";
	$result = mysqli_query($conn, $sql) or die('MySQL query error');
	echo "<table border='1'><br>";
	echo "<tr> 
			<th> 選課代號 </th> 
			<th> 課程名稱 </th>
			<th> 必選修 </th>
			<th> 學分數 </th> 
			<th> 上課日 </th> 
			<th> 上課 </th> 
			<th> 下課 </th>
		<tr>";
	while($row = mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>" .$row['c_id']."</td>";
		echo "<td>" .$row['c_name']."</td>";
		echo "<td>" .$row['required']."</td>";
		echo "<td>" .$row['c_credit']."</td>";
		echo "<td>" .$row['day']."</td>";
		echo "<td>" .$row['start_time']."</td>";
		echo "<td>" .$row['end_time']."</td>";
		echo "<tr>";
	}
	echo "</table>";	
?>
