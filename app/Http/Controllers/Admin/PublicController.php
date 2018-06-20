<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use DB;
use Session;

class PublicController extends Controller
{
    //展示登录界面
    public function login()
    {
    	return view('admin.login');
    }

    //登录验证
    public function checkLogin(Request $request)
    {	
    	//设置默认时区
    	date_default_timezone_set('Asia/Shanghai');
    	//接收用户数据
    	$data = $request ->only('username','password','captcha');
    	//闪存需要手动存入后调用，laravel不会自动保存闪存
    	$request->flashOnly('username');
    	//首先验证验证码
    	//if($data['captcha'] == session('milkcaptcha')) {
    		//验证码通过，删除验证码并进行数据库用户名和密码验证
    		unset($data['captcha']);
    		$info = DB::table('em_user')->where('username',$data['username'])->where('password',$data['password'])->where('is_use',1)->first();
    		if($info) {
    			//把用户信息存入session中
    			session(['id'=>$info->id,'role_id'=>$info->role_id,'truename'=>$info->truename,'username'=>$info->username]);
    			//记录登录日志
    			$log = '--姓名:'. $info->truename . '--用户名:'. $info->username . '--日期:'. date('Y-m-d H:i:s') . '--IP:'. $_SERVER['REMOTE_ADDR'] . "\r\n" ;
    			file_put_contents('login.log', $log , FILE_APPEND);
    			return redirect('/index');
    		} else {
    			return back()->with(['info'=>'用户名或密码错误，或账户处于关闭状态！']);
    		}
    	// } else {
    	// 	return back()->with('info','验证码错误，请重新输入！');
    	// }
    	//dd($data);
    }

    //输出验证码
    public function captcha()
    {
    	//生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        session(['milkcaptcha'=> $phrase]);
        //生成图片
        //header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    //退出并清空session
    public function logout(Request $request)
    {
    	$request->session()->flush();
    	return redirect('/login')->with('info','退出成功！');
    }
}
