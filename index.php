<?php
	include 'message.php';
	ini_set('date.timezone','Asia/Taipei');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo "我的留言版"?></title>
</head>
<body>
	<p>
		<?php
			$messages = array();
			$tmp_message_name = array();

			$dir = opendir("message");
			while ($file = readdir($dir)) {
				if($this_file_name = strstr($file, '.txt', true)){
					$tmp_path = "message/" . $this_file_name . '.txt';
					if($file = fopen($tmp_path, 'r+')){
						$tmp_message = new Message;
						$tmp_message->filename = $this_file_name . '.txt';
						while (($data = fgetcsv($file, 1000)) != null) {
							if(count($data) >= 4){
								$tmp_message->username = $data[0];
								$tmp_message->useremail = $data[1];
								$tmp_message->messagetitle = $data[2];
								$tmp_message->message = "\"" . $data[3] . "\"";
							}
						}
						$messages[] = $tmp_message;
						fclose($file);
					}
				}
			}
			closedir($dir);
		?>
		<a href=""></a>

		<?php foreach ($messages as $message) { ?>
			<li>
				<?php
					$tt_filename = $message->filename;
					echo "<a href='show.php?filename=$tt_filename'>" . $message->messagetitle . "<a/>";
				?>
			</li>
		<?php } ?>
	</p>

	<hr />

	<form method='post' action="process.php" enctype="multipart/form-data">
		<p>
			留言人：<input type="text" name="username" size="10">
		</p>
		<p>
			Email：<input type="text" name="useremail" size="20">
		</p>
		<p>
			留言主題：<input type="text" name="messagetitle" size="20">
		</p>
		<p>
			留言： <br>
			<textarea name="message" cols="60" rows="30"></textarea>
			<!-- <input type="text" name="messgae" size="200"> -->
		</p>
		<p>
			<input type="submit" value="送出">
		</p>
	</form>
</body>
</html>
