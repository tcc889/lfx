<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::rule('log', 'admin/Login/in')->method('GET,POST');
//后台首页
Route::get('admin$', 'admin/Index/index');

//console页
Route::get('admin-console', 'admin/Index/console');
Route::rule('admin-add-category', 'admin/Index/addCategory')->method('GET,POST');
Route::get('admin-list-category', 'admin/Index/categoryList');
Route::get('admin-tree-category', 'admin/Index/categoryTree');
//添加文章
Route::rule('admin-article-add', 'admin/Article/add')->method('GET,POST');
//ajax获取文章分类
Route::post('admin-article-category', 'admin/Article/ajaxCategory');
Route::post('admin-article-change-status', 'admin/Article/changeStatus');
Route::post('admin-article-upload-image', 'admin/Article/uploadImage');
Route::rule('admin-article-ueupload', 'admin/Article/ueUpload')->method('GET,POST');

Route::rule('admin-image/[:id]$', 'admin/Image/lists')->method('GET,POST');
Route::rule('admin-image-add', 'admin/Image/add')->method('GET,POST');
Route::rule('admin-image-category', 'admin/Image/getImageCategory')->method('GET,POST');



//新闻页
//Route::get('news', 'Index/index/news');
