<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>title</title>
	</head>
	<body>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["yard"]); ?>:<?php echo ($vo["cource"]); ?><br/><?php endforeach; endif; else: echo "" ;endif; ?>
		<a href="/thinkphp/Exbook.php/Home/index/page/page/1">首页</a>
		<a href="/thinkphp/Exbook.php/Home/index/page/page/<?php echo ($page-1); ?>">上一页</a>
		<?php $__FOR_START_17917__=1;$__FOR_END_17917__=4;for($i=$__FOR_START_17917__;$i < $__FOR_END_17917__;$i+=1){ ?><a href="/thinkphp/Exbook.php/Home/index/page/page/<?php echo ($page-(4-$i)); ?>"><?php echo ($page-(4-$i)); ?></a>&nbsp;<?php } ?>
		<a href="#" display="display"><?php echo ($page); ?></a>
		<?php $__FOR_START_4850__=1;$__FOR_END_4850__=4;for($i=$__FOR_START_4850__;$i < $__FOR_END_4850__;$i+=1){ ?><a href="/thinkphp/Exbook.php/Home/index/page/page/<?php echo ($page+$i); ?>"><?php echo ($page+$i); ?></a>&nbsp;<?php } ?>
		共<?php echo ($apage); ?>页
		<a href="/thinkphp/Exbook.php/Home/index/page/page/<?php echo ($page+1); ?>">下一页</a>
		<a href="/thinkphp/Exbook.php/Home/index/page/page/<?php echo ($apage); ?>">尾页</a>
	</body>
</html>