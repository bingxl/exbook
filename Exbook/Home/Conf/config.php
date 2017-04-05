<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'=>'mysqli',// 数据库类型
	'DB_HOST'=>'127.0.0.1',// 服务器地址
	'DB_NAME'=>'xd_book',// 数据库名
	'DB_USER'=>'root',// 用户名
	'DB_PWD'=>'lxb106170',// 密码
	'DB_PORT'=>3306,// 端口
	'DB_PREFIX'=>'gc_',// 数据库表前缀
	'DB_CHARSET'=>'utf8',// 数据库字符集
	'SHOW_PAGE_TRACE' =>true, 
	//过滤字段
	'DEFSULT_FILTER' => 'addslashes,htmlentities',
	
	'SESSION_AUTO_START' =>true,
);
