<?php
namespace app\admin\controller;
use	think\Controller;
use	think\Request;
use	think\Db;
use app\admin\model\LoginModel;
use think\Session;
class Login extends	Controller	
{	
	public function index()
	{
		return $this->fetch('login');
	}	


	public	function login()				
	{	
		$user = new LoginModel();
		if(input('param.')){
			$data = input("param.");
			$data['password'] = MD5(md5($data['password']).config('auth_key'));
			$res = $user->Login($data);
			if($res['username'] == $data['username'])
			{
				if($res['password'] == $data['password'])
				{
					//获取该管理员的角色信息
			        $info = $user->getRoleInfo($res['groupid']);
			        session('admin_username', $data['username']);
			        session('admin_uid', $res['user_id']);
			        session('rolename', $info['title']);  //角色名
			        session('rule', $info['rules']);  //角色节点
			        session('name', $info['name']);  //角色权限
					// Session::set('UserData',$res);
					// $arr = Session::get('name');

			        //更新管理员状态
			        $param = [
			            'loginnum' => $res['loginnum'] + 1,
			            'last_login_ip' => request()->ip(),
			            'last_login_time' => time()
			        ];
			        Db::name('admin')->where('user_id', $res['user_id'])->update($param);
			        writelog($res['user_id'],$data['username'],'用户【'.$data['username'].'】登录成功',1);
			        exit(json_encode(array('code' => 1, 'data' => url('index/index'), 'msg' => '登录成功！')));
					// $this->success('登录成功','Index/index');
				}
				else
				{
					writelog($res['user_id'],$data['username'],'用户【'.$data['username'].'】登录失败：密码错误',2);
			        exit(json_encode(array('code' => -2, 'data' => '', 'msg' => '登录失败：密码错误')));
				}
			}
			else
			{
				writelog($res['user_id'],$data['username'],'用户【'.$data['username'].'】登录失败：用户名不存在',2);
				exit(json_encode(array('code' => -1, 'data' => '', 'msg' => '管理员不存在')));
			}
		}	
		else
		{
			return $this->fetch();
		}						
	}

	/**
	 * 用户退出
	 */
	 public	function GetQuit()				
	{		
		session(null);						
		return $this->fetch('login');
	}


}
