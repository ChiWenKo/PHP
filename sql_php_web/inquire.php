<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>�d�߽ҵ{</title>
	<style>
		.large-title {
		font-size: 25px;
		}
	</style>
</head>
<body>
	<a href = "logout.php"><button>�n�X</button></a><p>
	

	<h1 class="large-title">�d�߽ҵ{<p></h1>

	<form name="table4" method="post" action="Inquire1.php">
	�ҵ{�N��: <input name ="inquire_id">
    �ҵ{�W��: <input name ="inquire_name">
    �ҵ{�ɶ�: <input name ="inquire_time">
    �½ҦѮv: <input name ="inquire_tr_name">

	<input type="submit" value="�d�߽ҵ{">
	</form>

	<?php
	//�ҵ{�d��
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
				echo '<span style="color:red"><p>�d�ߥ���!�ҵ{�N�X���~</p></span>';//�ҵ{�N�X���~
			}
			if($_GET['status'] === 'Namenotmatch'){
				echo '<span style="color:red"><p>�d�ߥ���!�ҵ{�W�ٿ��~</p></span>';//�ҵ{�W�ٿ��~
			}
			if($_GET['status'] === 'Timenotmatch'){
				echo '<span style="color:red"><p>�d�ߥ���!�ҵ{�ɶ����~</p></span>';//�ҵ{�ɶ����~
			}
			if($_GET['status'] === 'Trnamenotmatch'){
				echo '<span style="color:red"><p>�d�ߥ���!�Ѯv�m�W���~</p></span>';//�Ѯv�m�W���~
			}
			if($_GET['status'] === 'successful'){
				echo '<span style="color:blue"><p>�d�ߦ��\!</p></span>';//�d�ߦ��\
				//�q��Ʈw������Ҧ��ҵ{
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

				echo "<br>�ŦX���󪺽ҵ{";
				echo "<br><table border='1'><br>";
				echo "<tr>
						<th> ��ҥN�� </th> 
						<th> �ҵ{�W�� </th>
						<th> ����� </th> 
						<th> �Ǥ��� </th>
						<th> �}�Ҩt�� </th> 
						<th> �}�Ҧ~�� </th>
						<th> �H�ƤW�� </th> 
						<th> �w��H�� </th>
						<th> �W�Ҥ� </th> 
						<th> �W�� </th>
						<th> �U�� </th>
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






