<?php
namespace app\admin\controller;
use	think\Controller;
use	think\Request;
use	think\Db;
use think\Session;
class Index extends	Base	
{				
	public	function index()				
	{								
		return $this->fetch();
	} 

	public	function top()				
	{	
		$UserName = session::get("admin_username");
		$this->assign("UserName",$UserName);
		return $this->fetch();
	}

	public	function menu()				
	{								
		return $this->fetch();
	}

	public	function main()				
	{								
		return $this->fetch();
	}

}
