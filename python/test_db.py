#!/usr/bin/env python
# -*- coding: utf-8 -*-

"""
 :Author: lijian@midofa.com
 :URL: http://midofa.com
 :Date: 2020-05-20 10:41:48
 :LastEditors: thinkvue@thinkvue.cn
 :LastEditTime: 2020-05-30 20:53:24
 :FilePath: \\python\\test_db.py
 :Description:  
"""

import MySQLdb
import sys


def get(params_config, params=None, is_show_help=True):
    """标准化处理参数

    根据提供的params_config参数，提供参数params中的字段，返回字典
    params_config例：
        {
            'username':
                {'must':False,'data':True,'short':'U','long':'username','default':'root'},
            'password':
                {'must':True,'data':True,'short':'P','long':'password'},
            'remember':
                {'must':False,'data':False,'short':'R','long':'remember'},
        }
    其中：
        username：返回字段时的key
        must:表示是否为必需参数，如果必需，未提供则报错返回
        data:表示是否后面带了数据，例：-i 3306中3306为-i的数据
        short:短名称，即-i,
        long:长全称，即--install
        default:默认值，如果must为False，且未提供，则把该字段设为默认值
    成功返回：{'data':{'username':'root', 'password':'password','remember':True},'args':[]}
    失败返回：{'errcode':int,'error':'error msg'}

    调用示例：



     :param params_config: dict,每个key对应包含must（是否必须）、data（是否含有数据）、short（短名称）、long（长名称）等4个字段的字典
     :param params:list,系统参数 默认为sys.params
     :param is_show_help:bool,是否显示帮助信息，默认为True
     :return: {dict} : 例：{'data':{'username':'root', 'password':'password','remember':True},'args':[]}
    """
    import getopt
    if not params:
        params = sys.argv
    ret_dict = {}
    options = ''
    long_options = []
    readme = params[0]+" "
    for key1, dict1 in params_config.items():
        has_add = False
        short = dict1.get('short')
        long_tmp = dict1.get('long')
        has_data = dict1.get('data')
        must = dict1.get('must')
        if(short):
            options += (short+':' if has_data else short)
            readme_tmp = '-%s' % short
            if(has_data):
                readme_tmp = '%s <%s>' % (readme_tmp, key1)
            if not must:
                readme_tmp = '[%s]' % readme_tmp
            readme += readme_tmp+"  "
            has_add = True
        if(long_tmp):
            long_options.append(long_tmp+'=' if has_data else long_tmp)
            if not has_add:
                readme_tmp = '--%s ' % long_tmp
                if(has_data):
                    readme_tmp += '%s <%s> ' % (readme_tmp, key1)
                if not must:
                    readme_tmp = '[%s]' % readme_tmp
    try:
        opts, args = getopt.getopt(params[1:], options, long_options)
    except getopt.GetoptError as e:
        if is_show_help:
            print('\033[1;31;43m 超出范围的参数： \033[0m')
            print(e)
            print("\n规则：\n", readme)
        return {'errcode': -1, 'error': '超出范围的参数'+e.__str__()}
    for opt, arg in opts:
        if opt in ('-h', '--help'):
            print(readme)
            return {'errcode': 0, 'error': readme}
        for key, dict1 in params_config.items():
            if opt in ('-'+dict1.get('short'), '--'+dict1.get('long')):
                ret_dict[key] = arg if arg else True
    error = ""
    for key, dict1 in params_config.items():
        if key not in ret_dict:
            if dict1.get('must'):
                error += '  -%s <%s>' % (dict1.get('short'), key)
            elif dict1.get('default'):
                ret_dict[key] = dict1.get('default')
    if error:
        if is_show_help:
            print("\033[1;31;43m 缺少参数： \033[0m")
            print(error)
            print('\n用法：\n', readme)
        return {'errcode': -1, 'error': '缺少参数：'+error}
    return {'data': ret_dict, 'args': args}


