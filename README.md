# QuickView
前言：由于设计的妹子经常做一些WEB PC 及移动端（APP/微信/WAP）系统/营销活动 界面，然后做好了导出几十张jpg图打包zip附件给各方确认。公司邮箱很慢，下载个附件很麻烦，还有下载去解压，很多人不情愿去下载来看，而且是等最后的版本出来再看，后面我觉得有必要做一个工具让事情变得简单，点个鼠标，或者扫个码就OK了。而且自己电脑做为局域网内的服务器，页面上传或者请求访问十几兆的图片秒秒钟给你处理完。

* 使用了**[Dropzone.js](http://www.dropzonejs.com/)** 拖拽上传插件。和**[PHP qrcode](http://phpqrcode.sourceforge.net/)** 二维码生成类。
* 效果图(PC网页、APP、WAP)，拖拽上传线上或者本地服务器并生成预览界面，并生成二维码。手机可以扫描全屏访问
* 中文项目名支持中文（iis+php不用配置就可以支持中文URL） win 下的 apache + php 不支持中文目录。LINUX + PHP可以支持中文项目名及url.自已去搜索。
* 系统没有数据库，以目录名作为项目名，系统会自动生成时间戳为唯一标识的前前后辍，所以不用担心会重名。上传文件是创建目录，原名无压缩上传图片的过程，所以，请选排序。给图片命名，以满足图片排序显示要求。
* upload 文件夹有很多图片，我没同步到github,请自行创建(和index.php同级)，  upload 文件夹下还有 test 和 confirm 是分类， 请自行创建。
* 在线DEMO: [http://uinote.cn/done/quickView/](http://uinote.cn/done/quickView/)    (图片多、大，建议用局域网内的电脑做服务器) 。
