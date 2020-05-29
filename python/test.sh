###
 # @Author: thinkvue@thinkvue.cn
 # @URL: https://thinkvue.com
 # @Date: 2020-05-20 19:05:00
 # @LastEditors: thinkvue@thinkvue.cn
 # @LastEditTime: 2020-05-24 08:55:45
 # @FilePath: \\midofa_wechat_msg\\test.sh
 # @Description:  
### 
read -p "继续请输入yes后回车，直接回车将终止脚本:" asset
if [ -z $asset ]
then
    clear
else
    echo -e "\033[32m \nelse\n \033[0m"
    exit 1
fi
exit 0

echo
echo "================================"
echo -e "\033[32m请准备以下资料：\033[0m"
echo -e "================================
1. 域名（有备案号、需要分配两个子域名，用于API接口和前端，都开通SSL）
2. 微信服务号（拥有模板消息权限、有模板消息ID）
3. MySQL数据库
4. 邮箱（开通安全登录SMTP）
5. 阿里云短信或者短信宝接口信息(用于注册用户验证手机号)

\033[32m请确认准备好以上资料，否则将安装失败。具体要求查看readme.md\033[0m
"
typeset -l asset
read -p "继续请输入yes后回车，直接回车将终止脚本:" asset
if [[ $asset != "yes" && $asset != "y" ]]
then
    echo -e "\033[31m \n用户终止脚本。\n \033[0m"
    exit 1
fi

# has_error=0
# for loop in 1 2 3
# do
#     read -p "请输入数据库主机地址(默认localhost):" host
#     if [ -z $host ]
#     then
#         host="localhost"
#     fi
#     read -p "请输入数据库端口(默认3306):" port
#     if [ -z $port ]
#     then
#         port=3306
#     fi
#     read -p "请输入数据库端口(默认root):" username
#     if [ -z $username ]
#     then
#         username="root"
#     fi
#     read -s -p "请输入密码(隐藏输入):" password
#     echo
#     read -p "请输入数据库名称（该数据库必须存在）:" dbname
#     echo
#     # echo -e "  host:$host \n  port:$port \n  dbname:$dbname \n  username:$username \n  password:$password \n"
#     echo "尝试连接数据库..."
#     python3 test_db.py -a db test_db.py -H "$host" -O "$port" -U "$username" -P "$password" -D "$dbname"
#     if [ $? -eq 0 ]; then
#         break
#     else
#         has_error=`expr $has_error + 1`
#         if [ $has_error -ge 3 ]; then
#             echo -e "\033[31m \n尝试次数过多，请核对数据库配置后重试，脚本终止。\n \033[0m"
#             exit 1
#         fi
#         echo -e "\033[31m \n数据库连接失败，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
#     fi
# done

# has_error=0
# while true
# do
#     read -p "请输入微信公众号的appID: " appID1
#     read -p "请输入微信公众号的appsecret: " appsecret1
#     has_error=`expr $has_error + 1`
#     if [[ -z "$appID1" || -z "$appsecret1" ]]; then
#         echo -e "\033[31m \nappId和appsecret不可为空，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
#     else
#         echo "尝试联系微信公众号..."
#         python3 test_db.py -a wx test_db.py -I "$appID1" -S "$appsecret1"
#         if [ $? -eq 0 ]; then
#             break
#         else
#             if [ $has_error -ge 3 ]; then
#                 echo -e "\033[31m \n尝试次数过多，请核对微信appID、appsecret和IP白名单，脚本终止。\n \033[0m"
#                 exit 1
#             fi
#             echo -e "\033[31m \n微信公众号联系失败，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
#         fi
#     fi
# done
# appID2=''
# appsecret2=''
# appID3=''
# appsecret3=''

# has_error=0
# while true
# do
#     read -p "请输入用于发送错误邮件的账号(例：thinkvue@thinkvue.cn): " mail_from
#     read -p "请输入收件人(例：thinkvue@thinkvue.cn): " mail_to
#     read -p "请输入邮箱服务器(例：smtp.exmail.qq.com): " mail_host
#     read -p "请输入邮箱服务器端口(例：465): " mail_port
#     read -p "请输入登录密码(例：1yDhblk): " mail_pass
#     has_error=`expr $has_error + 1`
#     if [[ -z "$mail_from" || -z "$mail_to" || -z "$mail_host" || -z "$mail_port" || -z "$mail_pass" ]]; then
#         echo -e "\033[31m \n以上各项不可为空，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
#     else
#         echo "尝试发送邮件..."
#         # python3 test_db.py -a mail test_db.py -F "$mail_from" -T "$mail_to" -H "$mail_host" -O "$mail_port" -P "$mail_pass"
#         if [ $? -eq 0 ]; then
#             break
#         else
#             if [ $has_error -ge 3 ]; then
#                 echo -e "\033[31m \n尝试次数过多，请核对邮箱配置，脚本终止。\n \033[0m"
#                 exit 1
#             fi
#             echo -e "\033[31m \n发送测试邮件失败，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
#         fi
#     fi
# done

# 生成配置
# 配置php数据库
sed "s#<host>#$host#g" -i ../config/database.php
sed "s#<port>#$port#g" -i ../config/database.php
sed "s#<username>#$username#g" -i ../config/database.php
sed "s#<password>#$password#g" -i ../config/database.php
sed "s#<dbname>#$dbname#g" -i ../config/database.php
#配置sql文件
sed "s#<appID1>#$appID1#g" -i thinkvue.sql
sed "s#<appID2>#$appID2#g" -i thinkvue.sql
sed "s#<appID3>#$appID3#g" -i thinkvue.sql
sed "s#<appsecret1>#$appsecret1#g" -i thinkvue.sql
sed "s#<appsecret2>#$appsecret2#g" -i thinkvue.sql
sed "s#<appsecret3>#$appsecret3#g" -i thinkvue.sql
# python3服务配置
sed "s#<mail_from>#$mail_from#g" -i ./config.ini
sed "s#<mail_to>#$mail_to#g" -i ./config.ini
sed "s#<mail_host>#$mail_host#g" -i ./config.ini
sed "s#<mail_port>#$mail_port#g" -i ./config.ini
sed "s#<mail_pass>#$mail_pass#g" -i ./config.ini
sed "s#<host>#$host#g" -i ./config.ini
sed "s#<port>#$port#g" -i ./config.ini
sed "s#<username>#$username#g" -i ./config.ini
sed "s#<password>#$password#g" -i ./config.ini
sed "s#<dbname>#$dbname#g" -i ./config.ini
# 前台配置
sed "s#<api_url>#$api_url#g" -i ../h5/static/js/index.da425c07.js
sed "s#<appID1>#$appID1#g" -i ../h5/static/js/index.da425c07.js
sed "s#<appID2>#$appID2#g" -i ../h5/static/js/index.da425c07.js
sed "s#<appID3>#$appID3#g" -i ../h5/static/js/index.da425c07.js

# 导入SQL文件
