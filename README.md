# XPHP

[![License](https://poser.pugx.org/xtlsoft/xphp/license)](https://packagist.org/packages/xtlsoft/xphp)
[![Latest Stable Version](https://poser.pugx.org/xtlsoft/xphp/v/stable)](https://packagist.org/packages/xtlsoft/xphp)
[![Require PHP Version](https://img.shields.io/badge/PHP-5.4+-blue.svg)](https://php.net)
[![Build Status](https://travis-ci.org/xtlsoft/XPHP.svg?branch=master)](https://travis-ci.org/xtlsoft/XPHP)
[![MadeWithLove](https://img.shields.io/badge/Made%20with-love-yellowgreen.svg)](https://blog.xtlsoft.top)

XPHP is a light, easy PHP framework.
XPHP是一个轻便，简单的PHP框架。

## Tip 提示
XPHP will release a new version these months. The version must have a lot of changes. It will merge some features in Rqo. I compared more frameworks and had lots of thoughts, so it'll take me some time to write the code.

## Features 特性
- Use Composer and Archive-Library-Install together. 一起使用Composer和传统归档库管理。
- Light but Strong, Fast but Good. 轻便但强壮，快速但不少功能。
- Good Log and Error proccessing. 极棒的Log和Error处理。
- Self-written fast, useful and open Route. 自己实现的快速，自定义性强的路由。
- Fast template engine, use orgin php. 快速的模板引擎，使用原生php。
- MVC and MVVM compatible, plus `?inajax=yes` in URI to turn it into API. MVC和MVVM兼容，增加`?inajax=yes`参数，就可以把页面变成API。
- Muiti-Language Support 多语言支持
- Json API compatible. JSON格式API兼容。
- Less Code, Do More 极少的代码，极大的成效
- Easy to learn 极易上手

## Document 文档
Now only zh_cn Document avalible.
目前只有中文文档。
http://www.kancloud.cn/xtlsoft/xphp-doc/content/

## Installation 安装
Please go to the Releases Page to Download.

请到 Releases 页面下载。

https://github.com/xtlsoft/XPHP/releases

对于中国用户，我们提供了一个高速镜像：https://git.xapps.top/xtlsoft/XPHP

如果您使用0.3.x的XPHP，在nginx中，他必须处于站点根目录。在apache中，没有这个限制。网站的根无论指向根目录或`Public`目录都是被允许的。
如果使用nginx，伪静态配置样例已经附在了`nginx.conf`下。如果`root`指向根目录，请用根目录下的；指向`Public`目录，请用`Public`目录下的。

If you are using Version 0.3.x, You could only put XPHP in the siteroot in nginx, but anywhere you like in apache. You can point the website root both to `/` or `/Public/`.
If you are using nginx, we provide a Example rewrite configure. It's in a file which named `nginx.conf`. If your point your root to `/`, please use `/nginx.conf`; if you point your root to `/Public/`, please use `/Public/nginx.conf`.
