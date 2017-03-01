<?php

namespace app\port\model;
use think\Model;
use think\Db;

class LoginModel extends Model
{
	protected $name = 'porttest';

	/**
	 * 添加用户
	 * @param [type] $data [description]
	 */
	public function UserAdd($data){
		return Db::name("porttest")->insert($data);
	}

	function SelectOne($name){
		return Db::table('porttest')->where('name',$name)->find();
	}
}