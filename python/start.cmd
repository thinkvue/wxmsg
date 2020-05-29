::请把本程序加入定时任务，每15分钟执行一次
::@Author: MiDoFa
::@Date: 2019-07-09 10:39:53
::@LastEditors: lijian@midofa.com
::@Description: 项目描述
@echo off
color F3
title Wachat message sender
cd %~dp0
python main.py
if %errorlevel% neq 0 (
	echo 系统还没有安装python 3，请安装python 3，并把本程序加入定时任务，每15分钟执行一次
	pause
	exit
)