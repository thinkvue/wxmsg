# WxMsg微信消息推送

## 用途及原理

通过Web接口向微信发送消息，可用于工单、服务器报警、抢票等消息服务。  
前后端分离，前端负责提供用户接口，让用户在微信公众号中管理Token；后端处理数据提交到数据库；Python服务程序负责与腾讯微信服务器通讯，发送消息。
后端 Thinkphp 5.1.1+MySQL 5.6 ， 前端Uni-APP , 腾讯微信服务器通讯服务：Python 
建议后端API和前端使用不同子域名，

## 支持

- 支持用户多Token(多应用)
- 支持故障邮件告警
- 手机号验证


## 涉及的技术栈

- Python 3
- Thinkphp 5.1
- Vue 2
- Uni-App
- MySQL
- Bash
- PyPI


## 一键安装包
> 一键安装包已经编写完成，但还没找到稳定持久的托管地址，现在


## 手动安装方法

1. 打包下载文件，解压；
2. 命令行切换至本目录下，运行 `composer install` 安装依赖；
3. 将后台网站根目录指向`/wxmsg`，运行目录指向 `/wxmsg/public/`，前台网站指向`/wxmsg/app/`；
4. 导入install.sql；
5. 修改 `/wxmsg/config/database.php`中的数据库设置；
6. 修改`/wxmsg/app/static/js/index.da425c07.js`中的<api_url>和微信<appID>；
7. 修改Python后台服务配置`/wxmsg/python/config.ini`；
8. 安装python服务程序的依赖包，并把`python3 main.py`添加至开机启动；
9. 打开前台网站，修改短信接口、微信公众号配置等；
10. 重启服务器，安装完成。


## 安装前注意：

** 安装前需要准备以下资料： **
- 


## 注意的地方：

1. 使用请求头authkey和sessionid验证权限，而非cookie；
2. 在全局配置文件config/app.php中
3. 使用严格路由，未声明的地址重定位至 `admin/base/miss` ，且不可取消，因为该地址要响应所有options请求。


## 投入生产环境应做如下更改：

1. 更改日志文件级别（在全局配置文件/config/app.php中）
2. 关闭调试模式（/config/app.php=>app_debug）
3. 更改数据库密码（/config/database.php）


## 返回格式和约定返回值

返回格式为 ` json([code=>int,data=>object,error=>msg]) ` ，其中code为返回值，大于0为正确返回，小于0为错误返回。1为默认返回，-1为默认错误
* -1001~-1999 用户权限信息错误
    + -1001 登录失效
    + -1002 没有操作权限
    + -1003 账号或者密码错误
    + -1004 修改的新密码与原密码一致（准备废弃，用-2002代替）
    + -1005 该客户端未绑定账号
    + -1006 账号被禁用
    + -1007 合作伙伴不在邀请名单中
    + -1008 该账号未注册或者激活
* -2001~-2999 系统错误
    + -2001 发生了严重错误导致无法进行
    + -2002 参数错误
* -3001~-3999 数据错误
    + -3001 数据结构错误
    + -3002 数据存在冲突
    + -3003 数据库未知错误
    + -3004 指定数据不存在
* -4001~-4999 配置错误
    + -4001 地址错误
    + -4002 第三方OAuth2.0登录错误
    + -4003 服务器网络错误


## 开源许可
[MIT](./LICENSE.txt)