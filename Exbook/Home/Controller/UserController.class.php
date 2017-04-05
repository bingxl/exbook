<?php
	namespace Home\Controller;
	use Think\Controller;
	class UserController extends Controller{
		/*
		 * 读取用户信息
		 * @access public
		 * @param number $tell  user tell
		 * @return json $return
		 * */
		public function read(){
			header("Content-Type:text/html;charset=utf8");
			$tell = I('tell',null);
			if($tell && session('uid')){
				$user=M('user');
				//gc_user 表字段：uid`, `tell`, `pwd`, `nickname`, `address`, `time`, `school`, `email`, `qq`, `wechat`, `sex`, `head`, `type`, `yard`, `major`, `state`, `uname`, `class`
				$result = $user->where('tell='.$tell)->field(array('pwd','time','state'),true)->find();
				$state = true;
				$msg = "读取成功";
				$data = $result;
			}elseif(!$tell){
				$state = false;
				$msg = "读取失败，手机号为空";
				$data = null;
			}elseif(!session("uid")){
				$state = false;
				$msg = "读取失败，未登录";
				$data = null;
			}
			$return['state'] = $state;
			$return['msg'] = $msg;
			$return['data'] = $data;
			echo json_encode($return);
			exit;
		}
		
		/*
		 * 更新用户信息
		 * @access public
		 * @param array 
		 * @return json $return
		 * */
		public function update(){
			load("@.judgelogin");
			$user = D('User');
			if(!$user->where('uid='.$_POST['uid'])->data($_POST)->save()){
				$return['state'] = false;
				$return['msg'] = "数据未通过验证";
				$return['data'] = ($user->getError($_POST,0));
				
			}else{
				$return['state'] = true;
				$return['msg'] = "修改成功";
			}
			
			echo json_encode($return);
			exit;
		}
		
		
		public function del(){
			
		}
		
		/*
		 * 登录
		 * @access public
		 * @param number $tell
		 * @param string $pwd
		 * @return json
		 * */
		public function login(){
			header("Content-Type:text/html;charset=utf8");
			$tell = I("tell");
			if($tell==null || $tell==''){
				$return['state'] = false;
				$return['msg'] = "手机号为空";
				echo json_encode($return);
				exit;
			}else if(session('tell')===$tell){
				$return['state'] = true;
				$return['msg'] = "登录成功";
				echo json_encode($return);
				exit;
			}
			$pwd = I("pwd");
			$user = M('user');
		
			$result = $user->where('tell="'.$tell.'" AND pwd="'.$pwd.'"')->field('tell,nickname,uid')->find();
			if(count($result)){
				$return['state'] = "true";
				$return['msg'] = "登录成功";
				session('tell',$result['tell']);
				session('nickname',$result['nickname']);
				session('uid',$result['uid']);
			}else{
				$return['state'] = "false";
				$return['msg'] = "用户名或密码错误";
			}
			echo json_encode($return);
			exit;
		}
		
		/*
		 * 注销登录
		 * @access public
		 * @return json
		 * */
		public function unlogin(){
			session_start();
			session('tell',null);
			session('nickname',null);
			session('uid',null);
			$return['state'] = "true";
			$return['msg'] = "注销成功";
			echo json_encode($return);
			exit;
		}
		
		/*
		 * 用户注册
		 * @access public
		 * @param array POST 用户信息
		 * @return json
		 * 2016/09/10本地验证
		 * */
		public function register(){
			header("Content-Type:text/html;charset=utf8");
			$user = D('User');
			if(!$user->create()){
				$return['state'] = false;
				$return['msg'] = "数据未通过验证";
				$return['data'] = ($user->getError($_POST,0));
				echo json_encode($return);
				exit;
			}else{
				if($user->add()){
					$return['state'] = true;
					$return['msg'] = "注册成功成功";
				}else{
					$return['state'] = false;
					$return['msg'] = "注册失败";
				}
			}
			echo json_encode($return);
			exit;
		}
		
		//修改密码
		public function changepwd(){
			//load("@.judgelogin");
			//header("content-type:html;charset=utf8");
			$user = D('User');
			$uid = I("uid",session('uid'));
			$pwd = I("pwd",null);
			if(!$uid || !$pwd){
				$this->ajaxReturn(array(
					'state'=>false,
					'mssg'=>"数据格式不正确"
				));

			}
	
		if(!$user->where('uid='.$uid)->data("pwd=".$pwd)->save()){
				$return['state'] = false;
				$return['msg'] = "数据未通过验证";
			}else{
				$return['state'] = true;
				$return['msg'] = "修改成功";
			}
			
			echo json_encode($return);
			exit;
		}
		
		public function registerhtml(){
			$this->display('register');
		}
		public function updatehtml(){
			$userdb = M("user");
			$person = $userdb->where('tell=15002955935')->select();
			dump($person);
			$this->assign('person',$person[0]);
			$this->display('update');
		}
		
	}
	?>
