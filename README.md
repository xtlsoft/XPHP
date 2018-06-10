# XPHP

<p align="center"><a href="https://packagist.org/packages/xtlsoft/xphp">
<img src="https://poser.pugx.org/xtlsoft/xphp/license" alt="License"></a>
<a href="https://packagist.org/packages/xtlsoft/xphp"><img src="https://poser.pugx.org/xtlsoft/xphp/v/stable" alt="Latest Stable Version"></a>
<a href="https://php.net"><img src="https://img.shields.io/badge/PHP-5.4+-blue.svg" alt="Require PHP Version"></a>
<a href="https://codeclimate.com/github/xtlsoft/XPHP"><img src="https://codeclimate.com/github/xtlsoft/XPHP/badges/gpa.svg" alt="Code Climate"></a>
<a href="https://travis-ci.org/xtlsoft/XPHP"><img src="https://travis-ci.org/xtlsoft/XPHP.svg?branch=master" alt="Build Status"></a>
<a href="https://blog.xtlsoft.top"><img src="https://img.shields.io/badge/Made%20with-love-yellowgreen.svg" alt="MadeWithLove"></a>
</p>

XPHP is a lightweight, simple PHP framework.
XPHP是一个轻便，简单的PHP框架。

## Tip 提示
Please don't `clone` the master branch directly, because the version 1.0.0 is still in development.
You can download the 0.3.0 of XPHP here: https://github.com/xtlsoft/XPHP/releases/

请勿直接 `Clone` 主分支，因为1.0.0版还在开发。
你可以从此处下载XPHP的0.3.0版：https://github.com/xtlsoft/XPHP/releases/

## Features 特性
- Use Composer and Archive-Library-Install together. 一起使用 `Composer` 和传统归档库管理。
- Lightweight and Strong, Fast and Functional. 轻便但强壮，快速但不少功能。
- Good Log and Error proccessing. 极棒的Log和Error处理。
- Self-written fast, useful and open Route. 自己实现的快速，自定义性强的路由。
- Fast template engine, use orgin php. 快速的模板引擎，使用原生php。
- MVC and MVVM compatible, plus `?inajax=yes` in URI to turn it into API. MVC和MVVM兼容，增加`?inajax=yes`参数，就可以把页面变成API。
- Muiti-Language Support 多语言支持
- Json API compatible. JSON格式API兼容。
- Less Code, Do More. 极少的代码，极大的成效
- Easy to learn. 极易上手

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
