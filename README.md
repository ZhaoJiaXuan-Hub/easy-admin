# easyAdmin
使用高性能的webman框架开发的后台权限管理系统 [国内镜像](https://gitee.com/ZhaoJiaXuan-Hub/easy-admin)

# 使用
## 系统环境
- php版本:8.1↑
- mysql版本:7.4↑

## 安装程序依赖
```
composer install
```
## 启动
1. 导入数据库脚本 script.sql
2. 配置数据库文件 config/thinkorm.php
3. debug方式运行 php start.php start 正式运行 php start.php start -d
4. 访问http://项目地址:8787/admin/index.html 默认密码 admin 123456

# 界面预览
## 登录
![微信截图_20221120122705](https://user-images.githubusercontent.com/38801805/202885782-f18059f0-0129-4271-9c30-04958824a3f9.png)
## 角色管理
![微信截图_20221120122742](https://user-images.githubusercontent.com/38801805/202885791-4c50dde2-c5b6-4fb0-801e-c7d54b474176.png)
## 菜单权限管理
![微信截图_20221120122752](https://user-images.githubusercontent.com/38801805/202885798-da56921b-24a2-4e0d-bd93-27045f8098c7.png)
## 用户管理
![微信截图_20221120122805](https://user-images.githubusercontent.com/38801805/202885801-489d04c1-a05e-4570-91a3-1881e26720f1.png)
## 插件管理
![微信截图_20221120122816](https://user-images.githubusercontent.com/38801805/202885805-1cb5bd44-d5cc-4f3b-8347-6e8810fe2d14.png)
## 订单管理
![微信截图_20221120122823](https://user-images.githubusercontent.com/38801805/202885807-45310ab5-cae8-4cfd-ba96-591cfd298a2e.png)

# 使用帮助
* 系统默认配置了支付宝支付插件(默认为开发环境 正式使用需要修改支付宝插件文件的gatewayHost参数)
* 在app/api中有项目调用示例 包括获取支付方式 发起支付 支付回调
* 系统采用前后端分离形式 前端文件在public/admin中 可根据需求单独放置其他服务器运行
* 目前系统相对简单 仅用于学习参考 请勿用于商业用途 程序漏洞目前不明
