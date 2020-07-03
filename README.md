# WeChat-Group-HuoMa
微信群二维码活码工具，生成微信群活码，随时可以切换二维码！微信官方群二维码有效期是7天，过期后无法扫码进群，或者是群人数满200人就无法扫码进群，如果我们在推广的时候，群满人或者过期了，别人还想进群，我们将会失去很多推广效果，所以有了群活码，可以在不更换链接和二维码的前提下，切换扫码后显示的内容，灵活变换！

# 后台界面
![后台首页](https://common-fd.zol-img.com.cn/g1/M05/04/04/ChMljV77EfWINIFHAACFTDv0yZUAAQRFwNyeWMAAIVk111.jpg "后台首页")

# 添加群活码界面
![添加群活码](https://common-fd.zol-img.com.cn/g1/M06/04/04/ChMljl77EwSIdr40AAC7igqlce4AAQRGADKhRUAALui682.jpg "添加群活码")

# 活码界面
<img src="https://common-fd.zol-img.com.cn/g1/M09/04/0A/ChMljV78UCSIRkr-AADvZ7CurlQAAQSdwMlsWkAAO9_814.jpg" width="400"/>

# 使用方法
只需要修改MySql.php的数据库配置和后台账号密码即可，后台账号默认是admin，密码admin123456 ，还要把qun_huoma.sql导入到你的数据库，要求php5.5-5.6版本。

# 访问
```
例如你的代码放在服务器根目录下的huoma文件夹
那么后台访问地址是
http://www.xxx.com/huoma/admin
```

# 遇到数据库无法导入的问题，自己手动建表吧
<img src="http://pic.iask.cn/fimg/743365032832.jpg" width="600"/>

SQL语句
```
SET FOREIGN_KEY_CHECKS = 0; 
   DROP TABLE IF EXISTS `qun_huoma`; 
 CREATE TABLE `qun_huoma` ( 
 `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', 
 `hm_id` varchar(32) DEFAULT NULL COMMENT '活码id', 
 `title` varchar(32) DEFAULT NULL COMMENT '标题', 
 `qun_qrcode` text COMMENT '群二维码', 
 `wx_qrcode` text COMMENT '微信二维码', 
 `creat_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间', 
 `update_time` varchar(32) DEFAULT '' COMMENT '更新时间', 
 `wxid` varchar(32) DEFAULT NULL COMMENT '微信号', 
 `page_view` varchar(32) DEFAULT '0' COMMENT '访问量', 
 `biaoqian` varchar(32) DEFAULT NULL COMMENT '标签', 
 PRIMARY KEY (`id`) 
 ) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4; 
   SET FOREIGN_KEY_CHECKS = 1; 
```

# 各类问题解决
1、请保持php5.5以上环境
2、数据库无法正常导入，请看上图自己建表，表名是qun_huoma

# 配置
```
<?php
// 基于php5.5开发
// 前端使用Bootstrap4.0

$servername = "";//数据库地址
$username = "";//数据库账号
$password = "";//数据库密码
$dbname = "";//数据库名

// 后台账号密码
$adminusername = "admin";
$adminpassword = "admin123456";
?>
```

# 交流群
![二维码](https://common-fd.zol-img.com.cn/g5/M00/0C/0E/ChMkJl7-mZGIMqAqAABIBLxlQOYAAwkAALchAEAAEgc646.jpg "二维码")
