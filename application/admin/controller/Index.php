<?php
/**
 * Created by PhpStorm.
 * User: qingyun
 * Date: 19/5/20
 * Time: 下午2:46
 */

namespace app\admin\controller;

use app\admin\model\category;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function console()
    {
        return $this->fetch();
    }


    public function addCategory()
    {

        $re = $this->request;

        if($re->isGet()){
            $pid = $re->param('id', 0);

            if (empty($pid)){

                $this->assign('parentName', '顶级分类');
            }else{
                $parentName = category::where('id', $pid)->value('name');
                if (!$parentName){
                    $this->error('非法操作');
                }
                $this->assign('parentName', $parentName);
            }
            $this->assign('pid', $pid);
            return $this->fetch();
        }

        if ($re->isPost()){

            $name = $re->param('name');
            $pid = $re->param('pid', 0);

            if (mb_strlen($name, 'utf-8') > 10 || mb_strlen($name, 'utf-8') < 2){
                $this->error('分类名称长度应在2-10位之间');
            }
            //同一个父级下不能重名
            $where = ['pid'=>$pid, 'name'=>$name];
            if (category::where($where)->find()){
                $this->error('该分类已存在');
            }

            $parent = category::where('id', $pid)->find();

            //入库
            $data = [
                'name'=>$name,
                'pid' => $pid,
                'level' => $parent->level + 1
                ];
            if (category::create($data)){
                $this->success('成功');
            }else{
                $this->error('失败');
            }
        }
    }

    public function categoryList()
    {

        //如果使用的是ajax请求
        if ($this->request->isAjax()){
            $pid = $this->request->param('id', 0);
            $list = category::where('pid', $pid)->select();

            $str = '';
            foreach ($list as $v){
                $space = '';
                for ($i=0; $i< $v['level']; $i++){
                    $space .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                }
                $url = url('admin/Index/addCategory', ['id'=>$v['id']]);
                $str .= <<<SSS
                    <tr class="x{$pid}">
                        <td>{$v['id']}</td>
                        <td>{$space}|--{$v['name']}</td>
                        <td><a href="{$url}">添加</a></td>
                        <td><a data-id="{$v['id']}" class="point-e children" data-op="plus"><i class="fa fa-plus"></i></a></td>
                    </tr>
SSS;
            }

            return $str;
        }else{
            $list = category::where('pid', 0)->select();
            $this->assign('list', $list);
            return $this->fetch();
        }
    }
    
}