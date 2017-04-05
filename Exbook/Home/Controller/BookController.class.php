<?php
	namespace Home\Controller;
	use Think\Controller;
	class BookController extends Controller{
		
		/*
		 * 添加书籍
		 * @access public
		 * @param array POST 书籍信息
		 * @return array $return(state msg )
		 * */
		public function add(){
			load("@.judgelogin");//登录后才能执行此操作(only when login has authority to add,else exit)
			
			 /*
			 * 获取传入书籍的bid  (get the book's bid whitch will uploading)
			 * @access protected
			 * @param array $where 查询条件 ( condition of search)
			 * @param array $addbook 书籍具体信息/当数据库里不存在是新增记录(detail of the book in order to uploading)
			 * @return number $bid
			 * */
			function getbid($where,$addbook){
				$book = M('book');
				$bid = $book->where($where)->getField('bid');	//search
				if(!$bid){
					$bid = $book->data($addbook)->add();	
					$bid = getbid($where);						//recursion to use function 递归调用函数
				}
				
				return $bid;
			}
			
			//判断数据是否存在
			if(!(I('data'))){
				$this->ajaxReturn(array(
					'state'=>false,
					'msg'=>"数据为空",
					'data'=>null
				));
			}
			if(is_string(I("data"))){
				$advalue = json_decode(I("data"));
			}else{
				$advalue = I("data");
			}
			
			for($i=0;$i<count($advalue);$i++){
				$values = $advalue[$i];
				$bname = isset($values['bname'])?$values['bname']:null;
				if(!$bname){
					$this->ajaxReturn(array(
						'state'=>false,
						'msg'=>"书名不能为空"
					));
				}
				$author = isset($values['author'])?$values['author']:null;
				$press = isset($values['press'])?$values['press']:null;
				$edition = isset($values['edition'])?$values['edition']:null;
				$ISBN = isset($values['isbn'])?$values['isbn']:null;
				$img = isset($values['img'])?$values['img']:null;
				$type = isset($values['type'])?$values['type']:null;
				$introduction = isset($values['introduction'])?$values['introduction']:null;
				$tradetype = isset($values['tradetype'])?$values['tradetype']:null;
				$num = isset($values['num'])?$values['num']:null;
				
				$book = array(
					  'bname'=>$bname, //`edition``press``author
					  'press'=>$press, 
					  'edition'=>$edition, 
					  'author'=>$author,
					);
				$addbook = $book;
	
				$addbook['mprice']= isset($values['mprice'])?$values['mprice']:null;
				$addbook['title']= isset($values['title'])?$values['title']:null;
				$addbook['ISBN'] = $ISBN;
				if(!$ISBN){
					$where = $book;
				}else {
					$where['ISBN'] = $ISBN;
				}
				
				$bid = getbid($where,$addbook);

				$ubook = array(
					
					'bid'=> $bid,
					'num'=> $num,
					'price'=> $values['price'],
					'tradetype'=> $tradetype,
					'tell'=> $values['tell']?$values['tell']:session('tell'),
					'type'=> $type,
					'introduction'=> $introduction,
					'state'=> '有',
					'img'=>$img
				);
				
				$insert = M('ubook');
				$in = $insert->data($ubook)->add();
				if($in){
					$return[] = array(
						'state'=>true,
						'msg'=>$bname."添加成功",
						'data'=>null
					);
				}else{
					
					$return[] = array(
						'state'=>false,
						'msg'=>$bname."添加失败",
						'data'=>null
					);
				}
			}
			
			echo json_encode($return);
			exit;
		}
		
		/*
		 * 获取书籍信息
		 * @access public
     	 * @param string $type  书本类型
		 * @param number $page  第几页（搜索结果）
		 * @param number $row  每页显示的数量
     	 * @return json data include book basic and the tell whitch has it
		 * */
		public function read(){
			header("Content-Type:text/html;charset=utf8");
			/*
			 * 读取所有书籍信息除了按学院专业
			 * @param string $tradetype 交易类型
			 * @param string bname书名
			 * @param number bid书类id
			 * @param number id书id
			 * @param string classify分类
			 * @return json
			 * */
			function readAll($page = 1,$row = 1,$where='1=1'){
				$m = M('ubook');//
				$field = "u.id,u.bid,u.num,u.price,u.tradetype,u.tell,u.type,u.introduction,u.state,u.img,b.press,b.bname,b.edition,b.ISBN,b.author,b.mprice,b.title";
				$result['data'] = $m->field("$field")->alias('u')->join('right join gc_book b on b.bid=u.bid')->where($where)->order("u.id desc")->limit(($page-1)*$row,$row)->select();
				$result['count'] = $m->alias('u')->join('right join gc_book b on b.bid=u.bid')->where($where)->count();
				
				return $result;
			}
			function readYard($where,$page,$row){
				$m = M('ubook');//
				$result['data'] = $m->field("$field")->alias('u')->join('right join gc_book b on u.bid=b.bid')->where('b.bid in (select bid from gc_cource where'.$where.')')->limit(($page-1)*$row,$row)->select();
				$result['count'] = $m->alias('u')->join('right join gc_book b on u.bid=b.bid')->where($where)->count();
				return $result;
			}
			$type = I('type','all');
			$page = I('page',1);
			$row = I('row',10);
			switch($type){
				case 'all':
				//$ar = array('tradetype','bname','bid','classify');	//使用数组进行判断是否存在，从而进行操作
					$where=null;
					if(I('tradetype')){
						$tra = '';
						switch(I('tradetype')){
							case 'jie':
								$tra = '借';
								break;
							case 'mai':
								$tra = '卖';
								break;
						}
						$where["u.tradetype"]=$tra;
					}
					if(I('bname')){
						$where["b.bname"]	=array('like',"%".I('bname')."%");
					}
					if(I('bid')){
						$where['b.bid'] = I('bid');
					}
					if(I('classify')){
						$to = array(
							';'=>'%',
							'；'=>'%',
							' '=>'%'
						);
						$like = '%'.strtr(I('classify'),$to).'%';//把；; 分隔符转换成%
						$where['u.type'] = array('like',$like);
					}
					$result = readAll($page,$row,$where);
					break;
				case "yard":
					$where = " yard='".I('yard',null)."'";
					if(I('major')){
						$where.=" AND major='".I('major')."'";
					}
					$result = readYard($where,$page,$row);
					break;
				default :$result['data'] = null;break;
			}
			if($result['data']){
				$state = true;
				$msg ="读取成功";
			}else{
				$state = false;
				$msg = "读取失败";
			}
			$return = array(
				'state'=>$state,
				'msg'=>$msg,
				'data' =>$result
			);
			echo json_encode($return);
			exit;
		}
		
		/*
		 * 读取自己上传的书籍和收藏的书籍
		 * @parameter int uid use id
		 * @parameter string type  with collect or null,null is mean read book with translate
		 */
		public function readmy(){
			$field = "u.id,u.bid,u.num,u.price,u.tradetype,u.tell,u.type,u.introduction,u.state,u.img,b.press,b.bname,b.edition,b.ISBN,b.author,b.mprice,b.title";
			
			function readup($page,$row,$tell,$field){
				$m = M('ubook');
				$result['data'] = $m->field("$field")->alias('u')->join('right join gc_book b on u.bid=b.bid')->where('u.tell='.$tell)->limit(($page-1)*$row,$row)->select();
				$result['count'] = $m->alias('u')->join('right join gc_book b on u.bid=b.bid')->where('u.tell='.$tell)->count();
				
				return $result;
			}
			
			function readcollect($page,$row,$tell,$field){
				$m = M('ubook');//
				$result['data'] = $m->field("$field")->alias('u')->join('right join gc_book b on u.bid=b.bid')->where('u.id in (select bid from gc_collect where tell='.$tell.')')->limit(($page-1)*$row,$row)->select();
				$result['count'] = $m->alias('u')->join('right join gc_book b on u.bid=b.bid')->where('b.bid in (select bid from gc_collect where tell='.$tell.')')->count();
				
				return $result;
			}
			$type = I('type',null);
			$page = I('page',1);
			$row = I('row',10);
			$tell =I("tell",$_SESSION['tell']);
			if(!$type){
				$result = readup($page,$row,$tell,$field);
			}else{
				$result = readcollect($page,$row,$tell,$field);
			}
		//	var_dump( $result );
			$this->ajaxReturn($result);
		}
		
		/*
		 * 更新书籍
		 * 可以更新的参数`num``price``tradetype``type``introduction``state``img`
		 * 必传参数 id 需要更改书籍的id号
		 * */
		public function update(){
			//load("@.judgelogin");
			$id = I("id",null);
			if(!$id){
				$this->ajaxReturn(array(
					'state'=>false,
					'msg'=>"id is null"
				));
			}
			if(isset($_POST['id'])){
				unset($_POST['id']);
			}
			$data = $_POST;
			
			$user = D('ubook');
			$result = $user->where('id='.$id)->data($data)->save();
			if(!$result){
				$return['state'] = false;
				$return['msg'] = "数据未通过验证";
				$return['data'] = ($user->getError($_POST,0));
				
			}else{
				$return['state'] = true;
				$return['msg'] = "修改成功";
			}
		
			$this->ajaxReturn($return);
		}
		
		/*
		 * 删除书籍
		 * @access public
		 * @param array  or number $id 书籍ID
		 * @return json $return state/msg/num
		 * */
		public function del(){
			//load("@.judgelogin");//has login? if no exit
			$id = I('id');
			if($id==null || $id==''){
				echo json_encode(array(
					'state' =>false,
					'msg'=>'书id为空',
					'data'=>null
				));
				exit;
			}
			$where = null;
			if(is_array($id)){
				$i = 1;
				foreach($id as $key=>$value){
					if($i==1){
						$where.="id=".$value;
					}else{
						$where.=" or id=".$value;
					}
				}
			}else $where.="id=$id";
			if(I("collect")){
				$db="collect";
			}else{
				$db = "ubook";
			}
			
			$book = M($db);
			if($book->where($where)->delete()){
				$return = array(
					'state' =>true,
					'msg'=>'成功删除',
					'data'=>null
				);
			}else{
				$return = array(
					'state' =>false,
					'msg'=>'删除失败',
					'data'=>null
				);
			}
			echo json_encode($return);
			exit;
		}
		
		/*
		 *借书和买书
		 * @access public
		 * @param number $id 
		 * @param number $tell
		 * @return json $return
		 * */
		public function lend(){
			load("@.judgelogin");
			$id = I('id',null);
			$tell = I('tell',session('tell'));
			if(!($id && $tell)){
				echo json_encode(array(
					'state'=>false,
					'msg'=>"参数不正确,或者未登录",
					'data'=>null
				));
				exit;
			}
			$ubook = M('ubook');
			$num = $ubook->field('num,tell')->where('id='.$id)->find();
			if($num['num']<I('num',1) && $num['num']==0){
				echo json_encode(array(
					'state'=>false,
					'msg'=>"借书量超出",
					'data'=>null
				));
				exit;
			}
			$lend = M('lend');
			$data = array(
				'id'=>$id,
				'ltell'=>$tell,
				'btell'=>$num['tell'],
				'ftime'=>date("Ymd H:i"),
				'state'=>"预"
			);
			$addlend = $lend->data($data)->add();
			if($addlend){
				echo json_encode(array(
					'state'=>true,
					'msg'=>"操作成功",
					'data'=>null
				));
			exit;
			}else{
				echo json_encode(array(
					'state'=>false,
					'msg'=>"添加租单时失败",
					'data'=>null
				));
			exit;
			}
			
			
		}
		
		/*
		 * 收藏书籍
		 * @access public
		 * @param number $bid 书id
		 * @param number $tell 用户
		 * @param string $remark 收藏备注
		 * @return json $return
		 * */
		public function collect(){
		 	load("@.judgelogin");
			$id = I('id',null);
			$tell = I('tell',session('tell'));
			$remark = I('remark',null);
			if($id && $tell){
				$book = M('collect');
				$data = array(
					'bid'=>$id,
					'tell'=>$tell,
					'remark'=>$remark
				);
				if( $book->data($data)->add() ){
					$return = array(
						'state'=>true,
						'msg'=>"收藏成功",
						'data'=>null
					);
				}else{
					$return = array(
						'state'=>false,
						'msg'=>"添加失败",
						'data'=>null
					);
				}
				
			}else{
				$return = array(
					'state'=>false,
					'msg'=>"参数错误",
					'data'=>null
				);
			}
			//var_dump($return);
			echo json_encode($return);
			exit;
		 }
		
	}
	
	?>
