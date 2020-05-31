# !/bin/bash
# coding:utf-8
# @Author: ThinkVue
# @Date: 2019-07-09 10:39:53
# @LastEditors: lijian@midofa.com
# @Description: 项目描述

#!/bin/bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH
LANG=en_US.UTF-8

# 打印安装须知
total_steps=13
step=1
echo
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m请准备以下资料：\033[0m"
echo -e "================================
1. 域名（有备案号、需要分配两个子域名，用于API接口和前端，都开通SSL）
2. 微信服务号（拥有模板消息权限、有模板消息ID）
3. MySQL数据库
4. 邮箱（开通安全连接SMTP，用于故障时紧急联系）
5. 阿里云短信或者短信宝接口信息(用于注册用户验证手机号)

\033[32m请确认准备好以上资料，并将本文件夹移动至API网站根目录下。具体要求查看readme.md\033[0m
"
typeset -l asset
read -p "继续请输入yes后回车，直接回车将终止脚本:" asset
if [[ $asset != "yes" && $asset != "y" ]]
then
    echo -e "\033[31m \n用户终止脚本。\n \033[0m"
    exit 1
fi

# 判断当前登录的用户是否为root
if [ `whoami` != "root" ]
then
	echo -e "\033[31m当前用户不是root，请登录root后重试!\n \033[0m"
	exit 0
fi

# 测试依赖环境
step=`expr $step + 1`
echo
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m检测依赖环境：\033[0m"
echo -e "================================
1. PHP >= 7.0
2. MySQL >= 5.5
3. composer
4. Python >= 3.6

\033[32m考虑到生产环境安全性，PHP和MySQL无法自动安装，需要提前安装。
\033[31m如果composer和python3未安装将会自动安装（不会覆盖python2.7，两者共存)
\033[0m"
typeset -l asset
read -p "继续请回车，输入任意字符将终止脚本:" asset
if [ -z $asset ]
then
    ls >/dev/null
else
    echo -e "\033[31m\n脚本终止运行！"
    exit 1
fi

# 检测PHP
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m检测PHP\033[0m"
echo "================================"
which "php" >/dev/null 2>&1
if [ $? -ne 0 ]; then
	echo -e "\033[31m检测到未安装PHP，请手动安装后重试。脚本终止运行。"
	exit 1
else
	echo -e "\033[32m检测通过！\033[0m"
fi
# 检测MySQL
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m检测MySQL\033[0m"
echo "================================"
which "mysql" >/dev/null 2>&1
if [ $? -ne 0 ]; then
	echo -e "\033[31m检测到未安装MySQL，请手动安装后重试。脚本终止运行。"
	exit 1
else
	echo -e "\033[32m检测通过！\033[0m"
fi

# 检测是否安装composer
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m检测composer...\033[0m"
echo "================================"
which "composer" >/dev/null 2>&1
# 如果没有安装则安装之
if [ $? -ne 0 ]; then
	echo "未安装composer，现在开始下载composer..."
	php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"
	echo "开始安装..."
	php composer-setup.php
	# 移动 composer.phar，这样 composer 就可以进行全局调用：
	sudo mv composer.phar /usr/local/bin/composer
	# 切换为国内镜像：
	echo "切换为国内镜像..."
	composer config -g repo.packagist composer https://packagist.phpcomposer.com
	# 更新 composer：
	composer selfupdate
	rm -rf composer-setup.php
	echo -e "\033[32m安装composer完成！\n \033[0m" 
else
	echo -e "\033[32mcomposer检测通过！\n \033[0m" 
fi


# 检测是否安装python3
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m检测python3...\033[0m"
echo "================================"
which "python3" >/dev/null 2>&1
# 如果没有安装则安装之
if [ $? -ne 0 ]; then
	# 安装编译环境
	rm -rf Python-3.8.*
	echo "python3未安装，现在开始安装python3"
	echo "开始安装编译环境..."
	sudo yum -y groupinstall "Development tools"
	# 安装依赖包
	sudo yum -y install zlib-devel bzip2-devel openssl-devel ncurses-devel sqlite-devel readline-devel tk-devel gdbm-devel db4-devel libpcap-devel xz-devel libffi-devel
	echo -e "\033[32m 安装编译环境完成!\n \033[0m"
	# 获取Python3.8.2安装包
	echo "获取Python3.8.2安装包...\n"
	# wget https://www.python.org/ftp/python/3.8.2/Python-3.8.2.tgz
	wget http://cdn.thinkvue.cn/Python-3.8.2.tgz
	echo -e "\033[32m下载Python3.8.2安装包完成!\n \033[0m"
	# 解压安装包
	echo "解压安装包..."
	tar -zxvf Python-3.8.2.tgz
	echo -e "\033[32m解压安装包完成!\n \033[0m"
	# 切换到安装包目录
	cd Python-3.8.2
	# 删除可能存在的残留
	rm -rf /usr/local/bin/python3
	# 配置Python3的安装目录
	./configure --prefix=/usr/local/bin/python3
	# 编译安装 Python3 
	echo "编译安装Python-3.8.2..."
	sudo make && make install
	cd ..
	echo -e "\033[32m编译安装完成!\n \033[0m"
	# 创建软链接
	rm -rf /usr/bin/python3
	rm -rf /usr/bin/pip3
	ln -bfs /usr/local/bin/python3/bin/python3 /usr/bin/python3
	ln -bfs /usr/local/bin/python3/bin/pip3 /usr/bin/pip3
	# 输出 Python3 及 pip3 的安装目录
	echo -e "Python3版本及路径信息： "
	python3 -V && pip3 -V
	which python3 && which pip3
	# 清除临时文件
	rm -rf ./Python-3.8.2.tgz
	rm -rf ./Python-3.8.2
	echo -e "\033[32m安装完成😘\n \033[0m" 
else
	echo -e "\033[32mpython3检测通过！\n \033[0m" 
fi
# 安装依赖包
echo "安装依赖包..."
echo 'astroid==2.3.3' >packages.txt
echo 'autopep8==1.4.4' >>packages.txt
echo 'certifi==2019.11.28' >>packages.txt
echo 'cffi==1.13.2' >>packages.txt
echo 'chardet==3.0.4' >>packages.txt
echo 'colorama==0.4.3' >>packages.txt
echo 'cryptography==2.8' >>packages.txt
echo 'future==0.18.2' >>packages.txt
echo 'idna==2.8' >>packages.txt
echo 'isort==4.3.21' >>packages.txt
echo 'jedi==0.15.2' >>packages.txt
echo 'lazy-object-proxy==1.4.3' >>packages.txt
echo 'lxml==4.4.2' >>packages.txt
echo 'mccabe==0.6.1' >>packages.txt
echo 'mysql==0.0.2' >>packages.txt
echo 'mysqlclient==1.4.6' >>packages.txt
echo 'parso==0.5.2' >>packages.txt
echo 'Pillow==7.0.0' >>packages.txt
echo 'pluggy==0.13.1' >>packages.txt
echo 'pycodestyle==2.5.0' >>packages.txt
echo 'pycparser==2.19' >>packages.txt
echo 'pylint==2.4.4' >>packages.txt
echo 'PyMySQL==0.9.3' >>packages.txt
echo 'pyperclip==1.7.0' >>packages.txt
echo 'python-jsonrpc-server==0.3.2' >>packages.txt
echo 'python-language-server==0.31.4' >>packages.txt
echo 'requests==2.22.0' >>packages.txt
echo 'selenium==3.141.0' >>packages.txt
echo 'six==1.13.0' >>packages.txt
echo 'urllib3==1.25.8' >>packages.txt
echo 'wrapt==1.11.2' >>packages.txt
echo 'XlsxWriter==1.2.7' >>packages.txt
echo 'aliyun-python-sdk-core==2.13.16' >>packages.txt
pip3 install -r packages.txt --trusted-host mirrors.aliyun.com >/dev/null
echo -e "\033[32m安装依赖包完成😘 \n \033[0m" 
# 清除临时文件
rm -rf ./packages.txt
rm -rf ./thinkvue.wxms*
rm -rf /www/wwwroot/thinkvue.wxmsg/
echo.
echo "下载thinkvue.wxmsg压缩包..."
wget http://cdn.thinkvue.cn/thinkvue.wxmsg.1.0.5.tar.gz
echo -e "\033[32m下载压缩包完成。\n \033[0m" 
echo "压缩包解压..."
mkdir /www/wwwroot/thinkvue.wxmsg/
tar -zxvf thinkvue.wxmsg.1.0.5.tar.gz -C /www/wwwroot/
echo -e "\033[32m压缩包解压完成。\n \033[0m" 
echo "压缩包解压..."
# 安装PHP第三方依赖
echo "安装php第三方依赖模块..."
cd /www/wwwroot/thinkvue.wxmsg/
sudo /bin/composer self-update
composer install
cd python
echo -e "\033[32m安装composer和第三方依赖模块成功！\n \033[0m" 

# 配置数据库
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m配置MySQL数据库...\033[0m"
echo "================================"
has_error=0
for loop in 1 2 3
do
    read -p "请输入数据库主机地址(默认localhost):" host
    if [ -z $host ]
    then
        host="localhost"
    fi
    read -p "请输入数据库端口(默认3306):" port
    if [ -z $port ]
    then
        port=3306
    fi
    read -p "请输入数据库端口(默认root):" username
    if [ -z $username ]
    then
        username="root"
    fi
    read -s -p "请输入密码(隐藏输入):" password
    echo
    read -p "请输入数据库名称（该数据库必须存在）:" dbname
    echo
    echo "尝试连接数据库..."
    python3 test_db.py -a db test_db.py -H "$host" -O "$port" -U "$username" -P "$password" -D "$dbname"
    if [ $? -eq 0 ]; then
        break
    else
        has_error=`expr $has_error + 1`
        if [ $has_error -ge 3 ]; then
            echo -e "\033[31m \n尝试次数过多，请核对数据库配置后重试，脚本终止。\n \033[0m"
            exit 1
        fi
        echo -e "\033[31m \n数据库连接失败，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
    fi
done

# 配置微信公众号
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m配置微信公众号...\033[0m"
echo "================================"
has_error=0
while true
do
    read -p "请输入微信公众号的appID: " appID1
    read -p "请输入微信公众号的appsecret: " appsecret1
	read -p "请输入微信公众号的模板消息ID: " wechat_template_id1
    has_error=`expr $has_error + 1`
    if [[ -z "$appID1" || -z "$appsecret1" ]]; then
        echo -e "\033[31m \nappId和appsecret不可为空，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
    else
        echo "尝试联系微信公众号..."
        python3 test_db.py -a wx test_db.py -I "$appID1" -S "$appsecret1"
        if [ $? -eq 0 ]; then
            break
        else
            if [ $has_error -ge 3 ]; then
                echo -e "\033[31m \n尝试次数过多，请核对微信appID、appsecret和IP白名单，脚本终止。\n \033[0m"
                exit 1
            fi
            echo -e "\033[31m \n微信公众号联系失败，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
        fi
    fi
done
appID2=''
appsecret2=''
wechat_template_id2=""
appID3=''
appsecret3=''
wechat_template_id3=""


# 配置错误邮箱
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m配置邮箱...\033[0m"
echo "================================"
has_error=0
while true
do
    read -p "请输入用于发送错误邮件的账号(例：thinkvue@thinkvue.cn): " mail_from
    read -p "请输入收件人(例：thinkvue@thinkvue.cn): " mail_to
    read -p "请输入邮箱服务器(例：smtp.exmail.qq.com): " mail_host
    read -p "请输入邮箱服务器端口(例：465): " mail_port
    read -p "请输入登录密码(例：1yDhblk): " mail_pass
    has_error=`expr $has_error + 1`
    if [[ -z "$mail_from" || -z "$mail_to" || -z "$mail_host" || -z "$mail_port" || -z "$mail_pass" ]]; then
        echo -e "\033[31m \n以上各项不可为空，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
    else
        echo "尝试发送邮件..."
        python3 test_db.py -a mail test_db.py -F "$mail_from" -T "$mail_to" -H "$mail_host" -O "$mail_port" -P "$mail_pass"
        if [ $? -eq 0 ]; then
			echo -e "\033[32m测试通过\033[0m"
            break
        else
            if [ $has_error -ge 3 ]; then
                echo -e "\033[31m \n尝试次数过多，请核对邮箱配置，脚本终止。\n \033[0m"
                exit 1
            fi
            echo -e "\033[31m \n发送测试邮件失败，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
        fi
    fi
done

# 配置短信接口
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m配置短信接口...\033[0m"
echo "================================"
smsbao_username=""
smsbao_password=""
smsbao_verify_sms_content=""
ali_accesskeyid=""
ali_accesssecret=""
ali_signname=""
ali_verify_templatecode=""
sms_interface_type=""
has_error=0
while true
do
	echo -e "\033[33m\n请选择短信接口：\n\033[0m"
	echo "1. 阿里云"
	echo "2. 短信宝"
	read -p "请选择（默认1）: " asset
	if [[ $asset = "2" ]];then
		sms_interface_type="2"
		read -p "请输入短信宝用户名: " smsbao_username
		read -p "请输入短信宝密码(MD5加密保存): " smsbao_password
		read -p "请输入短信宝验证码短信模板内容: " smsbao_verify_sms_content
		smsbao_password=`echo -n $smsbao_password | md5sum | cut -d ' ' -f 1;`
		ali_accesskeyid=$smsbao_username
		ali_accesssecret=$smsbao_password
		ali_signname=$smsbao_verify_sms_content
		ali_verify_templatecode="8888"
	else
		sms_interface_type="1"
		read -p "请输入阿里云短信accessKeyId: " ali_accesskeyid
		read -p "请输入阿里云短信AccessSecret: " ali_accesssecret
		read -p "请输入阿里云短信签名: " ali_signname
		read -p "请输入阿里云验证码短信模板ID: " ali_verify_templatecode
	fi
	read -p "请输入接收短信的测试手机号: " mobile
    has_error=`expr $has_error + 1`
    if [[ -z "$ali_accesskeyid" || -z "$ali_accesssecret" || -z "$ali_signname" || -z "$ali_verify_templatecode" ]]; then
        echo -e "\033[31m \n各项不可为空，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
    else
        echo "尝试发送测试短信..."
		python3 test_db.py -a msg test_db.py -I "$sms_interface_type" -M "$mobile" -K "$ali_accesskeyid" -S "$ali_accesssecret" -N "$ali_signname" -T "$ali_verify_templatecode"
        if [ $? -eq 0 ]; then
            break
        else
            if [ $has_error -ge 3 ]; then
                echo -e "\033[31m \n尝试次数过多，请核对配置，脚本终止。\n \033[0m"
                exit 1
            fi
            echo -e "\033[31m \n短信接口测试失败，请重新输入(退出脚本请按Ctrl+C)\n \033[0m"
        fi
    fi
done
echo -e "\033[32m \n配置短信接口成功！\n \033[0m"


# 配置域名
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m配置域名...\033[0m"
echo "================================"
read -p '请输入API域名(必须开启SSL,API必须部署在根目录，最后一个字符不可以为"/"，例：https://api.thinkvue.cn): ' api_url
read -p "请输入前端域名（必须部署在根目录，最后一个字条不可以为“/”，例：http://wx.thinkvue.cn）: " wx_url

# 生成配置
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m生成配置文件...\033[0m"
echo "================================"
# 配置php数据库
echo "生成thinkphp数据库配置文件..."
sed "s#<host>#$host#g" -i ../config/database.php
sed "s#<port>#$port#g" -i ../config/database.php
sed "s#<username>#$username#g" -i ../config/database.php
sed "s#<password>#$password#g" -i ../config/database.php
sed "s#<dbname>#$dbname#g" -i ../config/database.php
# python3服务配置
echo "生成python服务配置文件..."
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
echo "配置前台接口..."
sed "s#<api_url>#$api_url#g" -i ../app/static/js/index.da425c07.js
sed "s#<appID1>#$appID1#g" -i ../app/static/js/index.da425c07.js
sed "s#<appID2>#$appID2#g" -i ../app/static/js/index.da425c07.js
sed "s#<appID3>#$appID3#g" -i ../app/static/js/index.da425c07.js
# 配置sql文件
echo "生成SQL文件..."
sed "s#<appID1>#$appID1#g" -i ./thinkvue.sql
sed "s#<appID2>#$appID2#g" -i ./thinkvue.sql
sed "s#<appID3>#$appID3#g" -i ./thinkvue.sql
sed "s#<appsecret1>#$appsecret1#g" -i ./thinkvue.sql
sed "s#<appsecret2>#$appsecret2#g" -i ./thinkvue.sql
sed "s#<appsecret3>#$appsecret3#g" -i ./thinkvue.sql
sed "s#<wechat_template_id1>#$wechat_template_id1#g" -i ./thinkvue.sql
sed "s#<wechat_template_id2>#$wechat_template_id2#g" -i ./thinkvue.sql
sed "s#<wechat_template_id3>#$wechat_template_id3#g" -i ./thinkvue.sql
sed "s#<smsbao_username>#$smsbao_username#g" -i ./thinkvue.sql
sed "s#<smsbao_password>#$smsbao_password#g" -i ./thinkvue.sql
sed "s#<smsbao_verify_sms_content>#$smsbao_verify_sms_content#g" -i ./thinkvue.sql
sed "s#<ali_accesskeyid>#$ali_accesskeyid#g" -i ./thinkvue.sql
sed "s#<ali_accesssecret>#$ali_accesssecret#g" -i ./thinkvue.sql
sed "s#<ali_signname>#$ali_signname#g" -i ./thinkvue.sql
sed "s#<ali_verify_templatecode>#$ali_verify_templatecode#g" -i ./thinkvue.sql
sed "s#<sms_interface_type>#$sms_interface_type#g" -i ./thinkvue.sql
# 导入SQL文件
echo "导入SQL文件到MySQL数据库..."
python3 test_db.py -a import test_db.py -H "$host" -O "$port" -U "$username" -P "$password" -D "$dbname" -F "thinkvue.sql"
if [ $? -eq 0 ]; then
	echo -e "\033[32mSQL文件导入完成！\n \033[0m"
else
	echo -e "\033[31m \n导入SQL文件失败，请手动导入。\n \033[0m"
fi

# 添加定时任务
step=`expr $step + 1`
echo "================================"
echo -e "\033[4;32m$step\033[0m/\033[0;35m$total_steps \033[34m添加定时任务composer...\033[0m"
echo "================================"
pathpy=`pwd`
rm -rf ./run.sh
echo "cd $pathpy" >./run.sh
echo 'python3 main.py' >>./run.sh
chmod +x ./run.sh
# 启动python3后台服务 每两小时启动一次 程序中限制了唯一实例，因此不会重复运行 只是防止意外挂掉
# crontab -l > conf && echo "1 */2 * * * $pathpy/run.sh >> $pathpy/run.log" >> conf && crontab conf && rm -f conf
echo -e "\033[32m添加定时任务完成！\n \033[0m"
echo -e "\033[32m安装完成\n \033[0m" 

echo "================================"
echo -e "\033[34m注意事项：\033[0m" 
echo "================================"
echo "1. 域名'${api_url}'根目录指向/www/wwwroot/thinkvue.wxmsg/，运行目录指向/www/wwwroot/thinkvue.wxmsg/public，伪静态设置为thinkphp；
2. 域名'${wx_url}'根目录和运行目录都指向/www/wwwroot/thinkvue.wxmsg/app/，伪静态设置详见说明书；
3. 安装完成后不可移动/www/wwwroot/thinkvue.wxmsg/目录。
"