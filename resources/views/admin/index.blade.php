@extends('layout.admin');

@section('title')
个人邮箱系统管理后台
@endsection

@section('truename')
{{ session('truename') }}
@endsection

@section('username')
{{ session('username') }}
@endsection