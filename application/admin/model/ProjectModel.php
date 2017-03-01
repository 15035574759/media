<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class ProjectModel extends Model
{
	 // 设置当前模型对应的完整数据表名称
    protected $table = 'zt_project';
    protected $tables = 'project';

    /**
     * 项目添加
     * @param [type] $data [description]
     */
    function ProjectAdd($data)
    {
    	//过滤字段添加
    	$user  = new ProjectModel;
    	return $user->data($data)->allowField(true)->save();
    }

    /**
     * 查询项目列表
     * @return [type] [description]
     */
    function showAll()
    {
        return Db::name($this->tables)->alias("p")->join('zt_brand b','p.brand=b.brand_id')->order("id desc")->select();
    }

    /**
     * 查询项目名称
     */
    public function ProjectSelectName()
    {
        return DB::name($this->tables)->field("id,project_name")->select();
    }
}