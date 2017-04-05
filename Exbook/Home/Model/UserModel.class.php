<?php
	namespace Home\Model;
	use Think\Model;
	class UserModel extends Model{
		/*protected $_map = array(
			'name' =>'username', // 把表单中name映射到数据表的username字段
			'mail'  =>'email', // 把表单中的mail映射到数据表的email字段
		);*/
		protected $patchValidate = true;//一次性全部验证后返回为false时碰到未通过的字段则停止验证
		protected $_validate = array(
		//array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
		//字段，规则require 字段必须、email 邮箱、url URL地址、currency 货币、number 数字
		//提示信息 （必须）用于验证失败后的提示信息定义
		//验证条件 0存在就验证（默认） 1必须验证 2不为空时验证
		//附加规则：function，callback confirm,equal,in,notin,length,unique等
		//验证时间：1新增数据时验证，2 编辑数据时验证，3 全部验证，4注册时验证（实例化时传入4）
			array('tell','require','手机号不能为空',1,'',1),
			array('tell','','手机号已被占用','0','unique',1),//主键不能验证唯一性，更改用户表的主键
			array('pwd','require','密码不能为空','0','',1),
			//array('nickname','',"昵称已存在",'2','unique',1),
			//array('uname','',"姓名不能为空",'2'),
			//array('head',"url",'头像不能为空','2','',1)
		);
		protected $_auto = array (
		    //array('status','1'),  // 新增的时候把status字段设置为1
		   // array('pwd','md5',3,'function') , // 对password字段在新增和编辑的时候使md5函数处理
		    //array('name','getName',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法       
		    //array('update_time','time',2,'function'), // 对update_time字段在更新的时候写入当前时间戳
		);
		
		public function read($where='1=1'){
			return M("user")->where($where)->select();
		}
	}
