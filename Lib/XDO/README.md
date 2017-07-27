# XDO - PHP Data Object

[License]MIT [Build]Pass [Database]99% [Cache]0% [Upload]5%

> XDO is a PHP Data Object includes Database, Cache and Upload.<br>
> XDO 是一个 PHP 数据类，它包括了 数据库，缓存和上传。

### Author 作者
The Author of XDO is Tianle Xu([xtl@xtlsoft.top](mailto:xtl@xtlsoft.top)).<br>
XDO 的作者是徐天乐([xtl@xtlsoft.top](mailto:xtl@xtlsoft.top))。

### Dependency 依赖项
We only need PHP! (PHP>=5.4) This is a portable software!<br>
我们只需要PHP! (PHP>=5.4) 这是一个绿色软件！

### Install 安装
###### 1. Common
1. Install PHP.
2. Clone this project.
3. Move the `XDO-master` directory into `vendor/XDO`
4. add one line code to your PHP Script:
```
require_once("vendor/XDO/Autoload.php");
```
5. Enjoy!
###### 2. One-Key Script
> Note: Please install `wget` first. <br> 
> If you want to use this way to install XDO, please add a `PATH` env for PHP first.

1. Run the script
```
wget http://raw.githubusercontents.com/xtlsoft/XDO/files/XDO-install.php -O XDO-install.php && php ./XDO-install.php
```
2. add one line code to your PHP Script:
```
require_once("vendor/XDO/Autoload.php");
```
3. Enjoy!
###### 3. Use composer
```
composer require xtlsoft/xdo:dev-master
```

-------------------------
###### 1. 通用
1. 安装PHP。
2. Clone 这个项目。
3. 把`XDO-master`文件夹移动到`vendor`下并重命名为`XDO`
4. 向你的程序添加一行:
```
require_once("vendor/XDO/Autoload.php");
```
5. Enjoy!
###### 2. 一键脚本
> Note: 请先安装 `wget` 。 <br> 
> 请先为PHP设置环境变量。

1. 运行脚本
```
wget http://raw.githubusercontents.com/xtlsoft/XDO/files/XDO-install.php -O XDO-install.php && php ./XDO-install.php
```
2. 向你的程序添加一行:
```
require_once("vendor/XDO/Autoload.php");
```
3. Enjoy!
###### 3. Use composer
```
composer require xtlsoft/xdo:dev-master
```

### Usage 使用
- Install XDO.
- Include XDO class: 
```
use XDO\XDO;
```
- Set a Data dir:
```
XDO::setDir("path/to/data");
```
> Please clone the `Data` branch into your project. Replace the `path/to/data` string into the path to the `Data` branch you cloned.  It includes some sample Data.

- Create a Database object:
```
$db = XDO::Database("Test"); //"Test" is the ModelName. We include a Test Model in the `Data` branch.
``` 
- Do some tests:
```
$db->get("Config"); //Get the Data from Config table.
$db->get("Config.#1"); //Get the Data from #1 of Config Table
$db->get("Config.where[name=xtlsoft%]"); //Get the Data which its name match "\^xtlsoft[\s\S]*$\" in Config table.
```
- More: put,ins,del ::: Read our [document](https://xdo.1im.pw/docs/en)

-----
- 安装 XDO.
- 引入 XDO 类: 
```
use XDO\XDO;
```
- 设置一个 Data 目录:
```
XDO::setDir("path/to/data");
```
> 请 clone `Data` 分支。 把 `path/to/data` 替换成你 clone 的 `Data` 分支.  它包括一些测试数据。

- 创建一个 Database 实例:
```
$db = XDO::Database("Test"); //"Test" is the ModelName. We include a Test Model in the `Data` branch.
``` 
- 做一些测试:
```
$db->get("Config"); //Get the Data from Config table.
$db->get("Config.#1"); //Get the Data from #1 of Config Table
$db->get("Config.where[name=xtlsoft%]"); //Get the Data which its name match "\^xtlsoft[\s\S]*$\" in Config table.
```
- 更多方法: put,ins,del ::: 阅读我们的 [文档](https://xdo.1im.pw/docs/zh)