def __test_db(params):
    """测试数据库连接

     :return: 无返回值，测试结果通过控制台退出码获得。0为成功，非0为失败
    """
    params_config = {
        'port':     {'must': False,  'data': True,    'short': 'O',    'long': 'port',  'default': 3306},
        'host':     {'must': False,  'data': True,    'short': 'H',    'long': 'host',  'default': 'localhost'},
        'user':     {'must': True,   'data': True,    'short': 'U',    'long': 'user'},
        'passwd':   {'must': True,   'data': True,    'short': 'P',    'long': 'passwd'},
        'db':       {'must': True,   'data': True,    'short': 'D',    'long': 'db'},
    }
    # params = sys.argv if len(sys.argv) > 1 else ['test.py', '-H','localhost','-O','3306','-U','root','-P','abc123','-D','thinkvue']
    ret_dict = get(params_config, params,False)
    errcode = ret_dict.get('errcode')
    if errcode and errcode < 0:
        sys.exit(131)
    try:
        ret_dict['data']['port'] = int(ret_dict.get('data').get('port'))
        db = MySQLdb.connect(**ret_dict.get('data'))
        db.close()
        print("\033[1;32m数据库连接测试通过。 \033[0m")
        sys.exit(0)
    except Exception as e:
        print("\033[1;31m数据库连接失败：\033[0m")
        print(e)
        sys.exit(132)


def __import_db(params):
    """导入数据库

     :return: 无返回值，测试结果通过控制台退出码获得。0为成功，非0为失败
    """
    params_config = {
        'port':     {'must': False,  'data': True,    'short': 'O',    'long': 'port',  'default': 3306},
        'host':     {'must': False,  'data': True,    'short': 'H',    'long': 'host',  'default': 'localhost'},
        'user':     {'must': True,   'data': True,    'short': 'U',    'long': 'user'},
        'passwd':   {'must': True,   'data': True,    'short': 'P',    'long': 'passwd'},
        'db':       {'must': True,   'data': True,    'short': 'D',    'long': 'db'},
        'sqlfile':  {'must': True,   'data': True,    'short': 'F',    'long': 'file'},
    }
    ret_dict = get(params_config, params,False)
    errcode = ret_dict.get('errcode')
    if errcode and errcode < 0:
        print("\033[1;31m参数不正确\033[0m")
        sys.exit(131)
    try:
        ret_dict['data']['port'] = int(ret_dict.get('data').get('port'))
        sqlfile=ret_dict.get('data').pop('sqlfile')
        db = MySQLdb.connect(**ret_dict.get('data'))
        c = db.cursor()
        with open(sqlfile,encoding='utf-8',mode='r') as f:
            sql_list = f.read().split(';\n')[:-1]
            for x in sql_list:
                if '\n' in x:
                    x = x.replace('\n', ' ')
                if '    ' in x:
                    x = x.replace('    ', '')
                sql_item = x+';'
                c.execute(sql_item)
        c.close()
        db.commit()
        db.close()                
        print("\033[1;32m导入数据库操作成功！\033[0m")
        sys.exit(0)
    except Exception as e:
        print("\033[1;31m导入数据库操作失败：\033[0m")
        print(e)
        c.close()
        db.commit()
        db.close()
        sys.exit(132)
        


