<?php
/**
 * 极客之家 高端PHP - 车系 车型模model
 *
 * @copyright  Copyright (c) 2016 QIN TEAM (http://www.qlh.com)
 * @license    GUN  General Public License 2.0
 * @version    Id:  Type_model.php 2016-6-12 16:36:52
 */
namespace app\admin\model;
use think\Model;
use think\Db;
class CarModel extends Model
{
	 // 设置当前模型对应的完整数据表名称
    protected $table = 'car_series';

    /*
     * 读取车系车型父级
     */
    function GetSelectOne()
    {
    	return Db::name($this->table)->where('pid',0)->select();
    }

    /**
     * 调用 车系车型 子级
     * @param [type] $id [description]
     */
    function CarClass($id)
    {
    	return Db::name($this->table)->where('pid',$id)->select();
    }

    /**
     * 调用 经销商 子级
     * @param [type] $id [description]
     */
    function DealerClass($id)
    {
        return Db::name("dealer_list")->where('pid',$id)->select();
    }

    /**
     * 查询车系车型 名称
     * @param [type] $id [description]
     */
    function CarSelectName($id)
    {
        $res = DB::name($this->table)->field("car_id,car_name")->where('car_id','in',$id)->select();
        foreach ($res as $key => $value) {
            $arr[] = $value['car_name'];;
            $string = join(",",$arr);
        }
        return $string;
    }


}