<?php
/**
 * 极客之家 高端PHP - 经销商模块
 *
 * @copyright  Copyright (c) 2016 QIN TEAM (http://www.qlh.com)
 * @license    GUN  General Public License 2.0
 * @version    Id:  Type_model.php 2016-6-12 16:36:52
 */
namespace app\admin\controller;
use	think\Controller;
use	think\Request;
use	think\Db;
use app\admin\model\DealerModel;
use app\admin\model\CarModel;
use app\admin\model\ProjectModel;
use app\admin\model\BrandModel;
class Dealer extends	Base	
{	
	/**
	 * 经销商添加
	 */
	public	function add()				
	{	
		$dealer = new DealerModel();
		$car = new CarModel();
		$project = new ProjectModel();
		// $user = new ProjectModel($_POST);
		if(input('param.')){
			$data = input('param.');
			$data['dealer_name'] = implode(",", $data['dealer_name']);
			$data['car_series_id'] = implode(",", $data['car_series_id']);
			$data['car_time'] = strtotime($data['car_time']);
			$data['time'] = time();
			// p($data);
			$res = $dealer->DealerAdd($data);
			if($res)
			{
				$this->success('添加成功','show');
			}
			else
			{
				$this->error('添加失败');
			}
		}
		else
		{
			//车型 车系
			$data = $car->GetSelectOne();
			//查询经销商 pid=0
			$DealerData = $dealer->SelectDealerPid();
			//项目
			$ProjectName = $project->ProjectSelectName();
			$this->assign('data',$data);
			$this->assign('DealerData',$DealerData);
			$this->assign('ProjectName',$ProjectName);
			return $this->fetch();
		}							
	} 

	/**
	 * 查询车系子级
	 */
	public function CarClass()
	{
		$car = new CarModel();
		$car_id = input('param.car_id');
		$data = $car->CarClass($car_id);
		exit(json_encode($data));
	}

	/**
	 * 查询经销商子级
	 */
	public function GetDealer()
	{
		$car = new CarModel();
		$dealer_id = input('param.dealer_id');
		$data = $car->DealerClass($dealer_id);
		exit(json_encode($data));
	}

	/**
	 * 经销商列表
	 * @return [type] [description]
	 */
	public function show()
	{

		$dealer = new DealerModel();
		$car = new CarModel();
		$id = empty(input('param.id/d')) ? "" : input('param.id/d');
		//查询车系车型
		if(!empty($id)){$data = $dealer->ProjectDealerAll($id);}else{$data = $dealer->SelectAll();}
		// p($data);
		foreach ($data as $key => $val) {
			//查询车系、车型
			$DataArrName = $car->CarSelectName($val['car_series_id']);
			//查询经销商
			$DataDealerName = $dealer->DealerSelectName($val['dealer_name']);
			$data[$key]['dealer_name'] = $DataDealerName;
			$data[$key]['car_series_id'] = $DataArrName;
		}
		// p($data);
		$this->assign('data',$data);												
		return $this->fetch();
	}

	/**
	 * 根据项目id查询经销商列表
	 */
	public function DealerIdList()
	{
		$dealer = new DealerModel();
		$id = input('param.id/d');
		$data = $dealer->DealerIdList($id);
		p($data);
	}

}
