<?php
namespace	app\admin\controller;
use	think\Controller;
use	think\Request;
use	think\Db;
use think\Session;
class Test extends	Base	
{				
	public	function index()				
	{								
	  return $this->fetch();	
	} 

	/**
	 * 登录
	 * @return [type] [description]
	 */
	public	function login()				
	{			
			$data = Request::instance()->post();

			// 获取表单上传文件 例如上传了001.jpg 
			$file = request()->file('image'); // image 为表单file的name值 
			// 移动到服务器的上传目录 /home/www/upload/ 
			if(empty($file))
			{
				$this->error("没有文件上传");
			}
			$info = $file->move('./static/upload/'); 
			if(!$info)
			{ 
				// 上传失败获取错误信息 
				echo $file->getError(); 
			} 
			//获取验证码
			$url = "http://www.qlh6.cn/code/session_code.php";
			$Arrcode = json_decode(file_get_contents($url),true);

			// 验证码检测
			if(strtolower($data['captcha']) != $Arrcode['code']){
				$this->error("验证码错误");
			}

			$res = Db::table('table')->where('name',$data['name'])->find();
			if($res)
			{
				if($data['password'] == $res['password'])
				{
					$this->success('登录成功','Test/show');
				}
				else
				{
					$this->error('密码输入错误');
				}
			}
			else
			{
				 $this->error('用户名输入错误');
			}
	} 

	/**
	 * 列表
	 * @return [type] [description]
	 */
	public function show()
	{
		//加载model
		// $user = model('User');
		// // $user->name= 'thinkphp';
		// $user->test();

		$data = db('table')->paginate(10);
		// 获取分页显示
		$page = $data->render();
		// echo $page;die;
		$this->assign('data',$data);
		$this->assign('page', $page);
		return $this->fetch();
	}

	/**
	 * 删除
	 * @return [type] [description]
	 */
	public function delete()
	{
		$id = Request::instance()->get('id'); // 获取某个get变量
		$res = db('table')->where("id",$id)->delete();
		if($res)
		{
			$this->success("删除成功","test/show");
		}
		else
		{
			$this->error("删除失败");
		}
	}

	/**
	 * 验证码生成
	 * @return [type] [description]
	 */
	function captcha()
	{
		$code = model("User");
		$images = $code->code();
		// echo $images;die;
		// header('Content-Type: image/png');
		// //3>imagepng() 建立png图形函数
		// imagepng($images);
		// //4>imagedestroy() 结束图形函数 销毁$image
		// imagedestroy($images);
	}

	function test()
	{
		return $this->fetch();
	}

	function tests()
	{
		return $this->fetch();
	}
}
