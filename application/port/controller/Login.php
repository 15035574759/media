<?php
namespace app\port\controller;
use	think\Controller;
use	think\Request;
use	think\Db;
use app\port\model\LoginModel;
class Login extends	Controller	
{	
	public function index()
	{
		// $time = time();
		return $this->fetch('login');
	}

	/**
	 * 用户注册
	 * @return [type] [description]
	 */
	public	function login()				
	{
		$time = time();								
		$data = input('param.');
		$data['time'] = $time;
		unset($data['key']);
		$KeyServer = MD5($data['name'].$data['password'].$time);
		if($KeyServer != $KeyServer){
			$result = array('code'=>1001,'data'=>"key值验证失败");
			exit(json_encode($result));
		}
		//注册入库
		$LoginModel = new LoginModel();
		$UserOne = $LoginModel->SelectOne($data['name']);

		if($UserOne){
			$result = array('code'=>1004,'data'=>"用户名已经存在");
			exit(json_encode($result));
		}

		$res = $LoginModel->UserAdd($data);
		if($res)
		{
			$result = array('code'=>1000,'data'=>"注册成功");
			exit(json_encode($result));
		}
		else
		{
			$result = array('code'=>1003,'data'=>"注册失败");
			exit(json_encode($result));
		}
	}

	 public	function GetQuit()				
	{								
		return $this->fetch('login');
	}


}
