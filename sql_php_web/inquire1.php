課程查詢判斷
<?php
	if(isset($_POST['inquire_id'])||$_POST['inquire_name']||$_POST['inquire_time']||$_POST['inquire_tr_name']) {
		session_start();
		
		$inquire_id=$_POST["inquire_id"];
        $inquire_name=$_POST["inquire_name"];
        $inquire_time=$_POST["inquire_time"];
        $inquire_tr_name=$_POST["inquire_tr_name"];
		$_SESSION["inquire_id"]= $inquire_id;
        $_SESSION["inquire_name"]= $inquire_name;
        $_SESSION["inquire_time"]= $inquire_time;
        $_SESSION["inquire_tr_name"]= $inquire_tr_name;

		$student_id=$_SESSION["student_id"] ;
	
		$dbhost = '127.0.0.1';
		$dbuser = 'hj';
		$dbpass = 'test1234';
		$dbname = 'testdb';
		$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
		mysqli_query($conn, "SET NAMES 'utf8'");
		mysqli_select_db($conn, $dbname);

		$query="SELECT c_credit FROM courses WHERE c_id = $drop_c_id";
		$result = mysqli_query($conn, $query) or die('MySQL query error');
		$row = mysqli_fetch_assoc($result);
		$credits = $row['c_credit'];
		
		//先判斷課程代碼是否正確
		$sql_r = "SELECT COUNT(*) as count 
				  FROM courses c 
				  WHERE c.c_id='$inquire_id'";
		$result_r = mysqli_query($conn, $sql_r) or die('MySQL query error');
		$row_r = $result_r->fetch_assoc();
		$count = $row_r['count'];
		if ($count != 1) {
			header('Location: inquire.php?status=Idnotmatch');//課程代碼錯誤
			exit;
		}

		//判斷課程名稱是否正確
		$sql_r = "SELECT COUNT(*) as count 
				  FROM courses c 
				  WHERE c.c_name='$inquire_name'";
		$result_r = mysqli_query($conn, $sql_r) or die('MySQL query error');
		$row_r = $result_r->fetch_assoc();
		$count = $row_r['count'];
		if ($count != 1) {
			header('Location: action4.php?status=Namenotmatch');//課程名稱錯誤
			exit;
		}

		//課程時間是否正確
		$sql_r = "SELECT COUNT(*) as count 
				  FROM courses c 
				  WHERE c.c_time='$inquire_time'";
		$result_r = mysqli_query($conn, $sql_r) or die('MySQL query error');
		$row_r = $result_r->fetch_assoc();
		$count = $row_r['count'];
		if ($count != 1) {
			header('Location: action4.php?status=Timenotmatch');//課程時間錯誤
			exit;
		}

		//老師姓名是否正確
		$sql_r = "SELECT COUNT(*) as count 
				  FROM courses c 
				  WHERE c.c_tr_name='$inquire_tr_name'";
		$result_r = mysqli_query($conn, $sql_r) or die('MySQL query error');
		$row_r = $result_r->fetch_assoc();
		$count = $row_r['count'];
		if ($count != 1) {
			header('Location: action4.php?status=Trnamenotmatch');//老師姓名錯誤
			exit;
		}
		
   	
   
    //其餘可查詢
    $sql_r = "SELECT 
			  FROM courses c 
			  WHERE  C.c_id='$inquire_id'
				or C.c_name='$inquire_name'
				or C.c_time='$inquire_time'
				or C.c_tr_name='$inquire_tr_name'";
    $result = mysqli_query($conn, $sql) or die('MySQL query error');
	
    header('Location: action4.php?status=查詢成功');//查詢成功
	exit;
    }    
?>
