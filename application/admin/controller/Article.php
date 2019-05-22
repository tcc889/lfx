<?php
/**
 * Created by PhpStorm.
 * User: qingyun
 * Date: 19/5/20
 * Time: 下午3:12
 */

namespace app\admin\controller;

use think\Controller;

class Article extends Controller
{

    /*
     * 添加
     */
    public function add(){

        $re = $this->request;

        if  ($re->isPost()){

            $data = $re->only(['title','category_id','author','content','status']);

            $rule = [
                'tite'=>'require|length:1,50',
                'category_id' => 'require|min:1',
                'author' => 'length:2,10',
                'content' => 'require|length:10,65535',
                'status' => 'in:0,1'
            ];
            $msg = [
                'title.require' => '文章标题为必填项',
                'title.length' => '文章标题长度应在1-50个字符之间',
                'category_id.require' => '请选择正确的分类信息',
                'category_id.min' => '请选择正确的分类信息',
                'author.length' => '署名长度应在2-10个字符之间',
                'content.require' => '文章内容为必填项',
                'content.length' => '文章内容过短或者过长',
                'status.in' => '文章状态有误'
            ];
            $check = $this->validate($data,$rule,$msg);
            if ($check !== true){
                $this->error($check);
            }

            $data['aid'] = session('adminLoginInfo')->id;

            if (\app\admin\model\article::create($data)){
                $this->success('添加成功', url('admin/Article/lists'));
            }else{
                $this->error('添加失败');
            }
        }

        if ($re->isGet()){

            $all = category::where('pid', 0)->all();

            $this->assign('all', $all);
            return $this->fetch();
        }
    }
/**
* 使用ajax获取文章分类
* @return \think\response\Json
* @throws \think\db\exception\DataNotFoundException
* @throws \think\db\exception\ModelNotFoundException
* @throws \think\exception\DbException
*/
    public function ajaxCategory()
    {
        $pid = $this->request->param('id', 0);
        $data = category::where('pid', $pid)->select();
        return json($data);
    }


    /**
     * 文章列表
     */
    public function lists()
    {
        $list = \app\admin\model\article::with('category')->order('create_time DESC')->paginate(2);
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function changeStatus()
    {
        $id = $this->request->param('id');
        if (empty($id)){
            return $this->error('非法操作');
        }

        $obj = \app\admin\model\article::get($id);
        if (empty($obj)){
            return $this->error('非法操作');
        }

        $obj->status = abs($obj->status - 1);

        if ($obj->save()){
            return $this->success('成功', '', $obj->status);
        }else{
            return $this->error('失败');
        }


    }


}