def __test_wx(params):
    """测试微信连接

     :return: 无返回值，测试结果通过控制台退出码获得。0为成功，非0为失败
    """
    params_config = {
        'appid':     {'must': True,  'data': True,    'short': 'I',    'long': 'appid'},
        'appsecret': {'must': True,  'data': True,    'short': 'S',    'long': 'appsecret'},
    }
    err_dict = {
        '-1'	:	'系统繁忙，此时请开发者稍候再试',
        '0'	:	'请求成功',
        '40001'	:	'获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口',
        '40002'	:	'不合法的凭证类型',
        '40003'	:	'不合法的 OpenID ，请开发者确认 OpenID （该用户）是否已关注公众号，或是否是其他公众号的 OpenID',
        '40004'	:	'不合法的媒体文件类型',
        '40005'	:	'不合法的文件类型',
        '40006'	:	'不合法的文件大小',
        '40007'	:	'不合法的媒体文件 id',
        '40008'	:	'不合法的消息类型',
        '40009'	:	'不合法的图片文件大小',
        '40010'	:	'不合法的语音文件大小',
        '40011'	:	'不合法的视频文件大小',
        '40012'	:	'不合法的缩略图文件大小',
        '40013'	:	'不合法的 AppID ，请开发者检查 AppID 的正确性，避免异常字符，注意大小写',
        '40014'	:	'不合法的 access_token ，请开发者认真比对 access_token 的有效性（如是否过期），或查看是否正在为恰当的公众号调用接口',
        '40015'	:	'不合法的菜单类型',
        '40016'	:	'不合法的按钮个数',
        '40017'	:	'不合法的按钮类型',
        '40018'	:	'不合法的按钮名字长度',
        '40019'	:	'不合法的按钮 KEY 长度',
        '40020'	:	'不合法的按钮 URL 长度',
        '40021'	:	'不合法的菜单版本号',
        '40022'	:	'不合法的子菜单级数',
        '40023'	:	'不合法的子菜单按钮个数',
        '40024'	:	'不合法的子菜单按钮类型',
        '40025'	:	'不合法的子菜单按钮名字长度',
        '40026'	:	'不合法的子菜单按钮 KEY 长度',
        '40027'	:	'不合法的子菜单按钮 URL 长度',
        '40028'	:	'不合法的自定义菜单使用用户',
        '40029'	:	'无效的 oauth_code',
        '40030'	:	'不合法的 refresh_token',
        '40031'	:	'不合法的 openid 列表',
        '40032'	:	'不合法的 openid 列表长度',
        '40033'	:	'不合法的请求字符，不能包含 \\uxxxx 格式的字符',
        '40035'	:	'不合法的参数',
        '40038'	:	'不合法的请求格式',
        '40039'	:	'不合法的 URL 长度',
        '40048'	:	'无效的url',
        '40050'	:	'不合法的分组 id',
        '40051'	:	'分组名字不合法',
        '40060'	:	'删除单篇图文时，指定的 article_idx 不合法',
        '40117'	:	'分组名字不合法',
        '40118'	:	'media_id 大小不合法',
        '40119'	:	'button 类型错误',
        '40120'	:	'子 button 类型错误',
        '40121'	:	'不合法的 media_id 类型',
        '40125'	:	'无效的appsecret',
        '40132'	:	'微信号不合法',
        '40137'	:	'不支持的图片格式',
        '40155'	:	'请勿添加其他公众号的主页链接',
        '40163'	:	'oauth_code已使用',
        '41001'	:	'缺少 access_token 参数',
        '41002'	:	'缺少 appid 参数',
        '41003'	:	'缺少 refresh_token 参数',
        '41004'	:	'缺少 secret 参数',
        '41005'	:	'缺少多媒体文件数据',
        '41006'	:	'缺少 media_id 参数',
        '41007'	:	'缺少子菜单数据',
        '41008'	:	'缺少 oauth code',
        '41009'	:	'缺少 openid',
        '42001'	:	'access_token 超时，请检查 access_token 的有效期，请参考基础支持 - 获取 access_token 中，对 access_token 的详细机制说明',
        '42002'	:	'refresh_token 超时',
        '42003'	:	'oauth_code 超时',
        '42007'	:	'用户修改微信密码， accesstoken 和 refreshtoken 失效，需要重新授权',
        '43001'	:	'需要 GET 请求',
        '43002'	:	'需要 POST 请求',
        '43003'	:	'需要 HTTPS 请求',
        '43004'	:	'需要接收者关注',
        '43005'	:	'需要好友关系',
        '43019'	:	'需要将接收者从黑名单中移除',
        '44001'	:	'多媒体文件为空',
        '44002'	:	'POST 的数据包为空',
        '44003'	:	'图文消息内容为空',
        '44004'	:	'文本消息内容为空',
        '45001'	:	'多媒体文件大小超过限制',
        '45002'	:	'消息内容超过限制',
        '45003'	:	'标题字段超过限制',
        '45004'	:	'描述字段超过限制',
        '45005'	:	'链接字段超过限制',
        '45006'	:	'图片链接字段超过限制',
        '45007'	:	'语音播放时间超过限制',
        '45008'	:	'图文消息超过限制',
        '45009'	:	'接口调用超过限制',
        '45010'	:	'创建菜单个数超过限制',
        '45011'	:	'API 调用太频繁，请稍候再试',
        '45015'	:	'回复时间超过限制',
        '45016'	:	'系统分组，不允许修改',
        '45017'	:	'分组名字过长',
        '45018'	:	'分组数量超过上限',
        '45047'	:	'客服接口下行条数超过上限',
        '45064'	:	'创建菜单包含未关联的小程序',
        '45065'	:	'相同 clientmsgid 已存在群发记录，返回数据中带有已存在的群发任务的 msgid',
        '45066'	:	'相同 clientmsgid 重试速度过快，请间隔1分钟重试',
        '45067'	:	'clientmsgid 长度超过限制',
        '46001'	:	'不存在媒体数据',
        '46002'	:	'不存在的菜单版本',
        '46003'	:	'不存在的菜单数据',
        '46004'	:	'不存在的用户',
        '47001'	:	'解析 JSON/XML 内容错误',
        '48001'	:	'api 功能未授权，请确认公众号已获得该接口，可以在公众平台官网 - 开发者中心页中查看接口权限',
        '48002'	:	'粉丝拒收消息（粉丝在公众号选项中，关闭了 “ 接收消息 ” ）',
        '48004'	:	'api 接口被封禁，请登录 mp.weixin.qq.com 查看详情',
        '48005'	:	'api 禁止删除被自动回复和自定义菜单引用的素材',
        '48006'	:	'api 禁止清零调用次数，因为清零次数达到上限',
        '48008'	:	'没有该类型消息的发送权限',
        '50001'	:	'用户未授权该 api',
        '50002'	:	'用户受限，可能是违规后接口被封禁',
        '50005'	:	'用户未关注公众号',
        '61451'	:	'参数错误 (invalid parameter)',
        '61452'	:	'无效客服账号 (invalid kf_account)',
        '61453'	:	'客服帐号已存在 (kf_account exsited)',
        '61454'	:	'客服帐号名长度超过限制 ( 仅允许 10 个英文字符，不包括 @ 及 @ 后的公众号的微信号 )(invalid   kf_acount length)',
        '61455'	:	'客服帐号名包含非法字符 ( 仅允许英文 + 数字 )(illegal character in     kf_account)',
        '61456'	:	'客服帐号个数超过限制 (10 个客服账号 )(kf_account count exceeded)',
        '61457'	:	'无效头像文件类型 (invalid   file type)',
        '61450'	:	'系统错误 (system error)',
        '61500'	:	'日期格式错误',
        '63001'	:	'部分参数为空',
        '63002'	:	'无效的签名',
        '65301'	:	'不存在此 menuid 对应的个性化菜单',
        '65302'	:	'没有相应的用户',
        '65303'	:	'没有默认菜单，不能创建个性化菜单',
        '65304'	:	'MatchRule 信息为空',
        '65305'	:	'个性化菜单数量受限',
        '65306'	:	'不支持个性化菜单的帐号',
        '65307'	:	'个性化菜单信息为空',
        '65308'	:	'包含没有响应类型的 button',
        '65309'	:	'个性化菜单开关处于关闭状态',
        '65310'	:	'填写了省份或城市信息，国家信息不能为空',
        '65311'	:	'填写了城市信息，省份信息不能为空',
        '65312'	:	'不合法的国家信息',
        '65313'	:	'不合法的省份信息',
        '65314'	:	'不合法的城市信息',
        '65316'	:	'该公众号的菜单设置了过多的域名外跳（最多跳转到 3 个域名的链接）',
        '65317'	:	'不合法的 URL',
        '87009'	:	'无效的签名',
        '9001001'	:	'POST 数据参数不合法',
        '9001002'	:	'远端服务不可用',
        '9001003'	:	'Ticket 不合法',
        '9001004'	:	'获取摇周边用户信息失败',
        '9001005'	:	'获取商户信息失败',
        '9001006'	:	'获取 OpenID 失败',
        '9001007'	:	'上传文件缺失',
        '9001008'	:	'上传素材的文件类型不合法',
        '9001009'	:	'上传素材的文件尺寸不合法',
        '9001010'	:	'上传失败',
        '9001020'	:	'帐号不合法',
        '9001021'	:	'已有设备激活率低于 50% ，不能新增设备',
        '9001022'	:	'设备申请数不合法，必须为大于 0 的数字',
        '9001023'	:	'已存在审核中的设备 ID 申请',
        '9001024'	:	'一次查询设备 ID 数量不能超过 50',
        '9001025'	:	'设备 ID 不合法',
        '9001026'	:	'页面 ID 不合法',
        '9001027'	:	'页面参数不合法',
        '9001028'	:	'一次删除页面 ID 数量不能超过 10',
        '9001029'	:	'页面已应用在设备中，请先解除应用关系再删除',
        '9001030'	:	'一次查询页面 ID 数量不能超过 50',
        '9001031'	:	'时间区间不合法',
        '9001032'	:	'保存设备与页面的绑定关系参数错误',
        '9001033'	:	'门店 ID 不合法',
        '9001034'	:	'设备备注信息过长',
        '9001035'	:	'设备申请参数不合法',
        '9001036'	:	'查询起始值 begin 不合法',
    }
    ret_dict = get(params_config, params)
    errcode = ret_dict.get('errcode')
    if errcode and errcode < 0:
        sys.exit(131)
    try:
        appid = ret_dict.get('data').get('appid')
        appsecret = ret_dict.get('data').get('appsecret')
        url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s" % (
            appid, appsecret)
        import requests
        reponse = requests.get(url)
        if reponse.status_code == 200:
            rejson = reponse.json()
            if rejson.get('access_token'):
                print("\033[1;32m\n微信公众号连接测试通过。 \n\033[0m")
                sys.exit(0)
            else:
                print("\033[1;31m\n微信公众号连接失败：\n\033[0m")
                errcode=rejson.get('errcode')
                print(errcode, "=>", err_dict.get(str(errcode)))
                sys.exit(131)
        else:
            print("\033[1;31m\n网络请求失败，请确认网络连接正常，防火墙放行，请求错误：\n\033[0m",
                  reponse.status_code)
            sys.exit(132)
    except Exception as e:
        print("\033[1;31m\n网络请求失败，请确认网络连接正常，防火墙放行，请求错误：\n\033[0m")
        print(e)
        sys.exit(133)



