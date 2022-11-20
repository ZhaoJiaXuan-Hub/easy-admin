# easyAdmin
使用高性能的webman框架开发的后台权限管理系统

# 使用

1. 导入数据库脚本 script.sql
2. 配置数据库文件 config/thinkorm.php
3. debug方式运行 php start.php start 正式运行 php start.php start -d
4. 访问http://项目地址:8787/admin/index.html

# 默认密码
admin 123456

# 使用帮助
* 系统默认配置了支付宝支付插件(默认为开发环境 正式使用需要修改支付宝插件文件的gatewayHost参数)
* 在app/api中有项目调用示例 包括获取支付方式 发起支付 支付回调
* 系统采用前后端分离形式 前端文件在public/admin中 可根据需求单独放置其他服务器运行
* 目前系统相对简单 仅用于学习参考 请勿用于商业用途 程序漏洞目前不明
