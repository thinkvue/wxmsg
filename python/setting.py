# -*- coding: UTF-8 -*-
# 设置
#

import ini
import encoding

import os
import logging
import json
from datetime import datetime


class DB(object):
    """数据库配置"""

    host = "localhost"
    user = "root"
    passwd = ""
    db = ""
    charset = "utf8"
    port = 3306

    def get_dict(self):
        return {
            "host": self.host,
            "user": self.user,
            "passwd": self.passwd,
            "db": self.db,
            "charset": self.charset,
            "port": self.port,
        }


class Setting(object):
    """设置,内部变量ini对外公开"""

    _ini_file = ""
    db = DB()
    ini = None
    sep = os.path.sep
    msg_url = ""
    all_dict = {}
    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36",
        "Accept-Encoding": "gzip, deflate",
        "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "Accept-Language": "zh-CN,zh;q=0.9,en-GB;q=0.8,en;q=0.7,en-US;q=0.6",
        "Connection": "keep-alive",
    }

    def __init__(self, load_file_name):
        """构造函数，参数：配置文件名"""
        self._ini_file = load_file_name
        try:
            open(file=load_file_name, mode="a+", encoding="utf-8")
        except Exception as e:
            logging.critical("配置文件不可读写")
            raise e
        self.ini = ini.Ini(load_file_name)
        self.all_dict = self.ini.get_dict()
        try:
            self.db.host = self.ini.get("database", "host")
            self.db.user = self.ini.get("database", "user")
            self.db.passwd = self.ini.get("database", "passwd")
            self.db.db = self.ini.get("database", "db")
            self.db.charset = self.ini.get("database", "charset")
            self.db.port = int(self.ini.get("database", "port", "3306"))
            logging.basicConfig(
                format="[%(asctime)s] - [%(filename)s] - [%(levelname)s] : %(message)s",
                filename=self.ini.get("logging", "log_file"),
                datefmt="%Y-%m-%d %H:%M:%S",
                level=int(self.ini.get("logging", "level")),
            )
            logging.critical("===============Start===============")
        except Exception as e:
            logging.critical("配置文件格式不正确，无法读取正确配置项。")
            raise e


setting = Setting("config.ini")