def __test_msg(params):
    """测试短信接口

     :return: 无返回值，测试结果通过控制台退出码获得。0为成功，非0为失败
    """
    params_config = {
        'sms_interface_type':          {'must': True,  'data': True,    'short': 'I',    'long': 'interface'},
        'mobile':           {'must': True,  'data': True,    'short': 'M',    'long': 'mobile'},
        'ali_accesskeyid':  {'must': True,  'data': True,    'short': 'K',    'long': 'keyid'},
        'ali_accesssecret': {'must': True,  'data': True,    'short': 'S',    'long': 'secret'},
        'ali_signname':     {'must': True,  'data': True,    'short': 'N',    'long': 'signname'},
        'ali_verify_templatecode':     {'must': True,  'data': True,    'short': 'T',    'long': 'template_id'},
    }
    ret_dict = get(params_config, params)
    errcode = ret_dict.get('errcode')
    if errcode and errcode < 0:
        sys.exit(131)
    try:
        sms_interface_type=ret_dict.get('data').get('sms_interface_type')
        mobile=ret_dict.get('data').get('mobile')
        ali_accesskeyid=ret_dict.get('data').get('ali_accesskeyid')
        ali_accesssecret=ret_dict.get('data').get('ali_accesssecret')
        ali_signname=ret_dict.get('data').get('ali_signname')
        ali_verify_templatecode=ret_dict.get('data').get('ali_verify_templatecode')
        if sms_interface_type=="2":
            import urllib
            import urllib.request
            import hashlib
            statusStr = {
                '0': '短信发送成功',
                '-1': '参数不全',
                '-2': '服务器空间不支持,请确认支持curl或者fsocket,联系您的空间商解决或者更换空间',
                '30': '密码错误',
                '40': '账号不存在',
                '41': '余额不足',
                '42': '账户已过期',
                '43': 'IP地址限制',
                '50': '内容含有敏感词'
            }
            smsapi = "http://api.smsbao.com/"
            data = urllib.parse.urlencode({'u': ali_accesskeyid, 'p': ali_accesssecret, 'm': mobile, 'c': ali_signname})
            send_url = smsapi + 'sms?' + data
            response = urllib.request.urlopen(send_url)
            the_page = response.read().decode('utf-8')
            if the_page != "0":
                print("\033[1;31m\n短信接口测试失败\n\033[0m")
                print (statusStr[the_page])
                sys.exit(131)
        else:
            from aliyunsdkcore.client import AcsClient
            from aliyunsdkcore.request import CommonRequest
            client = AcsClient(ali_accesskeyid, ali_accesssecret, 'cn-hangzhou')
            request = CommonRequest()
            request.set_accept_format('json')
            request.set_domain('dysmsapi.aliyuncs.com')
            request.set_method('POST')
            request.set_protocol_type('https') # https | http
            request.set_version('2017-05-25')
            request.set_action_name('SendSms')
            request.add_query_param('RegionId', "cn-hangzhou")
            request.add_query_param('PhoneNumbers', mobile)
            request.add_query_param('SignName', ali_signname)
            request.add_query_param('TemplateCode', ali_verify_templatecode)
            request.add_query_param('TemplateParam', "{\"code\":8888}")
            response = client.do_action(request)
            result=str(response, encoding = 'utf-8')
            if result.find('"OK"') == -1 :
                print("\033[1;31m\n短信接口测试失败\n\033[0m")
                print(result)
                sys.exit(131)
        print("\033[1;32m\n短信接口测试成功\n\033[0m")
        sys.exit(0)
    except Exception as e:
        print("\033[1;31m\n短信接口测试失败！\n\033[0m")
        print(e)
        sys.exit(131)


