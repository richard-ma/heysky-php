# heysky-php
heysky.com API PHP interface

# 系统需求

* 安装有curl模块的PHP WEB服务器或PHP cli平台

# 命令行版本

## 安装

* 将config.php.sample更名为config.php
* 编辑config.php，将heysky的用户名和密码填写正确

## 使用

* 打开cmd命令行，切换到程序的cli目录
* 填写好程序根目录下的data文件数据（手机号和三个关键字）
* 设置好短信模板（详见修改短信模板）
* 运行发送程序php send.php
* 每次发送情况会在cli目录的log文件中有详细记录

# WEB版本 

## 安装

* 将文件复制到web服务器的根目录
* 将config.php.sample更名为config.php
* 编辑config.php，将heysky的用户名和密码填写正确
* 目录下创建一个名为log.html的文件，并赋予777权限
    * touch log.html
    * chmod 777 log.html

## 使用

* 将手机号和三个可替换关键字写入文本框，点击发送即可。

# 修改短信模板

* 修改template文件的内容即可
* <text1>代表第一个关键字
* <text2>代表第二个关键字
* <text3>代表第三个关键字
