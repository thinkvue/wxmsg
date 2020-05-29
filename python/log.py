"""
  # Author: MiDoFa
  # Date: 2019-07-23 10:23:22
 :LastEditors: lijian@midofa.com
 :LastEditTime: 2020-05-03 19:28:46
  # Description: 项目描述
"""
# -*- coding: UTF-8 -*-
# 记录异常，并发送微信通知
#
# 使用方法：
#

import logging
import requests
import sys
import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from email.header import Header
from email.utils import formataddr

from setting import setting

_log_level = int(setting.ini.get("logging", "level"))

def log_exception(error_level, msg, *args, **kwargs):
    """
    写日志，达到配置文件指定的错误级别则发送微信提醒
    :param error_level:信息级别，10:DEBUG,20:INFO,30:WARNNING,40:ERROR,50:CIR
    :param msg:信息内容
    :param args:支持logging.debug()的所有参数
    :param kwargs:支持logging.debug()的所有参数
    """
    mothod = None
    if error_level <= 10:
        mothod = logging.debug
    elif error_level <= 20:
        mothod = logging.info
    elif error_level <= 30:
        mothod = logging.warning
    elif error_level <= 40:
        mothod = logging.error
    else:
        mothod = logging.critical
    mothod(msg, *args, **kwargs)
    if error_level >= _log_level:
        print(msg)
    if error_level >= 40:
        sendMailToSelf(msg)
        sys.exit(1)


def sendMailToSelf(msg):
    mail_from = setting.ini.get("logging", "mail_from")
    mail_to = setting.ini.get("logging", "mail_to")
    mail_host = setting.ini.get("logging", "mail_host")
    mail_port = int(setting.ini.get("logging", "mail_port"))
    mail_pass = setting.ini.get("logging", "mail_pass")
    mail_subject = setting.ini.get("logging", "mail_subject")
    mail_content = """<div><p>微信消息系统的python发送程序出错了程序自身无法修复的严重错误，已经停止运行，请尽快修复。</p>
        <p><h3>原因如下：</h3></p>
        <p><h2>%s</h2></p>
        <p><a href="http://thinkvue.cn">ThinkVue</a></p>
        
        </div>""" % msg
    message = MIMEMultipart()
    message['From'] = formataddr(["ThinkVue", mail_from])
    message['To'] = formataddr(["admin", mail_to])
    # message['From'] = Header(mail_from, 'utf-8') 
    # message['To'] = Header(mail_to, 'utf-8')
    message['Subject'] = Header(mail_subject, 'utf-8')
    message.attach(MIMEText(mail_content, 'html', 'utf-8'))
    try:
        smtpObj = smtplib.SMTP_SSL(mail_host, mail_port)
        smtpObj.login(mail_from, mail_pass)
        smtpObj.sendmail(mail_from, mail_to, message.as_string())
        return True
    except smtplib.SMTPException as e:
        print(e)
        return False


if __name__ == "__main__":
    log_exception(40, "============4")
