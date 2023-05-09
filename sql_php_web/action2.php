<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>加選系統</title>
	<style>
		.large-title {
		font-size: 25px;
		}
	</style>
</head>
<body>
	<a href = "logout.php"><button>登出</button></a><p>
	<a href = "action4.php"><button>退選</button></a>
	<a href="action1.php"><button>查看課表</button></a><p>
	<h1 class="large-title">加選系統<p></h1>
	<form name="table3" method="post" action="action3.php">
	請輸入想加選的課程: <input name ="enter_c_id">
	<input type="submit" value="加選">
	</form>

	<?php
		if (isset($_GET['status'])) {
			if($_GET['status'] === 'no found'){
				echo '<span style="color:red"><p>加選失敗!查無此課程</p></span>';
			}
			if($_GET['status'] === 'time conflict'){
				echo '<span style="color:red"><p>加選失敗!課程時間衝突</p></span>';
			}
			if($_GET['status'] === 'score limit'){
				echo '<span style="color:red"><p>加選失敗!學分已達上限</p></span>';
			}
			if($_GET['status'] === 'course full'){
				echo '<span style="color:red"><p>加選失敗!選課人數已滿</p></span>';
			}
			if($_GET['status'] === 'already selected'){
				echo '<span style="color:red"><p>加選失敗!課程名稱重複</p></span>';
			}
			if($_GET['status'] === 'successfully'){
				echo '<span style="color:blue"><p>加選成功!</p></span>';
			}
			if($_GET['status'] === 'addition failed'){
				echo '<span style="color:red"><p>加選失敗!</p></span>';
			}
			
		}

		//查詢可選課列表
		session_start();
		if(isset($_POST['enter_c_id'])) {
			$enter_c_id=$_POST["enter_c_id"];
			$_SESSION["enter_c_id"]= $enter_c_id;
		}

		//取得 Session 中的學生帳號
		$student_id=$_SESSION["student_id"] ;
		
		$dbhost = '127.0.0.1';
		$dbuser = 'hj';
		$dbpass = 'test1234';
		$dbname = 'testdb';
		$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
		mysqli_query($conn, "SET NAMES 'utf8'");
		mysqli_select_db($conn, $dbname);

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

		//從資料庫中獲取所有可選課程
		$sql = "SELECT distinct c_id, c_name, required, c_credit, department, c_grade, c_limit, current_enrollment, day, start_time,end_time
				FROM courses as C, student as S
				where C.c_grade <= S.s_grade  and C.department= S.major and s_id
				LIKE \"".$student_id."%\";";
		$result = mysqli_query($conn, $sql) or die('MySQL query error');
		$courses = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$courses[] = $row;
		}

		//從資料庫中獲取已加選課程
		$sql = "SELECT distinct * FROM enrollments WHERE s_id LIKE \"".$student_id."%\";";
		$result = mysqli_query($conn, $sql) or die('MySQL query error');
		$enrollments = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$enrollments[] = $row['c_id'];
		}

		//排除已加選課程
		$available_courses = array_filter(
			$courses, function($course) use ($enrollments) {
			return !in_array($course['c_id'], $enrollments);
			}
		);
		echo "<br>可加選課程";
		echo "<br><table border='1'><br>";
		echo "<tr>
				<th> 選課代號 </th> 
				<th> 課程名稱 </th>
				<th> 必選修 </th> 
				<th> 學分數 </th>
				<th> 開課系所 </th> 
				<th> 開課年級 </th>
				<th> 人數上限 </th> 
				<th> 已選人數 </th>
				<th> 上課日 </th> 
				<th> 上課 </th>
				<th> 下課 </th>
			<tr>";

		//在網頁中顯示剩餘的課程
		foreach ($available_courses as $course){
			echo "<tr>";
			echo "<td>" .$course['c_id']."</td>";
			echo "<td>" .$course['c_name']."</td>";
			echo "<td>" .$course['required']."</td>";
			echo "<td>" .$course['c_credit']."</td>";
			echo "<td>" .$course['department']."</td>";
			echo "<td>" .$course['c_grade']."</td>";
			echo "<td>" .$course['c_limit']."</td>";
			echo "<td>" .$course['current_enrollment']."</td>";
			echo "<td>" .$course['day']."</td>";
			echo "<td>" .$course['start_time']."</td>";
			echo "<td>" .$course['end_time']."</td>";
			echo "<tr>";
		}
		echo "</table>";
	?>
</body>
</html>








