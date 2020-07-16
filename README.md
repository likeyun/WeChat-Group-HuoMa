# WeChat-Group-HuoMa
微信群二维码活码工具，生成微信群活码，随时可以切换二维码！微信官方群二维码有效期是7天，过期后无法扫码进群，或者是群人数满200人就无法扫码进群，如果我们在推广的时候，群满人或者过期了，别人还想进群，我们将会失去很多推广效果，所以有了群活码，可以在不更换链接和二维码的前提下，切换扫码后显示的内容，灵活变换！

<img src="https://raw.githubusercontent.com/likeyun/TANKING/master/timg.jpg" width="700" />

# 作者博客
http://www.likeyun.cn/
# 交流群
http://pic.iask.cn/fimg/681565120779.jpg

# 更新日志
版本：v3.0.0<br/>
`1、新增备用群二维码`<br/>
`2、新增峰值，达到峰值自动切换群二维码`<br/>
`3、该版本改用一键安装模式`<br/>

本次更新与前2个版本不兼容，所以需要重新安装，安装前请到你的数据库把原来的数据表`qun_huoma`做好备份，以便安装完成后，恢复原有的数据，备份后，需要删除数据表`qun_huoma`，否则安装不能成功！<br/>

# 安装步骤
`1、把所有代码上传到服务器`<br/>
`2、访问install文件夹安装`<br/>
`例如、http://www.abc.com/huoma/install`<br/>

只需要输入数据库和管理员相关信息，即可快速安装，如果安装失败，请检查数据库配置是否填写正确。

![安装界面](https://github.com/likeyun/TANKING/blob/master/%E5%BE%AE%E4%BF%A1%E6%88%AA%E5%9B%BE_20200716112614.png?raw=true)

# 后台界面
![后台首页](https://github.com/likeyun/TANKING/blob/master/20200716-add.png)
![分享群活码](https://github.com/likeyun/TANKING/blob/master/%E5%BE%AE%E4%BF%A1%E6%88%AA%E5%9B%BE_20200716113948.png)

# 添加群活码界面
![添加群活码](https://github.com/likeyun/TANKING/blob/master/20200716113531.png)
![添加群活码](https://github.com/likeyun/TANKING/blob/master/20200716113652.png)

# 活码界面
<img src="https://github.com/likeyun/TANKING/blob/master/qunhuoma-page.jpg" width="400"/>

# 访问
```
例如你的代码放在服务器根目录下的huoma文件夹
那么后台访问地址是
http://www.xxx.com/huoma/admin
```

# 活码交流群
<img src="https://github.com/likeyun/TANKING/blob/master/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20200716114242.jpg" width="400"/>

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
