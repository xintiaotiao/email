<?php

namespace App\Http\Middleware;

use Closure;

class LoginMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * 进行用户登录判断
         * 1、如果未登录则跳转到登录页面
         * 2、原理为判断用户session信息是否存在，比如用户id、用户名等
         */
         if(empty(session('role_id'))) {
            //跳转到登录页面
            return redirect('/login');
        }

        /**
         *做权限判断，被限制的功能模块将无法访问
         *先获取当前访问的路由，再通过session中存储的用户role_id，到权限表中查询获取权限字符串，
         *后拿当前路由去权限信息中比对，如果比对成功，表示无访问权限，让页面返回上一页并提示！
         */
        $path =explode('/',$request->path());
        $auth = \DB::table('em_role_auth')->where('role_id',session('role_id'))->first()->auth_id;
        $authArr = explode(',',$auth);
        //dd($path[0] . '-----' . $auth);
        if(in_array($path[0],$authArr)){
            return redirect('/emailResiveBox')->with('info','没有访问权限，请联系管理员！');
        }
        
        
        return $next($request);
    }
}
