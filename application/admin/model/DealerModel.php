<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class DealerModel extends Model
{
	 // 设置当前模型对应的完整数据表名称
    protected $table = 'user_dealer';

    /**
     * 读取经销商列表
     */
    function SelectAll()
    {
    	return Db::name($this->table)
                        ->alias("d")
                        ->join('zt_car_series c','d.car_series_id=c.car_id')
                        ->join('zt_project p','d.project_id=p.id')
                        ->order("dealer_id desc")
                        ->select();
    }

    /**
     * 读取项目经销商列表
     */
    function ProjectDealerAll($id)
    {
        return Db::name($this->table)
                        ->alias("d")
                        ->join('zt_car_series c','d.car_series_id=c.car_id')
                        ->join('zt_project p','d.project_id=p.id')
                        ->where('d.dealer_id','in',$id)
                        ->order("dealer_id desc")
                        ->select();
    }


     /**
     * 添加经销商
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function DealerAdd($data)
    {
        return DB::name("user_dealer")->insert($data);
    }

    /**
     * 查询经销商 pid=0
     */
    public function SelectDealerPid()
    {
        return DB::name('dealer_list')->where("pid",0)->select();
    }

    /**
     * 查询经销商名称
     * @param [type] $id [description]
     */
    public function DealerSelectName($id)
    {
        $res = DB::name("dealer_list")->field("dealer_id,dealer_name")->where('dealer_id','in',$id)->select();
        foreach ($res as $key => $value) {
            $arr[] = $value['dealer_name'];;
            $string = join("",$arr);
        }
        return $string;
    }

    /**
     * 根据项目对应的经销商
     * @param [type] $id [description]
     */
    public function DealerIdList($id)
    {
        return DB::name('user_dealer')->where("dealer_id",$id)->select();
    }

}