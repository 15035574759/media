<?php
/**
 * 极客之家 高端PHP - 用户模块
 *
 * @copyright  Copyright (c) 2016 QIN TEAM (http://www.qlh.com)
 * @license    GUN  General Public License 2.0
 * @version    Id:  Type_model.php 2016-6-12 16:36:52
 */
namespace app\admin\model;
use think\Model;
use think\DB;
class UserModel extends Model
{
	 // 设置当前模型对应的完整数据表名称
    protected $table = 'table';

    public function UserAll()
    {
    	return Db::name("admin")->alias("a")->join('zt_auth_group g','a.groupid=g.id')->order("user_id desc")->select();
    }

    /**
     * 查询所有角色
     */
    function GroupSelect()
    {
    	return Db::name("auth_group")->select();
    }

    /**
     * 添加用户
     * @param [type] $data [description]
     */
    public function UserAdd($data)
    {
    	Db::name('admin')->insert($data);
        $userId = Db::name('admin')->getLastInsID();
        if($userId > 0){ 
            return Db::name('auth_user_group')->insert(array("uid"=>$userId,"group_id"=>$data['groupid']));
        }
    }
        
    /**
     * 查询所有菜单功能
     */
    public function MenuListAll()
    {
       return DB::name("auth_rule")->select();
        // return $this->RecursionAll($data_list);
    }

    /**
     * 添加菜单 节点
     */
    public function MenuAdd($data)
    {
        return DB::name("auth_rule")->insert($data);
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
                $this->RecursionAll($data_list,$val['id'],$leave+1);
            }
        }
        //print_r($result);die;
        return $result;
     }

     /**
      * 修改角色权限
      * @param [type] $group_id [description]
      * @param [type] $rule_id  [description]
      */
     public function GroupAllot($group_id,$rule_id)
     {
        return DB::name("auth_group")->where("id",$group_id)->update(['rules'=>$rule_id,'update_time'=>time()]);
     }

     /**
      * 角色添加
      */
     public function GroupAdd($data)
     {
        return Db::name('auth_group')->insert($data);
     }

     /**
      * 查询所有权限
      */
     function GroupAllData()
     {
        $data = Db::name("auth_rule")->where("pid",0)->select();
        foreach ($data as $key => $val) {
            $data[$key]['data_list'] = DB::name("auth_rule")->where("pid",$val['id'])->select();
            foreach ($data[$key]['data_list'] as $kk => $vv) {
                $data[$key]['data_list'][$kk]['data_lists'] = DB::name("auth_rule")->where("pid",$vv['id'])->select();
                // if($data[$key]['data_list'][$kk]['data_lists'])
            }
        }
        return $data;
     }
}