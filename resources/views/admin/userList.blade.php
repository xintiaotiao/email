@extends('layout.model')

@section('title','用户列表')

@section('content')

<div class="page-container">
	<form action='/userList' method='get'>
		{{csrf_field()}}
	<div class="text-c"> 
		<div class='form-group ' style="margin:0px 25px;">
			<label>显示条数</label>
			<select name='num' class='form-controll'>
				<option value='0'> 选择条数：</option>
				<option value='8' @if($num == 8) selected @endif>8条</option>
				<option value='15' @if($num == 15) selected @endif>15条</option>
				<option value='30' @if($num == 30) selected @endif>30条</option>
			</select>
		</div>
		<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
		<!-- 日期范围：
		<input type="text" name='picker1' onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" name='picker2' onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;"> -->
		<input type="text" name='keyword' class="input-text" value="{{$keyword}}" style="width:250px" placeholder="输入用户名或姓名关键词..." id="" name="">
		<button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
	</div>
	</form>
<form action='/userDell' method='post'>
	{{csrf_field()}}
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><input type='submit' value='批量删除' class="btn btn-danger radius" />  <a href="/userAdd"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a></span> <span class="r">共有数据：<strong>88</strong> 条</span> </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" class='check_all' name="" value=""></th>
				<th width="30">序号</th>
				<th width="50">姓名</th>
				<th width="80">用户名</th>
				<th width="30">性别</th>
				<th width="80">头像</th>
				<th width="80">部门</th>
				<th width="80">账号类别</th>
				<th width="50">是否开启</th>
				<th width="120">个人介绍</th>
				<th width="120">时间</th>
				<th width="80">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $k=>$v)
			<tr class="text-c">
				<td><input type="checkbox" value="{{$v->id}}" name="checkAll[]"></td>
				<td>{{$k+1}}</td>
				<td>{{$v->truename}}</td>
				<td>{{$v->username}}</td>
				<td>@if($v->sex == 1) 男 @elseif($v->sex == 2) 女 @elseif($v->sex == 3) 保密 @endif </td>
				<td><a href="javascript:;" onclick="member_add('用户头像及个人介绍','/imgLarge/{{$v->id}}','800','500')"><img src="{{$v->img}}" width='30' /></a></td>
				<td>{{deptName($v->dept_id)}}</td>
				<td>{{getRole($v->role_id)->name}}</td>
				<td class="td-status">@if($v->is_use == 1)<span class="label label-success radius">已启用</span>@elseif($v->is_use == 0) <span class="label label-danger radius">已停用</span> @endif</td>
				<td><a href="javascript:;" onclick="member_add('用户头像及个人介绍','/imgLarge/{{$v->id}}','800','500')">{{mb_substr($v->intro,0,10)}}...</a></td>
				<td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
				<td class="td-manage"> <a title="编辑" href="/userEdit/{{$v->id}}"  class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="member_add('修改用户密码','/password/{{$v->id}}','550','400')" href="javascript:;" title="修改密码"><i class="Hui-iconfont">&#xe63f;</i></a> <a title="删除" href="/userDel/{{$v->id}}" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</form>
	<div class='page'>
		{!! $data->appends(['num'=>$num,'keyword'=>$keyword])->render() !!}
	</div>
<div>

@endsection

@section('content_js')
<!--请在下方写此页面业务相关的脚本-->
<style>
	.page{
		margin:auto 50px;
	}
	.page a{
		float:left;
		margin:25px 15px;
		font-size:16px;
	}
	.page span{
		float:left;
		margin:25px 15px;
		font-size:16px;
	}
	.page .active span{
		float:left;
		margin:25px 15px;
		font-size:18px;
		font-family: bold;
		color:red;
	}	
</style>
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
$(function(){
	$('.table-sort').dataTable({
		"aaSorting": [[ 1, "desc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"aoColumnDefs": [
		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
		  {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
		]
	});

});
/*用户-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*用户-查看*/
function member_show(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*用户-停用*/
function member_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
				$(obj).remove();
				layer.msg('已停用!',{icon: 5,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

/*用户-启用*/
function member_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
				$(obj).remove();
				layer.msg('已启用!',{icon: 6,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});
	});
}
/*用户-编辑*/
function member_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*密码-修改*/
function change_password(title,url,id,w,h){
	layer_show(title,url,w,h);	
}
/*用户-删除*/
function member_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}
</script> 
@endsection