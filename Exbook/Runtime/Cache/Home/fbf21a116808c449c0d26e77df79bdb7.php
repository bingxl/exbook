<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<form action="/exbook.php/Home/Index/upload" enctype="multipart/form-data" method="post" >
			<input type="text" name="name" /><input type="file" name="photo" />
			<input type="hidden" name="type" value="book">
			<input type="hidden" name="tell" value="15002955935">
			<input type="submit" value="提交" >
		</form>
	</body>
</html>