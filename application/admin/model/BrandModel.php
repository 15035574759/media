<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class BrandModel extends Model
{
	 // 设置当前模型对应的完整数据表名称
    protected $table = 'brand_carseries';

    /**
     * 读取全部数据
     */
    function GetSelectAll()
    {
        $data_list = Db::name($this->table)->select(); 
        return $this->RecursionAll($data_list);
    }
    
    /**
     * 读取品牌父级 pid=0
     */
    function GetSelect()
    {
    	return Db::name($this->table)->where('pid',0)->select();
    }

    /**
     * 调用子级品牌
     * @param [type] $id [description]
     */
    function GetBrandAdd($id)
    {
    	return Db::name($this->table)->where('pid',$id)->select();
    }

    /**
     * 递归查询所有品牌
     * @param  [type]  $node_list [description]
     * @param  integer $parent_id [description]
     * @param  integer $leave     [description]
     * @return [type]             [description]
     */
     function RecursionAll($data_list,$pid=0,$leave=0){
        static $result;
        foreach ($data_list as $key => $val) {
            if($val['pid']==$pid){
                $val['leave']=$leave;
                $result[]=$val;
                $this->RecursionAll($data_list,$val['brandcar_id'],$leave+1);
            }
        }
        //print_r($result);die;
        return $result;
     }

     /**
      * 添加品牌
      */
     public function BrandAdd($data)
     {
        return Db::name($this->table)->insert($data);
     }

     /**
      * 查询品牌名称
      * @param [type] $id [description]
      */
     public function BrandSelectName($id)
     {
        $res = DB::name($this->table)->field("brandcar_id,brandcar_name")->where('brandcar_id','in',$id)->select();
        foreach ($res as $key => $value) {
            $arr[] = $value['brandcar_name'];;
            $string = join(",",$arr);
        }
        return $string;
     }

}