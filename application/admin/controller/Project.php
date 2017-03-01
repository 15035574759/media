<?php
/**
 * 极客之家 高端PHP - 项目模块
 *
 * @copyright  Copyright (c) 2016 QIN TEAM (http://www.qlh.com)
 * @license    GUN  General Public License 2.0
 * @version    Id:  Type_model.php 2016-6-12 16:36:52
 */
namespace app\admin\controller;
use	think\Controller;
use	think\Request;
use	think\Db;
use app\admin\model\ProjectModel;
use app\admin\model\BrandModel;
class Project extends	Base	
{	

	/**
	 * 项目列表
	 * @return [type] [description]
	 */
	public	function show()				
	{	
		$project = new ProjectModel();	
		$data = $project->showAll();
		$this->assign('data',$data);						
		return $this->fetch();
	}

	/**
	 * 项目添加
	 */
	public function add()
	{
		$brand = new BrandModel();
		$project = new ProjectModel();
		// $user = new ProjectModel($_POST);
		if(input('param.')){
			$data = input('param.');
			$data['brand'] = implode(",", $data['brand_id']);
			$beginPeriod = str_replace("-","/",$data['beginPeriod']);
			$endPeriod = str_replace("-","/",$data['endPeriod']);
			$data['period'] = $beginPeriod.'-'.$endPeriod;
			$data['time'] = date("Y-m-d H:i:s");
			// p($endPeriod);
			$res = $project->ProjectAdd($data);
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
			$data = $brand->GetSelect();
			$this->assign('data',$data);
			return $this->fetch();
		}
	}

	/**
	 * 查询品牌子级
	 */
	function GetBrandAdd()
	{
		$brand = new BrandModel();
		$brand_id = input('param.brand_id');
		$data = $brand->GetBrandAdd($brand_id);
		exit(json_encode($data));
	}

}
