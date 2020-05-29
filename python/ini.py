# -*- coding: UTF-8 -*-
# 读写配置文件
#

import configparser
import os
import codecs


class Ini(object):
    """操作ini配置文件夹

    设置本类的目的是简化ini配置文件的读取写入
    常用函数3个：get/set/save
    get_section和get_items用于获取
    本类需要用到configparser扩展，使用前请先安装。
    如果没有安装请运行“pip install configparser”
    节名、键名不区分大小写,支持以#或;起头的整行注释，支持=和:赋值符

    __init__(self,file_path,value_dict):
        构造函数，参数为配置文件名和初始化字典
    get(section,key,default_value="",add_if_not_exist=False):
        获取section节下key键的值
    set(section,key,value):
        设置section节下key键的值
    get_sections():
        获取所有节名，返回列表
    get_items(section):
        获取section节下所有键和值，返回字典
    save():
        保存配置至文件，如果不运行则默认不保存
    """

    _file_path = ""
    _config = None

    def __init__(self, file_path, value_dict=None):
        """构造方法

        :param file_path:配置文件名称（相对地址或者绝对地址都可以）；
        :param value_dict:初始化字典（可省略），如果存在则优先于读取file_path配置文件内容"""
        self._file_path = file_path
        self._config = configparser.ConfigParser(allow_no_value=True)
        if value_dict:
            self._config.read_dict(value_dict)
        else:
            if os.path.exists(self._file_path):
                self._config.readfp(codecs.open(filename=self._file_path, mode="r", encoding="utf-8"))
            else:
                self._config.write(codecs.open(filename=self._file_path, mode="w", encoding="utf-8"))

    def __del__(self):
        """析构函数"""
        del self._config

    def save(self):
        """保存配置至文件，如果不运行则默认不保存"""
        self._config.write(codecs.open(filename=self._file_path, mode="w+", encoding="utf-8"))

    def get(self, section, key, default_value="", add_if_not_exist=False):
        """获取section节下key键的值

        :param section:节名；
        :param key:键名；
        :param default_value:如果键名不存在则返回该值；
        :param add_if_not_exist:如果该键不存在则添加，默认为false"""
        if section in self._config:
            if key in self._config[section]:
                return self._config[section][key]
        if add_if_not_exist:
            self.set(section, key, default_value)
        return default_value

    def set(self, section, key, value):
        """设置section节下key键的值

        :param section 节名，如果不存在则会自动添加；
        :param key:键名，如果不存在则会自动添加；
        :param value: 键值"""
        self._config[section][key] = value

    def get_sections(self):
        """获取所有节名，返回列表"""
        return self._config.sections()

    def get_items(self, section):
        """获取section节下所有键和值，返回字典"""
        if section not in self._config:
            return {}
        else:
            return dict(self._config.items(section))

    def get_dict(self):
        """获取配置文件字典"""
        return_dict = {}
        for section in self.get_sections():
            return_dict[section] = self.get_items(section)
        return return_dict


# 以下测试内容
if __name__ == "__main__":
    ini3 = Ini("config.ini")
    print(ini3.get_dict())

