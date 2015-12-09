<?php
	include 'message.php';
	$message = new Message;
	$filename = $_GET['filename'];
	$path = 'message/' . $filename;
	if($file = fopen($path, 'r+')){
		$message->filename = $filename;
		while (($data = fgetcsv($file, 1000)) != null) {
			if(count($data) >= 4){
				$message->username = $data[0];
				$message->useremail = $data[1];
				$message->messagetitle = $data[2];
				$message->message = $data[3];
			}
		}
		fclose($file);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?echo $message->messagetitle?></title>
</head>
<body>
	<p>
		<?php
			echo "留言人：$message->username";
		?>
	</p>
	<p>
		<?php
			echo "email: $message->useremail";
		?>
	</p>
	<p>
		<?php
			echo "標題: $message->messagetitle";
		?>
	</p>
	<p>
		<?php
			echo "內容: <p>$message->message</p>";
		?>
	</p>

	<input type="submit" onclick="window.history.go(-1);" value="返回">
	<input name="del[]" type="submit" value="刪除" onclick="location.href='del_process.php?del=<?= $filename?>'">
</body>
</html>
