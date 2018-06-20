@extends('layout.model')

@section('title','发件箱列表')

@section('content')

<div class="page-container">
	<form action='/emailSendBox' method='get'>
		{{csrf_field()}}
	<div class="text-c"> 
		<div class='form-group ' style="margin:0px 25px;">
			<label>显示条数</label>
			<select name='num' class='form-controll'>
				<option value='0'> 选择条数：</option>
				<option value='10' @if($num == 10) selected @endif>10条</option>
				<option value='15' @if($num == 15) selected @endif>15条</option>
				<option value='30' @if($num == 30) selected @endif>30条</option>
			</select>
		</div>
		<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
		<!-- 日期范围：
		<input type="text" name='picker1' onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" name='picker2' onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;"> -->
		<input type="text" name='keyword' class="input-text" value="{{$keyword}}" style="width:250px" placeholder="输入邮件主题或内容关键词..." id="" name="">
		<button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜邮件</button>
	</div>
	</form>
<form action='/emailDell' method='post'>
	{{csrf_field()}}
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><input type='submit' value='批量删除' class="btn btn-danger radius" />  <a href="/emailAdd"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 发送邮件</a></span></div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" class='check_all' name="" value=""></th>
				<th width="30">序号</th>
				<th width="80">收件人</th>
				<th width="80">主题</th>
				<th width="50">附件数量</th>
				<th width="50">是否已读</th>
				<th width="150">邮件内容</th>
				<th width="80">时间</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $k=>$v)
			<tr class="text-c">
				<td><input type="checkbox" value="{{$v->id}}" name="checkAll[]"></td>
				<td>{{$k+1}}</td>
				<td>{{userInfo($v->to_id)->truename}}--{{userInfo($v->to_id)->username}}</td>
				<td>{{mb_substr($v->title,0,8)}}...</td>
				<td>{{$v->file_num}}</td>
				<td class="td-status"><a  href='/emailRead/{{$v->id}}' >@if($v->is_read == 1)<span class="label label-success radius">已读</span>@elseif($v->is_read == 0) <span class="label label-danger radius">未读</span> @endif</a></td>
				<td>{{mb_substr($v->content,0,15)}}...</td>
				<td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
				<td class="td-manage"><a title="查看" href="/emailRead/{{$v->id}}"  class="ml-5 label label-primary radius" style="text-decoration:none">查看</a><a title="删除" href="/emailDel/{{$v->id}}" class="ml-5 label label-danger radius" style="text-decoration:none"><i class="Hui-iconfont">删除</i></a>
				<a title="将该邮件标记为未读" href="/isRead/{{$v->id}}" class="ml-5 label label-success radius" style="text-decoration:none"><i class="Hui-iconfont">设为未读</i></a></td>
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