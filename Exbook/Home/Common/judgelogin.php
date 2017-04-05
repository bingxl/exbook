<?php
/*
 * 判断用户是否登录，未登录直接退出，返回相关状态，已登录则无影响
 * 
 * */
if(!(session('tell'))){//isset($_SESSION['tell'])
	$return = array(
		'state'=>false,
		'msg'=>"你还未登录",
		'data'=>null
	);
	echo json_encode($return);
	exit;
}
