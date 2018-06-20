@extends('layout.model')

@section('title','邮件发送页面')

@section('content')
<article class="page-container">
	<form action="" method="" enctype='multipart/form-data' class="form form-horizontal" id="form-member-add">
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<a href="/emailTrans/{{$data->id}}" class='btn btn-small btn-success radius'>转发</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="/emailDel/{{$data->id}}" class='btn btn-small btn-danger radius'>删除</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
		</div>
		<br/><hr/>
		<div class="row cl ">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>收件人：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{userInfo($data->to_id)->truename}}--{{userInfo($data->to_id)->username}}" placeholder="" id="username" name="title">
			</div>
		</div>
		<div class="row cl ">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>邮件主题：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$data->title}}" placeholder="" id="username" name="title">
			</div>
		</div>
		@foreach($data->file_name as $k=>$v)
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">附件{{$k+1}}：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="btn-upload form-group">
				<input class="input-text upload-url" type="text" value="{{$data->file_name[$k]}}" readonly nullmsg="请添加附件！" style="width:200px">
				<a href="/download/{{$data->id}}/{{$k}}" class="btn btn-primary radius upload-btn"><i class="Hui-iconfont">&#xe642;</i> 下载附件</a>
				</span> </div>
		</div>
		@endforeach
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">邮件内容：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="content" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" onKeyUp="$.Huitextarealength(this,100)">{{$data->content}}</textarea>
				<!-- <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p> -->
			</div>
		</div>

	</form>
</article>
@endsection
<!--请在下方写此页面业务相关的脚本--> 
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-member-add").validate({
		rules:{
			username:{
				required:true,
				minlength:2,
				maxlength:16
			},
			sex:{
				required:true,
			},
			mobile:{
				required:true,
				isMobile:true,
			},
			email:{
				required:true,
				email:true,
			},
			uploadfile:{
				required:true,
			},
			
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			//$(form).ajaxSubmit();
			var index = parent.layer.getFrameIndex(window.name);
			//parent.$('.btn-refresh').click();
			parent.layer.close(index);
		}
	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
@section('content_js')

@endsection