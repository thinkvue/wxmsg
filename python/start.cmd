::��ѱ�������붨ʱ����ÿ15����ִ��һ��
::@Author: MiDoFa
::@Date: 2019-07-09 10:39:53
::@LastEditors: lijian@midofa.com
::@Description: ��Ŀ����
@echo off
color F3
title Wachat message sender
cd %~dp0
python main.py
if %errorlevel% neq 0 (
	echo ϵͳ��û�а�װpython 3���밲װpython 3�����ѱ�������붨ʱ����ÿ15����ִ��һ��
	pause
	exit
)