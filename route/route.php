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

Route::rule('', 'admin/Login/in')->method('GET,POST');

Route::get('admin$', 'admin/Index/index');

Route::get('admin-console', 'admin/Index/console');
Route::rule('admin-add-category', 'admin/Index/addCategory')->method('GET,POST');
Route::get('admin-list-category', 'admin/Index/categoryList');