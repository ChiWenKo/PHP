<a href = "index.php"> Go Query Interface</a> <p>

<?php
	session_start(); // 啟動會話

// 檢查用戶是否已經登錄
if (!isset($_SESSION['student_id'])) {
  header('Location: index.php');
  exit();
}

// 刪除所有的會話數據
session_destroy();

// 轉到登錄頁面，並顯示登出成功信息
header('Location: index.php?status=logout_success');
exit();
?>


