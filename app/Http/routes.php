<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/**
 * 首页展示，laravel路由形式虽然必须每个访问方式必须单独写路由，
 * 但是相对tp3框架操作上更为便捷
 */
Route::get('/', function () {
    return redirect('/login');
});
//输入域名后自动进入登录界面
Route::get('/login','Admin\PublicController@login');

//登录验证
Route::post('/checkLogin','Admin\PublicController@checkLogin');

//验证码路由
Route::get('/captcha','Admin\PublicController@captcha');


//除却登录页面外，所有路由都需要经过session验证，可以使用group群组路由控制
Route::group(['middleware'=>'login'],function(){
	//后台首页展示
	Route::get('/index','Admin\IndexController@index');

	/**
	 * 这里是用户路由控制区
	 */

	//添加用户页面展示
	Route::get('/userAdd','Admin\IndexController@userAdd');

	//添加用户数据处理
	Route::post('/userAddForm','Admin\IndexController@userAddForm');

	//用户列表展示
	Route::get('/userList','Admin\IndexController@userList');

	//用户大图显示
	Route::get('/imgLarge/{id}','Admin\IndexController@imgLarge');

	//用户编辑展示
	Route::get('/userEdit/{id}','Admin\IndexController@userEdit');

	//用户编辑数据处理
	Route::post('/userEditForm','Admin\IndexController@userEditForm');

	//修改用户密码界面
	Route::get('/password/{id}','Admin\IndexController@password');

	//修改密码数据处理
	Route::post('/passwordForm','Admin\IndexController@passwordForm');

	//单个删除用户
	Route::get('/userDel/{id}','Admin\IndexController@userDel');

	//批量删除用户
	Route::post('/userDell','Admin\IndexController@userDell');

	//退出登录
	Route::get('/logout','Admin\PublicController@logout');

	/**
	 * 这里是部门路由控制区块
	 */

	//部门添加界面
	Route::get('/deptAdd','Admin\IndexController@deptAdd');

	//部门添加界面
	Route::post('/deptAddForm','Admin\IndexController@deptAddForm');

	//部门列表展示
	Route::get('/deptList','Admin\IndexController@deptList');

	//部门删除,批量删除
	Route::post('/deptDel','Admin\IndexController@deptDel');

	//部门删除，单个删除
	Route::get('/deptDell/{id}','Admin\IndexController@deptDell');

	//部门编辑页面展示
	Route::get('/deptEdit/{id}','Admin\IndexController@deptEdit');

	//部门编辑数据处理
	Route::post('/deptEditForm','Admin\IndexController@deptEditForm');

	/**
	 * 这里是邮件系统路由控制区块
	 */
	
	//添加邮件列表展示
	Route::get('/emailAdd','Admin\IndexController@emailAdd');

	//邮件数据处理入库
	Route::post('/emailAddForm','Admin\IndexController@emailAddForm');

	//发件箱列表展示
	Route::get('/emailSendBox','Admin\IndexController@emailSendBox');

	//查看邮件，包含发件箱
	Route::get('/emailRead/{id}','Admin\IndexController@emailRead');

	//邮件附件下载
	Route::get('/download/{id}/{k}','Admin\IndexController@download');

	//邮件的单个删除
	Route::get('/emailDel/{id}','Admin\IndexController@emailDel');

	//邮件的批量删除
	Route::post('/emailDell','Admin\IndexController@emailDell');

	//将邮件标记为未读
	Route::get('/isRead/{id}','Admin\IndexController@isRead');

	//转发邮件
	Route::get('/emailTrans/{id}','Admin\IndexController@emailTrans');

	//转发邮件数据处理入库
	Route::post('/emailTransForm','Admin\IndexController@emailTransForm');

	//收件箱列表
	Route::get('/emailResiveBox','Admin\IndexController@emailResiveBox');

	//查看邮件，包含收件箱
	Route::get('/emailRead1/{id}','Admin\IndexController@emailRead1');

	//ajax获取未读邮件的数量
	Route::get('/emailAjax/{id}','Admin\IndexController@emailAjax');

	//倒出邮件
	Route::get('/emailOut','Admin\IndexController@emailOut');


	/**
	 * 这里是权限管理控制区块
	 */
	
	//角色列表展示
	Route::get('/roleList','Admin\IndexController@roleList');

	//添加角色界面展示
	Route::get('/roleAdd','Admin\IndexController@roleAdd');

	//添加角色功能
	Route::post('/roleAddForm','Admin\IndexController@roleAddForm');

	//角色删除
	Route::get('/roleDel/{id}','Admin\IndexController@roleDel');

	//权限管理界面
	Route::get('authList','Admin\IndexController@authList');

	//权限编辑界面
	Route::get('authEdit/{id}','Admin\IndexController@authEdit');

	//权限编辑功能实现
	Route::post('authEditForm','Admin\IndexController@authEditForm');
	
	
});

//测试
Route::get('/test','Admin\IndexController@test');















/**
 * 路由群组
 * 对所有需要用户登录的路由进行控制
 */
Route::group(['middleware' => 'login'],function(){
	/**
	 * 1、这里是群组路由的路由
	 * 2、laravel路由对提交方式进行明确区分，同一个方法不同的提交方式就是不同的路由
	 * 3、比如首页展示用get方式，提交表单处理则是post方式
	 */
	Route::get('user/login',['uses' => 'UserController@login']);
});
