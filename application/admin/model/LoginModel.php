<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class LoginModel extends Model
{
	 // 设置当前模型对应的完整数据表名称
    protected $table = 'admin';

    public function Login($data)
    {
        return DB::name($this->table)->where("username",$data['username'])->find();
    }

     /**
     * [getRoleInfo 获取角色信息]
     * @author [jonny] [980218641@qq.com]
     */ 
    public function getRoleInfo($id)
    {

        $result = Db::name('auth_group')->where('id', $id)->find();
        if(empty($result['rules'])){
            $where = '';
        }else{
            $where = 'id in('.$result['rules'].')';
        }
        $res = Db::name('auth_rule')->field('name')->where($where)->select();

        foreach($res as $key=>$vo){
            if('#' != $vo['name']){
                $result['name'][] = $vo['name'];
            }
        }

        return $result;
    }
    
}