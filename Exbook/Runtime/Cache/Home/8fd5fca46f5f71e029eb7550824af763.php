<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<form action="/exbook.php/Home/Book/add" method="post" >
			书名<input type="text" name="data[0][bname]" /><br />
			图片<input type="text" name="data[0][img]" /><br />
			介绍<input type="text" name="data[0][introduction]" /><br />
			分类<input type="text" name="data[0][type]" /><br />
			手机号<input type="text" name="data[0][tell]" /><br />
			交易类型<input type="text" name="data[0][tradetype]" /><br />
			价格<input type="text" name="data[0][price]" /><br />
			数量<input type="text" name="data[0][num]" /><br />
			出版社<input type="text" name="data[0][press]" /><br />
			版次<input type="text" name="data[0][edition]" /><br />
			ISBN<input type="text" name="data[0][ISBN]" /><br />
			作者<input type="text" name="data[0][author]" /><br />
			<hr/>
			书名<input type="text" name="data[1][bname]" /><br />
			图片<input type="text" name="data[1][img]" /><br />
			介绍<input type="text" name="data[1][introduction]" /><br />
			分类<input type="text" name="data[1][type]" /><br />
			手机号<input type="text" name="data[1][tell]" /><br />
			交易类型<input type="text" name="data[1][tradetype]" /><br />
			价格<input type="text" name="data[1][price]" /><br />
			数量<input type="text" name="data[1][num]" /><br />
			出版社<input type="text" name="data[1][press]" /><br />
			版次<input type="text" name="data[1][edition]" /><br />
			ISBN<input type="text" name="data[1][ISBN]" /><br />
			作者<input type="text" name="data[1][author]" /><br />
			<input type="submit" value="提交" >
		</form>
	</body>
</html>