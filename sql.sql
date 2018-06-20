#这里是fox_email建表语句

#创建数据库
drop database if exists fox_email ;
create database fox_email;
use fox_email;

#创建用户表
drop table  if exists em_user;
create table em_user (
id int primary key auto_increment,
truename varchar(255) not null default ''  comment '用户姓名',
username varchar(50) not null default '' comment '登录用户名',
password varchar(32) not null default '' comment '登录密码',
dept_id int not null default 1 comment '用户所属部分，1表示待分发',
role_id int not null default 1 comment '用户所属权限，1表示普通用户',
intro text not null default '' comment '用户个人介绍',
addtime int not null default 0 comment '用户注册时间',
index (username,password),
index (addtime)
) engine = myisam default charset = utf8;

#插入测试账号
insert into em_user values (null,'杨小超','xintiaotiao','123456',1,1,'本网站开发作者',1111111111);


#部门em_dept 建表语句
drop table if exists em_dept;
create table em_dept(
id int primary key auto_increment,
name varchar(100) not null default '' comment '部门名称',
pid int not null default 0 comment '部门父类id，0表示顶级部门',
spath varchar(255) not null default '' comment '部门排序字段，由父类路径连上父类id组成',
addtime int not null default 0 comment '部门添加时间'
)engine = myisam default charset = utf8;

#邮件系统em_email 建表语句
drop table if exists em_email ;
create table em_email (
id int primary key auto_increment,
from_id int not null default 8 comment '记录发送者的id',
to_id int not null default 9 comment '记录收件者的id',
title varchar(100) not null default '' comment '邮件的标题信息',
file_num  tinyint not null default 0 comment '邮件的附件数量',
file_name varchar(255) not null default '' comment '附件的名字，供显示何下载的时候调用', 
file_path varchar(255) not null default '' comment '附件的路径，下载附件的时候需要',
content text not null default '' comment '邮件的文本内容',
addtime int not null default 0 comment '邮件发送时间'
) engine = myisam default charset = utf8;

#用户角色表
drop table if exists em_role;
create table em_role(
id int primary key auto_increment,
name varchar(100) not null default '' comment '用户角色名称',
addtime int not null default 0 comment '添加时间'
) engine = myisam default charset = utf8;

#权限表
drop table if exists em_auth;
create table em_auth(
id int primary key auto_increment,
name varchar(255) not null default '' comment '权限信息字符串',
addtime int not null default 0 comment '添加时间'
) engine = myisam default charset = utf8;

#角色权限表
drop table if exists em_role_auth;
create table em_role_auth(
id int primary key auto_increment,
role_id int not null default 1 comment '对应的角色id',
auth_id text comment '对应的权限信息',
addtime int not null default 0 comment '添加时间'
) engine = myisam default charset = utf8;