def __test_mail(params):
    """测试发送邮件

     :return: 无返回值，测试结果通过控制台退出码获得。0为成功，非0为失败
    """
    params_config = {
        'mail_from':     {'must': True,  'data': True,    'short': 'F',    'long': 'mail_from'},
        'mail_to':       {'must': True,  'data': True,    'short': 'T',    'long': 'mail_to'},
        'mail_host':     {'must': True,  'data': True,    'short': 'H',    'long': 'mail_host'},
        'mail_port':     {'must': True,  'data': True,    'short': 'O',    'long': 'mail_port'},
        'mail_pass':     {'must': True,  'data': True,    'short': 'P',    'long': 'mail_pass'},
    }
    ret_dict = get(params_config, params)
    errcode = ret_dict.get('errcode')
    if errcode and errcode < 0:
        sys.exit(131)
    try:
        import smtplib
        from email.mime.text import MIMEText
        from email.mime.multipart import MIMEMultipart
        from email.header import Header
        from email.utils import formataddr
        data_dict=ret_dict.get('data')
        mail_from=data_dict.get('mail_from')
        mail_to=data_dict.get('mail_to')
        mail_host = data_dict.get('mail_host')
        mail_port = data_dict.get('mail_port')
        mail_pass = data_dict.get('mail_pass')
        mail_subject = "ThinkVue测试邮件"
        mail_content = """<div><p>如果您能收到邮件，证明配置成功。</p></div>"""
        message = MIMEMultipart()
        message['From'] = formataddr(["ThinkVue", mail_from])
        message['To'] = formataddr(["admin", mail_to])
        message['Subject'] = Header(mail_subject, 'utf-8')
        message.attach(MIMEText(mail_content, 'html', 'utf-8'))
        smtpObj = smtplib.SMTP_SSL(mail_host, mail_port)
        smtpObj.login(mail_from, mail_pass)
        smtpObj.sendmail(mail_from, mail_to, message.as_string())
        print("\033[1;32m\n邮件发送成功\n\033[0m")
        sys.exit(0)
    except Exception as e:
        print("\033[1;31m\n邮件发送失败：\n\033[0m")
        print(e)
        sys.exit(131)


if __name__ == "__main__":
    params_config = {
        'action':     {'must': True,  'data': True,    'short': 'a',    'long': 'action'},
    }
    ret_dict = get(params_config, sys.argv, False)
    action = ret_dict.get('data').get('action')
    if(action == 'db'):
        __test_db(ret_dict.get('args'))
    elif(action == 'wx'):
        __test_wx(ret_dict.get('args'))
    elif(action == 'mail'):
        __test_mail(ret_dict.get('args'))
    elif action == 'msg':
        __test_msg(ret_dict.get('args'))
    elif action == 'import':
        __import_db(ret_dict.get('args'))
