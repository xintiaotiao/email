@extends('layout.model')

@section('title','用户编辑页面')

@section('content')
<article class="page-container">
	@if (count($errors) > 0) 
	<div class="Huialert Huialert-error"><i class="Hui-iconfont"></i>
		<ul> 
			@foreach ($errors->all() as $error) 
				<li>{{ $error }}</li> 
			@endforeach 
		</ul> 
	</div> 
	@endif
	<form action="/userEditForm" method="post" enctype='multipart/form-data' class="form form-horizontal" id="form-member-add">
		{{ csrf_field() }}
		<input type='hidden'  name='id' value='{{$data1->id}}' />
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>姓名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$data1->truename}}" placeholder="" id="truename" name="truename">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$data1->username}}" disabled placeholder="" id="username" name="username">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="radio-box">
					<input name="sex" type="radio" id="sex-1" value='1' @if($data1->sex == 1) checked @endif   />
					<label for="sex-1">男</label>
				</div>
				<div class="radio-box">
					<input name="sex" type="radio" id="sex-2" value='2' name="sex" @if($data1->sex == 2) checked @endif   />
					<label for="sex-2">女</label>
				</div>
				<div class="radio-box">
					<input name="sex" type="radio" id="sex-3" value='3' name="sex" @if($data1->sex == 3) checked  @endif  />
					<label for="sex-3">保密</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">账号类别：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="role_id">
					<option value="" >请选择</option>
					@foreach($role as $k=>$v)
						<option value ='{{$v->id}}' @if($data1->role_id == $v->id) selected  @endif >{{$v->name}}</option>
					@endforeach
				</select>
				</span> 
			</div>
		</div>
			<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">是否启用：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="is_use">
					<option value="" selected>请选择</option>
					<option value ='1' @if($data1->role_id == 1) selected  @endif>启用</option>
					<option value ='0' @if($data1->role_id == 0) selected  @endif>停用</option>
				</select>
				</span> 
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">所属部门：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="dept_id">
					<option value="" selected>请选择部门</option>
					@foreach($data as $k=>$v)
						<option value="{{$v->id}}" @if($data1->dept_id == $v->id ) selected @endif>{{ $v->name }} </option>
					@endforeach
				</select>
				</span> 
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">用户头像：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="btn-upload form-group">
				<input class="input-text upload-url" type="text" name="uploadfile" id="uploadfile" readonly nullmsg="请添加附件！" style="width:200px">
				<a href="javascript:void();" class="btn btn-primary radius upload-btn"><i class="Hui-iconfont">&#xe642;</i> 浏览文件</a>
				<input type="file" multiple name="img" class="input-file">
				</span> </div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="intro" cols="" rows="" class="textarea"  placeholder="个人介绍..." onKeyUp="$.Huitextarealength(this,100)">{{$data1->intro}}</textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>
@endsection

@section('content_js')
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
@endsection