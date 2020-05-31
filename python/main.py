"""
 :Author: MiDoFa
 :Date: 2019-07-30 07:58:52
 :LastEditors: thinkvue@thinkvue.cn
 :LastEditTime: 2020-05-31 18:39:19
 :Description: 项目描述
"""


from setting import setting
import requests
import time
import log
from lxml import etree
import os
import encoding
import re
from db_connect import Db_connect
import onlyone


last_init_session = 0
ses = requests.session()
retry_count = int(setting.ini.get("system", "retry_count", 5))
session_time = int(setting.ini.get("system", "session_time", 9999999))


def request(url, data,method='POST',from_url=""):

    """发送网页请求，返回response对象，含下载 
    :param url: 请求地址
    """
    response = None
    if time.time() - last_init_session > session_time:
        init_session()
    if from_url:
        ses.headers.update(from_url=from_url)
    for i in range(retry_count):
        try:
            if(method=='POST'):
                response = ses.post(url,json=data)
            else:
                response = ses.get(url,params=data)
            if response.status_code == 200:
                break
        except Exception as e:
            if i < retry_count:
                log.log_exception(30, "请求网址【%s】时发生了错误%s，尝试%d次失败。即将初始会话" % (url,e, retry_count))
                init_session()
            else:
                log.log_exception(50, "请求网址【%s】时发生了错误%s，尝试%d次失败。" % (url,e, retry_count))
    return response.json()


def init_session():
    """初始化请求会话,一般情况下不需要调用"""
    global last_init_session
    global ses
    last_init_session = time.time()
    ses = requests.session()
    ses.headers.update(setting.headers)

def resetToken(appid, appsecret):
    """重置令牌
    :param {str} appid: appid
    :param {str} appsecret: appsecret
    :return: token
    """
    if(not appid or not appsecret):
        return None
    url="https://api.weixin.qq.com/cgi-bin/token"
    payload = {
        'grant_type': 'client_credential',
        'appid': appid,
        'secret':appsecret
    }
    retData=request(url,payload,'GET')
    if(retData.get('errcode')):
        log.log_exception(Exception(),50,'resetToken:重置token失败，请检查微信公众号设置里是否把本机IP纳入安全地址。 '+retData.get('errmsg'))
    return retData.get('access_token')


def spider_list():
    db = Db_connect()
    msg=db.select_msg()
    err_count=0
    max_error_num=int(setting.ini.get('system','max_error_num',100))
    while True:
        if not msg:
            log.log_exception(20, "消息队列中没有数据。")
            time.sleep(1)
            msg=db.select_msg()
        else:
            if not msg.get('appid') or not msg.get('appsecret'):
                log.log_exception(30,'消息%s未设置appid或appsecret，因此未发送'%msg.get('id'))
                continue
            appid = msg.get('appid')
            appsecret = msg.get('appsecret')
            if(msg.get('token_time')<round(time.time())):
                token=resetToken(appid, appsecret)
                db.update_token(msg.get('wechat_id'), token)
            else:
                token=msg.get('access_token')
            data={
                "touser":msg.get('openid'),
                "template_id":msg.get('template_id'),
                "url":msg.get('url'),         
                "data":{
                        "first": {
                            "value":msg.get('title'),
                            "color":msg.get('color'),
                        },
                        "keyword1":{
                            "value":msg.get('keyword1'),
                            "color":"#000000"
                        },
                        "keyword2": {
                            "value":msg.get('keyword2'),
                            "color":"#000000"
                        },
                        "keyword3": {
                            "value":msg.get('keyword3'),
                            "color":"#000000"
                        },
                        "remark":{
                            "value":msg.get('remark'),
                            "color":"#000000"
                        }
                }
            }
            url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='+token
            retData=request(url,data=data,method='POST')
            errcode=retData.get('errcode')
            if(errcode==0):
                log.log_exception(10,'信息%s发送成功'%msg.get('id'))
                msg=db.select_msg()
                err_count=0
            else:
                err_count+=1
                if(err_count>=max_error_num):
                    log.log_exception(50,'连续错误次数超过设定值，程序已终止')
                if(errcode==40003): #不合法的 OpenID
                    log.log_exception(30,'信息%s发送失败，原因：不合法的openid'%msg.get('id'))
                    msg=db.select_msg()
                elif(errcode==42001 or errcode==41001): #access_token 超时
                    token=resetToken(appid, appsecret)
                    db.update_token(msg.get('wechat_id'), token)
                    log.log_exception(30,'信息%s发送失败，现在重试，原因：access_token 超时'%msg.get('id'))
                elif(errcode==48001): #api功能未授权
                    log.log_exception(50,'信息%s发送失败，原因：api功能未授权，请确认公众号已获得该接口，可以在公众平台官网 - 开发者中心页中查看接口权限'%msg.get('id'))
                elif(errcode==48004): #api接口被封禁
                    log.log_exception(50,'信息%s发送失败，原因：api接口被封禁'%msg.get('id'))
                else:
                    log.log_exception(30,'信息%s发送失败，原因：%s' % (msg.get('id'),retData.get('errmsg')))
                    msg=db.select_msg()
            


if __name__ == "__main__":
    onlyone.start(int(setting.ini.get("system", "onlyone_port")))
    spider_list()
