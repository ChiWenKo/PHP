
課程匯入系統<p>
<a href="action1.php"><button>已選課表</button></a>
<a href = "logout.php"><button>登出</button></a><p>


<fieldset style="width: 30%;">
	<legend>匯入課程</legend>
	<form action="" method="post">
		<label for="c_id">課程代碼:</label>
		<input type="text" name="c_id" id="c_id" value=""><br>

		<label for="c_name">課程名稱:</label>
		<input type="text" name="c_name" id="c_name" value=""><br>

		<label for="required">必選修:</label>
		<select name="required" id="required">
			<option value="必修">必修</option>
			<option value="選修">選修</option>
		</select><br>

		<label for="c_credit">學分數:</label>
		<select name="c_credit" id="c_credit">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select><br>

		<label for="department">科系:</label>
		<input type="text" name="department" id="department" value=""><br>

		<label for="c_grade">年級:</label>
		<select name="c_grade" id="c_grade">
			<option value="1">一年級</option>
			<option value="2">二年級</option>
			<option value="3">三年級</option>
			<option value="4">四年級</option>
		</select><br>

		<!-- <label for="instructor">授課教師:</label>
		<input type="text" name="instructor" id="instructor" required value=""><br> -->

		<label for="c_limit">加選人數上限:</label>
		<input type="number" name="c_limit" id="c_limit" value=""><br>

		<label for="day">上課星期:</label>
		<select name="day" id="day">
			<option value="星期一">星期一</option>
			<option value="星期二">星期二</option>
			<option value="星期三">星期三</option>
			<option value="星期四">星期四</option>
			<option value="星期五">星期五</option>
			<option value="星期六">星期六</option>
			<option value="星期日">星期日</option>
		</select><br>
	
		<label for="start_time">開始節數:</label>
		<select name="start_time" id="start_time">
			<?php
				$timeRanges = array();
				for ($i = 1; $i <= 14; $i++) {
					$startTime = ($i <= 11) ? sprintf('%02d', $i + 7) . ':10' : sprintf('%02d', $i + 6) . ':30';
					$endTime = ($i <= 11) ? sprintf('%02d', $i + 8) . ':00' : sprintf('%02d', $i + 7) . ':20';
					$timeRanges[] = $startTime . '~' . $endTime;
					echo "<option value=\"$i\">$i</option>";
				}
			?>
		</select>
		&nbsp;
		<label for="end_time">結束節數:</label>
		<select name="end_time" id="end_time">
			<?php

				for ($i = 1; $i <= 14; $i++) {
					echo "<option value=\"$i\">$i</option>";
				}
			?>
		</select><br><br>
		<button type="submit">匯入</button>
	</form>
</fieldset>

<?php
	function import($timeRanges) {
		$server = "localhost";
		$database = "course-registration-system";
		$db_username = "root";
		$db_password = "BlackPomeranian";
		$port = 3306;

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$course_data_dict = array(
				"c_id" => $_POST["c_id"],
				"c_name" => $_POST["c_name"],
				"required" => $_POST["required"],
				"c_credit" => $_POST["c_credit"],
				"department" => $_POST["department"],
				"c_grade" => $_POST["c_grade"],
				"c_limit" => $_POST["c_limit"],
				"day" => $_POST["day"],
				"start_time" => $_POST["start_time"],
				"end_time" => $_POST["end_time"]
				
			);

			$course_data_list = array_values($course_data_dict);

			for($i = 0; $i < 10; $i++) {
				if($course_data_list[$i] == null) {
					echo "<script>window.alert(\"資料不齊全\")</script>";
					return;
				}
			}

			if($course_data_dict["c_limit"] < 10) {
				echo "<script>window.alert(\"不符合最低開課人數要求\")</script>";
				return;
			}


			
			
			$conn = new mysqli($server, $db_username, $db_password, $database, $port);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$sql = "SELECT * FROM Courses;";
			$result = $conn->query($sql);

			while($row = $result->fetch_assoc()) {
				if($row["c_id"] == $course_data_dict["c_id"]) {
					echo "<script>window.alert(\"匯入失敗，課程代碼已存在\")</script>";
					return;
				}
			}
			$start_time = explode('~', $timeRanges[$course_data_dict["start_time"]-1]);
			$end_time = explode('~', $timeRanges[$course_data_dict["end_time"]-1]);
			$sql = "INSERT INTO Courses VALUES ({$course_data_dict["c_id"]}, \"{$course_data_dict["c_name"]}\", \"{$course_data_dict["required"]}\", {$course_data_dict["c_credit"]}, \"{$course_data_dict["department"]}\", {$course_data_dict["c_grade"]}, {$course_data_dict["c_limit"]}, 0, \"{$course_data_dict["day"]}\", \"{$start_time[0]}\", \"{$end_time[1]}\");";

			if ($conn->query($sql) === TRUE) {
				echo "<script>window.alert(\"匯入成功\")</script>";
			} else {
				die("錯誤: " . $sql . "<br>" . $conn->error);
			}
	
			$conn->close();
		}
	}
	import($timeRanges);
?>





