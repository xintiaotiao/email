<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use PHPExcel;
use IOFactory;

class IndexController extends Controller
{
    //首页展示
    public function index()
    {
    	//展示后台首页
    	return view('admin.index');
    }

    //部门添加展示页面
    public function deptAdd()
    {
    	//查询数据库，将已存在的部门展示在列表
    	$data = DB::select("select *,concat(spath,',',id) as paths from em_dept order by paths asc");
    	foreach($data as $key=>$value) {
    		$num = count(explode(',',$value->paths))-2;
    		$space = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $num);
    		$data[$key]->name = $space . $value->name;

    	}
    	//dd($data);
    	return view('admin.deptAdd',['data'=>$data]);
    }

    //部门添加处理数据
    public function deptAddForm(Request $request)
    {
    	$post = $request -> only('name','pid');
    	$data = DB::table('em_dept')->where('id',$post['pid'])->first();
    	$post['spath']= $data->spath . ',' . $post['pid'];
    	$post['addtime'] = time();
    	$info = DB::table('em_dept')->insert($post);
    	return back()->with('info','添加部门成功！');
    }

    //部门列表展示
    public function deptList()
    {
    	//dd(childNum(10));
    	//echo '部门列表展示';
    	date_default_timezone_set('Asia/Shanghai');
    	//查询数据库，将已存在的部门展示在列表
    	$data = DB::select("select *,concat(spath,',',id) as paths from em_dept  order by paths asc");
    	foreach($data as $key=>$value) {
    		$num = count(explode(',',$value->paths))-2;
    		$space = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $num);
    		$data[$key]->name = $space . $value->name;

    	}
    	return view('admin.deptList',['data'=>$data]);
    }

    //部门批量删除
    public function deptDel(Request $request)
    {
    	//通过表单获得的checkbox返回的就是一个数组，不需要用js组装
    	$data = $request ->only('box');
    	//dd($data['box']);
    	DB::table('em_dept')->WhereIn('id',$data['box'])->delete();
    	return back()->with('info','批量删除部门成功！');
    }


    //部门删除
    public function deptDell($id)
    {
    	$info = DB::table('em_dept')->where('id',$id)->delete();
    	return back()->with('info','删除部门成功！');
    }

    //部门编辑
    public function deptEdit($id)
    {
    	
    	$data1 = DB::table('em_dept')->where('id',$id)->first();
    	//dd($data1);
    	return view('admin.deptEdit',['data1'=>$data1]);
    }

    //部门编辑处理数据
    public function deptEditForm(Request $request)
    {
    	//接收表单数据
    	$id =$request->input('id');
    	$name =$request->input('name');
    	//dd($name);
    	DB::table('em_dept')->where('id',$id) ->update(['name'=>$name]);
    	//echo "<script>top.href='/deptList'</script>";
    	return back()->with('info','修改部门名称成功！');
    }


    //添加用户
    public function userAdd()
    {
    	//展示添加页面
    	//读取部门信息并显示在页面中
    	$data = DB::select("select *,concat(spath,',',id) as paths from em_dept where pid !=0  order by paths asc");
    	foreach($data as $key=>$value) {
    		$num = count(explode(',',$value->paths))-2;
    		$space = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $num);
    		$data[$key]->name = $space . $value->name;

    	}
    	return view('admin.userAdd',['data'=>$data]);
    }

    //处理添加用户表单
    public function userAddForm(Request $request)
    {
    	//echo '添加用户入库';
    	//接收表单数据
    	$post = $request->all();
    	$ses = $request->flash();
    	//dd($post);
    	//字段验证
    	$this->validate($request,[
    		'truename' => 'required',
    		'username' => 'required|unique:em_user|regex:/\w{3,15}/',
    		'password' => 'required|same:repassword|regex:/\w{3,15}/',
    		'sex' => 'required',
    		'dept_id' => 'required',
    		'intro' => 'required',
    		'img' => 'required'
    	],[
    		'truename.required' => '姓名不能为空！',
    		'username.regex' => '用户名长度为3-15个字符!',
    		'username.unique' => '用户名不能重复！',
    		'username.required' => '用户名不能为空！',
    		'password.required' => '密码不能为空！',
    		'password.same' => '两次密码输入不一致！',
    		'password.regex' => '密码长度为3-15个字符!',
    		'sex.required' =>'请选择性别！',
    		'dept_id.required' =>'请选择部门！',
    		'img.required' =>'请选择头像！',
    		'intro.required' =>'请填写个人简介！'
    	]);

    	//删除多余的字段
    	unset($post['_token']);
    	unset($post['repassword']);
    	unset($post['uploadfile']);
    	unset($post['img']);
    	//补全字段
    	//处理头像上传
    	if($request->hasFile('img')) {
    		//echo '文件上传';die;
    		//定义上传路径及上传文件名字
    		$path = './upload/'.date('Y-m-d') .'/';
    		$suffix = $request->file('img')->getClientOriginalExtension();
    		$fileName = time(). rand(11111,99999) . '.' .$suffix;
    		//dd($path . $fileName);
    		$request->file('img')->move($path,$fileName);
    		$post['img'] = ltrim($path . $fileName,'.');
    	}
    	
    	$post['role_id'] =3;
    	$post['is_use'] =1;
    	$post['addtime'] =time();
    	//dd($post);
    	$res = DB::table('em_user')->insert($post);
    	if($res) {
    		return redirect('/userList') ->with('info','添加用户成功！');
    	} else {
    		return back() ->with('info','添加用户失败，请重新添加!');
    	}
    	
    }

    //用户列表展示
    public function userList(Request $request)
    {
    	date_default_timezone_set('Asia/Shanghai');
    	//接收检索条件表单
    	$num = $request->input('num',8);
    	$picker1 = $request->input('picker1');
    	$picker2 = $request->input('picker2');
    	$keyword = $request->input('keyword');
    	if(!empty($keyword)) {
    		$data = DB::table('em_user')->where('username','like','%'.$keyword.'%')->orWhere('truename','like','%'.$keyword.'%')->paginate($num);
    	}else{
    		$data = DB::table('em_user')->paginate($num);
    	}
    	//dd($post);
    	//查询数据，并分配到模板
    	//$data = DB::table('em_user')->paginate($num);
    	return view('admin.userList',['data'=>$data,'num'=>$num,'keyword'=>$keyword]);
    }

    //用户头像大图显示
    public function imgLarge($id)
    {
    	//获取头像地址
    	$path = DB::table('em_user')->where('id',$id)->first();
    	return view('admin.imgLarge',['path'=>$path]);
    }

    //用户编辑列表展示
    public function userEdit($id)
    {
    	//读取部门信息并显示在页面中
    	$data = DB::select("select *,concat(spath,',',id) as paths from em_dept where pid !=0  order by paths asc");
    	foreach($data as $key=>$value) {
    		$num = count(explode(',',$value->paths))-2;
    		$space = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $num);
    		$data[$key]->name = $space . $value->name;

    	}
    	$role = DB::table('em_role')->get();
    	//读取当前id的信息，并分配到模板中
    	$data1 = DB::table('em_user')->where('id',$id)->first();
    	//dd($data1);
    	//展示界面
    	return view('admin.userEdit',['data'=>$data,'data1'=>$data1,'role'=>$role]);
    }

    //用户编辑处理表单
    public function userEditForm(Request $request)
    {
    	//接收表单数据
    	$post = $request->all();
    	//加入表单验证
    	$this->validate($request,[
    		//'truename' => 'required',
    		//'username' => 'required|unique:em_user|regex:/\w{3,15}/',
    		'sex' => 'required',
    		'is_use' => 'required',
    		'role_id' => 'required',
    		'dept_id' => 'required',
    		'intro' => 'required'
    	],[
    		// 'truename.required' => '姓名不能为空！',
    		// 'username.regex' => '用户名长度为3-15个字符!',
    		// 'username.unique' => '用户名不能重复！',
    		// 'username.required' => '用户名不能为空！',
    		'sex.required' =>'请选择性别！',
    		'is_use.required' =>'请选择是否启用账号！',
    		'role_id.required' =>'请选择账号类型！',
    		'dept_id.required' =>'请选择部门！',
    		'intro.required' =>'请填写个人简介！'
    	]);
    	//处理头像上传
    	if($request->hasFile('img')) {
    		//echo '文件上传';die;
    		//定义上传路径及上传文件名字
    		$path = './upload/'.date('Y-m-d') .'/';
    		$suffix = $request->file('img')->getClientOriginalExtension();
    		$fileName = time(). rand(11111,99999) . '.' .$suffix;
    		//dd($path . $fileName);
    		$request->file('img')->move($path,$fileName);
    		$post['img'] = ltrim($path . $fileName,'.');
    	}
    	$id = $post['id'];
    	//删除多余的字段，必须，无字段过滤功能
    	unset($post['_token']);
    	unset($post['id']);
    	unset($post['uploadfile']);
    	//补全字段
    	$post['addtime']=time();
    	//dd($post);
    	//更新数据入库
    	$info = DB::table('em_user')->where('id',$id)->update($post);
    	if($info) {
    		return redirect('/userList')->with('info','修改用户信息成功!');
    	}else {
    		return back()->with('info','修改用户信息失败!');
    	}		
    }

    //修改用户密码界面
    public function password($id)
    {
    	return view('admin.password',['id'=>$id]);
    }
    
    //修改密码处理数据
    public function passwordForm(Request $request)
    {
    	$post = $request->only('id','password','repassword');
    	$id = $post['id'];
    	$password = $post['password'];
    	//dd($post);
    	//表单验证
    	$this->validate($request,[
    		'password' => 'required|same:repassword|regex:/\w{3,15}/'
    	],[
    		'password.required' => '密码不能为空！',
    		'password.same' => '两次密码不一致！',
    		'password.regex' => '密码长度必须为3-15个字符!'
    	]);
    	//在数据库中修改密码
    	DB::table('em_user')->where('id',$id)->update(['password'=>$password]);
    	return back()->with('info','修改密码成功！');
    }

    //单个删除用户
    public function userDel($id)
    {
    	//同时删除头像以节省空间,文件的删除和下载必须以绝对路径指定根目录
    	$path = $_SERVER['DOCUMENT_ROOT'] . DB::table('em_user')->where('id',$id)->first()->img;
    	//dd($path);
    	unlink($path);
    	$info = DB::table('em_user')->where('id',$id)->delete();    	
    	if($info) {
    		return back()->with('info','删除用户成功！');
    	}
    }

    //通过checkbox批量删除用户
    public function userDell(Request $request)
    {
    	//接收checkbox数据，返回的是一维数组
    	$checkAll = $request -> only('checkAll');
    	//dd($checkAll);
    	//因为除了要删除数据库中的数据，还要删除上传的头像文件，这里不使用whereIn，而用数组的遍历循环
    	$id = $checkAll['checkAll'];
    	if(empty($id)){
    		return back()->with('info','请选择要删除的项目！');
    	}
    	foreach($id as $k=>$v){
    		//同时删除头像以节省空间,文件的删除和下载必须以绝对路径指定根目录
	    	$path = $_SERVER['DOCUMENT_ROOT'] . DB::table('em_user')->where('id',$v)->first()->img;
	    	//dd($path);
	    	unlink($path);
    		DB::table('em_user')->where('id',$v)->delete();
    	}
    	return back()->with('info','批量删除用户成功！');
    }

    /**
     * 以下为邮件系统功能代码
     */
    
    //邮件添加界面展示
    public function emailAdd(Request $request)
    {
    	//以部门为基准，将所有用户展示在发送界面中供选择
    	$dept = DB::select("select *,concat(spath,',',id) as paths from em_dept where pid > 0 order by paths asc");
    	foreach($dept as $key=>$value) {
    		$num = count(explode(',',$value->paths))-2;
    		$space = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $num);
    		$dept[$key]->name = $space . $value->name;

    	}
    	//dd(userFromDept(12));
    	//界面展示
    	return view('admin.emailAdd',['dept'=>$dept]);
    }

    //邮件添加入库代码
    public function emailAddForm(Request $request)
    {
    	$to_id = $request ->input('email_check');
    	$post = $request->only('title','content');
    	//补全字段
    	$post['addtime'] = time();
    	$post['from_id'] = session('id');
    	$post['is_read'] = 0;
    	//处理文件上传，保持路径到数据库
    	//定义上传路径及上传文件名字
    	//dd($request->hasfile('emailFile'));
    	if($request->hasfile('emailFile')){
    		$path = './upload/'.date('Y-m-d') .'/';
			$fileArray = $request->file('emailFile');
			//dd($fileArray);
			$file_path='';
			$file_name = '';
			$count = count($fileArray);
			//循环遍历
			foreach($fileArray as $k=>$v){
				$suffix = $v->getClientOriginalExtension();
				$fileName = time(). rand(11111,99999) . '.' .$suffix;
		    	$info = $v->move($path,$fileName);
		    	$file_name .= $fileName . ',';
		    	$file_path .=ltrim($path.$fileName,'.') .",";

			}
			$file_name = trim($file_name,',');
			$file_path = trim($file_path,',');
			//文件名及文件路径都是以逗号连接的字符串，读取的时候用explode（）分割成数组即可调用
			$post['file_name'] = $file_name;
			$post['file_path'] = $file_path;
			$post['file_num'] = $count;
			$post['from_id'] = session('id');
    	}
		//dd($post);
		//通过遍历接收的to_id数组，写入数据库
		foreach($to_id as $k=>$v){
			$post['to_id']= $v;
			DB::table('em_email')->insert($post);
		}
		//echo "发送邮件成功！";
		return redirect('/emailSendBox')->with('info','发送邮件成功！');
    }

    //发件箱列表
    public function emailSendBox(Request $request)
    {
    	//查询当前用户发送的邮件并分配到模板
    	date_default_timezone_set('Asia/Shanghai');
    	//接收检索条件表单
    	$num = $request->input('num',15);
    	$keyword = $request->input('keyword');
    	if(!empty($keyword)) {
    		$data = DB::table('em_email')->where('title','like','%'.$keyword.'%')->orWhere('content','like','%'.$keyword.'%')->where('from_id',session('id'))->orderBy('addtime','desc')->paginate($num);
    	}else{
    		$data = DB::table('em_email')->where('from_id',session('id'))->orderBy('addtime','desc')->paginate($num);
    	}
    	//展示列表
    	return view('admin.emailSendBox',['data'=>$data,'num'=>$num,'keyword'=>$keyword]);
    }

    //读取邮件，包含发件箱和收件箱功能实现
    public function emailRead($id,Request $request)
     {
    // 	if(explode('/',$request->path())[0]=='emailRead'){

    // 		echo 'true';die;
    // 	}else{

    // 		echo 'false';die;
    // 	}
    // 	dd($request->path());
    	//通过接收的id读取当前邮件的内容
    	$data = DB::table('em_email')->where('id',$id)->first();
    	$data->file_name=explode(',',$data->file_name);
    	$data->file_path=explode(',',$data->file_path);
    	//当点击打开后，设置当前邮件为已读
    	DB::table('em_email')->where('id',$id)->update(['is_read'=>1]);

    	//dd($data);
    	return view('admin.emailRead',['data'=>$data]);
    }

    //将已读的邮件重新标记为未读
    public function isRead($id)
    {
    	DB::table('em_email')->where('id',$id)->update(['is_read'=>0]);
    	return back()->with('info','标记邮件为未读！');
    }


    //邮件附件下载功能实现代码
    public function download($id,$k)
    {
    	$data = DB::table('em_email')->where('id',$id)->first();
		$data->file_name=explode(',',$data->file_name);
    	$data->file_path=explode(',',$data->file_path);
    	$name =$data->file_name[$k];
    	$path = $_SERVER['DOCUMENT_ROOT'] . $data->file_path[$k];
    	//dd($path);
    	return response()->download($path);
    }

    //邮件的单个删除功能代码
    public function emailDel($id)
    {
    	//通过id进行数据库的删除，这里是真删除，不是逻辑删除，细节是删除的时候同时删除附件（但是有群发功能，所以不能删除附件）
    	DB::table('em_email')->where('id',$id)->delete();
    	return redirect('/emailSendBox')->with('info','删除邮件成功!');
    }

    //邮件的批量删除功能代码
    public function emailDell(Request $request)
    {
    	$idArray = $request->only('checkAll');
    	//dd($idArray['checkAll']);
    	$id = $idArray['checkAll'];
    	//通过foreach遍历循环删除选定的内容
    	if(empty($id)){
    		return back()->with('info','请选择要删除的邮件！');
    	}
    	foreach($id as $k=>$v){
    		DB::table('em_email')->where('id','=',$v)->delete();
    	}
    	return back()->with('info','批量删除邮件成功！');
    }

    //转发邮件的功能实现
    public function emailTrans($id)
    {
    	//以部门为基准，将所有用户展示在发送界面中供选择
    	$dept = DB::select("select *,concat(spath,',',id) as paths from em_dept where pid > 0 order by paths asc");
    	foreach($dept as $key=>$value) {
    		$num = count(explode(',',$value->paths))-2;
    		$space = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $num);
    		$dept[$key]->name = $space . $value->name;

    	}
    	//通过id读取email数据并分配到模板
    	$data = DB::table('em_email')->where('id',$id)->first();
    	$data->file_name=explode(',',$data->file_name);
    	$data->file_path=explode(',',$data->file_path);
    	//dd(arrayToString($data->file_name));
    	return view('admin.emailTrans',['data'=>$data,'dept'=>$dept]);
    }

    //处理转发数据并入库
    public function emailTransForm(Request $request)
    {
    	//接收数据
    	//$post = $request->all();
    	//dd($post);
    	$to_id = $request ->input('email_check');
    	$post = $request->only('title','content','file_name','file_path','file_name','file_num');
    	//补全字段
    	$post['addtime'] = time();
    	$post['from_id'] = session('id');
    	$post['is_read'] = 0;
		//通过遍历接收的to_id数组，写入数据库
		foreach($to_id as $k=>$v){
			$post['to_id']= $v;
			DB::table('em_email')->insert($post);
		}
		//echo "发送邮件成功！";
		return redirect('/emailSendBox')->with('info','发送邮件成功！');
    }

    //收件箱列表，收件箱很多功能和发件箱雷同，比如转发、查看、下载等
    public function emailResiveBox(Request $request)
    {
    	//查询当前用户发送的邮件并分配到模板
    	date_default_timezone_set('Asia/Shanghai');
    	//接收检索条件表单
    	$num = $request->input('num',15);
    	$keyword = $request->input('keyword');
    	if(!empty($keyword)) {
    		$data = DB::table('em_email')->where('title','like','%'.$keyword.'%')->orWhere('content','like','%'.$keyword.'%')->where('to_id',session('id'))->orderBy('addtime','desc')->paginate($num);
    	}else{
    		$data = DB::table('em_email')->where('to_id',session('id'))->orderBy('addtime','desc')->paginate($num);
    	}
    	//展示列表
    	return view('admin.emailResiveBox',['data'=>$data,'num'=>$num,'keyword'=>$keyword]);
    }

    //读取收件箱内邮件，由于显示内容有略微不同，所以需要改写
    public function emailRead1($id)
    {
    	//通过接收的id读取当前邮件的内容
    	$data = DB::table('em_email')->where('id',$id)->first();
    	$data->file_name=explode(',',$data->file_name);
    	$data->file_path=explode(',',$data->file_path);
    	//当点击打开后，设置当前邮件为已读
    	DB::table('em_email')->where('id',$id)->update(['is_read'=>1]);

    	//dd($data);
    	return view('admin.emailRead1',['data'=>$data]);
    }

    //ajax获取未读邮件数量
    public function emailAjax($id)
    {
    	//通过id获取当前用户的未读邮件数量
    	return DB::table('em_email')->where('to_id',$id)->where('is_read',0)->count();
    }

    //使用phpexcel导出数据
    public function emailOut()
    {
    	out('em_email');
    }

    /**
     * 这里是权限管理控制代码
     */
    
    //角色界面展示
    public function roleList(Request $request)
    {

    	date_default_timezone_set('Asia/Shanghai');
    	$data = DB::table('em_role')->get();
    	return view('admin.roleList',['data'=>$data]);
    }

    //添加角色界面展示
    public function roleAdd()
    {
    	return view('admin.roleAdd');
    }

     //添加角色入库功能代码
    public function roleAddForm(Request $request)
    {
    	$post = $request->only('name');
    	//进行字段验证
    	$this->validate($request,[
    		'name' => 'required|unique:em_role'
    	],[
    		'name.required' => '角色名称不能为空',
    		'name.unique' =>'角色名称不能重复'
    	]);
    	$post['addtime'] = time();
    	//dd($post);
    	$info = DB::table('em_role')->insert($post);
    	if($info){
    		return redirect('/roleList')->with('info','添加角色成功!');
    	}else{
    		return back()->with('info','添加角色失败，请重新添加!');
    	}
    }

    //角色删除功能代码
    public function roleDel($id)
    {
    	$info1 = DB::table('em_role')->where('id',$id)->delete();
    	$info2 = DB::table('em_role_auth')->where('role_id',$id)->delete();
    	return back()->with('info','角色删除成功，并一起删除权限表中角色信息！');
    }

    //权限列表展示界面
    public function authList(Request $request)
    {
    	//查询部门信息并分配到模板中
    	$data = DB::table('em_role')->get();
    	//查询权限信息并分配到模板中
    	$auth = DB::table('em_auth')->orderBy('id','asc')->get();
    	return view('admin.authList',['data'=>$data,'auth'=>$auth]);
    }
    
    //权限添加和编辑功能界面展示
    public function authEdit($id)
    {
    	//查询权限信息并分配到模板中
    	$auth = DB::table('em_auth')->orderBy('id','asc')->get();
    	return view('admin.authEdit',['auth'=>$auth,'id'=>$id]);
    }

    //权限添加和编辑一体实现功能界面
    public function authEditForm(Request $request)
    {
    	//接收表单数据
    	$post = $request->only('role_id');
    	//组装权限字符串
    	$auth = $request->only('auth')['auth'];
    	$str='';
    	foreach($auth as $k=>$v){
    		$str .= $v . ',';
    	}
    	//补全字段
    	$post['auth_id'] = trim($str,',');
    	$post['addtime'] =time();
    	//dd($post);
    	//判断，如果role_id存在表示只需修改，如果不存在则是新增入库
    	if(DB::table('em_role_auth')->where('role_id',$post['role_id'])->get()){
    		$info = DB::table('em_role_auth')->where('role_id',$post['role_id'])->update($post);
    	}else{
    		$info = DB::table('em_role_auth')->insert($post);
    	}
    	if($info){
    		return redirect('./authList')->with('info','修改权限信息成功！');
    	}else{
    		return back()->with('info','修改权限信息失败！');
    	}
    }

    //测试
    public function test()
    {
    	$str = 'aaa';
    	$str = explode('/',$str)[0];
    	dd($str);
    	$string = 'aaa,bbb,ccc';
    	$stringArr = explode(',',$string);
    	if(in_array($str,$stringArr)){
    		echo 'true';
    	}else{
    		echo 'false';
    	}
    }

    
}
