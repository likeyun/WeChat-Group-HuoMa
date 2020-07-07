# WeChat-Group-HuoMa
微信群二维码活码工具，生成微信群活码，随时可以切换二维码！微信官方群二维码有效期是7天，过期后无法扫码进群，或者是群人数满200人就无法扫码进群，如果我们在推广的时候，群满人或者过期了，别人还想进群，我们将会失去很多推广效果，所以有了群活码，可以在不更换链接和二维码的前提下，切换扫码后显示的内容，灵活变换！

![logo](https://raw.githubusercontent.com/likeyun/TANKING/master/timg.jpg)

# 作者博客
http://www.likeyun.cn/

# 更新日志
版本：v2.0.0<br/>
`1、新增本地图片上传`<br/>
`2、优化Ui`<br/>
`3、新增个人微信二维码和微信号的显示隐藏开关`<br/>
`4、修复上一版本的Bug`<br/>

本次更新需要在上一版本的基础上替换和新增以下文件<br/>
# 替换：<br/>
index.php<br/>
admin/add_qun.php<br/>
admin/add_qun_do.php<br/>
admin/edi_qun.php<br/>
admin/edi_qun_do.php<br/>
admin/index.php<br/>

# 新增：<br/>
admin/upload.php<br/>
admin/upload/ （这是文件夹，用于存放本地上传的图片）<br/>

# 后台界面
![后台首页](https://github.com/likeyun/TANKING/blob/master/qunhuoma-index.png)
![分享群活码](https://github.com/likeyun/TANKING/blob/master/qunhuoma-share.png)

# 添加群活码界面
![添加群活码](https://github.com/likeyun/TANKING/blob/master/qunhuoma-add.png)
![上传二维码](https://github.com/likeyun/TANKING/blob/master/qunhuoma-upload.png)

# 活码界面
<img src="https://github.com/likeyun/TANKING/blob/master/qunhuoma-page.jpg" width="400"/>

# 使用方法
只需要修改MySql.php的数据库配置和后台账号密码即可，后台账号默认是admin，密码admin123456 ，还要把qun_huoma.sql导入到你的数据库，要求php5.5-5.6版本。

# 访问
```
例如你的代码放在服务器根目录下的huoma文件夹
那么后台访问地址是
http://www.xxx.com/huoma/admin
```

# 遇到数据库无法导入的问题，自己手动建表吧

SQL语句
```
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS  `qun_huoma`;
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
  `wxstatus` varchar(32) DEFAULT NULL COMMENT '是否隐藏微信号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

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

# 赞赏
<img src="https://github.com/likeyun/TANKING/blob/master/wxzhanshang.jpg?raw=true" width="300"/>

# 温馨提示
以上图片如果不显示，很有可能是你电脑的host文件没有添加以下ip，请自行设置，再刷新页面。

1、找到目录C:\Windows\System32\drivers\etc\hosts
2、编辑host，在最下方粘贴下面ip地址
```
199.232.68.133 raw.githubusercontent.com
199.232.68.133 githubusercontent.com
```
3、保存
