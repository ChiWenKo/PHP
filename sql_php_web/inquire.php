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
	<a href = "logout.php"><button>登出</button></a><p>
	

	<h1 class="large-title">查詢課程<p></h1>

	<form name="table4" method="post" action="Inquire1.php">
	課程代號: <input name ="inquire_id">
    課程名稱: <input name ="inquire_name">
    課程時間: <input name ="inquire_time">
    授課老師: <input name ="inquire_tr_name">

	<input type="submit" value="查詢課程">
	</form>

	<?php
	//課程查詢
		session_start();
		if(isset($_POST['inquire_id'])) {
			$inquire_id=$_POST["inquire_id"];
			$_SESSION["inquire_id"]= $inquire_id;
		}
		if(isset($_POST['inquire_name'])) {
			$inquire_name=$_POST["inquire_name"];
			$_SESSION["inquire_name"]= $inquire_name;
		}
		if(isset($_POST['inquire_time'])) {
			$inquire_time=$_POST["inquire_time"];
			$_SESSION["inquire_time"]= $inquire_time;
		}
		if(isset($_POST['inquire_tr_name'])) {
			$inquire_tr_name=$_POST["inquire_tr_name"];
			$_SESSION["inquire_tr_name"]= $inquire_tr_name;
		}
		if (isset($_GET['status'])) {
			if($_GET['status'] === 'Idnotmatch'){
				echo '<span style="color:red"><p>查詢失敗!課程代碼錯誤</p></span>';//課程代碼錯誤
			}
			if($_GET['status'] === 'Namenotmatch'){
				echo '<span style="color:red"><p>查詢失敗!課程名稱錯誤</p></span>';//課程名稱錯誤
			}
			if($_GET['status'] === 'Timenotmatch'){
				echo '<span style="color:red"><p>查詢失敗!課程時間錯誤</p></span>';//課程時間錯誤
			}
			if($_GET['status'] === 'Trnamenotmatch'){
				echo '<span style="color:red"><p>查詢失敗!老師姓名錯誤</p></span>';//老師姓名錯誤
			}
			if($_GET['status'] === 'successful'){
				echo '<span style="color:blue"><p>查詢成功!</p></span>';//查詢成功
				//從資料庫中獲取所有課程
				$sql = "SELECT distinct c_id, c_name, required, c_credit, department, c_grade, c_limit, current_enrollment, day, start_time,end_time
						FROM courses as C
						where C.c_id='$inquire_id'
						or C.c_name='$inquire_name'
						or C.c_time='$inquire_time'
						or C.c_tr_name='$inquire_tr_name'";
						
				$result = mysqli_query($conn, $sql) or die('MySQL query error');
				$courses = array();
				while ($row = mysqli_fetch_assoc($result)) {
					$courses[] = $row;
				}

				echo "<br>符合條件的課程";
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
			}	
		}		

		$student_id=$_SESSION["student_id"] ;
		
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






