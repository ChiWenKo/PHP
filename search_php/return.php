<!DOCTYPE html>
<html>
<head>
	</style>
</head>

<?php
session_start();

    $dbhost = '127.0.0.1';
    $dbuser = 'hj';
    $dbpass = 'test1234';
    $dbname = 'testdb';
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
    mysqli_query($conn, "SET NAMES 'utf8'");
    mysqli_select_db($conn, $dbname);

    if(isset($_SESSION["student_id"])) {
        header('Location: student.php?status=stu');
        exit;
    }
    elseif(isset($_SESSION["teacher_id"])) {
        header('Location: teacher.php?status=tr');
        exit;
    }
    elseif(isset($_SESSION["TA_id"])) {
        header('Location: TA.php?status=ta');
        exit;
    }
    
    // 關閉資料庫連接
    mysqli_close($conn);


    

?>
