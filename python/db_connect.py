"""
  # Author: MiDoFa
  # Date: 2019-07-09 10:35:01
 :LastEditors: lijian@midofa.com
 :LastEditTime: 2020-05-03 10:22:56
  # Description: 项目描述
"""
# -*- coding: UTF-8 -*-
# 插入数据库

import MySQLdb
import re
import log
import time
from setting import setting
import random


class Db_connect(object):

    """ 数据库操作类"""

    __MySQLConfig = {}
    __db = None
    __cursor = None
    __isInit = False
    prefix=""

    def setConfig(self, db_config):

        """ 设置配置，自动初始化，参数为数据库配置字典 """
        if isinstance(db_config, dict):
            log.log_exception(50, "初始化数据库类失败，缺乏配置字典。")
            return None
        self.__MySQLConfig = db_config
        return self.init()

    def init(self):
        """初始化数据库连接"""
        if self.__isInit:
            try:
                self.__cursor.close()
                self.__db.close()
            except:
                pass
            finally:
                self.__isInit = False
        try:
            self.__db = MySQLdb.connect(**(self.__MySQLConfig))
            self.__cursor = self.__db.cursor()
            self.__isInit = True
            self.prefix = setting.ini.get("database", "prefix")
            return self
        except Exception as e:
            log.log_exception(50, "数据库连接失败,%s" % e)

    def insert(self, table_name, keys, values):
        """ 插入数据，其中values为元组 
        :param table_name:表名
        :param keys:表字段，可以是空格或者逗号分隔的字符串，或者元组
        :param values:插入的值，元组，如果插入多行可以使用二维元组"""
        if not (self.__isInit) or not (isinstance(values, tuple)):
            return None
        if len(values) < 1:
            return None
        if type(keys) == str:
            keys = keys.replace(" ", ",")
            keys = tuple(keys.split(","))
        values = list(values)
        for key in range(len(values)):
            if isinstance(values[key], tuple):
                tmp_list = list(values[key])
                for a1 in range(len(tmp_list)):
                    tmp_list[a1] = tmp_list[a1].replace("'", "\\'")
                    tmp_list[a1] = tmp_list[a1].replace('"', '\\"')
                    tmp_list[a1] = tmp_list[a1].replace("\r", "")
                    tmp_list[a1] = tmp_list[a1].replace("\n", "\\n")
                    tmp_list[a1] = tmp_list[a1].replace("\t", "\\t")
                values[key] = tuple(tmp_list)
            else:
                values[key] = values[key].replace("'", "\\'")
                values[key] = values[key].replace('"', '\\"')
                values[key] = values[key].replace("\r", "")
                values[key] = values[key].replace("\n", "\\n")
                values[key] = values[key].replace("\t", "\\t")
        values = tuple(values)
        sql = "INSERT INTO `%s` %s VALUES (%s)" % (table_name, keys, (r'"%s",' * len(keys))[:-1])
        try:
            log.log_exception(10, "插入数据，SQL语句：\n%s" % (sql % values))
            if isinstance(values[0], tuple):
                ret = self.__cursor.executemany(sql, values)
            else:
                ret = self.__cursor.execute(sql, values)
            self.__db.commit()
        except Exception as e:
            log.log_exception(40, "insert数据库类插入数据失败%s，SQL语句：%s" %(e, sql))
        return ret

    def execute(self, sql):
        """执行SQL语句，返回结果集
        :param sql:需要执行的SQL语句"""
        try:
            log.log_exception(10, "执行SQL语句：" + sql)
            ret = self.__cursor.execute(sql)
            ret = self.__cursor.fetchall()
            self.__db.commit()
            return ret
        except Exception as e:
            log.log_exception(30, "数据库类执行查询失败%s，SQL语句：%s" % (e,sql))
            raise e

    def getCursor(self):
        """获取游标cursor对象，用于自定义扩展"""
        return self.__cursor

    def getConnect(self):
        """获取数据库连接对象，用于自定义扩展"""
        return self.__db

    def __init__(self):
        """构造函数"""
        self.__MySQLConfig = setting.db.get_dict()
        self.init()

    def close(self):
        """关闭数据库连接，会在__del__中自动调用"""
        try:
            if self.__isInit:
                log.log_exception(10, "关闭数据连接。")
                self.__cursor.close()
                self.__db.commit()
                self.__db.close()
                self.__isInit = False
        except Exception as e:
            log.log_exception(30, "数据库类关闭连接失败。%s" % e)

    def __del__(self):
        """析构函数"""
        self.close()


    def select_msg(self):
        """ 获取一条待发消息，返回dict，类似{'字段':'值'...}"""
        try:
            sql_select = (
                """SELECT 
                        a.`id`,
                        a.`openid`,
                        a.`title`,
                        a.`color`,
                        a.`keyword1`,
                        a.`keyword2`,
                        a.`keyword3`,
                        a.`url`,
                        a.`remark`,
                        a.`wechat_id`,
                        c.`template_id`,
                        b.`appid`, 
                        b.`appsecret`, 
                        b.`access_token`, 
                        b.`token_time`
                    FROM `%smsg` a,`%saccount` b ,`%stemplate` c
                    WHERE a.`delete_time` IS NULL AND a.`is_send`=0 AND a.`settime`< %s AND a.`wechat_id`=b.`id` And a.`template_id`=c.`id` 
                    ORDER BY a.`id`
                    LIMIT 1""" % (self.prefix, self.prefix, self.prefix, round(time.time()))
            )
            sql_update = (
                """UPDATE `%smsg` SET `is_send`=1,`send_time`=now() 
                    WHERE `id`= %%s""" % self.prefix
            )
            ret = self.execute(sql_select)
            if ret:
                self.execute(sql_update % ret[0][0])
                field_name = ('id', 'openid', 'title', 'color', 'keyword1', 'keyword2', 
                    'keyword3', 'url', 'remark', 'wechat_id', 'template_id', 
                    'appid',  'appsecret',  'access_token',  'token_time')
                return dict(zip(field_name, ret[0]))
            return None
        except Exception as e:
            log.log_exception(40, "select_msg数据库查询失败%s，" "SQL语句1：%s，SQL语句2：%s" % (e, sql_select, sql_update))


    def update_token(self,wechat_id,token):
        """ 更新微信公众号令牌，返回执行结果"""
        try:
            sql_update = ("""UPDATE `%saccount` SET `access_token` = '%s' , `token_time` = %s 
                    WHERE `id` = %s""" % (self.prefix, token, round(time.time()+7000), wechat_id)
            )
            return self.execute(sql_update)
        except Exception as e:
            log.log_exception(40, "update_token数据库更新失败%s，" "SQL语句：%s" % (e,sql_update))            

if __name__ == "__main__":
    """下面是测试内容"""
    con = Db_connect()
    print(con.select_msg())
    # print(con.update_token(2,'aaaaaaaaaaaaaaaa'))

