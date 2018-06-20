@extends('layout.model')

@section('title','用户列表')

@section('content')

<div class="page-container">	
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
	<div class='row cl'>
			<div class="formControls col-xs-8 col-sm-12">
				<label class="form-label col-xs-5 col-sm-7" style="margin:15px auto"><span class="c-red"></span>权限管理列表(<i style='color:red'>勾选的部分表示无权限</i>)：</label><br/>
			<table class="table table-border table-bordered table-hover table-bg table-sort">		
			<tbody>
				@foreach($data as $key=>$val)
				<tr class="">
					<td style='background-color:#ccc'>
						<span class = 'btn btn-primary btn-sm disabled radius'>{{$key+1}}、{{$val->name}}</span>
						<div style='text-align: right'>
							<a class = 'btn btn-success btn-xs pull-right radius' href='/authEdit/{{$val->id}}'>编辑</a>
							<a class = 'btn btn-danger btn-xs pull-right radius' href='/roleDel/{{$val->id}}'>删除</a>
						</div>
					</td>
				</tr>
				<tr class="">
					<td style='background-color:lightpink' >
						<input type='checkbox'  name='auth[]' value='test' />测试
						@foreach($auth as $k=>$v)
						@if($k%8 == 0)<br/><br/>@endif
						<span><input type='checkbox'  name='auth[]' value='{{$v->rpath}}' disabled  @if(auth_exists($v->rpath,getAuth($val->id))) checked @endif /></span>{{$v->name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						@endforeach
					</td>				
				</tr>


				@endforeach
			</tbody>
			</table>
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