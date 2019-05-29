<?php

namespace app\index\controller;

use app\admin\model\article;
use app\admin\model\category;
use app\admin\model\images;
use think\Controller;

class Index extends Controller
{
    public function news(){

        $id = $this->request->param('id',0);
        $this->assign('id',$id);
        //查出新闻中心的所有子分类信息
        $category = $this->categoryList(1);

        $categories = [];
        foreach ($category as $v){
            $categories[] = $v['id'];
        }

        if ($id){
            //当前分类信息
            $categoryInfo = category::where('id',$id)->find();
            $this->assign('categoryInfo',$categoryInfo);
            //文章列表
            $list = article::where('category_id',$id)
                ->where('status',1)
                ->order('create_time desc')
                ->paginate(10);
        }else{
            $this->assign('categoryInfo','');
            $list = article::where('category_id','in', $categories)
                ->where('status', 1)
                ->order('create_time desc')
                ->paginate(10);
        }

        $this->assign('list',$list);

        return $this->fetch();
    }
    protected function categoryList($id){

        $category = category::where('pid', $id)->select();
        $this->assign('category', $category);
        return $category;
    }


    public function detail()
    {
        $category = $this->categoryList(1);

        $id = $this->request->param('id');

        $info = article::get($id);
        $this->assign('info', $info);

        //更新阅读量
        $info->setInc('hits');


        return $this->fetch();
    }

    //关于我们
    public function about()
    {
        //分类的id
        $id = $this->request->param('id');
        $this->categoryList(2);

        $info = article::where('category_id', $id)->find();
        $this->assign('info', $info);

        $this->assign('id', $id);


        return $this->fetch();
    }

    public function product ()
    {
        $id = $this->request->param('id',13);
        $this->assign('id',$id);
        $this->categoryList(11);


        if (empty($id)){
            $where = [];
        }else{
            $where['category_id'] = $id;
        }

        $list = images::where($where)->select();


        $this->assign('list',$list);
        $categoryList = category::where('type',2)->select();
        $this->assign('categoryList',$categoryList);
        $images = images::where('category_id',$id)->paginate(1);
        $this->assign('images',$images);

        return $this->fetch();
    }
}