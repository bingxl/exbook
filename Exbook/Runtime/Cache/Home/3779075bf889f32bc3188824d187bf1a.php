<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<form action="/exbook.php/Home/User/update" method="post">
			手机:<input value="<?php echo ($person["tell"]); ?>" type='text' name='tell'><br />
			密码:<input value="<?php echo ($person["uid"]); ?>" type='number' name='uid'><br />
			昵称:<input value="<?php echo ($person["nickname"]); ?>" type='text' name='nickname'><br />
			姓名:<input value="<?php echo ($person["uname"]); ?>" type='text' name='uname'><br />
			班级:<input value="<?php echo ($person["class"]); ?>" type='text' name='class'><br />
			住址:<input value="<?php echo ($person["address"]); ?>" type='text' name='address'><br />
			学校:<input value="<?php echo ($person["school"]); ?>" type='text' name='school'><br />
			邮箱:<input value="<?php echo ($person["email"]); ?>" type='text' name='email'><br />
			Q&nbsp;Q:<input value="<?php echo ($person["qq"]); ?>" type='text' name='qq'><br />
			微信:<input value="<?php echo ($person["wechat"]); ?>" type='text' name='wechat'><br />
			性别:<input value="<?php echo ($person["sex"]); ?>" type='text' name='sex'><br />
			头像:<input value="<?php echo ($person["head"]); ?>" type='text' name='head'><br />
			分类:<input value="<?php echo ($person["type"]); ?>" type='text' name='type'><br />
			学院:<input value="<?php echo ($person["yard"]); ?>" type='text' name='yard'><br />
			专业:<input value="<?php echo ($person["major"]); ?>" type='text' name='major'><br />
			<input type='submit' value='sub'>
		</form>
	</body>
</html>