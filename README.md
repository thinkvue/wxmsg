
# WxMsg微信消息推送

## 用途及原理

通过Web接口向微信发送消息，可用于工单、服务器报警、抢票等消息服务。  
前后端分离，前端负责提供用户接口，让用户在微信公众号中管理应用Token；后端API处理数据提交到数据库；Python服务程序负责与腾讯微信服务器通讯，发送消息。
后端 Thinkphp 5.1.1+MySQL 5.6 ， 前端Uni-APP , 腾讯微信服务器通讯服务：Python 。


## 涉及的技术栈

- Python 3
- Thinkphp 5.1
- Vue 2
- Uni-App
- MySQL
- Bash
- PyPI


## 安装前准备：

- 安装了PHP 7和MySQL 5.5以上版本的服务器；
- 已经备案的域名分配两个子域名，指向服务器，一个用于后台API，另一个用于前台用户接口；
- 微信公众号（AppID和AppSecret），开通了模版消息[[如何开通模版消息](./md/template_id.md)]；
- 用于发送故障邮件的邮箱，需要开通安全SMTP；
- 短信接口，【[阿里云短信](https://www.aliyun.com/acts/alicomcloud/new-discount?spm=5176.11533457.1089570.34.48e877e3FKTGdQ&userCode=9fbzncbl)】或者【[短信宝](https://www.smsbao.com/)】


## 一键安装命令

> 无需手动下载任何文件，一个命令完成安装、配置，向导式安装。
> 手动安装会非常麻烦，不建议手动安装。在官网提供了具体教程。

### Centos安装命令

`yum install -y wget && wget -O install.sh http://api.thinkvue.cn/install.sh && sudo sh install.sh`

### Ubuntu/Deepin安装命令

`wget -O install.sh http://api.thinkvue.cn/install.sh && sudo bash install.sh`

### Debian安装命令

`wget -O install.sh http://api.thinkvue.cn/install.sh && bash install.sh`


## 安装后配置

- [如何设置网站](./md/website.md)
- [如何设置微信公众号](./md/wechat_auth.md)
- [如何设置微信公众号模版消息](./md/template_id.md)


## 效果图

**一键安装**

![一键安装效果图](./md/img/preview2.jpg)


**运行效果**

![运行效果图](./md/img/preview.jpg)


# 使用方法

搭建好后，请求API请参详【[API地址直达链接](https://thinkvue.cn/api/)】，把域名换成你的即可。  
  
你也可以直接使用我搭建好的：

**关注微信公众号【ThinkVue】，API参详【[API地址直达链接](https://thinkvue.cn/api/)】。公众号扫码直达：**

![微信公众号ThinkVue](./md/img/thinkvue.jpg)


# 目录结构
```
├─[application] Thinkphp应用目录
├─[config] 		Thinkphp应用配置目录
├─[extend]		扩展类库目录
├─[public]		WEB目录（对外访问目录）
├─[route]		路由定义目录
├─[thinkphp]	Thinkphp框架系统目录
├─[vendor]		第三方类库目录（Composer依赖库）
├─[前台源码]	通过JBuilder打开
├─[app]			前台网站WEB目录
├─[python]		PYTHON服务
│  │  config.ini	配置文件
│  │  db_connect.py	数据库操作模块
│  │  encoding.py	编码操作模块
│  │  ini.py		读写INI模块
│  │  install.sh	一键安装脚本
│  │  log.py		日志模块
│  │  main.py		主程序
│  │  onlyone.py	确保唯一实例模块
│  │  setting.py	加载设置模块
│  │  test_db.py	安装测试连通模块
│  └─ thinkvue.sql	SQL文件
└─[md]				说明书文档			
   │ template_id.md	微信公众号添加模版消息
   │ website.md		设置API和前台网站
   │ wechat_auth.md	微信公众号权限设置
   └─[img]			图片目录

```


# 开源许可
[MIT](./LICENSE.txt)