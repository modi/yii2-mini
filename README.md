# 基于 Yii2 搭建 Web 项目

## 准备工作

新建一个项目目录。

安装 PHP 7.4 和 Composer，或使用 Docker：

    docker run --rm -it -v $(pwd):/project -w /project -u $(id -u):$(id -g) modicn/php:7.4.23-fpm-alpine3.14-dev ash

## 使用 Composer 管理依赖，添加 `yiisoft/yii2` 包

Yii2 框架的核心依赖是 `yiisoft/yii2`，[官方项目模板](https://github.com/yiisoft/yii2-app-advanced)使用的版本约束是`~2.0.14`。

在项目目录里执行 `composer require "yiisoft/yii2:~2.0.14"`，报错找不到 `bower-asset/jquery` 等依赖：

```
  Problem 1
    - yiisoft/yii2[2.0.14, ..., 2.0.15.1] require bower-asset/jquery 3.2.*@stable | 3.1.*@stable | 2.2.*@stable | 2.1.*@stable | 1.11.*@stable | 1.12.*@stable -> could not be found in any version, but the follow
ing packages provide it:
      - craftcms/cms Craft CMS
      - yidas/yii2-bower-asset Bower Assets for Yii 2 app provided via Composer repository
      - yidas/yii2-composer-bower-skip A Composer package that allows you to install or update Yii2 without Bower-Asset
      ...
```

原因是，`bower-asset/*`、`npm-asset/*` 等前端包，在 Composer 的默认仓库里不存在。Yii2 官方项目模板的解决办法是添加 https://asset-packagist.org 仓库：https://github.com/yiisoft/yii2-app-advanced/blob/2.0.44/composer.json#L39

出于前后端分离的考虑，不应使用 Composer 管理前端依赖，所以创建 `composer.json` 文件，使用 `replace` 配置来跳过前端包的安装，具体内容如下：

```
{
    "replace": {
        "bower-asset/inputmask": "*",
        "bower-asset/jquery": "*",
        "bower-asset/punycode": "*",
        "bower-asset/yii2-pjax": "*",
        "npm-asset/bootstrap": "*"
    }
}
```

再执行 `composer require "yiisoft/yii2:~2.0.14"`，可以成功安装依赖。

2）PHP 入口文件

创建 `public` 目录作为 Web 目录（开放 Web 访问的目录），出于安全方面的考虑，Web 目录里只保存前端静态文件和必要的 PHP 入口文件。

在 `public` 目录里创建入口文件 `index.php`，内容为：

    <?php

    echo 'Hello World!';

运行 PHP 内置的 Web 服务器，`-S` 参数指定监听地址，`-t` 参数指定 Web 目录：

    php -S 0.0.0.0:8080 -t public/

访问 http://实际地址:实际端口 ，响应是“Hello World!”。
