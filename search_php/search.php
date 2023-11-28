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
	<h1 class="large-title">查詢課程<p></h1>
    <a href = "search1.php"><button>返回</button></a>
	<a href = "logout.php"><button>登出</button></a><p>
	</form>
<?php
session_start();

if (isset($_POST['search'])) {
    // 取得搜尋條件
    $inquire_id = $_POST['inquire_id'];
    $inquire_name = $_POST['inquire_name'];
    $inquire_department = $_POST['inquire_department'];
    $inquire_time = $_POST['inquire_time'];

    $dbhost = '127.0.0.1';
    $dbuser = 'hj';
    $dbpass = 'test1234';
    $dbname = 'testdb';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
    mysqli_query($conn, "SET NAMES 'utf8'");
    mysqli_select_db($conn, $dbname);

    // 動態添加查詢條件
$conditions = array();
if (!empty($inquire_id)) {
    $conditions[] = "c_id = '$inquire_id'";
}
if (!empty($inquire_name)) {
    $conditions[] = "c_name = '$inquire_name'";
}
if (!empty($inquire_time)) {
    $conditions[] = "start_time = '$inquire_time'";
}
if (!empty($inquire_department)) {
    $conditions[] = "department = '$inquire_department'";
}

// 組合 SQL 查詢
$sql = "SELECT * FROM courses";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

    // 執行 SQL 查詢
    $result = mysqli_query($conn, $sql);
    
    // 處理查詢結果
    if ($result->num_rows > 0) {
        // 輸出數據
        echo "<br><br>符合條件的課程";
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
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
			echo "<td>" .$row['c_id']."</td>";
			echo "<td>" .$row['c_name']."</td>";
			echo "<td>" .$row['required']."</td>";
			echo "<td>" .$row['c_credit']."</td>";
			echo "<td>" .$row['department']."</td>";
			echo "<td>" .$row['c_grade']."</td>";
			echo "<td>" .$row['c_limit']."</td>";
			echo "<td>" .$row['current_enrollment']."</td>";
			echo "<td>" .$row['day']."</td>";
			echo "<td>" .$row['start_time']."</td>";
			echo "<td>" .$row['end_time']."</td>";
			echo "<tr>";
        }
        
    } else {

        echo "<br>沒有找到符合條件的課程資訊";   
    }

    // 關閉資料庫連接
    mysqli_close($conn);
}
?>
