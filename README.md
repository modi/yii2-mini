# 搭建基于 Yii2 组件的框架

## 准备工作

新建一个项目目录。

安装 PHP 7.4，或使用 Docker：

    docker run --rm -it -v $(pwd):/project -w /project -u $(id -u):$(id -g) modicn/php:7.4.23-fpm-alpine3.14-dev ash

## 初始化新项目，使用 Composer 管理依赖

1）添加 `yiisoft/yii2` 为依赖

Yii2 框架的核心依赖是 `yiisoft/yii2`，[官方项目模板](https://github.com/yiisoft/yii2-app-advanced)使用的版本约束是`~2.0.14`。

在项目目录里执行 `composer require "yiisoft/yii2:~2.0.14"`，提示找不到 `bower-asset/jquery` 等依赖：

```
  Problem 1
    - yiisoft/yii2[2.0.14, ..., 2.0.15.1] require bower-asset/jquery 3.2.*@stable | 3.1.*@stable | 2.2.*@stable | 2.1.*@stable | 1.11.*@stable | 1.12.*@stable -> could not be found in any version, but the follow
ing packages provide it:
      - craftcms/cms Craft CMS
      - yidas/yii2-bower-asset Bower Assets for Yii 2 app provided via Composer repository
      - yidas/yii2-composer-bower-skip A Composer package that allows you to install or update Yii2 without Bower-Asset
      ...
```

原因是，`bower-asset/*`、`npm-asset/*` 等前端包，在 Composer 的默认仓库里不存在。Yii2 官方项目模板采用的解决办法是使用 https://asset-packagist.org 这个仓库：https://github.com/yiisoft/yii2-app-advanced/blob/2.0.44/composer.json#L39

出于前后端分离的考虑，我们不用 Composer 安装前端包。创建 `composer.json` 文件，内容如下：

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

再执行 `composer require "yiisoft/yii2:~2.0.14"`，可以成功添加依赖。
