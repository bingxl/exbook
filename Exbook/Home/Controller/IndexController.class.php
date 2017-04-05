<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function index() {
		/*$ubook = M('ubook');
		//$data = $cource->field(array('class'=>"班级",'count(cource)'=>'课程量'))->group('class')->order('class')->select();
		header("Content-Type:text/html;Charset=UTF-8");
		$result = $ubook -> where("state='正常'" ) -> select();
			$this -> ajaxReturn($result);*/
			$this->display('uploade');
	}

	/*
	 * 上传图片
	 * @access public
	 * @param string $type must 图像类型/用户头像 or 书籍图片
	 * @param interger $tell 用户手机上传头像时需要
	 * @return json
	 * */
	public function upload(){
		$type = I('type',null);
		$tell = I('tell',null);
		if($type!='book' && $type!='head'){
			$return['state']=false;
			$return['msg'] = "参数错误,type不正确";
			echo json_encode($return);
			exit;
		}
		$upload = new \Think\Upload();// 实例化上传类    
		if($type=='head'){
			if($tell==null){
				$return['state']=false;
				$return['msg'] = "参数错误,tell is error";
				echo json_encode($return);
				exit;
			}
			$upload->saveName = $tell;
			$upload->replace = true;
		}else{
			$time = time();
			$upload->saveName = "$time";//saveName 的值必须是字符或字符串，否则会出错
			$upload->replace = false;
		}
		$upload->maxSize   =     3145728 ;// 设置附件上传大小    
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
		$upload->rootPath  = 	'./Uploads/';//上传根目录
		$upload->savePath  =    'img/'.$type."/"; // 设置附件上传目录    // 上传文件   
		$upload->subName   = 	null;//子目录命名规则  
		$info   =   $upload->upload();    
		if(!$info) {
			// 上传错误提示错误信息       
		 	$state = false;
			$msg = $upload->getError();
			$data = null;
		}else{
			// 上传成功       
			foreach($info as $file){
			 	$img =  "http://182.254.148.178/Uploads/".$file['savepath'].$file['savename']; 
			}
			$state = true;
			$msg = "上传成功";
			$data = array('img'=>$img);
		}
		$return = array(
			'state' => $state,
			'msg' =>$msg,
			'data' =>$data,
		);
		echo json_encode($return);
		exit;
	}	
	
	//获取书籍分类
	public function getType(){
		$type = I('type',null);
		$db = M("type");
		if("first"==$type){
			$return = $db->distinct(true)->field('ftype')->select();
			$this->ajaxReturn($return);
		}
		
		$ftype = I("ftype",null);
		if($ftype){
			
			if($ftype=="教材类"){
				$return = M('class')->distinct(true)->field('yard')->select();
			}else{
				$return = $db->where("ftype='".$ftype."'")->select();
			}
				//var_dump($return);
				$this->ajaxReturn($return);
		}
			
		if(I("yard")){
			$yard = I("yard");
			$return = M('class')->where("yard='".$yard."'")->field('major')->select();
			$this->ajaxReturn($return);
		}
	}
	
	//获取课程名
	public function getcource(){
		$course = M("cource");
		$class = I('class',null);
		$yard = I("yard",null);
		//如果class和yard值都为空则退出
		if($class){
			$class=substr($class,2);
			$where['class'] = array('like',"__".$class);
			
		}elseif($yard){
			$where['yard'] =$yard;
		}else{
			$this->ajaxReturn(array(
				'state'=>false,
				'msg'=>"参数不正确	",
			));
		}
		if(I("grade")){
			$where['grade']=I("grade");
		}
		$result = $course->distinct(true)->field("class,yard,cource,grade")->where($where)->select();
		$return = array(
				'state'=>true,
				'msg'=>"读取成功	",
				'data'=>$result
			);
		
		$this->ajaxReturn($return);
		
	}
	
}
