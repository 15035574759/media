<?php
/**
 * 极客之家 高端PHP - 品牌模块
 *
 * @copyright  Copyright (c) 2016 QIN TEAM (http://www.qlh.com)
 * @license    GUN  General Public License 2.0
 * @version    Id:  Type_model.php 2016-6-12 16:36:52
 */
namespace app\admin\controller;
use	think\Controller;
use	think\Request;
use	think\Db;
use app\admin\model\BrandModel;
class Brand extends	Base	
{	
	/**
	 * 添加品牌
	 * @return [type] [description]
	 */
	public	function BrandAdd()				
	{	
		$brand = new BrandModel();
		if(input('param.'))
		{
			$data = input('param.');
			$data['time'] = date("Y-m-d H:i:s");
			// p($data);
			$res = $brand->BrandAdd($data);
			if($res){
				$this->success('添加成功','show');
			}
			else
			{
				$this->error('添加失败');
			}
		}
		else
		{
			//查询所有品牌分类
			$brandData = $brand->GetSelectAll();
			$this->assign('brandData',$brandData);									
			return $this->fetch('add');
		}
	} 

	/**
	 * 品牌列表
	 */
	public function BrandShow()
	{
		$brand = new BrandModel();
		$nav = new \org\Leftnav;
		$brandData = $brand->GetSelectAll();
		$this->assign('brandData',$brandData);									
		return $this->fetch('brand_show');
	}
}
