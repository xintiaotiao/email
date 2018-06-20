@extends('layout.model')

@section('title','部门列表展示页面')

@section('content')
<form action='/deptDel' method='post'>
	{{csrf_field()}}
<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><input type='submit' value="批量删除"  class="btn btn-danger radius"  />  <a href="javascript:;" onclick="admin_add('添加部门','/deptAdd','550','400')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加部门</a></span></div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="9">部门列表</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="40">序号</th>
				<th width="150">部门名称</th>
				<th width="90">上级部门</th>
				<th width="150">添加时间</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $k=>$v)
				<tr class="text-c">
					<td>
						@if(childNum($v->id)[0]->count == 0) <input type="checkbox" value="{{$v->id}}" name="box[]">@endif
					</td>
					<td>{{$k+1}}</td>
					<td style="text-align: left;">{{$v->name}}</td>
					<td>{{deptGetName($v->pid)}}</td>
					<td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
					<td class="td-manage"></a><a title="编辑" href="javascript:;" target='iframe' onclick="admin_add('部门编辑','/deptEdit/{{$v->id}}','550','400')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@if(childNum($v->id)[0]->count == 0)<a title="删除" href="/deptDell/{{$v->id}}" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>@endif</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
</form>
@endsection

@section('content_js')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);

}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '/deptDel',
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

/*管理员-编辑*/
function admin_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*管理员-停用*/
function admin_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		
		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
		$(obj).remove();
		layer.msg('已停用!',{icon: 5,time:1000});
	});
}

/*管理员-启用*/
function admin_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		
		
		$(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
		$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
		$(obj).remove();
		layer.msg('已启用!', {icon: 6,time:1000});
	});
}
</script>
@endsection